<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use app\Models\User;
use Carbon\Carbon;
use Session;
use Image;

class UserController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
       $allUser=User::orderBy('id','DESC')->get();
       return view('admin.user.all',compact('allUser'));
    }

    public function add(){
        return view('admin.user.add');
    }
    
    public function edit($id){
      $data = User::where('id',$id)->firstOrFail();
      return view('admin.user.edit',compact('data'));
    }

    public function password($id){
      $data = User::where('id',$id)->firstOrFail();
      return view('admin.user.password',compact('data'));
    }
    
    public function view($id){
      $data = User::where('id',$id)->firstOrFail();
      //$role = User::find($id)->roleInfo;
      //print_r($role->role_name);
      return view('admin.user.view',compact('data'));
    }
    
    public function insert(Request $request)
    {
        $this->validate($request,[
          'name' => ['required', 'string', 'max:255'],
          'phone' => ['required'],
          'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
          'password' => ['required', 'confirmed', Rules\Password::defaults()],
          'password_confirmation' => ['required'],
          'status' => ['required'],
          'role' => ['required'],
        ],[
          'name.required'=>'Please enter name!',
          'email.required'=>'Please enter email address!',
          'phone.required'=>'Please enter phone Number!',
          'password.required'=>'Please enter password!',
          'password_confirmation.required'=>'Please confirm password!',
          'status.required'=>'Please select status!',
          'role.required'=>'Please select role!',
        ]);

        $insert=User::insertGetId([
          'name'=>$request['name'],
          'phone'=>$request['phone'],
          'email'=>$request['email'],
          'password'=>Hash::make($request['password']),
          'status'=>$request['status'],
          'role'=>$request['role'],
          'created_at'=>Carbon::now()->toDateTimeString(),
        ]);

        if($request->hasFile('pic')){
          $image=$request->file('pic');
          $imageName=$insert.time().'.'.$image->getClientOriginalExtension();
          Image::make($image)->resize(300,300)->save('uploads/users/'.$imageName);

          User::where('id',$insert)->update([
            'photo'=>$imageName,
          ]);
        }

        if($insert){
          Session::flash('success','Successfully registered user.');
          return redirect('dashboard/user/add');
        }else{
          Session::flash('error','Opps! please try again.');
          return redirect('dashboard/user/add');
        }
    }
    
    public function update(Request $request)
    {
      $this->validate($request,[
        'name' => ['required', 'string', 'max:255'],
        'phone' => ['required'],
        'email' => ['required', 'string', 'email', 'max:255'],
        'role' => ['required'],
      ],[
        'name.required'=>'Please enter name!',
        'email.required'=>'Please enter email address!',
        'phone.required'=>'Please enter phone Number!',
        'role.required'=>'Please select role!',
      ]);

      $user = User::findOrFail($request->user_id);
      $user->name   = $request->name;
      $user->phone  = $request->phone;
      $user->email  = $request->email;
      $user->role   = $request->role;
      $user->updated_at = Carbon::now()->toDateTimeString();

      if($user->update()){
        // update image if uploaded
        if($request->hasFile('pic')){
          $image=$request->file('pic');
          $imageName=$request->user_id.time().'.'.$image->getClientOriginalExtension();
          Image::make($image)->resize(300,300)->save('uploads/users/'.$imageName);
  
          User::where('id',$request->user_id)->update([
            'photo'=>$imageName,
          ]);
        }

        Session::flash('success','Successfully registered user.');
        return redirect('dashboard/user/edit/'.$request->user_id);
      }else{
        Session::flash('error','Opps! please try again.');
        return redirect('dashboard/user/edit/'.$request->user_id);
      }

    }

    public function updatePassword(Request $request)
    {
      $this->validate($request,[
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'password_confirmation' => ['required'],
      ],[
        'password.required'=>'Please enter password!',
        'password_confirmation.required'=>'Please confirm password!',
      ]);

      $user = User::findOrFail($request->user_id);
      $user->password = Hash::make($request->password);
      $user->updated_at = Carbon::now()->toDateTimeString();

      if($user->update()){
        Session::flash('success','Password changed successfully.');
        return redirect('dashboard/user/password/'.$request->user_id);
      }else{
        Session::flash('error','Opps! please try again.');
        return redirect('dashboard/user/password/'.$request->user_id);
      }

    }
}
