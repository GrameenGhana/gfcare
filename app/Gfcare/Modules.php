<?php

namespace App\Gfcare;

use Countable;
use Exception;
use ArrayIterator;
use JsonSerializable;
use IteratorAggregate;

class Modules implements Countable, IteratorAggregate, JsonSerializable
{
    /**
     * All of the defined modules.
     *
     * @var array
     */
    protected $modules = [];

    /**
     * Create a new module collection instance.
     *
     * @param  array  $modules
     * @return void
     */
    public function __construct(array $modules = [])
    {
        $this->modules = $modules;
    }

    /**
     * Create a new module instance.
     *
     * @param  string  $name
     * @param  string  $id
     * @return \App\Gfcare\Module
     */
    public function create($name, $id)
    {
        return $this->add(new Module($name, $id));
    }

    /**
     * Get module matching a given ID.
     *
     * @param  string  $id
     * @return \App\Gfcare\Module
     */
    public function find($id)
    {
        foreach ($this->modules as $module) {
            if ($module->id === $id) {
                return $module;
            }
        }

        throw new Exception("Unable to find module with ID [{$id}].");
    }

    /**
     * Add a module to the module collection.
     *
     * @param  \App\Gfcare\Module  $module
     * @return \App\Gfcare\Module
     */
    public function add(Module $module)
    {
        $this->modules[] = $module;

        return $module;
    }

    /**
     * Get all of the modules that are active.
     *
     * @return array
     */
    public function active()
    {
        return new self(array_values(array_filter($this->modules, function ($module) {
            return $module->isActive();
        })));
    }

    /**
     * Determine the number of modules in the collection.
     *
     * @return int
     */
    public function count()
    {
        return count($this->modules);
    }

    /**
     * Get an iterator for the collection.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->modules);
    }

    /**
     * Get the JSON serializable fields for the object.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->modules;
    }
}
