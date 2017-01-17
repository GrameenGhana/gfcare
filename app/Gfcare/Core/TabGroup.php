<?php

namespace App\Gfcare\Core;

use App\Ux\Settings\Tab;
use App\Ux\Settings\Tabs;

class TabGroup {
    public $name;
    private $editorOnly;
    private $adminOnly;
    
    public function __construct($name, $editonly=false, $adminonly=false) 
    {
        $this->name = $name;
        $this->editorOnly = $editonly;
        $this->adminOnly =  $adminonly;
    }
    
    public function canShow($user) 
    {
        return ((!$this->editorOnly || $user->isSystemEditor()) && 
                (!$this->adminOnly  ||  $user->isSystemAdmin()));    
    }
}
