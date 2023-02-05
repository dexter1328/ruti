<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message='')
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        // return response()->json($response, 200, []);
        return response()->json($response, 200, [], JSON_PRESERVE_ZERO_FRACTION);
        // return response()->json($response, 200, [], JSON_PRESERVE_ZERO_FRACTION | JSON_NUMERIC_CHECK);
        // return response()->json($response, 200, [], JSON_NUMERIC_CHECK);
        /*$json = json_encode( $response, JSON_PRESERVE_ZERO_FRACTION);
        $json = preg_replace( "/\"(\d+)\"/", '$1', $json );
        echo $json;exit();*/
    }   

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 200)
    {
        $response = [
            'success' => false,
            'data' => null,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}