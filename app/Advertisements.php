<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisements extends Model
{
    public $table = "advertisements";

    public $fillable = [
        'id','name', 'discreption', 'priority','status','picture',
        'created_at', 'updated_at'
    ];

    public $dates = ['created_at', 'updated_at'];
    public $primaryKey = 'id';
}