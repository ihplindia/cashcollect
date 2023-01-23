<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;
use App\Models\Role;
use App\Models\SysetmLogs;
use App\Models\Permission;
use App\Models\Role_has_permissions;

class RoleController extends Controller
{
  public $role_name='';
  public $permission='';
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    $allRole=Role::orderBy('role_id','DESC')->get();
    return view('admin.role.all',compact('allRole'));
	}

  public function add()
  {
    $all_permissions  = Permission::all();
    $permission_groups = User::getpermissionGroups();
    return view('admin.role.add', compact('all_permissions','permission_groups'));
  }

  public function stored(Request $request)
  {
       // Validation Data
       $request->validate([
          'role_name' => 'required|max:100|unique:roles',
          ],
          [
              'role_name.requried' => 'Please give a role name'
        ]);
        $permission=$request->input('permissions');
        $permission =json_encode($permission);
        $array =array(
          'role_name'=>$request->role_name,
          'role_status'=>$request->status,
          'permission_list'=> $permission
        );
        $role=Role::insertGetId($array);
        if($role)
        {
          if(isset($request->role_name))
            $this->role_name=$request->role_name;            
          if(isset($permission))
            $this->permission=$permission;            
            $msg ='Create Role by '.Auth::user()->name.' Role Name is'.$request->role_name.' and Permissions'.$this->permission;
            $logs=SysetmLogs::insert([
                'action_id'   => $role,
                'user_id'   => Auth::user()->id,
                'user_ip'   => \request()->ip(),
                'title'     => 'Role '.$request->role_name,
                'action'      => $msg,
                'created_at' 	=> Carbon::now('Asia/Kolkata')
            ]);
            session()->flash('success', 'Role has been created !!');
            return back();
          }else{
            session()->flash('error', 'Ops try again !!');
            return back();
        }
      session()->flash('error', 'Ops try again !!');
        return back();
      
  }

  public function edit($role_id)
  {
    $all_permissions  = Permission::all();
    //$all_permissions  = DB::table('permissions')->select('permissions.id as pid','permissions.name','permission_groups.id as gid','permission_groups.group_name')->leftjoin('permission_groups','permission_groups.id','permissions.group_name')->get();
    // echo '<pre>';
    // print_r($role);
    // die;
    $permission_groups = User::getpermissionGroups();
    $role = Role::where('role_id',$role_id)->firstOrFail();
    return view('admin.role.edit',compact('role','all_permissions','permission_groups'));
  }
  
  public function update(Request $request)
  {
    $this->validate($request,[
        'role_name' => ['required', 'string', 'max:255'],
        'role_status' => ['required']
        ],[
          'role_name.required'=>'Please enter Role Name!',
          'role_status.required'=>'Please select status!',
        ]);
        $permission=$request->input('permissions');
        $permissions =json_encode($permission);
        extract($request->input());
        $array =array(
          'role_name'=>$role_name,
          'role_status'=>$role_status,
          'permission_list'=> $permissions,
          'updated_at' => Carbon::now()->toDateTimeString()
        );
        // print_r($array);
        // die;
        $data = Role::where('role_id',$role_id)->firstOrFail();
        $role = Role::where('role_id',$role_id)->update($array);
       
        if($role){
          if(isset($role_name))
            $this->role_name=$role_name;            
          if(isset($permission))
            $this->permission= json_encode($permission);            
          $msg ='Role modification '.Auth::user()->name.' Old data is (Name ='.$data->role_name.',permission='.$data->permission.') New Data is ('.$this->role_name.','.$this->permission.')';
          $logs=SysetmLogs::insert([
              'action_id'   => $role_id,
              'user_id'   => Auth::user()->id,
              'user_ip'   => \request()->ip(),
              'title'     => 'Role Name '.$data->role_name,
              'action'      => $msg,
              'created_at' 	=> Carbon::now('Asia/Kolkata')
          ]);
        Session::flash('success','Successfully registered user.');
        return redirect('dashboard/role/edit/'.$request->role_id);
      }else{
        Session::flash('error','Opps! please try again.');
        return redirect('dashboard/role/edit/'.$request->role_id);
      }

    }
}
