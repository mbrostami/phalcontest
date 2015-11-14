<?php
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;

class Motorbikes extends Model
{

    const ACTIVE = 'Active';
    
    const INACTIVE = 'Inactive';
    
    public $id;

    public $name;

    public function initialize()
    {
        $this->addBehavior(
            new SoftDelete(
                array(
                    'field' => 'status',
                    'value' => self::INACTIVE
                )
            )
        );
    }
    
    public function createQuery()
    {
        $builder = $this->getModelsManager()->createBuilder();
        $builder->columns('id, name')
            ->from('Motorbikes')
            ->where("status = '" . self::ACTIVE . "'")
            ->orderBy('id Desc');
        
        return $builder;
    }
}