<?php
error_reporting(E_ALL);

use Phalcon\Mvc\Application;
use Phalcon\Config\Adapter\Ini as ConfigIni;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Router;
use Phalcon\Config\Adapter\Ini;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Flash\Direct as FlashDirect;
use Phalcon\Flash\Session as FlashSession;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Forms\Manager as FormsManager;

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
    
    // add new service as form manager
    $di->set('forms', function () {
        return new FormsManager();
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
    

    /**
     * Start the session the first time some component request the session service
     */
    $di->set('session', function () {
        $session = new SessionAdapter();
        $session->start();
        return $session;
    });
    

    // Register the flash service with custom CSS classes
    $di->set('flashSession', function () {
        $flash = new FlashSession(
            array(
                'error'   => 'alert alert-danger',
                'success' => 'alert alert-success',
                'notice'  => 'alert alert-info',
                'warning' => 'alert alert-warning'
            )
        );
        return $flash;
    });
    
    // Register the flash service with custom CSS classes
    $di->set('flash', function () {
        $flash = new FlashDirect(
            array(
                'error'   => 'alert alert-danger',
                'success' => 'alert alert-success',
                'notice'  => 'alert alert-info',
                'warning' => 'alert alert-warning'
            )
        ); 
        return $flash;
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
