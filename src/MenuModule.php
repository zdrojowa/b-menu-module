<?php

namespace Selene\Modules\MenuModule;

use Illuminate\Support\Collection;
use Selene\Modules\Module;
use Selene\Support\Facades\ModuleManager;

class MenuModule extends Module
{


    public function __construct()
    {
        $this->getModulesMenus();
    }

    public function getModulesMenus() {
        $menuItems = new Collection;

        foreach (ModuleManager::getModules() as $module) {
            if(!method_exists($module, 'menuItems')) continue;

            foreach ($module->menuItems() as $menuItem) {
                $menuItems->put($menuItem['name'], $menuItem);
            }
        }

        return $menuItems;
    }
}
