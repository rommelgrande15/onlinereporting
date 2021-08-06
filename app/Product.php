<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	public function inspectionProducts(){
		return $this->belongsTo('App\InspectionProduct');
	}
	
	public function photos()
	{
		return $this->hasMany('App\ProductPhoto');
	}
    
}
