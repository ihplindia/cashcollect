<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\models\IncomeCategory;
use Carbon\Carbon;
use Session;
use Auth;


class IncomeCategoryController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index(){
        $all=IncomeCategory::where('incate_status',1)->orderBy('incate_id','DESC')->get();
        return view('admin.income.category.all',compact('all'));
    }
    
    public function add(){
        return view('admin.income.category.add');
    }
    
    public function edit($slug){
		$data=IncomeCategory::where('incate_status',1)->where('incate_slug',$slug)->firstOrFail();
        return view('admin.income.category.edit',compact('data'));
		
    }
    
    public function view($slug){
	   $data=IncomeCategory::where('incate_status',1)->where('incate_slug',$slug)->firstOrFail();
       return view('admin.income.category.view',compact('data')); 
    }
    
    public function insert(Request $request){
		$this->validate($request,[
			'name'=>'required|max:100|unique:income_categories,incate_name',
		],[
			'name.required'=>'please Insert Your Name!',
			'name.unique'=>'This Name Has Already Been Taken!!',
			'name.max'=>'InValid Name!'
		]);
        $slug=Str::slug($request['name'],'-');
		$creator=Auth::user()->id;
        $insert=IncomeCategory::insert([
            'incate_name'=>$request['name'],
            'incate_remarks'=>$request['remarks'],
            'incate_creator'=>$creator,
            'incate_slug'=>$slug,
            'created_at'=>Carbon::now()->toDateTimeString(),
        ]);
        
        
        if($insert){
			Session::flash('success','success Income Category Information');
            return redirect('dashboard/income/category/add');
        }else{
			Session::flash('error','Opps! Income Category Error');
            return redirect('dashboard/income/category/add');
        }
    }
    
    public function update(Request $request){
		$id=$request['id'];
        $this->validate($request,[
			'name'=>'required|max:100|unique:income_categories,incate_name,'.$id.',incate_id'
		],[
			'name.required'=>'please Insert Your Name!',
			'name.unique'=>'This Name Has Already Been Taken!!',
			'name.max'=>'InValid Name!'
		]);
		
		$slug=Str::slug($request['name'],'-');
		$editor=Auth::user()->id;
		
		$update=IncomeCategory::where('incate_status',1)->where('incate_id',$id)->update([
			'incate_name'=>$request['name'],
			'incate_remarks'=>$request['remarks'],
			'inncate_editor'=>$editor,
			'incate_slug'=>$slug,
			'updated_at'=>Carbon::now()->toDateTimeString(),
		]);
		
		if($update){
			Session::flash('success','Value');
			return redirect('dashboard/income/category/view/'.$slug);
		}else{
			Session::flash('success','Value');
			return redirect('dashboard/income/category/edit/'.$slug);
		}
    }
    
    public function softdelete(){
        
    }
    
    public function restore(){
        
    }
    
    public function delete(){
        
    }
}
