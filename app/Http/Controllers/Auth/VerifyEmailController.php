<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\SysetmLogs;
use App\Helper;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            $id=Auth::user()->id;
            $logs=SysetmLogs::insert([
                'action_id'   => $id,
                'user_id'   => $id,
                'user_ip'   => \request()->ip(),
                'title'     => 'Mail Verification',
                'action'      => 'Mail verification Done',
                'created_at'    => Carbon::now('Asia/Kolkata')
            ]); 
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            $id=Auth::user()->id;
            $logs=SysetmLogs::insert([
                'action_id'   => $id,
                'user_id'   => $id,
                'user_ip'   => \request()->ip(),
                'title'     => 'Mail Verification',
                'action'      => 'Mail verification Done',
                'created_at'    => Carbon::now('Asia/Kolkata')
            ]); 
            event(new Verified($request->user()));
        }

               
        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }
}
