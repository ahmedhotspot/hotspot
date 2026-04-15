<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $groups = Setting::orderBy('group')->orderBy('order')->get()->groupBy('group');
        return view('admin.settings.index', ['groups' => $groups]);
    }

    public function update(Request $request)
    {
        $settings = Setting::all();

        foreach ($settings as $setting) {
            $key = $setting->key;

            if ($setting->is_translatable) {
                $ar = $request->input($key . '_ar');
                $en = $request->input($key . '_en');
                $value = json_encode(['ar' => $ar, 'en' => $en], JSON_UNESCAPED_UNICODE);
                $setting->value = $value;
            } elseif ($setting->type === 'image') {
                if ($request->hasFile($key)) {
                    $path = $request->file($key)->store('settings', 'public');
                    $setting->value = 'storage/' . $path;
                }
            } elseif ($setting->type === 'boolean') {
                $setting->value = $request->boolean($key) ? '1' : '0';
            } else {
                if ($request->has($key)) {
                    $setting->value = $request->input($key);
                }
            }

            $setting->save();
        }

        Setting::clearCache();

        return back()->with('success', __('Updated successfully'));
    }
}
