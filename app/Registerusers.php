<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registerusers extends Model
{
    public $table = "registerusers";

    public $fillable = [
        'id','name', 'email', 'mobile', 'password','datepicker','status','picture',
        'created_at', 'updated_at'
    ];

    public $dates = ['created_at', 'updated_at'];
    public $primaryKey = 'id';
}