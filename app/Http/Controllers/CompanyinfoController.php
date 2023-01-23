<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;
use App\Models\SysetmLogs;
use App\Models\Companyinfo;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Setting;
use App\Helper;

class CompanyinfoController extends Controller
{
    public $name='';
    public $status='';
    public $parent='';
    public function index()
    {
        $company=Companyinfo::get();
        return view('companyinfo.all',compact('company'));
    }

    public function add()
    {
        return view('companyinfo.add');
    }

    public function insert(Request $request)
    {
        extract($request->input());
        $insert=Companyinfo::insertGetId([
            'name' => $name,
            'status' => 1
        ]);
        if($insert)
        {
            $status =Helper::Status($status);
            $msg ='name = '.$name.', status = '.$status.')';
            $logs=SysetmLogs::insert([
                'action_id'   => $insert,
                'user_id'   => Auth::user()->id,
                'user_ip'   => \request()->ip(),
                'title'     => 'New Company Create',
                'action'      => $msg,
                'created_at' 	=> Carbon::now('Asia/Kolkata')
            ]);
            session::flash('success','Data Added Successfully');
            return redirect('dashboard/companyinfo');
        }else{
            session::flash('error','OOPS Try again');
            return redirect('dashboard/companyinfo');
        }
    }
    public function branch()
    {
        return view('companyinfo.branch');
    }

    public function editcompany($id)
    {
        $edit=Companyinfo::where('id',$id)->firstOrFail();
        return view('companyinfo.add',compact('edit'));
    }


    public function update(Request $request)
    {
        extract($request->input());
        $array=array(
            'name' => $name,
            'status'=>$status
        );
        $data=Companyinfo::where('id',$id)->firstOrFail();
        $update=Companyinfo::where('id',$id)->update($array);
        if($update)
        {
            if(isset($name))
                $this->name=$name;

            if(isset($status))
                $this->status=Helper::Status($status);

            $status =Helper::Status($data->status);
            $msg ='Name = '.$data->name.' > '.$this->name.' , status = '.$status.'>'.$this->status;

            $logs=SysetmLogs::insert([
                'action_id'   => $id,
                'user_id'   => Auth::user()->id,
                'user_ip'   => \request()->ip(),
                'title'     => 'Company Name Modification',
                'action'      => $msg,
                'created_at' 	=> Carbon::now('Asia/Kolkata')
            ]);
            session::flash('success','Company Modified Successfully');
            return redirect('dashboard/companyinfo');
        }else{
            session::flash('error','OOPS Try again');
            return redirect('dashboard/companyinfo');
        }

    }

    // public function addbranch(Request $request)
    // {
    //     die;
    //     extract($request->input());
    //     $insert=Companyinfo::insertGetId([
    //         'name' => $name,
    //         'parent' => $parent
    //     ]);
    //     if($insert)
    //     {
    //         $msg ='New Branch added by '. Auth::user()->name.' Data('.$name.','.$parent.')';
    //         $logs=SysetmLogs::insert([
    //             'action_id'   => $insert,
    //             'user_id'   => Auth::user()->id,
    //             'user_ip'   => \request()->ip(),
    //             'title'     => 'New Branch added',
    //             'action'      => $msg,
    //             'created_at' 	=> Carbon::now('Asia/Kolkata')
    //         ]);
    //         session::flash('success','Data Added Successfully');
    //         return redirect('dashboard/companyinfo');
    //     }else{
    //         session::flash('error','OOPS Try again');
    //         return redirect('dashboard/companyinfo');
    //     }
    // }

    // //Branch edit
    // public function editbranch($id)
    // {
    //     $branch=Companyinfo::where('id',$id)->firstOrFail();
    //     return view('companyinfo.editbranch',compact('branch'));
    // }

    // public function updatebranch(Request $request)
    // {
    //     extract($request->input());
    //     $data = Companyinfo::where('id',$id)->firstOrFail();
    //     $update = Companyinfo::findOrFail($id);
    //     $update->name   = $name;
    //     $update->parent  = $parent;
    //     $update->status   = $status;
    //     $update->updated_at = Carbon::now()->toDateTimeString();
    //     if($update->update())
    //     {
    //         if(isset($name))
    //             $this->name=$name;
    //         if(isset($status))
    //             $this->parent=$parent;
    //         if(isset($status))
    //             $this->status=$status;
    //         $msg ='Branch Modification by '. Auth::user()->name.'Old Data('.$data->name.','.$data->parent.','.$data->status.') New Data('.$this->name.','.$this->parent.','.$this->status.')';
    //         $logs=SysetmLogs::insert([
    //             'action_id'   => $insert,
    //             'user_id'   => Auth::user()->id,
    //             'user_ip'   => \request()->ip(),
    //             'title'     => 'Branch Modification',
    //             'action'      => $msg,
    //             'created_at' 	=> Carbon::now('Asia/Kolkata')
    //         ]);
    //         session::flash('success','Data Added Successfully');
    //         return redirect('dashboard/companyinfo');
    //     }else{
    //         session::flash('error','OOPS Try again');
    //         return redirect('dashboard/companyinfo/branch');
    //     }
    // }
}
