<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{

    use HasFactory;
    
    protected $primaryKey='income_id';


    public function category()
    {
        return $this->belongsTo('App\Models\IncomeCategory','incate_id','incate_id');
    }
    public function currency()
    {
        return $this->belongsTo('App\Models\Currency','income_currency','id');
    }
    public function user()
    {
      return $this->belongsTo('App\Models\User','income_collector','id');
    }

    public function companyinfo()
    {
      return $this->belongsTo('App\Models\Companyinfo','company_id','id');
    }

}
