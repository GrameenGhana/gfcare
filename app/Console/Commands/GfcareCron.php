<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;
use App\Console\AfricasTalkingGateway;
use App\GfCare\src\MobileMidwife\Models\Subscription;
use App\GfCare\src\MobileMidwife\Models\Program;
use App\AppUser;
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


    $message = "Hi,this message is a test for scheduled messages on digiafya.It should be recieved daily, regards Suzzane & Sam :)";

    $subscription = Subscription::where('status','Pending')->get();


 
 /**
    $phonenumbers =  ['+254720988213','+254728441559','+254739203274','+254724968710','+254712208050',
    '+254725536534','+254720225936','+254721649665','+254798569407','+254721523291','+254721240166','+254703252013',
      '+254726854253','+254723749651','+254725943659','+254722366683','+254720988213','+254799847633']; **/

  
     Log::info("Response -> " .$subscription);

   // $Numbers
// Create a new instance of our awesome gateway class
    $gateway = new AfricasTalkingGateway($username, $apikey);
          
          Log::info("Response -> ");
          $this->info('Demo:Cron Cummand Run successfully!');

      


  try {


    foreach ($subscription as $sub)
    {
        $program  =  Program::find($sub->program_id);
         Log::info("Response ->------------------------------------------------------------------"); 
        // Log::info($program);


        $appuser = AppUser::find($sub->client_id);
        Log::info("user phonenumber   " . $appuser->phonenumber);

        $content =  $program->content;

        if(count($content)>0)
        {
          $week = $sub->current_week;
          foreach ($content as $con) {

            if( $week == $con->week)
            {
             Log::info("Message  " . $con->sms_message);

              // Thats it, hit send and we'll take care of the rest. 
         $results = $gateway->sendMessage($appuser->phonenumber, $con->sms_message);
      
        foreach ($results as $result) {
            //status is either "Success" or "error message"
           Log::info( " Number: " . $result->number);
           Log::info( " Status: " . $result->status);
           Log::info( " MessageId: " . $result->messageId);
           Log::info( " Cost: " . $result->cost . "\n </br>");

           if( $result->status=="Success")
           {

             $sub->complete();   
             $sub->increaseWeek($sub->current_week);
           }
          } 
//
           //Log::info("current week " .(int)$sub->current_week);
           //$sub->complete();   
          // $sub->increaseWeek($sub->current_week);

          }


         }
        }



        



    }
/*
    foreach ($phonenumbers as $number)
    {
       // Thats it, hit send and we'll take care of the rest. 
      $results = $gateway->sendMessage($number, $message);

       foreach ($results as $result) {
           // status is either "Success" or "error message"
           Log::info( " Number: " . $result->number);
           Log::info( " Status: " . $result->status);
           Log::info( " MessageId: " . $result->messageId);
           Log::info( " Cost: " . $result->cost . "\n </br>");
       }
    }
    */

    /*
     $results = $gateway->sendMessage('+233246005828', $message);
      // $results = $gateway->sendMessage('+254720988213', $message);
     //$results = $gateway->sendMessage('+254799847633', $message);
       foreach ($results as $result) {
           // status is either "Success" or "error message"
           Log::info( " Number: " . $result->number);
           Log::info( " Status: " . $result->status);
           Log::info( " MessageId: " . $result->messageId);
           Log::info(" Cost: " . $result->cost . "\n </br>");
       }

       */

   } catch (AfricasTalkingGatewayException $e) {
       echo "Encountered an error while sending: " . $e->getMessage();
   }

        // echo "Hi I dey here";
    }
}
