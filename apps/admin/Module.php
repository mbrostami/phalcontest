<?php
namespace Apps\Admin;

use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Dispatcher;
use Phalcon\DiInterface;
use Phalcon\Loader; 
use Phalcon\Mvc\Router;
use Apps\Admin\Routes\AdminRoutes;

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
            __NAMESPACE__ . '\Models' => __DIR__ . '/models/'
        ));
        
        $loader->registerDirs( array(
            __DIR__ . '/controllers/',
            __DIR__ . '/models/'
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
            $view->setViewsDir(__DIR__ . '/views/');
            $view->registerEngines(
                array(
                    ".phtml" => 'Phalcon\Mvc\View\Engine\Volt'
                )
            );
            return $view;
        });
    }
}