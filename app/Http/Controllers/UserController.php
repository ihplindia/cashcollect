<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use app\Models\User;
use App\Models\SysetmLogs;
use Carbon\Carbon;
use App\Helper;
use Session;
use Auth;
use Image;

class UserController extends Controller{

    public $name ='';
    public $phone ='';
    public $email ='';
    public $password ='';
    public $status='';
    public $role ='';
    public $company_id ='';
    public $branch_id ='';
    public $department_id ='';
    public $admin_view ='';
    public $imageName ='';

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
      $allUser=User::orderBy('id','DESC')->get();
      return view('admin.user.all',compact('allUser'));
    }

    public function add(){

      return view('admin.user.edit');
    }

    public function edit($id){
      $data = User::where('id',$id)->firstOrFail();
      return view('admin.user.edit',compact('data'));
    }

    public function password($id){
      $data = User::where('id',$id)->firstOrFail();
      return view('admin.user.password',compact('data'));
    }

    public function view($id)
    {
      $data = User::where('id',$id)->firstOrFail();
      //$role = User::find($id)->roleInfo;
      //print_r($role->role_name);
      return view('admin.user.view',compact('data'));
    }

    public function userProfile()
    {
      $data = User::where('id',Auth::user()->id)->firstOrFail();
      return view('admin.user.userprofile',compact('data'));
    }

    public function insert(Request $request)
    {
        $this->validate($request,[
          'name' => ['required', 'string', 'max:255'],
          'phone' => ['required'],
          'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
          'password' => ['required', Rules\Password::defaults()],
          'status' => ['required'],
          'role' => ['required'],
          'company_id' => ['required'],
          'department_id' => ['required'],
        ],[
          'name.required'=>'Please enter name!',
          'email.required'=>'Please enter email address!',
          'phone.required'=>'Please enter phone Number!',
          'password.required'=>'Please enter password!',
          'status.required'=>'Please select status!',
          'role.required'=>'Please select role!',
          'company_id.required'=>'Please select Company!',
          'department_id.required'=>'Please select Department!',
        ]);
        extract($request->input());
       // print_r($request->input()); die;
        $insert=User::insertGetId([
          'name'=>$name,
          'phone'=>$phone,
          'email'=>$email,
          'password'=>Hash::make($password),
          'status'=>$status,
          'role'=>$role,
          'company_id'=>$company_id,
          'branch_id'=>$branch_id,
          'department_id'=>$department_id,
          'admin_view'=>$admin_view,
          'created_at'=>Carbon::now()->toDateTimeString(),
        ]);

        if($request->hasFile('pic')){
          $image  = $request->file('pic');
          $imageName=$insert.time().'.'.$image->getClientOriginalExtension();
          Image::make($image)->resize(300,300)->save('uploads/users/'.$imageName);
          User::where('id',$insert)->update([
            'photo'=>$imageName,
          ]);
        }

        if($insert){
            if(isset($name))
                $this->name=$name;

            if(isset($phone))
                $this->phone=$phone;

            if(isset($email))
                $this->email=$email;

            if(isset($password))
                $this->password=$password;

            if(isset($status))
                $this->status=$status;

            if(isset($role))
                $this->role=Helper::Role_Name($role);

            if(isset($company_id))
                $this->company_id=Helper::company_Name($company_id);

            if(isset($branch_id))
                $this->branch_id==Helper::Branch_Name($branch_id);

            if(isset($department_id))
                $this->department_id=Helper::deparmentsName($department_id);

            if(isset($imageName))
                $this->imageName=$imageName;

                $admin_View =$admin_view;
                $admin_View=Helper::Admin_View($admin_View);
            // $admin_View=Helper::Admin_View($this->admin_view);

            $msg ='Name= '.$this->name.', Phone= '.$this->phone.', mail= '.$this->email .', password= '.$this->password.', status= '.$this->status.', role= '.$this->role.', Company= '.$this->company_id.', branch '.$this->branch_id.', Department= '.$this->department_id.', User type = '.$admin_View .', Pic= '. $this->imageName;

            $logs=SysetmLogs::insert([
                'action_id'   => $insert,
                'user_id'   => Auth::user()->id,
                'user_ip'   => \request()->ip(),
                'title'     => 'New User Create',
                'action'      => $msg,
                'created_at' 	=> Carbon::now('Asia/Kolkata')
            ]);
          Session::flash('success','Successfully  User Added.');
          return redirect('dashboard/user');
        }else{
          Session::flash('error','Opps! please try again.');
          return redirect('dashboard/user/add');
        }
    }

    public function update(Request $request)
    {
      $array=array(
          'name'=>$request['name'],
          'phone'=>$request['phone'],
          'email'=>$request['email'],
          // 'password'=>Hash::make($request['password']),
          'status'=>$request['status'],
          'role'=>$request['role'],
          'company_id'=>$request['company_id'],
          'branch_id'=>$request['branch_id'],
          'department_id'=>$request['department_id'],
          'admin_view'=>$request['admin_view'],
          'updated_at'=>Carbon::now()->toDateTimeString(),
      );
      $userData = User::where('id',$request->id)->firstOrFail();
      $user = User::where('id',$request->id)->update($array);
      if($user){
        // update image if uploaded
        if($request->hasFile('pic')){
          $image=$request->file('pic');
          $imageName=$request->id.time().'.'.$image->getClientOriginalExtension();
          Image::make($image)->resize(300,300)->save('uploads/users/'.$imageName);
          User::where('id',$request->id)->update([
            'photo'=>$imageName,
          ]);
            if(strcmp($imageName,$userData->photo))
            $this->imageName=$imageName;
          }
          extract($request->input());
          if(isset($name))
            $this->name=$name;
          if(isset($name))
            $this->phone=$phone;

          if(isset($email))
            $this->email=$email;

          if(isset($status))
            $this->status=Helper::paymentStatus($status);

          if(isset($role))
            $this->role = Helper::Role_Name($role);

            if(isset($company_id))
            $this->company_id=Helper::company_Name($company_id);

            if(isset($branch_id))
                $this->branch_id=Helper::Branch_Name($branch_id);

            if(isset($department_id))
            $this->department_id=Helper::deparmentsName($department_id);

          if(isset($admin_view))
            $this->admin_view=Helper::Admin_View($admin_view);

            $company= Helper::company_Name($company_id);
            $branch=Helper::Branch_Name($branch_id);
            $department=Helper::deparmentsName($department_id);
            $status=Helper::paymentStatus($userData->status);
            $role=Helper::Role_Name($role);

            $msg = 'Name = '.$userData->name.' > '.$this->name. ', Phone = '.$userData->phone .' > '. $this->phone.', Email' .$userData->email.' > '.$this->email.' > ' .$userData->email .', Status = '.$status.' > '.$this->status.', Role = '.$role.' > '.$this->role.', Company Name = '.$company.' > '.$this->company_id.', Branch Name = '.$branch.' > '.$this->branch_id.' , Department Name = '.$department.' > '.$this->department_id.', User type = '.$admin_view.' > '.$this->admin_view;

            $logs = SysetmLogs::insert([
              'action_id'   => $id,
              'user_id'     => Auth::user()->id,
              'user_ip'     => \request()->ip(),
              'title'       => 'User Modification ',
              'action'      => $msg,
              'created_at'  => Carbon::now('Asia/Kolkata')
            ]);
        Session::flash('success',' User Modification Successfully ');
        return redirect('dashboard/user');
      }else{
        Session::flash('error','Opps! please try again.');
        return redirect('dashboard/user');
      }

    }
    public function SetPassword($slug)
    {
      // die($slug);
      $user = User::where('id',$slug)->firstOrFail();
      return view('admin.user.password',compact('user'));
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
      extract($request->input());
      $user = User::findOrFail($id);
      $user->password = Hash::make($password);
      $user->updated_at = Carbon::now()->toDateTimeString();

      if($user->update()){
        if(isset($name))
            $this->name=$name;
        if(isset($password))
            $this->password=$password;
            $msg ='User ID = '.$id.' and password = '.$this->password;
            $logs=SysetmLogs::insert([
                'action_id'   => $id,
                'user_id'   => Auth::user()->id,
                'user_ip'   => \request()->ip(),
                'title'     => 'Reset Password',
                'action'      => $msg,
                'created_at' 	=> Carbon::now('Asia/Kolkata')
            ]);
        Session::flash('success','Password changed successfully.');
        return redirect('dashboard/user');
      }else{
        Session::flash('error','Opps! please try again.');
        return redirect('dashboard/user/password');
      }
    }

    public function searchData(Request $request)
    {
      dd($request->input());
    }
}
