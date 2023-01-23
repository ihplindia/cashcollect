<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ExpenseCategory;
use Carbon\Carbon;
use Session;
use Auth;


class ExpenseCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
      $all=ExpenseCategory::where('expcate_status',1)->orderBy('expcate_id','DESC')->get(); 
	  return view('admin.expense.category.all',compact('all'));
    }
    
    public function add()
    {
        return view('admin.expense.category.add');
    }
    
    public function edit($slug)
    {
        $data=ExpenseCategory::where('expcate_status',1)->where('expcate_slug',$slug)->firstOrFail();
		return view('admin.expense.category.edit',compact('data'));
    }
    
    public function view($slug)
    {
        $data=ExpenseCategory::where('expcate_status',1)->where('expcate_slug',$slug)->firstOrFail();
		return view('admin.expense.category.view',compact('data'));
    }
    
    public function insert(Request $request)
    {
        $this->validate($request,[
			'name'=>'required|unique:expense_categories,expcate_name|max:100',
		],[
			'name.required'=>'please Insert Your Name!',
			'name.unique'=>'This Name Has Already Been Taken!!',
			'name.max'=>'InValid Name!'
		]);
		$slug=Str::slug($request['name'],'-');
		$creator=Auth::user()->id;
		$insert=ExpenseCategory::insert([
			'expcate_name'=>$request['name'],
			'expcate_remarks'=>$request['remarks'],
			'expcate_creator'=>$creator,
			'expcate_slug'=>$slug,
			'created_at'=>Carbon::now()->toDateTimeString(),
		]);
		
		 if($insert){
			Session::flash('success','success expense Category Information');
            return redirect('dashboard/expense/category/add');
        }else{
			Session::flash('error','Opps! expense Category Error');
            return redirect('dashboard/expense/category/add');
        }
    }
    
    public function update(){
        
    }
    
    public function softdelete(){
        
    }
    
    public function restore(){
        
    }
    
    public function delete(){
        
    }
}
