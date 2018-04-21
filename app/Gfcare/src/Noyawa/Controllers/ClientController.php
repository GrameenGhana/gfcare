<?php

namespace App\Gfcare\src\Noyawa\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\AppUser;
use App\User;
use App\GfCare\src\Noyawa\Models\Client;

class ClientController extends Controller
{
    public function show(Request $request, $teamId=null)
    {
        $clients = Client::all();
        return response()->json($clients);
    }
    
       public function showKijana(Request $request, $teamId=null)
    {
        $users = AppUser::where('app_data','kj')->get();
        return response()->json($users);
    }
    public function store(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
                                   'name' => 'required|max:255',
                                   'user_id' => 'required|exists:users,id',
                                   'registered' => 'required|in:0,1',
                                  ]);

        $client = Client::whereRaw('name=? and user_id=?',array($request->name,$request->user_id))->first();

        if(!$client) {
            $client = new Client();
            $client->name = $request->name;
            $client->team_id = $user->current_team_id;
            $client->user_id = $request->user_id;
            $client->registered = $request->registered;
            $client->registration_date = ($request->registered) ? date('Y-m-d') : ''; 
            $client->modified_by = $user->id;
            $client->save();
        }
        
        return response()->json($client); 
    }

    public function update(Request $request, $clientId)
    {
        $user = $request->user();
        $client = Client::findOrFail($clientId);
        $this->validate($request, [
                                   'name' => 'required|max:255',
                                   'user_id' => 'required|exists:users,id',
                                   'registered' => 'required|in:0,1',
                                  ]);

            $client->name = $request->name;
            $client->team_id = $user->current_team_id;
            $client->user_id = $request->user_id;
            $client->registered = $request->registered;
            $client->registration_date = ($request->registered) ? date('Y-m-d') : ''; 
            $client->modified_by = $user->id;
            $client->save();

        return $client; 
    }

    public function destroy(Request $request, $clientId)
    {
        $client = Client::findOrFail($clientId); 
        $client->delete();
        return $client; 
    }
}
