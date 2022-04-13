<?php

use Phalcon\Mvc\Controller;


class IndexController extends Controller
{
    public function indexAction()
    {
    }
    public function demoAction()
    {
        
        $collection = $this->mongo;
            $insert1data = $collection->insertOne([
                'username' => 'ImranKhan18',
                'email' => 'ik@example.com',
                'name' => 'Imran',
            ]);

            printf("Inserted %d document(s)\n", $insert1data->getInsertedCount());

            var_dump($insert1data->getInsertedId());


            $insermanydata = $collection->insertMany([
                [
                    'username' => 'admin',
                    'email' => 'admin@example.com',
                    'name' => 'Admin User',
                ],
                [
                    'username' => 'test',
                    'email' => 'test@example.com',
                    'name' => 'Test User',
                ],
            ]);
            
            printf("Inserted %d document(s)\n", $insermanydata->getInsertedCount());
            
            var_dump($insermanydata->getInsertedIds());

            // $document = $collection->findOne(['_id' => '625576a14ce8aee09e0b7784']);

            // var_dump($document);

            die;
    }
}
