<?php

namespace Selene\Modules\MenuModule;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class MenuModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        Blade::directive('menu', function($menu) {
            return '
            <?php 
                $_menu = '.$menu.';
                $_menu .= "_'.app()->getLocale().'";

                $_menu = Selene\Modules\MenuModule\Models\Menu::where("name", $_menu)->first();
                
                if($_menu) {
                    $_structure = $_menu->structure ?? [];
                }
                else {
                    $_structure = [];
                }
              
                       
                if(isset($name)) $temp_name = $name;
                if(isset($value)) $temp_value = $value;
                if(isset($data)) $temp_data = $data;
                if(!$_menu) {
                    $_menu = new \stdClass;
                    $_menu->structure = [];
                }
                 foreach($_menu->structure as $structureItem):
                    $structureItem = (object) $structureItem;
                    
                    if($structureItem->type !== "Blade") {
                        $name = $structureItem->name;
                        $value = $structureItem->value;
                        $data = $structureItem->data ?? [];
                    }
                    else {
                        echo view($structureItem->value, ["data" => $structureItem->data, "value" => $structureItem->value, "name" => $structureItem->name])->render();
                        continue;
                    }
            ?>';
        });

        Blade::directive('endmenu', function() {
            return '<?php
                endforeach;
                
                if(isset($temp_name)) $name = $temp_name;
                if(isset($temp_value)) $value = $temp_value;
                if(isset($temp_data)) $data = $temp_data;
            ?>';
        });
    }
}
