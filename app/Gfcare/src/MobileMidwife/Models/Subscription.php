<?php

namespace App\Gfcare\src\MobileMidwife\Models;

use App\Scopes\TeamScopeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

use App\GfCare\src\MobileMidwife\Models\Program;

class Subscription extends Model
{
    protected $table = 'mod_mm_subscriptions';

    protected $guarded = [];

    protected $hidden = [];

    public function subscriber()
    {
        //return $this->belongsTo('\App\Gfcare\src\MobileMidwife\Models\Subscriber');
         return $this->belongsTo('\App\AppUser');
    }

    public function program()
    {
        return $this->belongsTo('\App\Gfcare\src\MobileMidwife\Models\Program');
    }
    
    public function canBeActive()
    {
        return (strototime($this->end_date) > strototime(date('Y-m-d')));
    }
    
    public function setStatus($status)
    {
        $this->status = $status;
        $this->save();
    }

    public function increaseWeek($week)
    {
        Log::info('week ' .$week);
        $this->current_week = (int)$week + 1;


        Log::info('current week ' .$this->current_week);
        $this->save();

    }
    
    public function activate()  { $this->setStatus('Active'); }

    public function pause() {  $this->setStatus('Paused'); }
    
    public function cancel() { $this->setStatus('Cancel'); }
    
    public function expire() { $this->setStatus('Expired'); }

    public function complete() { $this->setStatus('Completed'); }

    public function unpause() 
    {
        if ($this->canBeActive()) { $this->activate(); } else { $this->expire(); }
    }
    
    public static function subscribe($client)
    {
          
          Log::info('find program ' .$client);
         $p = Program::find($client->program);

         
        //if ($p) {
          //  $channel = Program::validateChannel($client->channel);
            
            //if ($channel=='both') {
               // Subscription::add($client, $program, 'sms');  
           //     Subscription::add($client, $program, 'voice');   
          //  } else {
                Subscription::add($client, $p,'sms');   
           // }
       // }
    }
                                
    public static function add($client, $p,$channel)
    {               
        $i = new Subscription();
        $i->team_id = $client->id;
        $i->module_id = 1;
        $i->program_id = $client->program;
        $i->client_id = $client->id;
        $i->channel = $channel;
        $i->start_week = $client->start_week;
        $i->current_week = $client->start_week;
        $i->start_date = date('Y-m-d', strtotime(date('Y-m-d').' +1 week')); 
        $i->end_date = date('Y-m-d', strtotime($i->start_date.' +'.$p->end_week.' week'));
        $i->status = 'Pending';
        $i->registered_by = $client->uuid;
        $i->modified_by = $client->uuid;
        $i->save();     
    }
}
