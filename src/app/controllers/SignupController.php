<?php

use Phalcon\Mvc\Controller;


class SignupController extends Controller
{
    public function indexAction()
    {
    }
    public function registerAction()
    {
        if ($this->request->has('name'))
            $data = $this->request->get();
        $password = $data['password'];
        $cpassword = $data['cpassword'];
        if ($password == $cpassword) {
            $this->mongo->test->users->insertOne(
                [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                    'confirm password' => $data['cpassword'],
                ]
            );
            $this->response->redirect('/');
        } else {
            echo "Password not matched";
        }
    }
    public function deleteAction()
    {
        $id = $this->request->get('id');
        // echo $id;
        // die;
        $this->mongo->test->users->deleteOne(
            [
                '_id' => new mongoDB\BSON\ObjectId("$id")
            ]
        );
        $this->response->redirect('/dashboard/');
    }
    public function editAction()
    {

        $id = $this->request->get('id');
        // echo $id;
        // die;
        $edit = $this->mongo->test->users->findOne(
            [
                '_id' => new mongoDB\BSON\ObjectId("$id")
            ]
        );
        $this->view->edit = $edit;
    }
    public function updateAction()
    {
        $id = $this->request->getPost('id');
        $name = $this->request->get('name');
        $email = $this->request->get('email');
        // print_r($email);
        // die;
        $this->mongo->test->users->updateOne(
            ['_id'=>new mongoDB\BSON\ObjectId("$id")],
            ['$set'=>[
                'name'=>$name,
                'email'=>$email,
                ]]
        );
        $this->response->redirect('/dashboard/');
    }
}
