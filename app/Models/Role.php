<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model{
	
	protected $primaryKey='role_id';
    protected $fillable=['role_name'];
    use HasFactory;
}

