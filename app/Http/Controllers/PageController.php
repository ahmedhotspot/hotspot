<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Article;
use App\Models\Bank;
use App\Models\Faq;
use App\Models\HowItWorksStep;
use App\Models\Offer;
use App\Models\Page;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\TrustMetric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    public function home()
    {
        $ready = Schema::hasTable('services');

        return view('pages.home', [
            'services'     => $ready ? Service::active()->orderBy('order')->get() : collect(),
            'trustMetrics' => $ready ? TrustMetric::active()->orderBy('order')->get() : collect(),
            'steps'        => $ready ? HowItWorksStep::active()->orderBy('order')->get() : collect(),
            'banks'        => $ready ? Bank::active()->orderBy('order')->get() : collect(),
            'offers'       => $ready ? Offer::active()->with('bank')->orderBy('order')->get() : collect(),
            'articles'     => $ready ? Article::published()->orderBy('order')->limit(3)->get() : collect(),
            'testimonials' => $ready ? Testimonial::active()->orderBy('order')->get() : collect(),
        ]);
    }

    public function about()   { return $this->renderPage('about'); }
    public function contact() { return $this->renderPage('contact'); }
    public function privacy() { return $this->renderPage('privacy'); }
    public function terms()   { return $this->renderPage('terms'); }

    public function faq()
    {
        $ready = Schema::hasTable('faqs');
        return view('pages.faq', [
            'page' => $ready ? Page::where('slug', 'faq')->first() : null,
            'faqs' => $ready ? Faq::active()->orderBy('order')->get()->groupBy('category') : collect(),
        ]);
    }

    public function apply(Request $request)
    {
        $ready = Schema::hasTable('banks');
        return view('pages.apply', [
            'banks'    => $ready ? Bank::active()->orderBy('order')->get() : collect(),
            'services' => $ready ? Service::active()->orderBy('order')->get() : collect(),
            'bank'     => $request->query('bank'),
        ]);
    }

    public function financingRequest()
    {
        $ready = Schema::hasTable('services');
        return view('pages.financing-request', [
            'services' => $ready ? Service::active()->orderBy('order')->get() : collect(),
        ]);
    }

    public function storeFinancingRequest(Request $request)
    {
        $data = $request->validate([
            'full_name'   => 'required|string|max:150',
            'phone'       => ['required', 'string', 'regex:/^05\d{8}$/'],
            'national_id' => ['required', 'string', 'regex:/^\d{10}$/'],
            'service_id'  => 'required|exists:services,id',
        ], [
            'phone.regex'       => __('Please enter a valid Saudi mobile number (05XXXXXXXX).'),
            'national_id.regex' => __('National ID must be exactly 10 digits.'),
        ]);

        Application::create($data + ['status' => 'new']);

        return redirect()->route('financing-request')
            ->with('success', __('Your request has been submitted. We will contact you shortly.'));
    }

    public function services()
    {
        $ready = Schema::hasTable('services');
        return view('pages.services', [
            'services' => $ready ? Service::active()->orderBy('order')->get() : collect(),
        ]);
    }

    public function service(string $slug)
    {
        $service = Service::where('slug', $slug)->active()->firstOrFail();
        return view('pages.service', [
            'service' => $service,
            'offers'  => Offer::active()->where('service_id', $service->id)->with('bank')->orderBy('order')->get(),
        ]);
    }

    public function offer(string $slug)
    {
        $bank   = Bank::where('slug', $slug)->active()->firstOrFail();
        $offers = Offer::active()->where('bank_id', $bank->id)->with('service')->get();
        return view('pages.offer', compact('bank', 'offers'));
    }

    public function article(string $slug)
    {
        $article = Article::where('slug', $slug)->published()->firstOrFail();
        return view('pages.article', compact('article'));
    }

    public function switchLocale(Request $request, string $locale)
    {
        $available = config('app.available_locales', ['ar', 'en']);
        if (in_array($locale, $available, true)) {
            Session::put('locale', $locale);
            App::setLocale($locale);
        }
        return redirect()->back();
    }

    protected function renderPage(string $slug)
    {
        $page = Schema::hasTable('pages') ? Page::where('slug', $slug)->first() : null;
        return view('pages.' . $slug, ['page' => $page]);
    }
}
