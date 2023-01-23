<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\SysetmLogs;
use Carbon\Carbon;
use Session;

class PermissionController extends Controller
{
    public $name='';
    public $guard_name='';
    public $group_name='';
    public $pr_details='';
    public $status='';
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $allpermission=Permission::orderBy('id')->get();
        return view('admin.permission.all',compact('allpermission'));
    }
    public function add(){
        return view('admin.permission.add');
    }

    public function insert(Request $request)
    {
        $this->validate($request,[
          'name' => ['required', 'string', 'max:255'],
          'guard_name' => ['required', 'string', 'max:255'],
          'group_name' => ['required', 'string','max:255'],
          'status' => ['required']
        ],[
          'name.required'=>'Please enter Child Name Name!',
          'guard_name.required'=>'Please enter View Name!',
          'group_name.required'=>'Please enter Group!',
          'status.required'=>'Please select status!',
        ]);
        extract($request->input());
        $insert=Permission::insertGetId([
          'name'        =>  $name,
          'guard_name'  =>  $guard_name,
          'group_name'  =>  $group_name,
          'pr_details'  =>  $pr_details,
          'status'      =>  $status,
          'created_at'  =>  Carbon::now()->toDateTimeString()
        ]);
        if($insert){         
            $msg ='New Permission added by '. Auth::user()->name.'('.$name.','.$guard_name.','.$group_name.','.$pr_details.','.$status.')';
            $logs=SysetmLogs::insert([
                'action_id'   => $insert,
                'user_id'   => Auth::user()->id,
                'user_ip'   => \request()->ip(),
                'title'     => 'Permission '.$name,
                'action'      => $msg,
                'created_at' 	=> Carbon::now('Asia/Kolkata')
            ]);
          Session::flash('success','Successfully Permission Added.');
          return redirect('dashboard/permission');
        }else{  
          Session::flash('error','Opps! please try again.');
          return redirect('dashboard/permission/add');
        }
    }

    public function edit($id){
        $data = Permission::where('id',$id)->firstOrFail();
        return view('admin.permission.edit',compact('data'));
    }

    
    public function update(Request $request)
    {
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'guard_name' => ['required', 'string', 'max:255'],
            'group_name' => ['required', 'string','max:255'],
            'status' => ['required']
          ],[
            'name.required'=>'Please enter Child Name Name!',
            'guard_name.required'=>'Please enter View Name!',
            'group_name.required'=>'Please enter Group!',
            'status.required'=>'Please select status!',
          ]);
        extract($request->input());
        $data = Permission::where('id',$user_id)->firstOrFail();
        $user = Permission::findOrFail($user_id);
        $user->name         = $name;
        $user->guard_name   = $guard_name;
        $user->group_name   = $group_name;
        $user->pr_details   = $pr_details;
        $user->status       = $status;
        $user->updated_at   = Carbon::now()->toDateTimeString();
        
        if($user->update()){
          if(isset($name))
            $this->name=$name;
            if(isset($guard_name))
            $this->guard_name=$guard_name;
            if(isset($group_name))
            $this->group_name=$group_name;
            if(isset($pr_details))
            $this->pr_details=$pr_details;
            if(isset($status))
            $this->status=$status;
          $msg ='Permission Modification by '. Auth::user()->name.'Old Data (Name='.$data->name.',Guard Name='.$data->guard_name.',group name='.$data->group_name.',Details='.$data->pr_details.',status='.$data->status.') and New Data('.$this->name.','.$this->guard_name.','.$this->group_name.','.$this->pr_details.','.$this->status.')';
            $logs=SysetmLogs::insert([
                'action_id'   => $user_id,
                'user_id'   => Auth::user()->id,
                'user_ip'   => \request()->ip(),
                'title'     => 'Permission '.$data->name,
                'action'      => $msg,
                'created_at' 	=> Carbon::now('Asia/Kolkata')
            ]);

        Session::flash('success','Permission Updated successfully.');
        return redirect('dashboard/permission');
      }else{
        Session::flash('error','Opps! please try again.');
        return redirect('dashboard/permission/edit/'.$request->user_id);
      }
    }

    public function permissionDelete()
    {
        $id = $_POST['id'];
        $delete = Permission::find($id)->delete();
        if($delete)
        {
          Session::flash('success','successfully delete income information');
          return redirect('dashboard/permission');
        }else{
          Session::flash('error','Opps! try again!');
          return redirect('dashboard/permission');
        }
    }
}
