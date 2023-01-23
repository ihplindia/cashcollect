<?php


namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SysetmLogs;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;
use App\Models\Department;


class DepartmentController extends Controller
{
    public $name='';
    public $status='';
    public function index()
	{
        $data=Department::get();
		return view('companyinfo.alldepartment',compact('data'));
	}
    public function add()
	{
		return view('companyinfo.department');
	}
    public function insert(Request $request){
        extract($request->input()); 
        $insert=Department::insertGetId([
            'name' => $name,
            'status' => $status
        ]);
        if($insert)
        {
            $msg ='New Department added by '. Auth::user()->name.' Data('.$name.','.$status.')';
            $logs=SysetmLogs::insert([
                'action_id'   => $insert,
                'user_id'   => Auth::user()->id,
                'user_ip'   => \request()->ip(),
                'title'     => 'Department '.$name,
                'action'      => $msg,
                'created_at' 	=> Carbon::now('Asia/Kolkata')
            ]);
            session::flash('success','Department Added Successfully');
            return redirect('dashboard/department/view');
        }else{
            session::flash('error','OOPS Try again');
            return redirect('dashboard/department/view');
        }
    }
	public function edit($id)
	{
		if($id)
		{
			$edit = Department::where('id',$id)->firstOrFail();
			//print_r($edit); die;
            return view('companyinfo.department',compact('edit'));
		}
	}

    public function update(Request $request)
	{
        extract($request->post());
        $array =[
            'name'=>$name,           
            'status'=>$status
        ];
        // print_r($array); die;
        $data = Department::where('id',$id)->firstOrFail();
        $update = Department::where('id',$id)->update($array);
        if($update)
        {
            if(isset($name))
                $this->name=$name;
            if(isset($status))
                $this->status=$status;
            $msg ='Department Modification by '. Auth::user()->name.' Old Data(Name ='.$data->name.',Status='.$data->status.' )New Data('.$this->name.','.$this->status.' )';
            $logs=SysetmLogs::insert([
                'action_id'   => $id,
                'user_id'   => Auth::user()->id,
                'user_ip'   => \request()->ip(),
                'title'     => 'Department '.$data->name,
                'action'      => $msg,
                'created_at' 	=> Carbon::now('Asia/Kolkata')
            ]);
            session::flash('success','Department Added Successfully');
            return redirect('dashboard/department/view/');
        }else{
            session::flash('error','OOPS Try again');
            return redirect('dashboard/department/view');
        }
	}
    
}
