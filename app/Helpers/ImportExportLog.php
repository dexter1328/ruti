<?php

namespace App\Helpers;
use Request;
use App\LogActivity as LogActivityModel;


class ImportVendor
{
    public static function addToLog($subject)
    {
        if($subject == 'Import Vendor'){
            $action = 'Import';
            $module = 'Vendor';
        }
        if($subject == 'Export Vendor'){
            $action = 'Export';
            $module = 'Vendor';
        }
        if($subject == 'Import Store'){
            $action = 'Import';
            $module = 'Store';
        }
        if($subject == 'Export Store'){
            $action = 'Export';
            $module = 'Store';
        }
        if($subject == 'Import Product'){
            $action = 'Import';
            $module = 'Product';
        }
        if($subject == 'Export Product'){
            $action = 'Import';
            $module = 'Product';
        }
    	$log = [];
    	$log['subject'] = $subject;
    	$log['url'] = Request::fullUrl();
    	$log['method'] = Request::method();
    	$log['ip'] = Request::ip();
    	$log['agent'] = Request::header('user-agent');
    	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;
        $log['type'] = 'vendor';
        $log['action'] = $action;
        $log['module'] = $module;
    	LogActivityModel::create($log);
    }


    public static function logActivityLists()
    {
    	return LogActivityModel::latest()->get();
    }


}