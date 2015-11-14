<?php
use Phalcon\Mvc\Controller;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;

class IndexController extends Controller
{

    public function indexAction()
    {  
        $currentPage = $this->request->getQuery('page', 'int', 1); // GET 
        $countItemsPerPage = $this->request->getQuery('count', 'int', 10); // GET 
        
        // This type of paginator selects all records from database and THEN limits results for display
        // $motorbikes = Motorbikes::find(array(null, "order" => "id desc"));
        // $paginator   = new PaginatorModel(
        //     array(
        //         "data"  => $motorbikes,
        //         "limit" => $countItemsPerPage,
        //         "page"  => $currentPage
        //     )
        // );
        
        // This type of paginator selects limited records from database
        $motorbikesModel = new Motorbikes();
        $queryBuilder = $motorbikesModel->createQuery();
        $paginator = new PaginatorQueryBuilder(
            array(
                "builder" => $queryBuilder,
                "limit" => $countItemsPerPage,
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
        // We can register for inside form manager in order to access from any file
        // $this->forms->set('MotorbikesForm', $motorbikesForm); 
        
        if ($this->request->isPost()) {
            if ($motorbikesForm->isValid($this->request->getPost(), $motorbikesModel)) {
                if ($this->security->checkToken('csrf')) {  
                    $success = $motorbikesModel->save(); 
                    if ($success) {
                        $message = 'Last Inserted ID: ' . $motorbikesModel->id; // last inserted id
                        $this->flashSession->success($message);
                        return $this->response->redirect('admin/index/index');
                    } else {
                        foreach ($motorbikesModel->getMessages() as $message) {
                            // get last error
                            $this->view->errorMessage = $message->getMessage();
                        }
                    }
                } else {
                    $this->view->errorMessage = 'Token invalid!';
                }
            } else {
                foreach ($motorbikesForm->getMessages() as $message) {
                    // get last error
                    $this->view->errorMessage = $message->getMessage();
                }
            }
        }
        $this->view->motorbikesForm = $motorbikesForm;
    }
    

    public function editAction($id)
    {
        $this->view->errorMessage = null;
        $motorbikesModel = Motorbikes::findFirst($id);
        $motorbikesForm = new MotorbikesForm($motorbikesModel, array(
            'edit' => true
        ));
    
        // 'forms' is a service which is registered as a form manager
        // We can register for inside form manager in order to access from any file
        // $this->forms->set('MotorbikesForm', $motorbikesForm);
    
        if ($this->request->isPost()) {
            if ($motorbikesForm->isValid($this->request->getPost(), $motorbikesModel)) {
                if ($this->security->checkToken('csrf')) {
                    $success = $motorbikesModel->save();
                    if ($success) {
                        $message = 'Last Edited ID: ' . $motorbikesModel->id; // edited id
                        $this->flashSession->success($message);
                        return $this->response->redirect('admin/index/index');
                    } else {
                        foreach ($motorbikesModel->getMessages() as $message) {
                            // get last error
                            $this->view->errorMessage = $message->getMessage();
                        }
                    }
                } else {
                    $this->view->errorMessage = 'Token invalid!';
                }
            } else {
                foreach ($motorbikesForm->getMessages() as $message) {
                    // get last error
                    $this->view->errorMessage = $message->getMessage();
                }
            }
        }
        $this->view->motorbikesForm = $motorbikesForm;
    }
    
    public function deleteAction($id)
    { 
        if ($this->security->checkToken('csrf', $this->request->getQuery('token'))) {
            if ($motorbikesModel = Motorbikes::findFirst($id)) {
                if ($motorbikesModel->delete() == false) {
                    foreach ($motorbikesModel->getMessages() as $message) {
                        // get first error message
                        $this->flashSession->error($message->getMessage());
                        break;
                    }
                } else {
                    $this->flashSession->success('Record deleted!');
                }
            } else {
                $this->flashSession->error('Record not found!');
            }
        } else { 
            $this->flashSession->error('Token invalid!');
        }  
        return $this->response->redirect('admin/index/index');
    } 
    
}