<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role_has_permissions extends Model
{
    protected $primaryKey='role_id';
    use HasFactory;
}
