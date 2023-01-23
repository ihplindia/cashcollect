<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\User;
use App\Models\Payment_logs;
use Auth;
use Carbon\Carbon;

class QrCodeController extends Controller
{
  public function __construct(){
		$this->middleware('auth');
	}
    public function scan($slug,$receiver)
    {
      $slug = hex2bin($slug);
      $data = Income::where('income_ref_no',$slug)->firstOrFail();
      
      $receiver = User::where('id',$receiver)->firstOrFail();
      // $payment = Payment_logs::insert([
			// 	'payment_id' => $data->income_id,
			// 	'details' => ' Scan the QrCode for send Payment ' ,
			// 	'income_status' => $data->income_status,
			// 	'created_at' => Carbon::now()->toDateTimeString()
			// ]);
      return view('qrcode.qrcodeview',compact('data','receiver'));
    }

    
}