<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use App\Http\Requests\SendPasswordResetLinkRequest;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Support\Facades\DB;

class PasswordResetController extends Controller
{
    public function requestForm(): InertiaResponse
    {
        return Inertia::render('Auth/ForgotPassword');
    }

    public function sendLink(SendPasswordResetLinkRequest $request): RedirectResponse
    {
        $status = Password::sendResetLink($request->validated());

        return back()->with('status', __($status));
    }

    public function resetForm(Request $request, string $token): InertiaResponse
    {
        return Inertia::render('Auth/ResetPassword', ['token' => $token, 'email' => $request->query('email')]);
    }

    public function reset(ResetPasswordRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $status = Password::reset($validated, function ($user, string $password): void {
            DB::transaction(function () use ($user, $password): void {
                $user->forceFill(['password' => Hash::make($password), 'remember_token' => Str::random(60)])->save();
                event(new PasswordReset($user));
            });
        });

        return $status === Password::PASSWORD_RESET
            ? to_route('login')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}
