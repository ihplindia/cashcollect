<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Currency;
use App\Models\SysetmLogs;

class CurrencyController extends Controller
{
    public $title='';
    public $rate='';
    public $code='';
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $allcurrency =  Currency::orderBy('id','ASC')->get();
        return view('currency.all',compact('allcurrency'));
    }

    public function add()
    {
       return view('currency.add');
    }

    public function Currency_Rate($id)
    {
        $allcurrency =  Currency::where('id',$id)->orderBy('id','ASC')->get();
        foreach($allcurrency as $all)
        {
            $id=$all->id;
            $curl = curl_init();
            $link="https://currency-converter-by-api-ninjas.p.rapidapi.com/v1/convertcurrency?have=$all->code&want=INR&amount=1";
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
                // print_r($response); die;
                $amount= $response['new_amount'];
                $update=Currency::where('id',$id)->update([
                    'rate'=>$amount
                ]);

                if($update){
                    $logs=SysetmLogs::insert([
                        'action_id'   => $id,
                        'user_id'   => Auth::user()->id,
                        'user_ip'   => \request()->ip(),
                        'title'     => 'Currency Rate Edit',
                        'action'      => 'Manuaily currency rate updated by '.Auth::user()->name,
                        'created_at' 	=> Carbon::now('Asia/Kolkata')
                    ]);
                }
            }
        }
        return redirect('dashboard/currency');
    }

    public function insert(Request $request)
    {
        $this->validate($request,['title' => 'required','string','max:255' ,'status' => 'required'],
        ['title.required' => 'Enter Currency Title']
        );
        extract($request->input());
        $insert=Currency::insertGetId([
            'title' => $title,
            'code' => $code,
            'status' => $status
        ]);
        if($insert)
        {
            if(isset($title))
                $this->title=$title;

            if(isset($code))
                $this->code=$code;

            // if(isset($title))
            //     $this->title=$title;
            $msg =' Name = '.$this->title.', Code = '.$this->code;
            $logs=SysetmLogs::insert([
                'action_id'   => $insert,
                'user_id'   => Auth::user()->id,
                'user_ip'   => \request()->ip(),
                'title'     => 'New Payment Currency',
                'action'      => $msg,
                'created_at' 	=> Carbon::now('Asia/Kolkata')
            ]);
            session::flash('success','Currency added successfully');
            return redirect('dashboard/currency');
        }else
        {
            session::flash('error','Ops Try again');
            return redirect('dashboard/currency');
        }

    }

    public function edit($id)
    {
        $currency =Currency::where('id',$id)->firstOrFail();
        return view('currency.edit',compact('currency'));
    }

    public function update(Request $request)
    {
        extract($request->input());
        $data = Currency::where('id',$id)->firstOrFail();
        $currency = Currency::findOrFail($id);
        $currency->title = $title;
        $currency->code = $code;
        $currency->status = $status;

        if($currency->update()){

            if($data->title==$title)
                $this->title=$title;

                // if($data->icon==$icon)
                // $this->icon=$icon;

            $msg = 'Name = '.$data->title.' > '.$this->title.', Code = '.$data->code.' > '.$this->code;
            // $msg =' Name = '.$this->title.' Code = '.$this->code.' Icon code = '.$this->icon;
            $logs=SysetmLogs::insert([
                'action_id'   => $request->id,
                'user_id'   => Auth::user()->id,
                'user_ip'   => \request()->ip(),
                'title'     => 'Currency Modification',
                'action'      => $msg,
                'created_at' 	=> Carbon::now('Asia/Kolkata')
            ]);
            session::flash('success','Data updated seccessfully');
            return redirect('dashboard/currency');
        }else
        {
            session::flash('error','Opps! please try again.');
            return redirect('dashboaed/currency/edit'.$request->id);
        }
    }
}
