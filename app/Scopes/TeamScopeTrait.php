<?php

namespace App\Scopes;

trait TeamScopeTrait 
{
    /**
     * Boot the scope.
     * 
     * @return void
     */
    public static function bootTeamScopeTrait()
    {
        static::addGlobalScope(new TeamScope);
    }
  
    /**
     * Get the query builder without the scope applied.
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function withAllTeams()
    {
        return with(new static)->newQueryWithoutScope(new TeamScope);
    }

}

