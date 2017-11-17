<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;
use App\Console\AfricasTalkingGateway;
//require_once('App\Console\AfricasTalkingGateway.php');

class GfcareCron extends Command
{

   

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gfcare:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'CBCC cron job';

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
        //
    $username = "sammuchiri";
    $apikey = "173533f403c5c79928d95530c3514335f66297c4b31c617d47912d1344ad4523";


    $message = "hello hello testing mic";



// Create a new instance of our awesome gateway class
    $gateway = new AfricasTalkingGateway($username, $apikey);
          
          Log::info("Response -> ");
          $this->info('Demo:Cron Cummand Run successfully!');

          try {
       // Thats it, hit send and we'll take care of the rest. 
      $results = $gateway->sendMessage('+233246005828', $message);
      // $results = $gateway->sendMessage('+254720988213', $message);
     //$results = $gateway->sendMessage('+254799847633', $message);
       foreach ($results as $result) {
           // status is either "Success" or "error message"
           echo " Number: " . $result->number;
           echo " Status: " . $result->status;
           echo " MessageId: " . $result->messageId;
           echo " Cost: " . $result->cost . "\n </br>";
       }
   } catch (AfricasTalkingGatewayException $e) {
       echo "Encountered an error while sending: " . $e->getMessage();
   }


        // echo "Hi I dey here";
    }
}
