<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Exports\ExpenseExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Expense;
use Carbon\Carbon;
use Session;
use Auth;
use PDF;

class ExpenseController extends Controller{
	public function __construct(){
		$this->middleware('auth');
	}

	public function index(){
		$all=Expense::where('expense_status',1)->orderBy('expense_id','DESC')->get();
		return view('admin.expense.main.all',compact('all'));
	}

	public function add(){
		return view('admin.expense.main.add');
	}

	public function edit(){

	}

	public function view(){

	}

	public function insert(Request $request){
		$this->validate($request,[
			'title'=>'required',
			'category'=>'required',
			'date'=>'required',
			'amount'=>'required'
		],[
			'title.required'=>'please insert expense title! ',
			'category.required'=>'please insert expense category!',
			'date.required'=>'please insert expense date!',
			'amount.required'=>'please insert expense amount!',
		]);
		$slug=uniqid('EPC');
		$creator=Auth::user()->id;
		$insert=Expense::insert([
			'expense_title'=>$request['title'],
			'expcate_id'=>$request['category'],
			'expense_date'=>$request['date'],
			'expense_amount'=>$request['amount'],
			'expense_creator'=>$creator,
			'expense_slug'=>$slug,
			'created_at'=>Carbon::now()->ToDateTimeString(),
		]);
		if($insert){
			Session::flash('success','successfully add income information');
			return redirect('dashboard/expense/add');
		}else{
			Session::flash('error','Opps! try again!');
			return redirect('dashboard/expense/add');
		}
	}

	public function update(){

	}

	public function softdelete(){

	}

	public function delete(){

	}
	public function export(){

		return Excel::download(new ExpenseExport, 'expense.xlsx');

	}
	public function pdf(){
			$all=Expense::where('expense_status',1)->orderBy('expense_id','DESC')->get();
		    $pdf = PDF::loadView('admin.expense.main.pdf', compact('all'));
        return $pdf->download('Expense.pdf');
	}
}
