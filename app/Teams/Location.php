<?php

namespace App\Teams;

use App\Spark;
use App\Scopes\TeamScopeTrait;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use TeamScopeTrait;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'locations';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','parent_id','type','level'];

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
     * Get the team that owns the location.
     */
    public function team()
    {
        return $this->belongsTo(Spark::model('teams', Team::class), 'team_id');
    }

    /**
     * Get the parent location
     */
    public function parent()
    {
        return ($this->parent_id==0) ? null : $this->belongsTo(Spark::model('locations', Location::class), 'parent_id');
    }
    
    public function isParent() 
    {
        return Location::where('parent_id', $this->id)->exists();
    }
    
    public function hasFacilities()
    {
        return Facility::where('location_id', $this->id)->exists();
    }
}
