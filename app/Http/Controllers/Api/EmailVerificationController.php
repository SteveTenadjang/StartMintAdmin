<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function sendVerificationEmail(Request $request): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail())
        { return response()->executed('Already Verified'); }
        $request->user()->sendEmailVerificationNotification();
        return response()->executed('verification-link-sent');
    }

    public function verify(EmailVerificationRequest $request): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail())
        { return response()->executed('Email already verified'); }
        if ($request->user()->markEmailAsVerified())
        { event(new Verified($request->user())); }
        return response()->executed('Email has been verified');
    }
}
