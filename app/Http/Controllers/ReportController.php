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
  // public function reports(){
    public function index(){
    return view('admin.reports.reports');
  }
  public function view($income_id){
    //echo $income_id;
   $alldata=Income::where('income_status',1)->where('income_id','=',$income_id)->firstOrFail();
    return view('admin.reports.view', compact('alldata'));
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
    $RtottalIncome=Income::all();
   //$RtottalIncome=Income::orderBy('income_id','DESC')->get();
   $TottalIncome=Income::orderBy('incate_id','DESC')->sum('income_amount');
   $Rtottalexpense=Expense::where('expense_status',1)->orderBy('expense_id','DESC')->get();
   $Tottalexpense=Expense::where('expense_status',1)->orderBy('expense_id','DESC')->sum('expense_amount');
   return view('admin.reports.summary',compact('RtottalIncome','TottalIncome','Rtottalexpense','Tottalexpense'));
  }

  public function search(Request $request)
  {
    
      // extract($request->input());
      $startingDate= date('Y-m-d',strtotime($start));
      $endingDate= date('Y-m-d',strtotime($end));
      // $key=$request->key;
      
      //  dd($request);
    //$RtottalIncome=Income::whereBetween('income_date',[$startingDate,$endingDate])->orderBy('income_id','DESC')->get();
    $RtottalIncome=Income::where('income_ref_no','Like',$keyword)
    ->orWhere('guest_name','Like',$keyword)
    ->orWhere('guest_email','Like',$keyword)
    ->orWhere('tally_ref_no','Like',$keyword)
    ->orderBy('income_id','DESC')->get();

    /*
    if($request->has('start') && $request->has('end'))
    {
        $RtottalIncome->whereBetween('income_date',[$startingDate,$endingDate]);
    }
    */
    
    //dd($RtottalIncome);
    //  echo $RtottalIncome->toSql();

    $TottalIncome=Income::orderBy('income_id','DESC')->sum('income_amount');
    return view('admin.reports.search',compact('startingDate','endingDate','RtottalIncome','TottalIncome'));
  }

}
