<?php

namespace App\Teams;

use App\Spark;
use App\Scopes\TeamScopeTrait;
use Illuminate\Database\Eloquent\Model;

class FacilityGroup extends Model
{
    use TeamScopeTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'locations_facilitygroups';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type','name','facilities','path'];
    
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
     * Get the team that owns the facility group.
     */
    public function team()
    {
        return $this->belongsTo(Spark::model('teams', Team::class), 'team_id');
    }
}
