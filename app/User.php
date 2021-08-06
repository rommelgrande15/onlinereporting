<?php

namespace App;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{

	use \Illuminate\Auth\Authenticatable;
	
    public function roles()
    {
    	return $this->belongsToMany('App\Role');
    }

    public function hasAnyRole($roles)
    {
    	if (is_array($roles)) {
    		foreach ($roles as $role) {
    			if ($this->hasRole($role)) {
    				return true;
    			}
    		}
    	} else {
    		if ($this->hasRole($role)) {
    				return true;
    		}
    	}
    	return false;
    }

    public function hasRole($role)
    {
    	if ($this->roles()->where('name',$role)->first()) {
    		return true;
    	}
    	return false;
    }
}
