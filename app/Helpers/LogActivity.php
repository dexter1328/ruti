<?php

namespace App\Helpers;
use Request;
use Auth;
use App\LogActivity as LogActivityModel;

class LogActivity
{
    public static function addToLog($subject,$id)
    {
        if($subject == 'Import Vendor'){
            $action = 'Import';
            $module = 'Vendor';
            $type = 'vendor';
        }

        if($subject == 'Export Vendor'){
            $action = 'Export';
            $module = 'Vendor';
            $type = 'vendor';
        }

        if($subject == 'Import Store'){
            $action = 'Import';
            $module = 'Store';
            $type = 'vendor';
        }

        if($subject == 'Export Store'){
            $action = 'Export';
            $module = 'Store';
            $type = 'vendor';
        }

        if($subject == 'Import Product'){
            $action = 'Import';
            $module = 'Product';
            $type = 'vendor';
        }

        if($subject == 'Export Product'){
            $action = 'export';
            $module = 'Product';
            $type = 'vendor';
        }

        if($subject == 'Vendor Login'){
            $action = 'Login';
            $module = 'Vendor';
            $type = 'vendor';
        }

        if($subject == 'Supplier Login'){
            $action = 'Login';
            $module = 'Supplier';
            $type = 'supplier';
        }

        if($subject == 'Admin Login'){
            $action = 'Login';
            $module = 'Admin';
            $type = 'admin';
        }

        if($subject == 'Customer Login'){
            $action = 'Login';
            $module = 'Customer';
            $type = 'customer';
        }

    	$log = [];
    	$log['subject'] = $subject;
    	$log['url'] = Request::fullUrl();
    	$log['method'] = Request::method();
    	$log['ip'] = Request::ip();
    	$log['agent'] = Request::header('user-agent');
    	$log['user_id'] = $id;
        $log['type'] = $type;
        $log['action'] = $action;
        $log['module'] = $module;

    	LogActivityModel::create($log);
    }


    public static function logActivityLists()
    {
    	return LogActivityModel::latest()->get();
    }


}
