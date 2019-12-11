<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Priceset extends Model
{
    protected $fillable = ['priceset_type','category_id','slug'];
    public $timestamps = true;

    public function category(){
    	/*return $this->belongsTo(Category::class);*/
    	return $this->belongsTo('App\Category','category_id');
    }
    public function price(){
    	return $this->belongsTo('App\Price');
    }
}
