<?php
use Phalcon\Mvc\Controller;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class IndexController extends Controller
{

    public function indexAction()
    {  
        $motorbikes = Motorbikes::find(array(null, "order" => "id desc"));
        $currentPage = $this->request->getQuery('page', 'int', 1); // GET 
        $paginator   = new PaginatorModel(
            array(
                "data"  => $motorbikes,
                "limit" => 10,
                "page"  => $currentPage
            )
        );
        $this->view->motorbikes = $paginator->getPaginate();
    }
    
    public function addAction()
    {
        $this->view->errorMessage = null;  
        $motorbikesModel = new Motorbikes();
        $motorbikesForm = new MotorbikesForm($motorbikesModel);
        // 'forms' is a service which is registered as a form manager
        // $this->forms->set('MotorbikesForm', $motorbikesForm); 
        
        if ($this->request->isPost()) {
            if ($motorbikesForm->isValid($this->request->getPost(), $motorbikesModel)) {
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
            } else {
                foreach ($motorbikesForm->getMessages() as $message) {
                    $this->view->errorMessage = $message;
                }
            }
        }
        $this->view->motorbikesForm = $motorbikesForm;
    }
    
    public function deleteAction()
    {
        
    }
       
    public function testAction()
    {
        echo "<h1>Test Action!</h1>";
    }
}