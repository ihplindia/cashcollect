<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SysetmLogs;
use App\Models\PermissionGroup;
use Carbon\Carbon;
use Session;

class PermissionGroupController extends Controller
{
  public $group_name='';
  public $status='';
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $allpermission=PermissionGroup::orderBy('id')->get();
        return view('admin.permission.permissiongroup.all',compact('allpermission'));
    }
    public function add(){
        return view('admin.permission.permissiongroup.add');
    }

    public function insert(Request $request)
    {
        $this->validate($request,[
          'group_name' => ['required', 'string','max:255'],
          'status' => ['required']
        ],[
          'group_name.required'=>'Please enter Group!',
          'status.required'=>'Please select status!',
        ]);
        extract($request->input());
        $insert=PermissionGroup::insertGetId([
          'group_name'  =>  $group_name,
          'status'      =>  $status,
          'created_at'  =>  Carbon::now()->toDateTimeString()
        ]);
        if($insert){
          if(isset($request->role_name))
            $this->role_name=$request->role_name;            
          if(isset($permission))
            $this->permission=$permission;            
            $msg ='New Permission Group added by '. Auth::user()->name.' Name is '.$group_name;
            $logs=SysetmLogs::insert([
                'action_id'   => $insert,
                'user_id'   => Auth::user()->id,
                'user_ip'   => \request()->ip(),
                'title'     => 'New Permission added',
                'action'      => $msg,
                'created_at' 	=> Carbon::now('Asia/Kolkata')
            ]);
          Session::flash('success','Permission group added successfully.');
          return redirect('dashboard/permission/group');
        }else{  
          Session::flash('error','Opps! please try again.');
          return redirect('dashboard/permission/permissiongroup/add');
        }
    }

    public function edit($id){
        $data = PermissionGroup::where('id',$id)->firstOrFail();
        return view('admin.permission.permissiongroup.edit',compact('data'));
    }

    
    public function update(Request $request)
    {
        $this->validate($request,[
            'group_name' => ['required', 'string','max:255'],
            'status' => ['required']
          ],[
            'group_name.required'=>'Please enter Group!',
            'status.required'=>'Please select status!',
          ]);
        extract($request->input());
        $data = PermissionGroup::where('id',$id)->firstOrFail();
        $upgroup = PermissionGroup::findOrFail($id);
        $upgroup->group_name  = $group_name;  
        $upgroup->status      = $status;
        $upgroup->updated_at  = Carbon::now()->toDateTimeString();

        if($upgroup->update()){
          if(isset($group_name))
          $this->group_name=$group_name;
          $msg ='Permission Group modification '.Auth::user()->name.' Old data is ('.$data->group_name.','.$data->status.') New Data is ('.$this->group_name.','.$this->status.')';
          $logs=SysetmLogs::insert([
              'action_id'   => $id,
              'user_id'   => Auth::user()->id,
              'user_ip'   => \request()->ip(),
              'title'     => 'Permission Group Modification',
              'action'      => $msg,
              'created_at' 	=> Carbon::now('Asia/Kolkata')
          ]);
          Session::flash('success',' Permissio Group  Updated successfully .');
          return redirect('dashboard/permission/group');
        }else{
          Session::flash('error','Opps! please try again.');
          return redirect('dashboard/permission/group/edit/'.$request->id);
        }

    }

}
