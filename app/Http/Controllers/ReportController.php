<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Expense;
use Carbon\Carbon;
use Session;

class ReportController extends Controller{

  public function __construct(){
    $this->middleware('auth');
  }
  public function reports(){
    return view('admin.reports.reports');
  }
  public function current(){
   $today=Carbon::now();
   $month=date('m' , strtotime($today));
   $fullmonth=date('F' , strtotime($today));
   $year=date('Y' , strtotime($today));
   $RtottalIncome=Income::where('income_status',1)->whereMonth('income_date','=',$month)->orderBy('income_id','DESC')->get();
   $TottalIncome=Income::where('income_status',1)->whereMonth('income_date','=',$month)->sum('income_amount');
   $Rtottalexpense=Expense::where('expense_status',1)->whereMonth('expense_date','=',$month)->orderBy('expense_id','DESC')->get();
   $Tottalexpense=Expense::where('expense_status',1)->whereMonth('expense_date','=',$month)->sum('expense_amount');
   return view('admin.reports.current',compact('today','fullmonth','year','RtottalIncome','TottalIncome','Rtottalexpense','Tottalexpense'));
  }

  public function summary(){
   $RtottalIncome=Income::where('income_status',1)->orderBy('income_id','DESC')->get();
   $TottalIncome=Income::where('income_status',1)->orderBy('income_id','DESC')->sum('income_amount');
   $Rtottalexpense=Expense::where('expense_status',1)->orderBy('expense_id','DESC')->get();
   $Tottalexpense=Expense::where('expense_status',1)->orderBy('expense_id','DESC')->sum('expense_amount');
   return view('admin.reports.summary',compact('RtottalIncome','TottalIncome','Rtottalexpense','Tottalexpense'));
  }

  public function search(Request $request){
    $startingDate= date('Y-m-d',strtotime($request->start));
    $endingDate= date('Y-m-d',strtotime($request->end));
   $RtottalIncome=Income::where('income_status',1)->whereBetween('income_date',[$startingDate,$endingDate])->orderBy('income_id','DESC')->get();
   $TottalIncome=Income::where('income_status',1)->orderBy('income_id','DESC')->sum('income_amount');
   $Rtottalexpense=Expense::where('expense_status',1)->whereBetween('expense_date',[$startingDate,$endingDate])->orderBy('expense_id','DESC')->get();
   $Tottalexpense=Expense::where('expense_status',1)->orderBy('expense_id','DESC')->sum('expense_amount');
   return view('admin.reports.search',compact('startingDate','endingDate','RtottalIncome','TottalIncome','Rtottalexpense','Tottalexpense'));
  }
}
