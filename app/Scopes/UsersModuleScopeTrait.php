<?php

namespace App\Scopes;

trait UsersModuleScopeTrait 
{
    /**
     * Boot the scope.
     * 
     * @return void
     */
    public static function bootUsersModuleScopeTrait()
    {
        static::addGlobalScope(new UsersModuleScope);
    }
  
    /**
     * Get the query builder without the scope applied.
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function withNonModuleUsers()
    {
        return with(new static)->newQueryWithoutScope(new UsersModuleScope);
    }

}

