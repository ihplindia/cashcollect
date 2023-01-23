<?php

namespace App\Providers;
use Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Helper;
use App\Models\Setting;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $settings = DB::table('settings')->get();
		$mail_info = array();
        foreach ($settings as $mail) {
            $key = $mail->key;
            $mail_info[$key] = $mail->value;
        }

        $MAIL_FROM      = $mail_info['MAIL_FROM'];
        $MAIL_EMAIL     = $mail_info['MAIL_EMAIL'];        
    
        config()->set('settings', $settings); // optional
        config()->set('mail', array_merge(config('mail'), [
            'driver' => 'smtp',
            'from' => [
                'address' => $MAIL_EMAIL,
                'name' => $MAIL_FROM
            ]
        ]));

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $config = DB::table('settings')->get()->toArray();
		$config_info = array();
        foreach ($config as $con) {
            $key = $con->key; 
            $config_info[$key] = $con->value;
        }
        $MAIL_HOST      = $config_info['MAIL_HOST'];
        $MAIL_USERNAME  = $config_info['MAIL_USERNAME'];
        $MAIL_PASSWORD  = $config_info['MAIL_PASSWORD'];
        $MAIL_PORT      = $config_info['MAIL_PORT'];
        $MAIL_FROM      = $config_info['MAIL_FROM'];
        $MAIL_EMAIL     = $config_info['MAIL_EMAIL'];
        $MAIL_SSL       = $config_info['MAIL_SSL'];
        $config = array(
            'host'       => $MAIL_HOST,
            'port'       => $MAIL_PORT,
            'from'       => array('address' => $MAIL_EMAIL, 'name' => $MAIL_FROM),
            'encryption' => $MAIL_SSL,
            'username'   => $MAIL_USERNAME,
            'password'   => $MAIL_PASSWORD,
        );
        Config::set('mail', $config);
    }
    
}
