<?php

namespace App\View\Composers;

use App\Models\MenuItem;
use App\Models\Setting;
use App\Models\SocialLink;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class LayoutComposer
{
    public function compose(View $view): void
    {
        // Graceful fallback if tables don't exist yet
        if (!Schema::hasTable('settings')) {
            $view->with([
                'siteSettings'  => collect(),
                'headerMenu'    => collect(),
                'footerFinance' => collect(),
                'footerCompany' => collect(),
                'socialLinks'   => collect(),
            ]);
            return;
        }

        $view->with([
            'siteSettings'  => $this->settings(),
            'headerMenu'    => MenuItem::for('header')->active()->orderBy('order')->get(),
            'footerFinance' => MenuItem::for('footer_finance')->active()->orderBy('order')->get(),
            'footerCompany' => MenuItem::for('footer_company')->active()->orderBy('order')->get(),
            'socialLinks'   => SocialLink::active()->orderBy('order')->get(),
        ]);
    }

    protected function settings(): object
    {
        return new class {
            public function __get($key) { return Setting::get($key); }
            public function get($key, $default = null) { return Setting::get($key, $default); }
        };
    }
}
