<?php

namespace App\Traits;
use App\UserNotification;
use Carbon\Carbon;

trait VendorNotification {

	private static $API_SERVER_KEY = 'AAAAyunUF2U:APA91bHMXCfeJYbOUJSPaHQtCX_nWtj1OhRJgoWYc-droLImzCf-pbTbV5mDkPJsIl6FtVATmdpfis7kVhHQWlDNW767IEKWf79Zn3YBSWz1Cc23P6rYM7b9XZUnlKXnLxO7ai0ehU9e';

	public function sendPushNotification($token, $title, $message, $type, $id) 
	{
        $path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';
 
        if(is_array($token)){
            $token_key = 'registration_ids';
        }else{
            $token_key = 'to';
        }
        $fields = array(
            //'registration_ids' => $token,
            //'to' => $token,
            $token_key => $token,
            'priority' => 10,
            'mutable_content' => true,
            'notification' => array(
            	'title' => $title, 
            	'body' =>  $message ,
            	'sound'=>'Default',
            	//'image'=>'Notification Image' 
            ),
            'data' => array(
            	'type' => $type,
                'id' => (int)$id
            ),
        );
        $headers = array(
            'Authorization:key=' . self::$API_SERVER_KEY,
            'Content-Type:application/json'
        );  
       
        // Open connection  
        $ch = curl_init(); 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm); 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // Execute post   
        $result = curl_exec($ch); 
        // Close connection      
        curl_close($ch);

        return $result;

    }
    public function sendVendorNotification($title, $message, $devices ,$type, $id)
    {
        if($devices->isNotEmpty()){

            $device = $devices->last();
           
            $notificationData= array(
                'user_id' => $device->user_id,
                'device_id' => $device->id,
                'reference_id' => $id,
                'user_type' => 'vendor',
                'title' => $title,
                'description' => $message,
                'type' => $type,
                'is_send' => 0,
                'is_read' => 0,
                'resend' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            );

            foreach ($devices as $key => $value) {
                $token = $value->device_token;
                $response = $this->sendPushNotification($token, $title, $message, $type, $id);
                $someArray = json_decode($response, true);

                if($someArray['success'] == 1) {
                    $notificationData['is_send'] = 1;
                    $notificationData['device_id'] = $value->id;
                }
            }
            UserNotification::insert($notificationData);
        }
    }
}
