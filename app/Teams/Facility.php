<?php

namespace App\Teams;

use App\Spark;
use App\Scopes\TeamScopeTrait;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use TeamScopeTrait;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'locations_facility';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['location_id','type','name','contact','address','email','phonenumber',
                           'longitude','latitude','path'];

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
     * Get the team that owns the facility.
     */
    public function team()
    {
        return $this->belongsTo(Spark::model('teams', Team::class), 'team_id');
    }

    /**
     * Get the location
     */
    public function location()
    {
        return $this->belongsTo(Spark::model('locations', Location::class), 'location_id');
    }
    
    /*
     * Remove from facility Groups
     */
    public function removeFromGroups()
    {
        //TODO: find id in facilitycolumn and fix    
    }
}
