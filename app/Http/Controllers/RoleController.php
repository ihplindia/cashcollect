<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{

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
          ], [
              'role_name.requried' => 'Please give a role name'
          ]);
      $role=Role::create(['role_name'=>$request->role_name,'status'=>$request->status, 'gaurd_name'=>'admin']);
      
      //$permission=$request->input('permissions');
      // print_r($permission); die;
        session()->flash('success', 'Role has been created !!');
        return back();
  }

  public function edit($role_id)
  {
    $data = Role::where('role_id',$role_id)->firstOrFail();
    return view('admin.role.edit',compact('data'));
  }
  
  public function update(Request $request)
  {
    $this->validate($request,[
        'role_name' => ['required', 'string', 'max:255'],
        'role_slug' => ['required'],
        'role_status' => ['required']
        ],[
          'role_name.required'=>'Please enter Role Name!',
          'role_slug.required'=>'Please enter Slug Name!',
          'role_status.required'=>'Please select status!',
        ]);            
        $role = Role::findOrFail($request->role_id);
        //$role = Role::find($request->role_id);
        print_r($role); die;
        $role->role_name   = $request->role_name;
        $role->role_slug  = $request->role_slug;
        $role->role_status   = $request->role_status;
        $role->updated_at = Carbon::now()->toDateTimeString();
          
        if($role->update()){
        Session::flash('success','Successfully registered user.');
        return redirect('dashboard/role/edit/'.$request->role_id);
      }else{
        Session::flash('error','Opps! please try again.');
        return redirect('dashboard/role/edit/'.$request->role_id);
      }

    }
}
