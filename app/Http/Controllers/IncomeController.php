<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\IncomeMail;
use App\Exports\IncomeExport;
use Maatwebsite\Excel\Facades\Excel;
use App\models\Income;
use Carbon\Carbon;
use Session;
use Auth;
use PDF;
use Mail;

class IncomeController extends Controller{
	public function __construct(){
		$this->middleware('auth');
	}

	public function index(){
		$all=Income::where('income_status',1)->orderBy('income_id','DESC')->get();
		return view('admin.income.main.all',compact('all'));

	}

	public function add(){
		return view('admin.income.main.add');
	}

	public function edit($slug){
		$edit=Income::where('income_status',1)->where('income_slug',$slug)->firstOrFail();
		return view('admin.income.main.edit',compact('edit'));
	}

	public function view($slug){
		$data=Income::where('income_status',1)->where('income_slug',$slug)->firstOrFail();
		return view('admin.income.main.view',compact('data'));
	}

	public function insert(Request $request){
		$this->validate($request,[
			'title'=>'required',
			'category'=>'required',
			'date'=>'required',
			'amount'=>'required'
		],[
			'title.required'=>'please insert income title',
			'category.required'=>'plaese insert income category!',
			'date.required'=>'please insert date!',
			'amount.required'=>'please insert income amount!',
		]);

		$email="nahiddx100@gmail.com";
		$title=$request['title'];
		$date=$request['date'];
		$amount=$request['amount'];

		$slug=uniqid('INC');
		$creator=Auth::user()->id;
		$insert=Income::insert([
			'income_title'=>$title,
			'incate_id'=>$request['category'],
			'income_date'=>$date,
			'income_amount'=>$amount,
			'income_creator'=>$creator,
			'income_slug'=>$slug,
			'created_at'=>Carbon::now()->toDateTimeString(),
		]);

		//Mail::to($email)->send(new IncomeMail($title,$date,$amount));

		if($insert){
			Session::flash('success','successfully add income information');
			return redirect('dashboard/income/add');
		}else{
			Session::flash('error','Opps! try again!');
			return redirect('dashboard/income/add');
		}
	}

	public function update(Request $request){
			$this->validate($request,[
				'title'=>'required'
	],[
		'title.required'=>'please Insert Your Name!',
	]);

	$id=$request['id'];
	$slug=Str::slug($request['title'],'-');
	$editor=Auth::user()->id;

	$update=Income::where('income_status',1)->where('income_id',$id)->update([
		'income_date'=>$request['date'],
		'income_title'=>$request['title'],
		'income_amount'=>$request['amount'],
		'income_editor'=>$editor,
		'income_slug'=>$slug,
		'updated_at'=>Carbon::now()->toDateTimeString(),
	]);

	if($update){
		Session::flash('success','Value');
		return redirect('dashboard/income/view/'.$slug);
	}else{
		Session::flash('success','Value');
		return redirect('dashboard/income/edit/'.$slug);
	}
	}
	public function softdelete(){
		$id=$_POST['modal_id'];
		$softDel=Income::where('income_status',1)->where('income_id',$id)->update([
			'income_status'=>'0'
		]);

		if($softDel){
			Session::flash('success','successfully delete income information');
			return redirect('dashboard/income');
		}else{
			Session::flash('error','Opps! try again!');
			return redirect('dashboard/income');
		}
	}

	public function restore(){
		$id=$_POST['modal_id'];
		$restore=Income::where('income_status',0)->where('income_id',$id)->update([
			'income_status'=>'1'
		]);

		if($restore){
			Session::flash('success','successfully restore income information');
			return redirect('dashboard/income');
		}else{
			Session::flash('error','Opps! try again!');
			return redirect('dashboard/income');
		}
	}

	public function delete(){
		$id=$_POST['modal_id'];
		$delete=Income::where('income_status',0)->where('income_id',$id)->delete();

		if($delete){
			Session::flash('success','successfully delete income information');
			return redirect('dashboard/recycle/income');
		}else{
			Session::flash('error','Opps! try again!');
			return redirect('dashboard/recycle/income');
		}
	}
	public function export(){
		return Excel::download(new IncomeExport, 'income.xlsx');

	}
	public function pdf(){
				$all=Income::where('income_status',1)->orderBy('income_id', 'DESC')->get();
        $pdf = PDF::loadView('admin.income.main.pdf', compact('all'));
        return $pdf->download('itsolutionstuff.pdf');
	}
}
