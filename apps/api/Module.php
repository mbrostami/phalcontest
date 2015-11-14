<?php
namespace Apps\Api;

use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Dispatcher;
use Phalcon\DiInterface;
use Phalcon\Loader; 
use Phalcon\Mvc\Router; 

class Module implements ModuleDefinitionInterface
{

    /**
     * Register a specific autoloader for the module
     */
    public function registerAutoloaders(DiInterface $di = null)
    {  
        $loader = new Loader();
        $loader->registerNamespaces(array(
            __NAMESPACE__ . '\Controllers' => __DIR__ . '/controllers/',
            'Apps\Admin\Models' => '../apps/admin/models/',
            'Apps\Admin\Forms' => '../apps/admin/forms/',
        ));
        
        $loader->registerDirs( array(
            __DIR__ . '/controllers/',
            '../apps/admin/models/',
            '../apps/admin/forms/'
        ));
        $loader->register();  
    }

    /**
     * Register specific services for the module
     */
    public function registerServices(DiInterface $di)
    {  
        // Registering the view component
        $di->set('view', function () {
            $view = new View();
            $view->setRenderLevel(View::LEVEL_NO_RENDER); 
            return $view;
        });
    }
}