<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['category_name','slug'];

    public function priceset(){
    	
		return $this->hasMany('App\Priceset','category_id');
    }

    public function item(){
    	/*return $this->hasMany(Priceset::class);*/
		return $this->belongsTo('App\Item');
    }
}
