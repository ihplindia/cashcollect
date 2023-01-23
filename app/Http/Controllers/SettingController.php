<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;
use App\Models\Role;
use App\Models\setting;
use App\Models\SysetmLogs;

class SettingController extends Controller
{
    public $key='';
    public $value='';
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $allsetting = Setting::orderBy('id','DESC')->get();
        return view('setting.all',compact('allsetting'));
    }

    public function add()
    {
        return view('setting.add');
    }

    public function insert(Request $request)
    {

        $this->validate($request,[
        'key' => ['required','string','max:255'],
        'value' => ['required','string','max:255'],
        ],[
            'key.required' => 'Key name',
            'value.required' => 'Enter Value'
        ]);
       extract($request->input());
        //  print_r($data); die;
        $insert = Setting::insertGetId([
            'key' => $key,
            'value' => $value,
            'created_at' =>  Carbon::now()->toDateTimeString(),
        ]);
        if($insert)
        {
            if(isset($key))
            $this->key=$key;
            if(isset($value))
            $this->value=$value;
            $msg ='Key= '.$this->key.' , and value = '.$value;
            $logs=SysetmLogs::insert([
                'action_id' => $insert,
                'user_id'   => Auth::user()->id,
                'user_ip'   => \request()->ip(),
                'title'     => 'New Data Create',
                'action'      => $msg,
                'created_at' 	=> Carbon::now('Asia/Kolkata')
            ]);
            session::flash('success','Successfuylly added');
            return redirect('dashboard/setting');
        }else
        {
            session::flash('error','Opps! please try again.');
            return redirect('dashboard/setting/add');
        }
    }

    public function edit($id)
    {
        $settingId=Setting::where('id',$id)->firstOrFail();
        return view('setting/edit',compact('settingId'));
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'key' => ['required','string','max:255'],
            'value' => ['required','string','max:255'],
        ],[
            'key.required' => 'Key name',
            'value.required' => 'Enter Value'
        ]);
        $data = Setting::where('id',$request->id)->firstOrFail();
        $upsetting = Setting::findOrFail($request->id);
        $upsetting->key = $request->key;
        $upsetting->value =$request->value;
        $upsetting->updated_at = Carbon::now()->toDateTimeString();
        if($upsetting->update()){
            $comp = array(
                'key' =>  $data['key'],
                'value' =>  $data['value']
            );
            $logs = array_diff($comp,$request->input());
            extract($logs);
            if(isset($key))
            $this->key=$key;
            if(isset($value))
            $this->value=$value;
            $msg ='key = '.$request->key. ' > ' . $data->key. ', values' .$request->value.' > '.$data->value;
            $logs=SysetmLogs::insert([
                'user_id'   => Auth::user()->id,
                'action_id' => $request->id,
                'user_ip'   => \request()->ip(),
                'title'     => 'Setting Modification',
                'action'      => $msg,
                'created_at' 	=> Carbon::now('Asia/Kolkata')
            ]);
            session::flash('success','Data updated seccessfully');
            return redirect('dashboard/setting');
        }else
        {
            session::flash('error','Opps! please try again.');
            return redirect('dashboaed/setting/edit'.$request->id);
        }
    }
}
