<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;

class RecycleController extends Controller{
  public function __construct(){
    $this->middleware('auth');
  }

  public function index(){
      return view('admin.recycle.index');

	}
  public function user(){


  }
  public function income(){
    $all=Income::where('income_status',0)->orderBy('income_id','DESC')->get();
			return view('admin.recycle.income',compact('all'));

  }
  public function income_category(){


  }
  public function expense(){


  }
  public function iexpense_category(){


  }
}
