<?php

namespace App\Gfcare;

use Exception;
use JsonSerializable;

class Module implements JsonSerializable
{
    /**
     * The Stripe ID of the module.
     *
     * @var string
     */
    public $id;

    /**
     * The human-readable name of the module.
     *
     * @var string
     */
    public $name;

    /**
     * The description of the module.
     *
     * This description should be in a human-readable format.
     *
     * @var string
     */
    public $description;

    /**
     * The menu name of the module.
     *
     * This is a human-readable nav menu name for module 
     *
     * @var string
     */
    public $menu_name;

    /**
     * The menu slug of the module.
     *
     * This is a URL link fore nav menu for module 
     *
     * @var string
     */
    public $menu_slug;

    /**
     * The directory name of the module 
     *
     * The directory name of the module 
     *
     * @var string
     */
    public $module_path;
    
    /**
     * Specifies whether the module is active.
     *
     * @var bool
     */
    public $active = true;

    /**
     * Create a new module instance.
     *
     * @param  string  $name
     * @param  string  $id
     * @return void
     */
    public function __construct($name, $id, $description='')
    {
        $this->id = $id;
        $this->name = $name;
        $this->menu_slug = str_replace(" ","-",strtolower($name));
        $this->description = $description;
    }

    /**
     * Determine whether the module is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set the Stripe ID of the module.
     *
     * @param  string  $id
     * @return $this|string
     */
    public function id($id = null)
    {
        if (is_null($id)) {
            return $this->id;
        }

        $this->id = $id;

        return $this;
    }

    /**
     * Set the display name of the module.
     *
     * @param  string  $name
     * @return $this|string
     */
    public function name($name = null)
    {
        if (is_null($name)) {
            return $this->name;
        }

        $this->name = $name;

        return $this;
    }

    /**
     * Set the description of the module.
     *
     * @param  string  $description
     * @return $this|string
     */
    public function description($description = null)
    {
        if (is_null($description)) {
            return $this->description;
        }

        $this->description = $description;

        return $this;
    }
    
     /**
     * Set the menu name of the module.
     *
     * @param  string  $menu_name
     * @return $this|string
     */
    public function module_path($path = null)
    {
        if (is_null($path)) {
            return $this->module_path;
        }

        $this->module_path = $path;

        return $this;
    }

    /**
     * Set the menu name of the module.
     *
     * @param  string  $menu_name
     * @return $this|string
     */
    public function menu_name($menu_name = null)
    {
        if (is_null($menu_name)) {
            return $this->menu_name;
        }

        $this->menu_name = $menu_name;

        return $this;
    }

    /**
     * Set the menu url of the module.
     *
     * @param  string  $menu_slug
     * @return $this|string
     */
    public function menu_slug($menu_slug = null)
    {
        if (is_null($menu_slug)) {
            return $this->menu_slug;
        }

        $this->menu_slug = $menu_slug;

        return $this;
    }

    /**
     * Specify that the module is currently hidden.
     *
     * @return $this
     */
    public function hidden()
    {
        $this->active = false;

        return $this;
    }

    /**
     * Get the JSON serializable fields for the object.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'menu_name' => $this->menu_name,
            'menu_slug' => $this->menu_slug,
            'active' => $this->active,
        ];
    }

    /**
     * Provide dynamic access to the object's methods as properties.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        if (method_exists($this, $key)) {
            return $this->{$key}();
        }

        throw new Exception("No property or method [{$key}] exists on this object.");
    }
}
