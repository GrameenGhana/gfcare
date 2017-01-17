<?php

namespace App\Gfcare;

use App\Gfcare\Modules;
use App\Gfcare\LocationTypes;


trait Gfcare
{
    /**
     * The GFCare tools collection instance.
     *
     * @var \App\Gfcare\Modules
     */
    protected static $modules;

    /**
     * The GFCare location type collection instance.
     *
     * @var array 
     */
    protected static $location_types;

    /**
     * The GFCare facitlity types collection instance.
     *
     * @var array 
     */
    protected static $facility_types;

    /**
     * The GFCare facitlity group types collection instance.
     *
     * @var array 
     */
    protected static $facilitygroup_types;
    
    /**
     * Define a new GFCare module.
     *
     * @param  string  $name
     * @param  string  $id
     * @return \App\Gfcare\Module
     */
    public static function module($name, $id = null)
    {
        return static::modules()->create($name, $id);
    }

    /**
     * Get the GFCare modules collection.
     *
     * @return \App\Gfcare\Modules
     */
    public static function modules()
    {
        return static::$modules ?: static::$modules = new Modules;
    }
    
    /**
     * Get the directory path for a module
     *
     * @param  string  $menu_slog
     * @return string
     */
    public static function getModulePath($menu_slug) 
    {
        foreach(static::$modules as $m) {
            if ($m->menu_slug==$menu_slug) {
                return $m->module_path;
            }
        }
        return null;
    }

    /**
     * Get or define the team location types 
     *
     * @param  array|null  $location_types
     * @return array|void
     */
    public static function locationTypes(array $types = null)
    {
        if (is_null($types)) {
            return (sizeof(static::$location_types)) ? static::$location_types : ['Country'];
        } else {
            static::$location_types = $types;
        }
    }
    
    /**
     * Get or define the team facility types 
     *
     * @param  array|null  $facility_types
     * @return array|void
     */
    public static function facilityTypes(array $types = null)
    {
        if (is_null($types)) {
            return (sizeof(static::$facility_types)) ? static::$facility_types : ['Clinic'];
        } else {
            static::$facility_types = $types;
        }
    }

    /**
     * Get or define the team facility group types 
     *
     * @param  array|null  $facilitygroup_types
     * @return array|void
     */
    public static function facilityGroupTypes(array $types = null)
    {
        if (is_null($types)) {
            return (sizeof(static::$facilitygroup_types)) ? static::$facilitygroup_types : ['Zone'];
        } else {
            static::$facilitygroup_types = $types;
        }
    }
}
