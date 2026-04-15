<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Article;
use App\Models\Bank;
use App\Models\Contact;
use App\Models\Offer;
use App\Models\Service;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'stats' => [
                'users'        => User::count(),
                'applications' => Application::count(),
                'pending_apps' => Application::where('status', 'pending')->count(),
                'contacts'     => Contact::count(),
                'new_contacts' => Contact::where('status', 'new')->count(),
                'services'     => Service::count(),
                'banks'        => Bank::count(),
                'offers'       => Offer::count(),
                'articles'     => Article::count(),
            ],
            'recentApplications' => Application::with(['bank', 'service'])->latest()->limit(5)->get(),
            'recentContacts'     => Contact::latest()->limit(5)->get(),
        ]);
    }
}
