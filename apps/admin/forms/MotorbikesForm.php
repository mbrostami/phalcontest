<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\StringLength;

class MotorbikesForm extends Form
{

    /**
     * This method returns the default value for field 'csrf'
     */
    public function getCsrf()
    {
        return $this->security->getToken();
    } 
    
    /**
     * Initialize the form
     */
    public function initialize($entity = null, $options = array())
    {

        if (isset($options['edit'])) {
            $this->add(new Hidden("id"));
        }

        $name = new Text("name");
        $name->setLabel("Name");
        $name->setFilters(array('striptags', 'string'));
        $name->setAttributes(array(
            'class' => 'form-control'
        )); 
        $name->addValidators(array(
            new PresenceOf(array(
                'message' => 'Name is required'
            )),
            new StringLength(
                array(
                    'min'            => 3,
                    'messageMinimum' => 'The name is too short'
                )
            )
        ));
        $this->add($name); 
        
        
        // Add a text element to put a hidden CSRF 
        $this->add(new Hidden("csrf"));
    }
}