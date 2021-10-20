<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discounts extends Model
{
    public $table = "discounts";

    public $fillable = [
        'id','name', 'originalprice','projectid', 'discountprice', 'progressval','picture',
        'created_at', 'updated_at'
    ];

    public $dates = ['created_at', 'updated_at'];
    public $primaryKey = 'id';
}