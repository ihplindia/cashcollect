<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\IncomeCategory;
use App\Models\SysetmLogs;
use Carbon\Carbon;
use Session;
use Auth;


class IncomeCategoryController extends Controller
{
    public $name='';
    public $remarks='';
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $all=IncomeCategory::where('incate_status',1)->orderBy('incate_id','DESC')->get();
        return view('admin.income.category.all',compact('all'));
    }

    public function add()
    {
        return view('admin.income.category.add');
    }

    public function insert(Request $request)
    {
		$this->validate($request,[
			'name'=>'required|max:100|unique:income_categories,incate_name',
		],[
			'name.required'=>'please Insert Your Name!',
			'name.unique'=>'This Name Has Already Been Taken!!',
			'name.max'=>'InValid Name!'
		]);
        extract($request->input());
        $slug=Str::slug($name,'-');
        $insert=IncomeCategory::insertGetId([
            'incate_name'=>$name,
            'incate_remarks'=>$remarks,
            'incate_creator'=>Auth::user()->id,
            'incate_slug'=>$slug,
            'created_at'=>Carbon::now()->toDateTimeString(),
        ]);
        if($insert){
            if(isset($name))
            $this->name=$name;
            if(isset($remarks))
            $this->remarks=$remarks;
            $msg ='Name = '.$this->name.', remarks= '.$this->remarks;
            $logs=SysetmLogs::insert([
                'action_id'   => $insert,
                'user_id'   => Auth::user()->id,
                'user_ip'   => \request()->ip(),
                'title'     => 'New Payment Category Create ',
                'action'      => $msg,
                'created_at' 	=> Carbon::now('Asia/Kolkata')
            ]);
			Session::flash('success','success Income Category Information');
            return redirect('dashboard/income/category/add');
        }else{
			Session::flash('error','Opps! Income Category Error');
            return redirect('dashboard/income/category/add');
        }
    }

    public function view($slug)
    {
	   $data=IncomeCategory::where('incate_id',$slug)->firstOrFail();
       return view('admin.income.category.view',compact('data'));
    }

    public function edit($slug)
    {
		$data=IncomeCategory::where('incate_id',$slug)->firstOrFail();
        return view('admin.income.category.edit',compact('data'));
    }

    public function update(Request $request)
    {
		$id=$request['id'];
        $this->validate($request,[
			'name'=>'required|max:100|unique:income_categories,incate_name,'.$id.',incate_id'
		],[
			'name.required'=>'please Insert Your Name!',
			'name.unique'=>'This Name Has Already Been Taken!!',
			'name.max'=>'InValid Name!'
		]);

		extract($request->input());
        $slug=Str::slug($name,'-');
		$data=IncomeCategory::where('incate_id',$id)->firstOrFail();
        $update=IncomeCategory::where('incate_id',$id)->update([
            'incate_name'=>$name,
            'incate_remarks'=>$remarks,
            'incate_creator'=>Auth::user()->id,
            'incate_slug'=>$slug,
            'created_at'=>Carbon::now()->toDateTimeString(),
		]);

		if($update){
            if(isset($name))
            $this->name=$name;
            if(isset($remarks))
            $this->remarks=$remarks;
            $msg ='Name ='.$data->incate_name.' > '.$this->name.' , remarks = '.$data->incate_remarks.' > '.$this->remarks;
            $logs=SysetmLogs::insert([
                'action_id'   => $id,
                'user_id'   => Auth::user()->id,
                'user_ip'   => \request()->ip(),
                'title'     => 'Payment Category Modification',
                'action'      => $msg,
                'created_at' 	=> Carbon::now('Asia/Kolkata')
            ]);
			Session::flash('success','Category modification successfully');
			return redirect('dashboard/income/category');
		}else{
			Session::flash('error','Ops try again');
			return redirect('dashboard/income/category');
		}
    }

    public function softdelete()
    {

    }

    public function restore()
    {

    }

    public function delete()
    {

    }
}
