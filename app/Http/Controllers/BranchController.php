<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SysetmLogs;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;
use App\Models\Branch;
use App\Helper;

class BranchController extends Controller
{
    public $name='';
    public $company_id='';
    public $company_mail='';
    public $status='';
    public function index($slug)
    {
        if($slug=='add'){
            return view('companyinfo.branch');
        }
        $data = Branch::where('company_id',$slug)->get();
        return view('companyinfo.allbranch',compact('data'));
    }

    public function newbranch()
    {
        return view('companyinfo.branch');
    }

    public function storedBranch(Request $request)
    {
        extract($request->input());
        $insert=Branch::insertGetId([
            'name' => $name,
            'company_id'=>$company_id,
            'company_mail'=>$company_mail,
            'create_at' => Carbon::now('Asia/Kolkata')
        ]);
        if($insert)
        {
            $company=Helper::company_Name($company_id);
            $msg ='Name = '.$name.', '.$company.', Company Email = '.$company_mail.' )';
            $logs=SysetmLogs::insert([
                'action_id'   => $insert,
                'user_id'   => Auth::user()->id,
                'user_ip'   => \request()->ip(),
                'title'     => 'New Branch Create',
                'action'      => $msg,
                'created_at' 	=> Carbon::now('Asia/Kolkata')
            ]);
            session::flash('success','Branch Added Successfully');
            return redirect('dashboard/branch/'.$request['company_id']);
        }else{
            session::flash('error','OOPS Try again');
            return redirect('dashboard/branch/'.$request['company_id']);
        }
    }

    public function edit($id)
    {
        $edit= Branch::where('id',$id)->firstOrFail();
        return view('companyinfo.branch',compact('edit'));
    }

    public function update(Request $request)
    {
        extract($request->input());
        $array=array(
            'name' => $name,
            'company_id'=>$company_id,
            'company_mail'=>$company_mail,
            'status'=>$status,
            'updated_at' => Carbon::now('Asia/Kolkata')
        );
        $data=Branch::where('id',$id)->firstOrFail();
        $upbranch=Branch::where('id',$id)->update($array);
        if($upbranch)
        {
            if(isset($name))
                $this->name=$name;

            if(isset($company_id))
                $this->company_id=Helper::company_Name($company_id);

            if(isset($company_mail))
                $this->company_mail=$company_mail;

            if(isset($status))
                $this->status=$status;

                $company=$data->company_id;
                $company=$data->status;
                $company=Helper::company_Name($company);
                $Status=Helper::Status($status);

            $msg ='Name = '.$data->name.' > '.$this->name.' , Company Name = '.$company.' > '.$this->company_id.' , Company mail'.$data->company_mail.' > '.$this->company_mail.' , status = '.$status.' > '.$this->status;
            $logs=SysetmLogs::insert([
                'action_id'   => $id,
                'user_id'   => Auth::user()->id,
                'user_ip'   => \request()->ip(),
                'title'     => 'Branch Modification',
                'action'      => $msg,
                'created_at' 	=> Carbon::now('Asia/Kolkata')
            ]);
            session::flash('success','Branch updated Successfully');
            return redirect('dashboard/branch/'.$request['company_id']);
        }else{
            session::flash('error','OOPS Try again');
            return redirect('dashboard/branch/'.$request['company_id']);
        }
    }
}
