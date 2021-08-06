<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspectionProduct extends Model
{
	public function products(){
		return $this->hasMany('App\Product');
	}
    
}
