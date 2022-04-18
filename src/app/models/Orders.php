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
    public function search($status = "", $f_date = "", $t_date = "")
    {
        $result=array();
        if ($status != "") {
            $doc = $this->di->get("mongo");
            $result =  $doc->store->orders->find(

                ['date' => ['$gte' => new MongoDB\BSON\UTCDateTime(new \DateTimeImmutable(date("Y-m-d H:i:s", strtotime($f_date)))), '$lte' => new MongoDB\BSON\UTCDateTime(new \DateTimeImmutable(date("Y-m-d H:i:s", strtotime($t_date))))], "status" => $status]
            );
        } else {
            echo "not find";
            $doc = $this->di->get("mongo");
            $result = $doc->store->orders->find();
        }

        return $result;
    }
}
