<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Priceset extends Model
{
    protected $fillable = ['priceset_type','category_id','slug'];
    public $timestamps = true;
}
