<?php

namespace App\Gfcare\src\MobiHealth\Models;

use App\Spark;
use App\User;
use App\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\TeamScopeTrait;


class Role extends Model
{
    use TeamScopeTrait;
    
    protected $table = 'mod_mobi_roles';

    protected $guarded = [];

    protected $hidden = [];

    public function team()
    {
        return $this->belongsTo(Spark::model('teams', Team::class), 'team_id');
    }

    public function users()
    {
        $u = $this->usersModuleByRole();
        $u->transform(function ($item, $key) { return $item->user_id; });
        return User::find($u->all());
    }
    
    public function updateUserModuleRole($role, $isEditor)
    {        
        $ums = $this->usersModuleByRole();
        foreach($ums->all() as $um) {
                DB::update('update user_modules set role=?, editor=? where id=?', [$role, $isEditor, $um->id]);
        }
    }

    public function toggleEditorStatus()
    {
        $this->is_editor = !$this->is_editor;
        $this->save();
    }
    
    private function usersModuleByRole()
    {
        $user = Auth::user();
        $um = DB::table('user_modules')
                    ->whereRaw('team_id=? and module_id=? and role=?',array($this->team_id, $user->current_module_id, $this->name))
                    ->get();
        return collect($um);
    }
}
