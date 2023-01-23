<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_logs extends Model
{
    use HasFactory;
    protected $table= 'payment_log';
    protected $primarykey=['id'];
    protected $fillable = ['payment_id','user_id','details','update_values'];
}
