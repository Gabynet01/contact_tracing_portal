<?php

namespace App\Console\Commands;

use App\FormRequester;
use Carbon\Carbon;
use App\Notifier;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotifyHelpdesk extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:notifyHelpdesk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will notify IT Helpdesk when a wifi code generation is due to be sent to the requester';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        return Log::info("sending email!");
        $notifyResults = FormRequester::where("it_helpdesk", "<>", "")
        ->where("it_helpdesk_status", "approved")
        ->whereNotNull("date_to_receive_code")
        ->whereNull("notify_requester_code")
        ->whereBetween(DB::raw("UNIX_TIMESTAMP(date_to_receive_code)"), [Carbon::now()->subMinute()->getTimestamp(), Carbon::now()->addMinute()->getTimestamp()]);

        $notifyResults->chunk(100, function($requesters)  {
            foreach($requesters as $requester) {
                Log::info("sending email!");
                $mailFunc = new Notifier();
                $message = view('layouts.email', ['link' => route('Dashboard'), 'myMessage' => 'Kindly send the wifi code to this requester email '.$requester->requester_email.' at this time '.$requester->date_to_receive_code, 'email' => $requester->it_helpdesk]);
                $response = $mailFunc->sendGuestWifiEmail($requester->requester_email, $message);

                if ($response == 200) {
                    Log::info("I will be setting the current date inside the notifier column in db!");

                    $requesterForm =  FormRequester::where("form_id", $requester->form_id)->first();

                    $requesterForm->notify_requester_code =  Carbon::now();

                    $saveResults = 0;
                    DB::beginTransaction();
                    $saveResults = $requesterForm->save();
                    DB::commit();

                    if ($saveResults) {
                        Log::info("Successfully set value into db");
                    }
                }

            }
        });
    }
}
