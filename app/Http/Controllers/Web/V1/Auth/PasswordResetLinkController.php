<?php

namespace App\Http\Controllers\Web\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Throwable;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('backend.auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        try {
            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            $status = Password::sendResetLink(
                $request->only('email')
            );

            return $status == Password::RESET_LINK_SENT
                ? back()->with('status', 'We have emailed your password reset link!')
                : back()->withInput($request->only('email'))
                    ->withErrors(['email' => __($status)]);
        } catch (Throwable $e) {
            Log::error('Password reset email sending failed via SMTP: ' . $e->getMessage(), [
                'email'     => $request->input('email'),
                'exception' => $e,
            ]);

            // In local or testing environments, gracefully fallback to log mailer so development is not blocked by invalid external SMTP credentials
            if (app()->environment('local', 'testing')) {
                $user = User::where('email', $request->input('email'))->first();

                if ($user) {
                    try {
                        Mail::purge();
                        Config::set('mail.default', 'log');

                        $token = Password::broker()->createToken($user);
                        $user->notify(new ResetPasswordNotification($token));

                        $resetUrl = url(route('password.reset', [
                            'token' => $token,
                            'email' => $user->email,
                        ], false));

                        Log::channel('single')->info('=========================================');
                        Log::channel('single')->info('[LOCAL DEV] Password reset link for ' . $user->email . ': ' . $resetUrl);
                        Log::channel('single')->info('=========================================');

                        return back()->with('status', 'We have emailed your password reset link!');
                    } catch (Throwable $fallbackError) {
                        Log::error('Local fallback mailer also failed: ' . $fallbackError->getMessage());
                    }
                }
            }

            $errorMessage = 'Failed to send password reset email. ';
            if (str_contains($e->getMessage(), '535') || str_contains($e->getMessage(), 'BadCredentials')) {
                $errorMessage .= 'SMTP authentication failed (535 Bad Credentials). Please verify your SMTP settings in Settings > Mail Configuration.';
            } else {
                $errorMessage .= 'Please verify your SMTP mail configuration or try again later.';
            }

            return back()->withInput($request->only('email'))
                ->withErrors(['email' => $errorMessage]);
        }
    }
}
