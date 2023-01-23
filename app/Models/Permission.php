<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $permisiion='permission';
    public function permissionnfo()
    {
        return $this->belongsTo('App\Models\PermissionGroup','group_name','id');
    }
}
