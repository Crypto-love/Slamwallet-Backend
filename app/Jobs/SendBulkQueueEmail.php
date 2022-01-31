<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Mail;
use App\Mail\BulkEmail;

class SendBulkQueueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $details;
    public $timeout = 7200; // 2 hours

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = User::where('email', 'hussein@slamcoin.io')->get();
        $input['subject'] = $this->details['subject'];

        foreach ($data as $key => $value) {
            $input['email'] = $value->email;
            $input['name'] = $value->name;
            \Mail::send("emails.bulkEmails", ["details"=>$this->details], function($message) use($input){
                $message->to($input['email'], $input['name'])
                    ->subject($input['subject']);
            });
        }
    }
}
