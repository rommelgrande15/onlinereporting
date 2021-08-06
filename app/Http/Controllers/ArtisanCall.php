<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;

class ArtisanCall extends Controller
{
    public function callArtisan(){
    	Artisan::call('config:cache');
    	// Artisan::call('migrate');
    	// Artisan::call('db:seed');
    	return response('Cache Cleared!', 200)->header('Content-Type', 'text/plain');
    }
}
