<?php

use Phalcon\Mvc\Controller;


class IndexController extends Controller
{
    public function indexAction()
    {
        
        // print_r($find[0]['name']);
        // die;
    }
    public function demoAction()
    {
//--------------------------------------------insert data by form------------------------------
        // $data = $this->request->get();
        // $collection = $this->mongo->test->users;
        // $insert1data = $collection->insertOne([
        //     'username' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => $data['password'],
        //     'status' => 'approve',
        // ]);
        // printf("Inserted %d document(s)\n", $insert1data->getInsertedCount());
        

//----------------------------------------------find---------------------------
        // $find = $this->mongo->test->users->find();
        // echo "<pre>";
        // foreach ($find as $key => $value) {
        //     foreach ($value as $k => $val) {
        //         echo $k."=".$val . "<br>";
        //     }
        // }

//-------------------updateOne-------------------------------------------
    //     $this->mongo->test->users->updateOne(
    //         ['username'=>'Satyam'],
    //         ['$set'=>['username'=>'Imran Khan']]
    // );

//---------------------------delete-------------------------------------

        // $this->mongo->test->users->deleteOne([
        //     'username'=>'Utkarsh',
        // ]);
        // var_dump($insert1data->getInsertedId());

//----------------------------------------insert many-------------------------------------------


        // $insermanydata = $collection->insertMany([
        //     [
        //         'username' => 'admin',
        //         'email' => 'admin@example.com',
        //         'name' => 'Admin User',
        //     ],
        //     [
        //         'username' => 'test',
        //         'email' => 'test@example.com',
        //         'name' => 'Test User',
        //     ],
        // ]);
            // $insert=$this->mongo->test->demo->insertOne(['name'=>'Imran Khan']);
            // print_r("Inserted  document(s)".$insert->getInsertedCount());
            // die;
    }
}
