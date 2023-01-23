<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    public function companyinfo()
    {
        return $this->belongsTo('App\Models\Currency','company_id','id');
    }
}
