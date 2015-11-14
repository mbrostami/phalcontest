<?php  
use Phalcon\Mvc\Router\Group as RouterGroup;

class ApiRoutes extends RouterGroup
{
    public function initialize()
    {
        // Default paths
        $this->setPaths(
            array(
                'module'    => 'api' 
            )
        );

        // All the routes start with /api
        $this->setPrefix('/api');
    
        $this->addGet(
            "/fetch",
            array( 
                'controller' => 'index',
                'action' => 'fetch'
            )
        );
        
        $this->addGet(
            "/fetch/:int",
            array( 
                'controller' => 'index',
                'action' => 'fetch',
                'id' => 1
            )
        );
        
        // add new record
        $this->addPost(
            "/post",
            array(
                'controller' => 'index',
                'action'     => 'post'
            )
        );
         
        // update a record
        $this->addPut(
            "/put/:int",
            array(
                'controller' => 'index',
                'action'     => 'put',
                'id'         => 1
            )
        );
        
        // delete a record
        $this->addDelete(
            "/delete/:int",
            array(
                'controller' => 'index',
                'action'     => 'delete',
                'id'         => 1
            )
        ); 
    }
}