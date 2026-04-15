<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendVerificationEmail;
use App\Jobs\SendWelcomeEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin() { return view('auth.login'); }
    public function showRegister() { return view('auth.register'); }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($data, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => __('auth.failed')]);
        }

        if (! $request->user()->is_active) {
            Auth::logout();
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => __('Your account is inactive.')]);
        }

        $request->session()->regenerate();

        return redirect()->intended($request->user()->isAdmin() ? route('admin.dashboard') : route('client.dashboard'));
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:120'],
            'email'    => ['required', 'email', 'max:160', 'unique:users,email'],
            'phone'    => ['nullable', 'string', 'max:40'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name'                     => $data['name'],
            'email'                    => $data['email'],
            'phone'                    => $data['phone'] ?? null,
            'password'                 => Hash::make($data['password']),
            'role'                     => 'user',
            'locale'                   => app()->getLocale(),
            'email_verification_token' => Str::random(64),
        ]);

        SendVerificationEmail::dispatch($user);

        Auth::login($user);

        return redirect()->route('client.dashboard')
            ->with('success', 'تم إنشاء حسابك بنجاح يا ' . $user->name . '. أرسلنا رسالة تأكيد إلى بريدك الإلكتروني، الرجاء التحقق منها لتفعيل الحساب.');
    }

    public function verifyEmail(string $token)
    {
        $user = User::where('email_verification_token', $token)->first();

        if (! $user) {
            return redirect()->route('home')
                ->withErrors(['email' => 'رابط التأكيد غير صالح أو منتهي الصلاحية.']);
        }

        if (! $user->email_verified_at) {
            $user->forceFill([
                'email_verified_at'        => now(),
                'email_verification_token' => null,
            ])->save();

            SendWelcomeEmail::dispatch($user);
        }

        if (! Auth::check()) {
            Auth::login($user);
        }

        return redirect()->route('client.dashboard')
            ->with('success', 'تم تأكيد بريدك الإلكتروني بنجاح. أهلاً بك في هوت سبوت!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
