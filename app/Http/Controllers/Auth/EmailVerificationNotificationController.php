<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\SysetmLogs;
use App\Helper;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        $request->user()->sendEmailVerificationNotification();
        $id=Auth::user()->id;
            $logs=SysetmLogs::insert([
                'action_id'   => $id,
                'user_id'   => $id,
                'user_ip'   => \request()->ip(),
                'title'     => 'Mail Verification',
                'action'      => 'Send verification link mail',
                'created_at'    => Carbon::now('Asia/Kolkata')
            ]);

        return back()->with('status', 'verification-link-sent');
    }
}
