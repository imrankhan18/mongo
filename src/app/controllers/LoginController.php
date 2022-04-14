<?php

use Phalcon\Mvc\Controller;


class LoginController extends Controller
{
    public function indexAction()
    {
    }
    public function checkAction()
    {
        $logindata = $this->request->get();
        $cursor = ["typeMap" => ['root' => 'array', 'document' => 'array']];
        $find = $this->mongo->test->users->find();
        foreach ($find as $key => $value) {
            $email = $value->email;
            $password = $value->password;
            if ($logindata['email'] == $email && $logindata['password'] == $password) {
                echo "Login successfull";
                $this->response->redirect('/');
            }
        }
        echo "Invalid details";
    }
}
