<?php

namespace App\Teams;

use App\Spark;
use App\Scopes\TeamScopeTrait;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use TeamScopeTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'modules';

    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get the team that owns the module.
     */
    public function team()
    {
        return $this->belongsTo(Spark::model('teams', Team::class), 'team_id');
    }
    
    /**
     * Get all of the users that can use this model.
     */
    public function users()
    {
        return $this->belongsToMany(Spark::model('users', \App\User::class), 'user_modules')->withPivot(['role','editor']);
    }
    
    public function scopeActive($query) 
    {
        return $query->where('active','1');
    }

    /**
     * Determine if the module active
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active; 
    }
    
    /**
     * Toggle module status 
     *
     * @return bool
     */
    public function toggleStatus()
    {
        $this->active = !$this->active;
        $this->save();
    }
}
