<?php

use Phalcon\Mvc\Controller;


class DashboardController extends Controller
{
    public function indexAction()
    {
        $cursor = ["typeMap" => ['root' => 'array', 'document' => 'array']];
        $this->view->find = $this->mongo->test->users->find();
    }
}
