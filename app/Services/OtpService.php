<?php

declare(strict_types=1);

namespace App\Services;

use App\Mail\SendOtpMail;
use App\Models\EmailOtp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OtpService
{
    public function generateAndSend(string $email): string
    {
        // 1. Invalidate previous unexpired OTPs for this email
        EmailOtp::where('email', $email)->delete();

        // 2. Generate cryptographically secure 6-digit OTP
        $otp = (string) random_int(100000, 999999);

        // 3. Store hashed OTP in database with 10-minute validity
        EmailOtp::create([
            'email' => $email,
            'otp_hash' => Hash::make($otp),
            'expires_at' => now()->addMinutes(10),
            'attempts' => 0,
        ]);

        // 4. Send email via Resend API or Laravel Mailer
        $resendKey = config('services.resend.key');

        if (! empty($resendKey)) {
            $fromAddress = config('mail.from.address', 'mail@kinerja.web.id');
            $fromName = config('mail.from.name', 'Kinerja');

            try {
                $response = Http::withToken($resendKey)
                    ->timeout(10)
                    ->post('https://api.resend.com/emails', [
                        'from' => "{$fromName} <{$fromAddress}>",
                        'to' => [$email],
                        'subject' => 'Kode Verifikasi Masuk Kinerja: '.$otp,
                        'html' => view('emails.otp', ['otp' => $otp])->render(),
                    ]);

                if (! $response->successful()) {
                    /** @var array{message?: string, name?: string} $errBody */
                    $errBody = $response->json() ?? [];
                    $errMsg = $errBody['message'] ?? 'Gagal mengirim email (Status: '.$response->status().')';

                    Log::warning('Resend API error: '.$response->body());

                    throw new \RuntimeException($errMsg);
                }
            } catch (\RuntimeException $e) {
                throw $e;
            } catch (\Throwable $e) {
                Log::warning('Failed sending via Resend API: '.$e->getMessage());
                throw new \RuntimeException('Gagal menghubungi layanan surel: '.$e->getMessage());
            }
        } else {
            try {
                Mail::to($email)->send(new SendOtpMail($otp));
            } catch (\Throwable $mErr) {
                Log::info("OTP generated for {$email}: {$otp} (Mail driver unconfigured or local)");
            }
        }

        return $otp;
    }

    public function verify(string $email, string $otp): bool
    {
        $record = EmailOtp::where('email', $email)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (! $record) {
            return false;
        }

        if ($record->attempts >= 5) {
            $record->delete();

            return false;
        }

        if (! Hash::check($otp, $record->otp_hash)) {
            $record->increment('attempts');

            return false;
        }

        // Successfully verified, clean up token
        $record->delete();

        return true;
    }
}
