<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\Response;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function sendVerificationEmail(Request $request): array
    {
        if ($request->user()->hasVerifiedEmail())
        { return (new Response)->executed('Already Verified'); }
        $request->user()->sendEmailVerificationNotification();
        return (new Response)->executed('verification-link-sent');
    }

    public function verify(EmailVerificationRequest $request): array
    {
        if ($request->user()->hasVerifiedEmail())
        { return (new Response)->executed('Email already verified'); }
        if ($request->user()->markEmailAsVerified())
        { event(new Verified($request->user())); }
        return (new Response)->executed('Email has been verified');
    }
}
