<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysetmLogs extends Model
{
    use HasFactory;
    protected $table= 'system_logs';
    protected $primarykey=['id'];
    protected $fillable = ['user_id','title','user_ip','action'];

    public function user()
    {
      return $this->belongsTo('App\Models\User','user_id','id');
    }
}
