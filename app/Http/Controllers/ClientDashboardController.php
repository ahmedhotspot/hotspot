<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Offer;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ClientDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Application::where('user_id', $user->id)
            ->orWhere(function ($q) use ($user) {
                $q->whereNull('user_id')
                  ->where('email', $user->email);
            })
            ->with(['service', 'bank', 'offer'])
            ->latest();

        $applications = $query->paginate(10);

        $stats = [
            'total'     => (clone $query)->count(),
            'new'       => Application::where('user_id', $user->id)->where('status', 'new')->count(),
            'reviewing' => Application::where('user_id', $user->id)->where('status', 'reviewing')->count(),
            'approved'  => Application::where('user_id', $user->id)->where('status', 'approved')->count(),
            'rejected'  => Application::where('user_id', $user->id)->where('status', 'rejected')->count(),
            'completed' => Application::where('user_id', $user->id)->where('status', 'completed')->count(),
        ];

        return view('client.dashboard', compact('applications', 'stats'));
    }

    public function show(Request $request, Application $application)
    {
        $user = $request->user();
        abort_unless(
            $application->user_id === $user->id
                || (is_null($application->user_id) && $application->email === $user->email),
            403
        );

        $application->load(['service', 'bank', 'offer']);

        return view('client.application', compact('application'));
    }

    public function profile(Request $request)
    {
        return view('client.profile', ['user' => $request->user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name'  => ['required', 'string', 'max:120'],
            'phone' => ['nullable', 'string', 'max:40'],
        ]);

        $user->update($data);

        return redirect()->route('client.profile')->with('success', 'تم تحديث بياناتك بنجاح.');
    }

    public function createFinancing(Request $request)
    {
        $apiIndustries = Cache::remember('api.industries', 300, function () {
            try {
                $response = Http::timeout(8)->withHeaders([
                    'Authorization' => '6NKbQBoieHE8xf29cl1pyUFNP9vowU=',
                    'Accept'        => 'application/json',
                ])->get('http://8.213.80.135/hotspotloans/public/api/website/industries');

                if ($response->successful()) {
                    return $response->json('data') ?: [];
                }
            } catch (\Throwable $e) {
                // silent fail
            }
            return [];
        });

        $offers = Offer::query()
            ->when(method_exists(Offer::class, 'scopeActive'), fn ($q) => $q->active())
            ->with('bank')
            ->orderBy('order')
            ->get();

        return view('client.financing.create', [
            'apiIndustries' => $apiIndustries,
            'offers'        => $offers,
            'user'          => $request->user(),
        ]);
    }

    public function storeFinancing(Request $request)
    {
        $data = $request->validate([
            'industry_id'              => ['required', 'string', 'max:40'],
            'sub_industry_id'          => ['required', 'string', 'max:40'],
            'industry_name'            => ['nullable', 'string', 'max:200'],
            'sub_industry_name'        => ['nullable', 'string', 'max:200'],
            'service_id'               => ['nullable', 'exists:services,id'],
            'offer_id'                 => ['nullable', 'exists:offers,id'],
            'sub_product'              => ['nullable', 'string', 'max:150'],

            'full_name'                => ['required', 'string', 'max:150'],
            'national_id'              => ['required', 'string', 'size:10'],
            'residence_number'         => ['nullable', 'string', 'max:40'],

            'city'                     => ['required', 'string', 'max:100'],
            'street_name'              => ['required', 'string', 'max:150'],
            'postal_code'              => ['required', 'string', 'max:20'],
            'district_name'            => ['required', 'string', 'max:150'],
            'additional_code'          => ['nullable', 'string', 'max:20'],
            'location_description'     => ['nullable', 'string', 'max:255'],

            'phone'                    => ['required', 'string', 'max:40'],
            'mobile_2'                 => ['nullable', 'string', 'max:40'],
            'phone_1'                  => ['nullable', 'string', 'max:40'],
            'phone_2'                  => ['nullable', 'string', 'max:40'],
            'email'                    => ['required', 'email', 'max:160'],

            'legal_form'               => ['required', 'string', 'max:150'],
            'commercial_name'          => ['required', 'string', 'max:200'],
            'commercial_registration'  => ['required', 'string', 'max:60'],
            'commercial_city'          => ['required', 'string', 'max:100'],
            'license_expiry_hijri'     => ['required', 'string', 'max:30'],
            'establishment_date_hijri' => ['required', 'string', 'max:30'],

            'owner_name'               => ['required', 'string', 'max:200'],
            'owner_id_number'          => ['required', 'string', 'size:10'],
            'nationality'              => ['required', 'string', 'max:80'],
            'birth_date'               => ['required', 'date'],
            'id_expiry_date'           => ['required', 'string', 'max:30'],

            'amount'                   => ['required', 'numeric', 'min:1'],
            'term_years'               => ['required', 'integer', 'min:1', 'max:30'],
            'notes'                    => ['nullable', 'string', 'max:2000'],

            'guarantee_types'          => ['nullable', 'array'],
            'guarantee_types.*'        => ['string', 'in:real_estate,stocks,other'],
            'guarantee_details'        => ['nullable', 'array'],

            'documents'                => ['nullable', 'array'],
            'documents.*'              => ['file', 'mimes:pdf,jpg,jpeg,png,doc,docx', 'max:5120'],
        ]);

        $docsMeta = [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $key => $file) {
                $path = $file->store('applications/' . $request->user()->id, 'public');
                $docsMeta[] = [
                    'key'           => is_string($key) ? $key : null,
                    'path'          => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'size'          => $file->getSize(),
                ];
            }
        }

        $payload = $data;
        $payload['user_id'] = $request->user()->id;
        $payload['status']  = 'new';
        $payload['documents'] = $docsMeta ?: null;

        $app = Application::create($payload);

        return redirect()->route('client.applications.show', $app)
            ->with('success', 'تم استلام طلب التمويل بنجاح. سنتواصل معك قريباً.');
    }
}
