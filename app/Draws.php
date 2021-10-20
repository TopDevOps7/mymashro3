<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Draws extends Model
{
    public $table = "draws";

    public $fillable = [
        'id','name', 'discreption', 'priority','status','file',
        'created_at', 'updated_at'
    ];

    public $dates = ['created_at', 'updated_at'];
    public $primaryKey = 'id';
}