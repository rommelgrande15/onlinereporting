<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section;
class CMSApiController extends Controller
{
    public function getPage($page, $lang){
    	$page = Section::where('page', $page)->where('lang', $lang)->get();
    	return response()->json([
    		'page' => $page
    	]);
    }
}
