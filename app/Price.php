<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
	public $timestamps = false;
    protected $fillable = ['priceset_id', 'item_id','price'];

    public function priceset(){

    	return $this->hasMany('App\Priceset');
    }

    public function item(){

    	return $this->belongsTo('App\Item','item_id');
    }

}
