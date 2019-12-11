<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
	protected $fillable = ['category_id','name','description','quantity', 'slug','updated_at','created_at'];
	//protected $guarded = ['*'];
	//public $timestamps = false;

	public function category(){
		return $this->hasOne('App\Category');
	}

	public function prices(){
		return $this->hasMany('App\Price');
	}
}
