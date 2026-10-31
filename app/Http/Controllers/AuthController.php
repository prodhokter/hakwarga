<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function redirectToGoogle(): RedirectResponse
    {
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');

        if (empty($clientId) || empty($clientSecret)) {
            return back()->with('error', 'Kredensial Google OAuth belum dikonfigurasi di file .env.');
        }

        /** @var GoogleProvider $driver */
        $driver = Socialite::driver('google');

        return $driver->with(['prompt' => 'select_account'])->redirect();
    }

    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            /** @var GoogleProvider $driver */
            $driver = Socialite::driver('google');
            $googleUser = $driver->user();
        } catch (\Throwable $e) {
            return redirect()->route('login')->with('error', 'Gagal memproses autentikasi Google: '.$e->getMessage());
        }

        $email = $googleUser->getEmail();
        if (empty($email)) {
            return redirect()->route('login')->with('error', 'Surel tidak ditemukan dari respon Google.');
        }

        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $email)
            ->first();

        if ($user) {
            $user->update([
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'email_verified_at' => $user->email_verified_at ?? now(),
            ]);
        } else {
            $user = User::create([
                'name' => $googleUser->getName() ?? explode('@', $email)[0],
                'email' => $email,
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'role' => UserRole::Citizen,
                'email_verified_at' => now(),
            ]);
        }

        Auth::login($user, true);
        session()->forget('is_guest');

        return redirect()->route('home')->with('success', 'Berhasil masuk dengan akun Google.');
    }

    public function sendOtp(Request $request, OtpService $otpService): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255'],
        ], [
            'email.required' => 'Alamat surel wajib diisi.',
            'email.email' => 'Format alamat surel tidak valid.',
        ]);

        $email = strtolower(trim($validated['email']));

        $rateKey = 'send-otp:'.$email;
        if (RateLimiter::tooManyAttempts($rateKey, 4)) {
            $seconds = RateLimiter::availableIn($rateKey);

            return back()->withInput()->with('error', "Terlalu banyak permintaan OTP. Silakan tunggu {$seconds} detik lagi.");
        }
        RateLimiter::hit($rateKey, 300);

        $otp = $otpService->generateAndSend($email);

        // Flash dev OTP if in local environment without Resend key
        if (app()->environment('local') && empty(config('services.resend.key'))) {
            session()->flash('dev_otp', $otp);
        }

        return redirect()->route('auth.otp.verify', ['email' => $email])
            ->with('success', 'Kode OTP 6 digit telah dikirim ke surel Anda.');
    }

    public function showVerifyOtp(Request $request): View|RedirectResponse
    {
        $email = $request->query('email');
        if (empty($email) || ! is_string($email)) {
            return redirect()->route('login');
        }

        return view('auth.verify-otp', [
            'email' => strtolower(trim($email)),
        ]);
    }

    public function verifyOtp(Request $request, OtpService $otpService): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'otp' => ['required', 'string', 'size:6'],
        ], [
            'email.required' => 'Alamat surel wajib diisi.',
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.size' => 'Kode OTP harus berupa 6 digit angka.',
        ]);

        $email = strtolower(trim($validated['email']));
        $otp = trim($validated['otp']);

        $rateKey = 'verify-otp:'.$email;
        if (RateLimiter::tooManyAttempts($rateKey, 5)) {
            $seconds = RateLimiter::availableIn($rateKey);

            return back()->withInput()->with('error', "Terlalu banyak percobaan salah. Coba lagi dalam {$seconds} detik.");
        }

        $isValid = $otpService->verify($email, $otp);

        if (! $isValid) {
            RateLimiter::hit($rateKey, 300);

            return back()->withInput()->with('error', 'Kode OTP salah atau telah kadaluarsa.');
        }

        RateLimiter::clear($rateKey);

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => explode('@', $email)[0],
                'role' => UserRole::Citizen,
                'email_verified_at' => now(),
            ]
        );

        Auth::login($user, true);
        session()->forget('is_guest');

        return redirect()->route('home')->with('success', 'Berhasil masuk ke akun Anda.');
    }

    public function guest(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            Auth::logout();
        }

        $request->session()->put('is_guest', true);

        return redirect()->route('home')->with('success', 'Melanjutkan penjelajahan dalam Mode Tamu.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah keluar dari akun.');
    }
}
