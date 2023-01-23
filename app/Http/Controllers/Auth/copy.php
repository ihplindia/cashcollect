<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\setting;
use App\Helper;
use Session;
use Illuminate\Support\Facades\Redirect;
class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $url_referer = url()->previous();
        return view('auth.login',['url_referer'=>$url_referer]);
    }
    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $url_referer = $request->input('url_referer');
        $request->authenticate();
        $request->session()->regenerate();
        //Mobile verification

                 $session = Role::select('permission_list')
                 ->where('role_id',Auth::user()->role)
                 ->firstOrFail();
                 $permission_list = $session['permission_list'];
                 $permission_list_arr = json_decode($permission_list);
                 $i = 0;
                 $permissionsArray = array();
                 $permissionsGroup = PermissionGroup::where('status',1)->orderBy('order_id','ASC')->get()->toArray();
                foreach($permissionsGroup as $key)
                {
                    $group_id = $key['id'];
                    $group_name = $key['group_name'];
                    $group_child = array();
                    $permissions = Permission::where('status',1)->where('group_name',$group_id)->orderBy('order_id','ASC')->get();
                    foreach($permissions as $perms)
                    {
                        $perm_id = $perms['id'];
                        if(in_array($perm_id,$permission_list_arr))
                        {
                            $guard_name = $perms['guard_name'];
                            $group_child[$guard_name] = $perms['name'];
                        }
                    }
                    if(count($group_child)>0)
                    {
                        $permissionsArray[$i]['url'] = Str::slug($group_name);
                        $permissionsArray[$i]['name'] = $group_name;
                        $permissionsArray[$i]['child'] = $group_child;
                    }
                    $i++;
                }
                $config_info = array();
                    $config = setting::all()->toArray();
                    foreach ($config as $con) {
                        $key = $con['key'];
                        $config_info[$key] = $con['value'];
                    }

                session()->put('config_info',$config_info);
                session()->put('navArray',$permissionsArray);
                $emailverify=Auth::User()->email_verified_at;
                $otp=Auth::User()->otp;
                if( $otp !==1)
                {
                    $sms=Helper::sendSmsOutBox(Auth::user()->phone,Auth::user()->id,Auth::user()->name);
                    // return view('auth.otp');
                    // return redirect()('https://cash.indianholiday.com/otp-verify');
                    return redirect()->away('https://cash.indianholiday.com/otp-verify');
                    // return route('otp-verify');
                }elseif(!empty($emailverify))
                {
                    // return redirect()('https://cash.indianholiday.com/verify-email');
                    return redirect()->away('https://cash.indianholiday.com/verify-email');
                    // return route()('/verify-email');
                }
                else
                {
                    die('Dash');
                    if($url_referer)
                    {
                        // die($url_referer);
                        //preg matching url set for verify email url
                        if(strpos('verify-email',$url_referer) !== false){
                            $url_referer;
                            return redirect($url_referer);
                        }
                        $url_referer.'out';
                        return view('admin.dashboard.index');
                    }
                    return view('admin.dashboard.index');
                }




        // return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function otpsend(){
        return view('auth.otp');
    }
    public function otpConfirm(Request $request)
    {
        $verify= User::where('otp',$request->otp)->update(['otp'=>1]);
        // die($verify);
        // $verify= User::where('id',$id)->update(['otp'=>'1']);
        if($verify){
            Session::flash('success','Phone Verified successfully.');
            return route('verify-email');
            // return view('admin.dashboard.index');
        }else{
            Session::flash('error','OTP ERROR');
            return view('auth.otp');
        }

    }
    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
