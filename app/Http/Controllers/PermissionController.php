<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use Carbon\Carbon;
use Session;

class PermissionController extends Controller
{
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
          'guard_name' => ['required'],
          'group_name' => ['required', 'string','max:255'],
          'status' => ['required']
        ],[
          'name.required'=>'Please enter name!',
          'guard_name.required'=>'Please enter Gaurd Name!',
          'group_name.required'=>'Please enter Group!',
          'status.required'=>'Please select status!',
        ]);
        $insert=Permission::insertGetId([
          'name'=>$request['name'],
          'guard_name'=>$request['guard_name'],
          'group_name'=>$request['group_name'],
          'status'=>$request['status'],
          'created_at' => Carbon::now()->toDateTimeString()
        ]);

        if($insert){
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
            'guard_name' => ['required'],
            'group_name' => ['required', 'string','max:255'],
            'status' => ['required']
          ],[
            'name.required'=>'Please enter name!',
            'guard_name.required'=>'Please enter Gaurd Name!',
            'group_name.required'=>'Please enter Group!',
            'status.required'=>'Please select status!',
          ]);
        $user = Permission::findOrFail($request->user_id);
        $user->name   = $request->name;
        $user->guard_name  = $request->guard_name;
        $user->group_name  = $request->group_name;
        $user->status   = $request->status;
        $user->updated_at = Carbon::now()->toDateTimeString();

        if($user->update()){
        Session::flash('success','Successfully registered user.');
        return redirect('dashboard/permission/edit/'.$request->user_id);
      }else{
        Session::flash('error','Opps! please try again.');
        return redirect('dashboard/permission/edit/'.$request->user_id);
      }

    }

}
