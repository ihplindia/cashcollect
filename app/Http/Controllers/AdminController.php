<?php
namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
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
use App\Helper;

class AdminController extends Controller
{
    public function __construct()
    {
        // die('app\Http\Controllers\AdminController.php');


        $this->middleware('auth');
    }

    public function index()
    {
        $otp=Auth::User()->otp;
        if(empty($otp) || $otp!=1){
            $sms=Helper::sendSmsOutBox(Auth::user()->phone,Auth::user()->id,Auth::user()->name);
            return view('auth.otp');
        }
        //Email verification
        if(empty(Auth::User()->email_verified_at))
        {
            return redirect('verify-email');
        }
        // die('dashboard');
        return view('admin.dashboard.index');
    }

}
