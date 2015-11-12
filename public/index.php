<?php
error_reporting(E_ALL);

use Phalcon\Mvc\Application;
use Phalcon\Config\Adapter\Ini as ConfigIni;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Router;
use Phalcon\Config\Adapter\Ini;
use Phalcon\Loader;

try {
    define('APP_PATH', realpath('..') . '/');
    
    $di = new FactoryDefault();
    
    // register routes namespace
    $loader = new Loader();
    $loader->registerNamespaces(array(
        'Routes' => '../routes/'
    ));
    $loader->registerDirs(array(
        '../routes/'
    ))->register();
     
    $iniConfig = new Ini('../configs/config.ini');
    $di->set('router', function () use ($iniConfig) {
        
        $router = new Router();
        
        $router->setDefaultModule($iniConfig->application->defaultModule);
        // auto check module names for mounting router groups
        if ($iniConfig->modules) {
            foreach ($iniConfig->modules as $moduleName => $moduleNamespace) {
                // Add the group to the router
                $routeGroupClass = ucwords($moduleName) . 'Routes';
                if (class_exists($routeGroupClass)) {
                    $router->mount(new $routeGroupClass());
                }
            }
        }
        return $router;
    });
    
    // Setup the database service
    $di->set('db', function () use ($iniConfig) {
        $adapter = '\Phalcon\Db\Adapter\Pdo\\' . $iniConfig->database->adapter;
        return new $adapter(array(
            "host" => $iniConfig->database->host,
            "username" => $iniConfig->database->username,
            "password" => $iniConfig->database->password,
            "dbname" => $iniConfig->database->dbname
        ));
    });
    
    $application = new Application($di);
    // Register the installed modules
    $modules = array();
    if ($iniConfig->modules) {
        foreach ($iniConfig->modules as $moduleName => $moduleNamespace) {
            $modules[$moduleName]['className'] = $moduleNamespace . "\Module";
            $modules[$moduleName]['path'] = "../apps/$moduleName/Module.php";
        }
    }
    $application->registerModules($modules);
    echo $application->handle()->getContent();
} catch (Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
