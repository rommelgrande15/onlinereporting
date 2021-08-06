<?php


namespace App\Helpers;
use Request;
use App\UserLog as LogActivityModel;


class LogActivity
{


    public static function addToLog($category,$category_id,$type,$group_id,$subject)
    {
    	$log = [];
        $log['category'] = $category;
        $log['category_id'] = $category_id;
        $log['type'] = $type;
    	$log['subject'] = $subject;
    	$log['url'] = Request::fullUrl();
    	$log['method'] = Request::method();
    	$log['ip'] = Request::ip();
    	$log['agent'] = Request::header('user-agent');
        $log['group_id'] = $group_id;
    	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;
    	LogActivityModel::create($log);
    }


    public static function logActivityLists()
    {
    	return LogActivityModel::latest()->get();
    }


}