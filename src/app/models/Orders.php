<?php
use Phalcon\Mvc\Model;

class Orders extends Model
{
   
    public function insert($orders)
    {
        $doc = $this->di->get("mongo");
        $doc = $doc->store->orders;
        $doc->insertOne($orders);
            
    }
}
