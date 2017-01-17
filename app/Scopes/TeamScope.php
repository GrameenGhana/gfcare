<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ScopeInterface;
 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Exception;

use App\Teams\Module;

class TeamScope implements ScopeInterface
{
    public function apply(Builder $builder, Model $model)
    {
        $user = Auth::user();
        if ($user) {
            $builder->where($model->getTable().'.team_id', $user->current_team_id);
        } 
    }
}

