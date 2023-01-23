<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Mail\IncomeMail;
use App\Exports\IncomeExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Income;
use App\Models\Payment_logs;
use App\Models\User;
use App\Models\IncomeCategory;
use App\Models\Currency;
use Carbon\Carbon;
use App\Helper;
use Session;
use Auth;
use Illuminate\Contracts\Session\Session as SessionSession;
use PDF;
use Mail;
use Image;

class IncomeController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}

	public function index()
	{
		/* user
		0 = Web admin	, 1 = Admin ,2 = Accountent ,3 = Receiver Sales .4 Collector
		*/
		$user = Auth::user()->admin_view;
		$userid = Auth::user()->id;
		// $usertype=Helper::checkuser($userid);

		if( $user == 0 || $user == 1 || $user == 2)
		{
			$all=Income::orderBy('income_id','DESC')->get();

		}elseif($user == 3)
		{
			$all=Income::where('income_receiver',$userid)->orderBy('income_id','DESC')->get();
		}elseif($user == 4)
		{
			$all=Income::where('income_operation',$userid)->orderBy('income_id','DESC')->get();
		}elseif($user == 5)
		{
			$all=Income::where('income_collector',$userid)->orderBy('income_id','DESC')->get();
		}
		return view('admin.income.main.all',compact('all'));
	}

	public function add()
	{
		return view('admin.income.main.add');
	}

	//Repayment againt income reffrence no.
	public function rePayment(Request $request)
	{
		$file_ref_no=$request->input('file_ref_no');
		if($file_ref_no)
		{
			$edit = Income::where('file_ref_no',$file_ref_no)->count();
			if($edit > 0)
			{
				$edit = Income::where('file_ref_no',$file_ref_no)->firstOrFail();
				Session::flash('success','Payment created successfully.');
				return view('admin.income.main.add',compact('edit'));
			}else
			{
				Session::flash('error','No Data Available.');
				return view('admin.income.main.main');
			}

		}
		Session::flash('error','No Data Available.');
				return view('admin.income.main.add');
	}
	public function edit($slug)
	{
		if($slug)
		{
			$edit = Income::where('income_status','>',0)->where('income_id',$slug)->firstOrFail();
			return view('admin.income.main.main',compact('edit'));
		}
	}

	public function view($slug)
	{
		$income_ref_no = hex2bin($slug);
		$data = Income::where('income_ref_no',$income_ref_no)->firstOrFail();

		return view('admin.income.main.view',compact('data'));
	}

	public function insert(Request $request)
	{
        $get = Income::orderBy('income_id', 'DESC')->firstOrFail('income_id');
        $get=json_decode($get,TRUE);
        $id = ++$get['income_id'];
        $date= date('y');
        // echo $id = Income::latest()->id->get();
        $income_ref_no='IHPL00000'.$id;

        extract($request->input());

        $currency_code = Currency::where('id',$income_currency)->firstOrFail();
        $currency_rate_amount = Helper::CurrencyRateAPI($currency_code->code);

        $creator=Auth::user()->id;
		if($collection_type==1){
			$branch_name=$branch_name;
		}else{
			$branch_name='';
		}
		$data_array = [
			'income_ref_no'=>$income_ref_no,
			'file_ref_no'=>$file_ref_no,
			'guest_name'=>$guest_name,
			'guest_phone'=>$guest_phone,
			'guest_email'=>$guest_email,
			'income_title'=>$income_title,
			'incate_id'=> $incate_id,
			'income_date'=>$income_date,
			'income_amount'=>$income_amount,
			'income_currency'=>$income_currency,
			'income_receiver'=>$income_receiver,
			'income_collector'=>$income_collector,
			'income_creator'=>$creator,
			'collection_type'=>$collection_type,
			'company_name'=>$company_name,
			'vendor_detatils'=>$vendor_detatils,
			'income_operation'=>$income_operation,
			'currency_rate'=>$currency_rate_amount,
			'otherpaymentremarks'=>$otherpaymentremarks,
			'created_at'=>Carbon::now('Asia/Kolkata')
		];
		$insert=Income::insertGetId($data_array);

		if($insert){
			//Check Vendor Payment And set mail
			if($collection_type == 0)
			{
				$collector_name = User::where('id',$income_collector)->select('name','email')->firstOrFail();
				$collector		= $collector_name->name;
				$email_to 		= $collector_name->email;
			}else{
				$collector	= '';
			}

			$rceiver = User::where('id',$income_receiver)->select('name','email')->firstOrFail();
			$opr = User::where('id',$income_operation)->select('name','email')->firstOrFail();
			$services = IncomeCategory::where('incate_id',$incate_id)->select('incate_name')->firstOrFail();
			$currency = Currency::where('id',$income_currency)->select('title')->firstOrFail();
			//Mail variables
			$mail = array(
				'steps'			=> 1,
				'collector'     => $collector,
				'creatar'       => Auth::user()->name,
				'income_ref_no' => $income_ref_no,
				'createtime'    => Carbon::now('Asia/Kolkata'),
				'guest'         => $guest_name,
				'email'         => $guest_email,
				'phone'         => $guest_phone,
				'amount'        => $income_amount,
				'currency'		=> $currency->title,
				'services'      => $services->incate_name,
				'receiver'      => $income_receiver,
				'time' 			=> $income_date,
				'username' 		=> Auth::user()->name
			);

			$payment = Payment_logs::insert([
				'payment_id' 	=> $insert,
				'user_id' 		=> Auth::user()->id,
				'details' 		=>  Auth::user()->name .' has added a new payment ',
				'income_values' => json_encode($data_array),
				'income_status' => 1,
				'created_at' 	=> Carbon::now('Asia/Kolkata')
			]);
			if($collection_type == 0){
				$email_to 		= $collector_name->email;
			}else{
				$email_to 		= $opr->email;//OPR
			}
			$subject = 'New collection added | '.config('app.name');
			$config_info 	= session()->get('config_info');
			$email_cc[] 	= $config_info['MAIL_CC'];
			$email_cc[] 	= $opr->email;//OPR
			$email_cc[]		= Auth::user()->email;	// creator
			$send = Mail::to($email_to)
				->cc($email_cc)
				->send(new IncomeMail($mail,$subject));

			Session::flash('success','Payment added successfully.');
			return redirect('dashboard/income');

		}else{
			Session::flash('error','Opps! try again!');
			return redirect('dashboard/income');
		}
	}

	public function update(Request $request)
	{
		$id=$request['id'];
		$editor=Auth::user()->id;
		$array = [
			'file_ref_no'=>$request['file_ref_no'],
			'guest_name'=>$request['guest_name'],
			'guest_phone'=>$request['guest_phone'],
			'guest_email'=>$request['guest_email'],
			'income_title'=>$request['income_title'],
			'incate_id'=>$request['incate_id'],
			'income_date'=>$request['income_date'],
			'income_amount'=>$request['income_amount'],
			'income_currency'=>$request['income_currency'],
			'income_editor'=>$editor,
			'income_collector'=>$request['income_collector'],
			'income_receiver'=>$request['income_receiver'],
			'income_operation'=>$request['income_operation'],
			'updated_at'=>Carbon::now('Asia/Kolkata'),
		];
		// die(json_encode($array));
		$update = Income::where('income_id',$id)->update($array);

		if($update){
			$payment = Payment_logs::insert([
				'payment_id' => $id,
				'user_id' => $editor,
				'details' => Auth::user()->name.' has modified the payment details',
				'income_values' => json_encode($array),
				'income_status'=>$request['income_status'],
				'created_at' => Carbon::now('Asia/Kolkata')
			]);

			$config_info = session()->get('config_info');
			$mail_to = $config_info['MAIL_CC'];
			//Mail send on Payments Modification
			$subject = 'Payment Collection';
			$maildata = Helper::mailData($request['income_ref_no'],Auth::user()->name,5,$request['income_status']);
			$send = Mail::to($mail_to)->send(new IncomeMail($maildata,$subject));
			Session::flash('success','Updated Successfully');
			return redirect('dashboard/income');
		}else{
			Session::flash('error','OOPS Try again');
			return redirect('dashboard/income');
		}
	}

	public function collect(Request $request)
	{

		extract($request->input());
		if($self=='self'){
			$collected = Income::where('income_ref_no',$income_ref_no)->update([
				'is_partial' =>$is_partial,
				'partial_amount' =>$partial_amount,
				'partial_remarks' =>$partial_remarks,
				'income_status'=>'3',
				'collection_date' => date("Y-m-d")
			]);
			$logmsg = Auth::user()->name.' has collected payment from '.$guest_name.' ( self collection ) ';
		}else{
			$collected = Income::where('income_ref_no',$income_ref_no)->update([
				'is_partial' =>$is_partial,
				'partial_amount' =>$partial_amount,
				'partial_remarks' =>$partial_remarks,
				'income_status'=>'2',
				'collection_date' => date("Y-m-d")
			]);
			$logmsg = Auth::user()->name.' has collected payment from '.$guest_name.' ';
		}
		if($collected)
		{
			$receiver = Income::where('income_id',$income_id)->firstOrFail();
			$r_mail=Helper::userMail($receiver->income_receiver);
			$c_mail=Helper::userMail($receiver->income_collector);
			$subject = 'Payment Collected | '.config('app.name');
			$config_info = session()->get('config_info');
			$email_to 		= $r_mail;	//receiver
			$email_cc[]		= $c_mail;	// Collector
			$email_cc[] 	= $config_info['MAIL_CC']; // Accounts Mail
			$maildata = Helper::mailData($income_ref_no,Auth::user()->name,2,$income_status);
			$send = Mail::to($email_to)
			->cc($email_cc)
			->send(new IncomeMail($maildata,$subject));

			$payment = Payment_logs::insert([
				'payment_id' => $income_id,
				'user_id' => Auth::user()->id,
				'income_status' => 2,
				'details' =>$logmsg,
				'media' => '',
				'created_at' => Carbon::now('Asia/Kolkata')
			]);
			$income_ref_no=bin2hex($income_ref_no);
			Session::flash('success','Payment collected successfully');
			return redirect('dashboard/income/view/'.$income_ref_no);
		}
		else
		{
			Session::flash('error','Opps! try again!');
			return redirect('dashboard/income');
		}
	}

	public function deposit($data)
	{
		$data = unserialize(base64_decode($data));
		$income_ref_no = $data['income_ref_no'];
		$id = $data['id'];
		$income_status= $data['income_status'];
		$user = $data['user'];
		if($income_status == 2){
			$deatils = Auth::user()->name.' depositing payment to OPR Or Sales department';
		}else{
			$deatils =  Auth::user()->name.' depositing payment to account';
		}
		$showqr=Income::where('income_ref_no',$income_ref_no)->update([
			'qrcode'=>'1',
			'transaction_status'=>'0',
			]);
		// Mail to collector, receiver & accounts
		if($showqr)
		{
			$payment = Payment_logs::insert([
				'payment_id' => $id,
				'user_id' => Auth::user()->id,
				'income_status' => 2,
				'details' => $deatils,
				'media' => '',
				'created_at' => Carbon::now('Asia/Kolkata')
			]);
			$income_ref_no=bin2hex($income_ref_no);
			Session::flash('success','Scan The QrCode and click send Button ');
			return redirect('dashboard/income/view/'.$income_ref_no);
		}
		else
		{
			Session::flash('error','Opps! try again!');
			return redirect('dashboard/income');
		}
	}

	public function sendPayment($data)
	{
		$data = unserialize(base64_decode($data));
		$income_ref_no = $data['income_ref_no'];
		$income_status= $data['income_status'];
		$receiver = $data['receiver'];
		$id = $data['id'];
		$user = $data['user'];
		if($income_status == 2){
			$deatils = Auth::user()->name.' sent payment accpet request to '.$receiver;
		}else{
			$deatils = Auth::user()->name.' sent payment accpet request to '.$receiver;
		}

		$sendrequest=Income::where('income_ref_no',$income_ref_no)->update([
			'qrcode' => '0',
			'transaction_status'=>'1'
		]);
		// Mail to collector, receiver & accounts
		if($sendrequest)
		{
			$payment = Payment_logs::insert([
				'payment_id' => $id,
				'user_id' => Auth::user()->id,
				'income_status' => 2,
				'details' => $deatils,
				'media' => '',
				'created_at' => Carbon::now('Asia/Kolkata')
			]);
			$income_ref_no=bin2hex($income_ref_no);
			Session::flash('success','Payment Send  successfully');
			return redirect('dashboard/income/view/'.$income_ref_no);
		}
		else
		{
			Session::flash('error','Opps! try again!');
			return redirect('dashboard/income');
		}
	}

	//Income File attchemenets
	public function fileattchment(Request $request)
	{
		$request->attachment;
		$income_ref_no = $request['income_ref_no'];
		$imageName = time() . '.' . $request->attachment->extension();
		$path = $request->attachment->move(public_path('uploads/payments/'), $imageName);
		$departmentname['income_file'] = $imageName;
		$departmentname['income_status'] = 3;
		$departmentname['transaction_status'] = 0;
		$departmentname['qrcode'] = 0;
		$result =Income::where('income_id',$request->income_id)->update(
			$departmentname
		);
		if($result)
		{
			$deatils = Auth::user()->name.' has received the vendor payment with attchement';
			$payment = Payment_logs::insert([
				'payment_id' => $request->income_id,
				'user_id' => Auth::user()->id,
				'income_status' => $request->income_status,
				'details' => $deatils,
				'media' => '',
				'created_at' => Carbon::now('Asia/Kolkata')
			]);
			$income_ref_no=bin2hex($income_ref_no);
			Session::flash('success','Payment Received successfully');
			return redirect()->route('income.view',bin2hex($request->income_ref_no))->with('success', 'File Uploades Successfully');
		}
		else
		{
			Session::flash('error','Opps! try again!');
			return redirect()->route('income.view',bin2hex($request->income_ref_no));
		}

	}

	public function accept($data)
	{
		$data = unserialize(base64_decode($data));
		$income_ref_no = $data['income_ref_no'];
		$id = $data['id'];
		$income_status = $data['income_status'] + 1 ;
		$user = $data['user'];
		$vendor = $data['vendor'];
		if($income_status == 3)
		{
			$account = 0;
			$deatils = Auth::user()->name. ' has received the payment';
		}else
		{
			$account = $user;
			$deatils = Auth::user()->name.' has received the payment';
		}
		$received = Income::where('income_ref_no',$income_ref_no)->update([
			'income_status'=> $income_status,
			'account_receiver' => $account,
			'transaction_status'=>'0',
			'qrcode'=>'0'
			]);

		// Mail to collector, receiver & accounts
		$receiver = Income::where('income_id',$id)->firstOrFail();
		if($received)
		{
			if($vendor == 0)
			{
				$c_mail=Helper::userMail($receiver->income_receiver);
				$email_cc[]		= $c_mail;	// Collector
			}

			$r_mail=Helper::userMail($receiver->income_receiver);

			$subject = 'Payment Received | '.config('app.name');
			$config_info = session()->get('config_info');
			$email_to 		= $r_mail;	//receiver
			//$email_cc[]		= $c_mail;	// Collector
			$email_cc[] 	= $config_info['MAIL_CC']; // Accounts Mail
			$maildata = Helper::mailData($income_ref_no,Auth::user()->name,3,$income_status);
			$send = Mail::to($email_to)
			->cc($email_cc)
			->send(new IncomeMail($maildata,$subject));

			$payment = Payment_logs::insert([
				'payment_id' => $id,
				'user_id' => Auth::user()->id,
				'income_status' => $income_status,
				'details' => $deatils,
				'media' => '',
				'created_at' => Carbon::now('Asia/Kolkata')
			]);

			$income_ref_no=bin2hex($income_ref_no);
			Session::flash('success','Payment Received successfully');
			return redirect('dashboard/income/view/'.$income_ref_no);
		}
		else
		{
			Session::flash('error','Opps! try again!');
			return redirect('dashboard/income');
		}
	}

	//Settled the Payment
	public function incomeSettled(Request $request)
	{
		//dd($request);
		$income_ref_no = $request->income_ref_no;
		$vendor = $request->vendor;
		$array=[
			'income_status'=> $request->income_status + 1,
			'transaction_status'=>'0',
			'qrcode'=>'0',
			'tally_ref_no' => $request->tally_ref_no,
			'income_remarks' => $request->income_remarks,
			'income_settled_type' => $request->income_settled_type
		];
		//  print_r($array); die;
		$settled = Income::where('income_ref_no',$income_ref_no)->update($array);

		// Mail to collector, receiver & accounts
		if($settled)
		{
			if($vendor == 0)
			{
				$c_mail=Helper::userMail($receiver->income_collector);
				$email_cc[]		= $c_mail;	// Collector
			}
			$income_status=$request->income_status + 1;
			$receiver = Income::where('income_ref_no',$income_ref_no)->firstOrFail();
			$r_mail=Helper::userMail($receiver->income_receiver);

			$subject = 'Payment Settled | '.config('app.name');
			$config_info = session()->get('config_info');
			$email_to 		= $r_mail;	//receiver
			$email_cc 		= $r_mail;	//receiver
			//$email_cc[]		= $c_mail;	// Collector
			$email_to 	= $config_info['MAIL_CC']; // Accounts Mail
			$maildata = Helper::mailData($income_ref_no,Auth::user()->name,4,$income_status);
			$send = Mail::to($email_to)
			->cc($email_cc)
			->send(new IncomeMail($maildata,$subject));

			$id = $request->income_id;
			$payment = Payment_logs::insert([
				'payment_id' => $id,
				'user_id' => Auth::user()->id,
				'income_status' => '5',
				'details' => 'Payment has been settled by ' .Auth::user()->name. ' with Tally reffrence No. ' .$request->tally_ref_no,
				'media' => '',
				'created_at' => Carbon::now('Asia/Kolkata')
			]);
			Session::flash('success','Payment Settled ');
			return redirect('dashboard/income');
		}
		else
		{
			Session::flash('error','Opps! try again!');
			return redirect('dashboard/income');
		}
	}

	//Cancelled payments
	public function cancelled($income_id,$income_ref_no)
	{
		die('cancelled method');
		$income_ref_no= hex2bin($income_ref_no);
		//die($income_ref_no);
		$data =[
			'income_status'=> 0,
			'updated_at'=>Carbon::now('Asia/Kolkata')
		];
		$update = Income::where('income_ref_no',$income_ref_no)->update($data);

		if($update){
			$payment = Payment_logs::insert([
				'payment_id' => $income_id,
				'user_id' => Auth::user()->id,
				'details' => 'Payments has been cancelled by ' .Auth::user()->name,
				'income_values' => '',
				'income_status'=>'1',
				'created_at' => Carbon::now('Asia/Kolkata')
			]);
			return redirect('dashboard/income');
		}else{
			Session::flash('error','OOPS Try again');
			return redirect('dashboard/income');
		}
	}

	public function softdelete()
	{
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

	public function restore()
	{
		$id=$_POST['modal_id'];
		$restore=Income::where('income_status',0)->where('income_id',$id)->update([
			'income_status'=>'1'
		]);

		if($restore)
		{
			Session::flash('success','successfully restore income information');
			return redirect('dashboard/income');
		}else
		{
			Session::flash('error','Opps! try again!');
			return redirect('dashboard/income');
		}
	}

	public function delete()
	{
		$id=$_POST['modal_id'];
		$delete=Income::where('income_status',0)->where('income_id',$id)->delete();

		if($delete)
		{
			Session::flash('success','successfully delete income information');
			return redirect('dashboard/recycle/income');
		}else{
			Session::flash('error','Opps! try again!');
			return redirect('dashboard/recycle/income');
		}
	}
	public function export()
	{
		return Excel::download(new IncomeExport, 'income.xlsx');
	}
	public function pdf(){
		$all=Income::where('income_status',1)->orderBy('income_id', 'DESC')->get();
        $pdf = PDF::loadView('admin.income.main.pdf', compact('all'));
        return $pdf->download('itsolutionstuff.pdf');
	}

	public function search(Request $request, $slug='')
	{
		$keyword = $request->keyword;
		if(!empty($slug))
		{
			if(Auth::user()->admin_view == 0 || Auth::user()->admin_view == 1 || Auth::user()->admin_view == 2 )
			{
				$all = Income::where('income_status',$slug)->orderBy('income_id','DESC')->get();

			}elseif(Auth::user()->admin_view == 3)
			{
				$data = Income::where('income_receiver',Auth::user()->id)->where('income_status',$slug)->orderBy('income_id','DESC')->get();
				if(count($data) > 0)
				{
					$all=Income::where('income_receiver',Auth::user()->id)->where('income_status',$slug)->orderBy('income_id','DESC')->get();
				}else
				{
					$all=Income::where('income_collector',Auth::user()->id)->where('income_status',$slug)->orderBy('income_id','DESC')->get();
				}
			}elseif(Auth::user()->admin_view == 4)
			{
				$all=Income::where('income_operation',Auth::user()->id)->where('income_status',$slug)->orderBy('income_id','DESC')->get();
			}
			elseif(Auth::user()->admin_view == 5)
			{
				$all=Income::where('income_collector',Auth::user()->id)->where('income_status',$slug)->orderBy('income_id','DESC')->get();
			}
				return view('admin.income.main.all',compact('all'));

		}
		elseif($keyword)
		{
			//$startingDate= date('Y-m-d',strtotime($request->start));
			//$endingDate= date('Y-m-d',strtotime($request->end));
			//$RtottalIncome=Income::whereBetween('income_date',[$startingDate,$endingDate])->orderBy('income_id','DESC')->get();
			$all=Income::where('income_ref_no','Like','%'.$request->keyword.'%')
			->orWhere('guest_name','Like','%'.$request->keyword.'%')
			->orWhere('guest_email','Like','%'.$request->keyword.'%')
			->orWhere('tally_ref_no','Like','%'.$request->keyword.'%')
			->orderBy('income_id','DESC')->get();
			/*
			if($request->has('start') && $request->has('end'))
			{
				$RtottalIncome->whereBetween('income_date',[$startingDate,$endingDate]);
			}
			*/
			//$TottalIncome=Income::orderBy('income_id','DESC')->sum('income_amount');
			return view('admin.income.main.all',compact('all','keyword'));
		}
		else
		{
			$all=Income::orderBy('income_id','DESC')->get();
			return view('admin.income.main.all',compact('all'));
		}
	}

	public function advanced()
	{
		$RtottalIncome=Income::all();
		//$RtottalIncome=Income::orderBy('income_id','DESC')->get();
		$TottalIncome=Income::orderBy('incate_id','DESC')->sum('income_amount');
		return view('admin.reports.search',compact('RtottalIncome','TottalIncome'));
		// return view('admin.reports.search',compact('TottalIncome'));

	}
	public function advancedSearch(Request $request )
  	{
		extract($request->input()); //extract post method values
		$query = DB::table('incomes');
		if (isset($keyword)){
			$query->where('income_ref_no','Like','%'.$keyword.'%')
				->orWhere('file_ref_no','Like','%'.$keyword.'%')
				->orWhere('guest_name','Like','%'.$keyword.'%')
				->orWhere('guest_email','Like','%'.$keyword.'%')
				->orWhere('tally_ref_no','Like','%'.$keyword.'%')
				->orWhere('file_ref_no','Like','%'.$keyword.'%');
		}
		if (isset($start) && isset($end))
		{
			$start= date('Y-m-d',strtotime($start));
			$end= date('Y-m-d',strtotime($end));
			$query->whereBetween('income_date',[$start,$end]);
		}
		if (isset($income_status)){
			$query->where('income_status', $income_status);
		}
		if (isset($income_collector)){
			$query->where('income_collector', $income_collector);
		}
			$TottalIncome=0;
			$RtottalIncome = $query->get();
		foreach($RtottalIncome as $total){
			$Tottal =Income::where('income_id',$total->income_id)->orderBy('incate_id','DESC')->sum('income_amount');
			$TottalIncome += $Tottal;
		}
		if($RtottalIncome){
			return view('admin.reports.search',compact('RtottalIncome','TottalIncome'));
		}else
		{
			Session::flash('error','No Data find');
			return back();
		}
 	}
}
