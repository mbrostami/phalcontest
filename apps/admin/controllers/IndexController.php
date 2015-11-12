<?php
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{

    public function indexAction()
    { 
        $motorbikesModel = new Motorbikes(); 
        // $motorbikesModel->name = 'test';
        $success = $motorbikesModel->save();
        if ($success) {
            var_dump($motorbikesModel->id); // last inserted id
        } else { 
            foreach ($motorbikesModel->getMessages() as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }
        echo "<h1>Hello!</h1>";
        $this->view->disable();
    }
    
    public function testAction()
    {
        echo "<h1>Test Action!</h1>";
    }
}