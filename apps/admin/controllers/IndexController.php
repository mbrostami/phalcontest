<?php
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{

    public function indexAction()
    {  
        $this->view->motorbikes = Motorbikes::find(array(null, "order" => "id desc"));
    }
    
    public function addAction()
    {
        $this->view->errorMessage = null;
        if ($this->request->isPost()) {
            $name = $this->request->getPost('name');
            $motorbikesModel = new Motorbikes();
            $motorbikesModel->name = $name;
            $success = $motorbikesModel->save(); 
            if ($success) {
                $message = 'Last Inserted ID: ' . $motorbikesModel->id; // last inserted id
                $this->flashSession->success($message);
                return $this->response->redirect('admin/index/index');
            } else {
                foreach ($motorbikesModel->getMessages() as $message) {
                    $message = $message->getMessage();
                }
                $this->view->errorMessage = $message;
            }
        }
    }
    
    public function testAction()
    {
        echo "<h1>Test Action!</h1>";
    }
}