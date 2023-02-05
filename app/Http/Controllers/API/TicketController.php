<?php

namespace App\Http\Controllers\API;

use DB;
use App\SupportTicket;
use App\Orders;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

class TicketController extends BaseController
{
	public function createTicket(Request $request, $id){

		$ticket_no =  rand(100000, 999999);
        
        $store_id = NULL;
        $order_id = NULL;
        if($request->order_id){
            $order = Orders::where('id',$request->order_id)->first();
            $store_id = $order->store_id;
            $order_id = $order->id;
        }

        $support_ticket = new SupportTicket;
        $support_ticket->user_id = $id;
        $support_ticket->user_type = $request->user_type;
        $support_ticket->subject = $request->subject;
        $support_ticket->message = $request->message;
        $support_ticket->ticket_no = $ticket_no;
        $support_ticket->order_id = $order_id;
        $support_ticket->store_id = $store_id;
        $support_ticket->generated_by = 'customer';
        $support_ticket->save();
      
        if($support_ticket)
        {
            $data = array('user_id'=>(int)$support_ticket->user_id,
                    'user_type'=>$support_ticket->user_type,
                    'subject'=>$support_ticket->subject,
                    'message'=>$support_ticket->message,
                    'ticket_no'=>$support_ticket->ticket_no,
                    'created_at' => 1000 * strtotime($support_ticket->created_at)
                );

            return $this->sendResponse($data,'Your ticket has been created successfully.');
        }
	}

	public function SupportTicketList($id)
    {
        $support_tickets = SupportTicket::where('user_id',$id)
                            ->where('generated_by','customer')
                            ->orderBy('created_at','DESC')
                            ->paginate(10);
        $data = [];
        if($support_tickets->isNotEmpty())
        {	
        	$current_page = $support_tickets->currentPage();
			$total_pages  = $support_tickets->lastPage();	

            foreach($support_tickets as $support_ticket)
            {
                $data[] = array('user_id'=>$support_ticket->user_id,
                    'user_type' => $support_ticket->user_type,
                    'subject' => $support_ticket->subject,
                    'message' => $support_ticket->message,
                    'ticket_no' => (int)$support_ticket->ticket_no,
                    'created_at' => 1000 * strtotime($support_ticket->created_at)
                );
      
            }
            return $this->sendResponse(array('page'=>$current_page,'totalPage'=>$total_pages,'tickets'=>$data),'Data retrieved successfully');
        }
        else
        {
        	return $this->sendResponse(array('page'=>1,'totalPage'=>1,'tickets'=>$data),'We can\'t find proper data to display');
        }
    }
}