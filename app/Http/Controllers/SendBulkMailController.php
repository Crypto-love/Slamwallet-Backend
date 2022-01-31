<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SendBulkMailController extends Controller
{
    public function sendBulkMail(Request $request)
    {
    	$details = [
            'subject' => 'A THANK YOU LETTER TO OUR COMMUNITY!',
            'emailSubject'   => $request->emailSubject,
            'emailContent' => $request->emailContent
    	];

    	// send all mail in the queue.
        $job = (new \App\Jobs\SendBulkQueueEmail($details))
            ->delay(
            	now()
            	->addSeconds(2)
            ); 

        dispatch($job);

        return back();
    }
}
