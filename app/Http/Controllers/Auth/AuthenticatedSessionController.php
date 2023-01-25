<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
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
use App\Models\SysetmLogs;
use App\Helper;
use Session;
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

        //Mobile verification
        $emailverify=Auth::User()->email_verified_at;
        $otp=Auth::User()->otp;

        if($otp!=1){
            $sms=Helper::sendSmsOutBox(Auth::user()->phone,Auth::user()->id,Auth::user()->name);
            return view('auth.otp');
        }

        //Email verification
        if(empty($emailverify))
        {
            return redirect('verify-email');
        }
        if($url_referer)
        {
            //preg matching url set for verify email url
            if(strpos('verify-email',$url_referer) !== false){
                $url_referer;
                return redirect($url_referer);
            }
            $url_referer.'out';
            return view('admin.dashboard.index');
        }
        else
        {
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
            $ip='';
            if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
            $id=Auth::user()->id;
            $logs=SysetmLogs::insert([
                'action_id'   => $id,
                'user_id'   => $id,
                'user_ip'   => \request()->ip(),
                'title'     => $request->otp.'OTP Verification',
                'action'      => 'Phone verification succussfully  ',
                'created_at' 	=> Carbon::now('Asia/Kolkata')
            ]);
            Session::flash('success','Phone Verified successfully.');
            return redirect('verify-email');
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
