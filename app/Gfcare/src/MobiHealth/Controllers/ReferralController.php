<?php

namespace App\Gfcare\src\MobiHealth\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

use App\GfCare\src\MobiHealth\Models\Referral;

class ReferralController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request, $teamId=null)
    {
        $referrals = Referral::all();
        return response()->json($referrals);
    }
    
    public function store(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
                                   'mhv' => 'required|numeric',
                                   'supervisor' => 'required|numeric',
                                  ]);

        $referral = Referral::whereRaw('mhv=? and supervisor=?',array($request->mhv,$request->supervisor))->first();

        if(!$referral) {
            $referral = new Referral();
            $referral->mhv = $request->mhv;
            $referral->supervisor = $request->supervisor;
            $referral->modified_by = $user->id;
            $referral->team_id = $user->current_team_id;
            $referral->save();
        }
        
        return $this->getReferrals(); 
    }

    public function update(Request $request, $referralId)
    {
        $user = $request->user();
        $referral = Referral::findOrFail($referralId);
        $this->validate($request, [
                                   'mhv' => 'required|numeric',
                                   'supervisor' => 'required|numeric',
                                  ]);

        $referral->mhv = $request->mhv;
        $referral->supervisor = $request->supervisor;
        $referral->modified_by = $user->id;
        $referral->save();

        return $referral;; 
    }

    public function destroy(Request $request, $referralId)
    {
        $referral = Referral::findOrFail($referralId); 
        $referral->delete();
        return $this->getReferrals(); 
    }

    private function getReferrals()
    {
        return Referral::all();
    }
}
