<?php
use Phalcon\Mvc\Controller;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder; 
use Phalcon\Http\Response;

class IndexController extends Controller
{

    public function fetchAction($id = null)
    {    
        $result = Motorbikes::find($id); 
        return $this->response->setJsonContent($result->toArray());
    }
    
    // FIXME prevent csrf attack!
    public function postAction()
    {
        $data = (array)$this->request->getJsonRawBody();  
        
        $motorbikesModel = new Motorbikes();
        $motorbikesForm = new MotorbikesForm($motorbikesModel);
        
        $result['status'] = false;
        $response = new Response();
        if ($motorbikesForm->isValid($data, $motorbikesModel)) {
            $success = $motorbikesModel->save(); 
            if ($success) {
                $result['message'] = 'Last Inserted ID: ' . $motorbikesModel->id; // last inserted id
                $result['status'] = true;
                $response->setStatusCode(201, "Created");
            } else {
                foreach ($motorbikesModel->getMessages() as $message) {
                    // get first error
                    $result['message'] = $message->getMessage();
                    $response->setStatusCode(409, "Conflict");
                    break;
                } 
            }
        } else {
            foreach ($motorbikesForm->getMessages() as $message) {
                // get first error
                $result['message'] = $message->getMessage();
                $response->setStatusCode(409, "Conflict");
                break;
            }
        }
        return $response->setJsonContent($result);
    }
    
    // FIXME prevent csrf attack!
    public function putAction($id)
    {
        $data = (array)$this->request->getJsonRawBody();
         
        $motorbikesModel = Motorbikes::findFirst($id);
        $motorbikesForm = new MotorbikesForm($motorbikesModel, array(
            'edit' => true
        ));
     
        $result['status'] = false;
        $response = new Response();
        if ($motorbikesForm->isValid($data, $motorbikesModel)) {
            $success = $motorbikesModel->save();
            if ($success) {
                $result['message'] = 'Last Edited ID: ' . $motorbikesModel->id; // edited id
                $result['status'] = true;
                $response->setStatusCode(201, "Updated");
            } else {
                foreach ($motorbikesModel->getMessages() as $message) {
                    // get first error
                    $result['message'] = $message->getMessage();
                    $response->setStatusCode(409, "Conflict");
                    break;
                }
            }
        } else {
            foreach ($motorbikesForm->getMessages() as $message) {
                // get first error
                $result['message'] = $message->getMessage();
                $response->setStatusCode(409, "Conflict");
                break;
            }
        }
        return $response->setJsonContent($result);
    }
    
    // FIXME prevent csrf attack!
    public function deleteAction($id)
    { 
        $result['status'] = false;
        $response = new Response();
        if ($motorbikesModel = Motorbikes::findFirst($id)) {
            if ($motorbikesModel->delete() == false) {
                foreach ($motorbikesModel->getMessages() as $message) {
                    // get first error message
                    $result['message'] = $message;
                    $response->setStatusCode(409, "Conflict");
                    break;
                }
            } else {
                $result['message'] = 'Record deleted!';
                $result['status'] = true;
                $response->setStatusCode(201, "Deleted");
            }
        } else {
            $result['message'] = 'Record not found!';
            $response->setStatusCode(409, "Conflict");
        }
        return $response->setJsonContent($result);
    } 
    
}