<?php namespace App\Validators;

use Illuminate\Validation\Validator as Validator;
    
class LocationParentValidator extends Validator
{
    protected function validateLocationParent($attribute, $value, $parameters, $validator)
    {
        return ($value==0 || \App\Teams\Location::where('id',$value)->exists()); 
    }
}
