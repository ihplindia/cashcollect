<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class Helper
{

    // $diff=date_diff($date1,$date2);
    /**
     * The payment status title array.
     *
     * @var array
     */

    public static function GetDays($udate='',$cdate='')
    {
        date_default_timezone_set("asia/Kolkata");
        $d=date("d-m-Y");
        $date1=date_create($udate);
        if(!empty($cdate))
        {
            $date2=date_create($cdate);
        }else
        {
            $date2=date_create($d);
        }
        $diff=date_diff($date1,$date2);
        return $diff->format("%a");
    }
    public static function Status($status)
    {
        if($status==1)
        {
            return $status='Active';
        }else{
            return $status='Pending';
        }
    }

	//Set status
    public static function paymentStatus($status)
	{
		$statusArray = array(
			0=>'Cancelled',
			1=>'Pending',
			2=>'Collected',
			3=>'Deposited',
			4=>'Approved',
			5=>'Settled'
		);
		if($status =='all'){
			return $statusArray;
		}
		return $statusArray[$status];
    }
    //Admin View
    public static function Admin_View($status)
	{
        $statusArray = array(
			0=>'Web Admin',
			1=>'Admin',
			2=>'Accountent',
			3=>'Sales',
			4=>'OPR',
			5=>'Others'
        );

		return $statusArray[$status];
	}

    // // Pending on
    public static function PendingOn($income_id='',$status='')
	{
        $data=DB::table('incomes')
            ->select('income_collector','income_receiver','account_receiver','created_at','collected_date','receive_date','approved_date')
            ->where('income_id',$income_id)
            ->first();
            $data = (array) $data;
            extract($data);
        $column='';
		switch ($status)
        {
            case 1:
                $column=$income_collector;//user id
                $pending_days=$created_at;
            break;
            case 2:
                $column=$income_collector;
                $pending_days=$collected_date;
            break;
            case 3:
                // $column1='income_operation';
                $column=$income_receiver;
                $pending_days=$receive_date;
            break;
            case 4:
                $column=$account_receiver;
                $pending_days=$approved_date;
            break;
            default:
            $pending_days='NULL';
            $msg='NA';
        }
        if($pending_days !== 'NULL' || $column=='NULL'){
             return $d=[
                'day'=>self::GetDays($pending_days),
                'p_by'=>self::userName($column),
                'msg' => isset($msg)?$msg:''
            ];
        }
	}

	//Payments Expired
	public static function paymentExpired($id)
	{
		$exp = DB::table('incomes')
			->where('income_id',$id)
			->update('income_status',0);
	}
	public static function currenyType($id)
	{
		$currency = DB::table('currencies')
		->where('id',$id)
		->first();
		return $currency;
    }

    //Currency Rate API
    public static function CurrencyRateAPI($code,$amount='')
    {
        $amount=isset($amount)?$amount:1;
        $curl = curl_init();
            $link="https://currency-converter-by-api-ninjas.p.rapidapi.com/v1/convertcurrency?have=$code&want=INR&amount=$amount";
            curl_setopt_array($curl, [
                CURLOPT_URL => $link,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "X-RapidAPI-Host: currency-converter-by-api-ninjas.p.rapidapi.com",
                    "X-RapidAPI-Key: 771dbb1d50mshcb1c2561561db48p16824fjsn261e03b5a504"
                ],
            ]);
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err)
            {
                echo "cURL Error #:" . $err;
            } else {
                $response=json_decode($response,TRUE);
                return $currency_rate_amount = $response['new_amount'];

            }
    }

	public static function IncomeHistory($id)
	{
		$data = DB::table('payment_log')
			->where('payment_id',$id)
			->get()
			->toArray();
		return $data;
	}

    public static function sendSmsOutBox($mobile,$uid,$name)
    {
        $otp=rand(1000,9999);
        // $user=Auth::user()->name;
        // $uid=Auth::user()->id;
        $message = 'Dear '.$name.', your mobile verification OTP is '.$otp.' for cash collection. IHPL';
        $url="https://bhashsms.com/api/sendmsg.php?";
        //echo $message."<br/>";
        $data="user=IHPLCS"
                ."&pass=oMH441krLPQY"
                ."&sender=IHPLCS"
                ."&phone=".$mobile
                ."&text=".self::sanetizeSMS($message)
                ."&priority=ndnd&stype=normal";

        $ch = curl_init();
        $url.=$data;
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        //  curl_setopt($ch,CURLOPT_HEADER, false);
        $output=curl_exec($ch);
        curl_close($ch);
        if($output)
        {
            $ip='';
            if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
            $totalIncome 	=	DB::table('users')->where('id',$uid)->update(['otp'=>$otp]);
            $totalIncome 	=	DB::table('system_logs')->insert(['action_id'=>$uid,'user_ip'=>$ip,'user_id'=>$uid,'title'=>'OTP send for phone verification','action'=>' '.$otp.' OTP send to '.$name.' ']);
            return $output;
        }else{
            return $output;
        }
    }

    public static function sanetizeSMS($string)
    {
        $array=array("%"=>"%25",
                " "=>"%20",
                "\n"=>"%0A",
                "!"=>"%21",
                "\""=>"%22",
                "#"=>"%23",
                "$"=>"%24",
                "&"=>"%26",
                "'"=>"%27",
                "("=>"%28",
                ")"=>"%29",
                "*"=>"%2A",
                "+"=>"%2B",
                ","=>"%2C",
                "-"=>"%2D",
                "."=>"%2E",
                "/"=>"%2F",
                ":"=>"%3A",
                ";" =>"%3B",
                "<" =>"%3C",
                "=" =>"%3D",
                ">" =>"%3E",
                "?" =>"%3F",
                "@" =>"%40",
                "^" =>"%14",
                "{" =>"%28",
                "}" =>"%29",
                "\\"=>"%2F",
                "[" =>"%3C",
                "~" =>"%3D",
                "]" =>"%3E",
                "|" =>"%40",
                "€"	=>"%65");

        $from=array_keys($array);
        $to=array_values($array);

        return str_replace($from,$to,$string);
    }


	//Get Count Income data with payments status accordind to users
	public static function Dashboard($adminview,$userid,)
    {
		// Web Admin = 0        Admin = 1        Accountent = 2
		if($adminview == 0 || $adminview == 1 || $adminview == 2 )
		{
			//Admin data
			$totalIncome 	=	DB::table('incomes')->count('income_id');
			$pendingIncome	=	DB::table('incomes')->where('income_status',1)->count('income_id');
			$collected 		=	DB::table('incomes')->where('income_status',2)->count('income_id');
			$depositeIncome =	DB::table('incomes')->where('income_status',3)->count('income_id');
			$approved 		= 	DB::table('incomes')->where('income_status',4)->count('income_id');
			$completeIncome = 	DB::table('incomes')->where('income_status',5)->count('income_id');
			$expired 		= 	DB::table('incomes')->where('income_status',0)->count('income_id');

			$countdata =array (
				'totalIncome' 	=>	$totalIncome,
				'pendingIncome' =>	$pendingIncome,
				'collected' 	=>	$collected,
				'depositeIncome'=>	$depositeIncome,
				'approved' 		=>	$approved,
				'completeIncome'=>	$completeIncome,
				'expired'		=>  $expired
			);
		}
        // elseif($adminview == 2) //Account data
        // {
		// 	$totalIncome 	=	DB::table('incomes')->where('account_receiver',$userid)->count('income_id');
		// 	$pendingIncome	=	DB::table('incomes')->where('account_receiver',$userid)->where('income_status',1)->count('income_id');
		// 	$collected 		=	DB::table('incomes')->where('income_receiver',$userid)->where('income_status',2)->count('income_id');
		// 	$depositeIncome =	DB::table('incomes')->where('account_receiver',$userid)->where('income_status',3)->count('income_id');
		// 	$approved 		= 	DB::table('incomes')->where('account_receiver',$userid)->where('income_status',4)->count('income_id');
		// 	$completeIncome = 	DB::table('incomes')->where('account_receiver',$userid)->where('income_status',5)->count('income_id');
		// 	$expired 		= 	DB::table('incomes')->where('income_status',0)->count('income_id');

		// 	$countdata =array (
		// 		'totalIncome' 	=>	$totalIncome,
		// 		'pendingIncome' =>	$pendingIncome,
		// 		'collected' 	=>	$collected,
		// 		'depositeIncome'=>	$depositeIncome,
		// 		'approved' 		=>	$approved,
		// 		'completeIncome'=>	$completeIncome,
		// 		'expired'		=>  $expired
		// 	);
        // }
		// Sales = 3
		elseif($adminview == 3 )
		{
			$totalIncome 	=	DB::table('incomes')->where('income_receiver',$userid)->count('income_id');
			$pendingIncome	=	DB::table('incomes')->where('income_receiver',$userid)->where('income_status',1)->count('income_id');
			$collected 		=	DB::table('incomes')->where('income_receiver',$userid)->where('income_status',2)->count('income_id');
			$depositeIncome =	DB::table('incomes')->where('income_receiver',$userid)->where('income_status',3)->count('income_id');
			$approved 		= 	DB::table('incomes')->where('income_receiver',$userid)->where('income_status',4)->count('income_id');
			$completeIncome = 	DB::table('incomes')->where('income_receiver',$userid)->where('income_status',5)->count('income_id');
			$countdata =array (
				'totalIncome' 	=>	$totalIncome,
				'pendingIncome' =>	$pendingIncome,
				'collected' 	=>	$collected,
				'depositeIncome'=>	$depositeIncome,
				'approved' 		=>	$approved,
				'completeIncome'=>	$completeIncome
			);
		}
		// OPR = 4
		elseif($adminview == 4)
		{

			//Operation data
			$totalIncome	=	DB::table('incomes')->where('income_operation',$userid)->count('income_id');
			$pendingIncome 	= 	DB::table('incomes')->where('income_operation',$userid)->where('income_status',1)->count('income_id');
			$collected 		= 	DB::table('incomes')->where('income_operation',$userid)->where('income_status',2)->count();
			$depositeIncome = 	DB::table('incomes')->where('income_operation',$userid)->where('income_status',3)->count('income_id');
			$completeIncome = 	DB::table('incomes')->where('income_operation',$userid)->where('income_status',5)->count('income_id');
			$approved 		= 	DB::table('incomes')->where('income_operation',$userid)->where('income_status',4)->count('income_id');
			$countdata =array (
				'totalIncome' 	=>	$totalIncome,
				'pendingIncome' =>	$pendingIncome,
				'collected' 	=>	$collected,
				'depositeIncome'=>	$depositeIncome,
				'completeIncome'=>	$completeIncome,
				'approved' 		=>	$approved,
			);
		}
		// Other = 5 (Collector)
		elseif($adminview == 5)
		{
			//Collector data
			$totalIncome	=	DB::table('incomes')->where('income_collector',$userid)->count('income_id');
			$pendingIncome 	= 	DB::table('incomes')->where('income_collector',$userid)->where('income_status',1)->count('income_id');
			$collected 		= 	DB::table('incomes')->where('income_collector',$userid)->where('income_status',2)->count();
			$depositeIncome = 	DB::table('incomes')->where('income_collector',$userid)->where('income_status',3)->count('income_id');
			$countdata =array (
				'totalIncome' 	=>	$totalIncome,
				'pendingIncome' =>	$pendingIncome,
				'collected' 	=>	$collected,
				'depositeIncome'=>	$depositeIncome,
			);
		}
			return $countdata;

	}

	//If conditatioin
	public static function checkConditation ($data1='',$data2='',$msg='',$msg2='')
	{
		if($data1 == $data2)
		{
			return $msg;
		}else {
			return $msg2;
		}

	}

	//Get income data according to income ref  no
	public static function mailData($income_ref_no,$username,$steps,$status)
	{
		// date_default_timezone_set("asia/Kolkata");
		//echo $status;
		if($status == 3 ){
			$user ='income_collector';
		}else{
			$user='income_receiver';
		}
		$mail = DB::table('incomes')
				->select('incomes.income_amount','incomes.income_ref_no as income_ref_no','incomes.income_date as income_date','incomes.created_at as createat','incomes.guest_name as guest_name','incomes.guest_phone as guest_phone','incomes.guest_email as guest_email','currencies.title as title','income_categories.incate_name as incate_name','users.name as name')
				->leftjoin('income_categories','income_categories.incate_id','incomes.incate_id')
				->leftjoin('currencies','currencies.id','incomes.income_currency')
				->leftjoin('users','users.id','incomes.'.$user)
				->where('incomes.income_ref_no',$income_ref_no)
				->get()
				->toArray();
				foreach($mail as $maildata){
					//Set Array data use for mail template
					$arraydata=array(
					'steps' => $steps,
					'income_ref_no' =>  $maildata->income_ref_no,
					'time' => $maildata->income_date, //Payment Collection Time
					'createtime' => $maildata->createat, //Payment Create Date
					// 'time' => date("d-m-Y h:i:A" ,time()), //Payment Action Time
					'guest' => $maildata->guest_name,	//Guest Name
					'phone' => $maildata->guest_phone,	//Guest Phone Numbar
					'email' => $maildata->guest_email,	//Guest Email
					'currency' => $maildata->title, //Currency Type
					'amount' => $maildata->income_amount, //Amount
					'services' => $maildata->incate_name, //Payment Type
					'sender' => $maildata->name, //Collector and Receiver
					'username' => $username //Username
					);
				}
				//print_r($arraydata); die;
		return $arraydata;
	}

	//Get Company ID from user id
	public static function company_Id($id)
	{

		$cid = DB::table('users')
			->select('company_id')
			->where('id',$id)
            ->first();
			return $cid->company_id;
    }
    public static function company_Name($id)
	{

		$cid = DB::table('companyinfos')
			->where('id',$id)
            ->first();
			return $cid->name;
    }
    //Branch Name
    public static function Branch_Name($id)
	{
		$branch = DB::table('branches')
			->select('name')
			->where('id',$id)
			->first();
			return $branch->name;
    }

    //Get Branch by Company
    public static function getCompanyBranches($company_id)
	{
		$branch = DB::table('branches')
			->select('name')
			->where('company_id',$company_id)
			->first();
			return $branch->name;
    }

    public static function Department_Name($id)
	{
		$dep = DB::table('departments')
			->select('name')
			->where('id',$id)
			->first();
			return $dep->name;
    }

    public static function Role_Name($id)
	{
		$roles = DB::table('roles')
			->select('role_name')
			->where('role_id',$id)
			->first();
		return $roles->role_name;
	}
	//Get User Name
	public static function userName($id)
	{
        if(!empty($id)){
            $uname = DB::table('users')
            ->select('name')
            ->where('id',$id)
            ->first();
            return $uname->name;
        }

	}

	//Get User email
	public static function userMail($id)
	{
		$user = DB::table('users')
			->select('email')
			->where('id',$id)
			->first();
		return $user->email;
	}

    public static function IncomeCategory($id)
    {
        $dname = DB::table('income_categories')
            ->select('incate_name')
            ->where('incate_id',$id)
            ->first();
        return $dname->incate_name;
    }

	//User Department name
	public static function deparmentsName($id)
	{
		$dname = DB::table('departments')
			->select('name')
			->where('id',$id)
			->first();
		return $dname->name;
	}

	public static function setDate($data){
		return date('d-m-Y', strtotime($data));
	}

	public static function setNumbur($data){
		return number_format($data,2);
	}

    //Currecny Symbols
    public static function get_currency_symbol($currency = '')
    {
        $symbols = array(
            'AED' => '&#1583;.&#1573;', // ?
            'AFN' => '&#65;&#102;',
            'ALL' => '&#76;&#101;&#107;',
            'AMD' => '&#1423;',
            'ANG' => '&#402;',
            'AOA' => '&#75;&#122;', // ?
            'ARS' => '&#36;',
            'AUD' => '&#36;',
            'AWG' => '&#402;',
            'AZN' => '&#1084;&#1072;&#1085;',
            'BAM' => '&#75;&#77;',
            'BBD' => '&#36;',
            'BDT' => '&#2547;', // ?
            'BGN' => '&#1083;&#1074;',
            'BHD' => '.&#1583;.&#1576;', // ?
            'BIF' => '&#70;&#66;&#117;', // ?
            'BMD' => '&#36;',
            'BND' => '&#36;',
            'BOB' => '&#36;&#98;',
            'BRL' => '&#82;&#36;',
            'BSD' => '&#36;',
            'BTC' => '&#3647;',
            'BTN' => '&#78;&#117;&#46;', // ?
            'BWP' => '&#80;',
            'BYR' => '&#112;&#46;',
            'BYN' => '&#66;&#114;',
            'BZD' => '&#66;&#90;&#36;',
            'CAD' => '&#36;',
            'CDF' => '&#70;&#67;',
            'CHF' => '&#67;&#72;&#70;',
            'CLF' => '', // ?
            'CLP' => '&#36;',
            'CNY' => '&#165;',
            'COP' => '&#36;',
            'CRC' => '&#8353;',
            'CUC' => '&#8396;',
            'CUP' => '&#8396;',
            'CVE' => '&#36;', // ?
            'CZK' => '&#75;&#269;',
            'DJF' => '&#70;&#100;&#106;', // ?
            'DKK' => '&#107;&#114;',
            'DOP' => '&#82;&#68;&#36;',
            'DZD' => '&#1583;&#1580;', // ?
            'EGP' => '&#163;',
            'ERN' => '&#78;&#102;&#107;', // ?
            'ETB' => '&#66;&#114;',
            'EUR' => '&#8364;',
            'FJD' => '&#36;',
            'FKP' => '&#163;',
            'GBP' => '&#163;',
            'GEL' => '&#4314;', // ?
            'GGP' => '&#163;',
            'GHS' => '&#162;',
            'GIP' => '&#163;',
            'GMD' => '&#68;', // ?
            'GNF' => '&#70;&#71;', // ?
            'GTQ' => '&#81;',
            'GYD' => '&#36;',
            'HKD' => '&#36;',
            'HNL' => '&#76;',
            'HRK' => '&#107;&#110;',
            'HTG' => '&#71;', // ?
            'PKE' => '&#36;',
            'HUF' => '&#70;&#116;',
            'IDR' => '&#82;&#112;',
            'ILS' => '&#8362;',
            'IMP' => '&#163;',
            'INR' => '&#8377;',
            'IQD' => '&#1593;.&#1583;', // ?
            'IRR' => '&#65020;',
            'IRT' => '&#65020;',
            'ISK' => '&#107;&#114;',
            'JEP' => '&#163;',
            'JMD' => '&#74;&#36;',
            'JOD' => '&#74;&#68;', // ?
            'JPY' => '&#165;',
            'KES' => '&#75;&#83;&#104;', // ?
            'KGS' => '&#1083;&#1074;',
            'KHR' => '&#6107;',
            'KMF' => '&#67;&#70;', // ?
            'KPW' => '&#8361;',
            'KRW' => '&#8361;',
            'KWD' => '&#1583;.&#1603;', // ?
            'KYD' => '&#36;',
            'KZT' => '&#1083;&#1074;',
            'LAK' => '&#8365;',
            'LBP' => '&#163;',
            'LKR' => '&#8360;',
            'LRD' => '&#36;',
            'LSL' => '&#76;', // ?
            'LTL' => '&#76;&#116;',
            'LVL' => '&#76;&#115;',
            'LYD' => '&#1604;.&#1583;', // ?
            'MAD' => '&#1583;.&#1605;.', //?
            'MDL' => '&#76;',
            'MGA' => '&#65;&#114;', // ?
            'MKD' => '&#1076;&#1077;&#1085;',
            'MMK' => '&#75;',
            'MNT' => '&#8366;',
            'MOP' => '&#77;&#79;&#80;&#36;', // ?
            'MRO' => '&#85;&#77;', // ?
            'MUR' => '&#8360;', // ?
            'MVR' => '.&#1923;', // ?
            'MWK' => '&#77;&#75;',
            'MXN' => '&#36;',
            'MYR' => '&#82;&#77;',
            'MZN' => '&#77;&#84;',
            'NAD' => '&#36;',
            'NGN' => '&#8358;',
            'NIO' => '&#67;&#36;',
            'NOK' => '&#107;&#114;',
            'NPR' => '&#8360;',
            'NZD' => '&#36;',
            'OMR' => '&#65020;',
            'PAB' => '&#66;&#47;&#46;',
            'PEN' => '&#83;&#47;&#46;',
            'PGK' => '&#75;', // ?
            'PHP' => '&#8369;',
            'PKR' => '&#8360;',
            'PLN' => '&#122;&#322;',
            'PYG' => '&#71;&#115;',
            'QAR' => '&#65020;',
            'RON' => '&#108;&#101;&#105;',
            'RSD' => '&#1044;&#1080;&#1085;&#46;',
            'RUB' => '&#1088;&#1091;&#1073;',
            'RWF' => '&#1585;.&#1587;',
            'SAR' => '&#65020;',
            'SBD' => '&#36;',
            'SCR' => '&#8360;',
            'SDG' => '&#163;', // ?
            'SEK' => '&#107;&#114;',
            'SGD' => '&#36;',
            'SHP' => '&#163;',
            'SLL' => '&#76;&#101;', // ?
            'SOS' => '&#83;',
            'SPL' => '&#163;',
            'SRD' => '&#36;',
            'STD' => '&#68;&#98;', // ?
            'SVC' => '&#36;',
            'SYP' => '&#163;',
            'SZL' => '&#76;', // ?
            'THB' => '&#3647;',
            'TJS' => '&#84;&#74;&#83;', // ? TJS (guess)
            'TMT' => '&#109;',
            'TND' => '&#1583;.&#1578;',
            'TOP' => '&#84;&#36;',
            'TRY' => '&#8356;', // New Turkey Lira (old symbol used)
            'TTD' => '&#36;',
            'TVD' => '&#36;',
            'TWD' => '&#78;&#84;&#36;',
            'TZS' => '',
            'UAH' => '&#8372;',
            'UGX' => '&#85;&#83;&#104;',
            'USD' => '&#36;',
            'UYU' => '&#36;&#85;',
            'UZS' => '&#1083;&#1074;',
            'VEF' => '&#66;&#115;',
            'VND' => '&#8363;',
            'VUV' => '&#86;&#84;',
            'WST' => '&#87;&#83;&#36;',
            'XAF' => '&#70;&#67;&#70;&#65;',
            'XCD' => '&#36;',
            'XDR' => '',
            'XOF' => '',
            'XPF' => '&#70;',
            'ZAR' => '&#82;',
            'ZMW' => '&#90;&#75;',
        );
        if (isset($symbols[$currency])) {
            return $symbols[$currency];
        }
        return $currency;
    }

    //echo get_currency_symbol('INR');
	public static function  encode_arr($data) {
		return base64_encode(serialize($data));
	}

	public static function decode_arr($data) {
		return unserialize(base64_decode($data));
	}

}
