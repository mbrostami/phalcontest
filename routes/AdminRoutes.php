<?php  
use Phalcon\Mvc\Router\Group as RouterGroup;

class AdminRoutes extends RouterGroup
{
    public function initialize()
    {
        // Default paths
        $this->setPaths(
            array(
                'module'    => 'admin' 
            )
        );

        // All the routes start with /admin
        $this->setPrefix('/admin');
    
        $this->add(
            "/:controller",
            array( 
                'controller' => 1,
            )
        );
        
        $this->add(
            "/:controller/:action",
            array(
                'controller' => 1,
                'action'     => 2
            )
        );
        // Add a route to the group
        $this->add(
            '/indexex',
            array(
                'action' => 'index'
            )
        ); 
    }
}