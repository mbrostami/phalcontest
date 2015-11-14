<?php
use Phalcon\Mvc\Model;

class Motorbikes extends Model
{

    public $id;

    public $name;

    public function createQuery()
    {
        $builder = $this->getModelsManager()->createBuilder();
        $builder->columns('id, name')
            ->from('Motorbikes')
            ->orderBy('id Desc');
        
        return $builder;
    }
}