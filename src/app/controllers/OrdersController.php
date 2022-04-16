<?php

use Phalcon\Mvc\Controller;


class OrdersController extends Controller
{
    public function indexAction()
    {
        $products = $this->mongo->store->products->find();
        foreach ($products as $key => $val) {
            $value[] = $val;
        }
        $value = json_decode(json_encode($value), true);
        $this->view->products =  $value;
    }
    public function addOrderAction()
    {
        $order = $this->request->getPost();
        // echo "<pre>";
        // print_r($order['pname']);
        // // die;
        $date = new MongoDB\BSON\UTCDateTime(new \DateTime(date("Y-m-d H:i:s")));
        // $status='paid';
        // ['order date' => ['$gt' => new MongoDB\BSON\UTCDateTime(new \DateTimeImmutable(date("Y-m-d H:i:s", strtotime("this week")))), '$lt' => new MongoDB\BSON\UTCDateTime(new \DateTimeImmutable(date("Y-m-d H:i:s", strtotime("this week +6 day"))))]]
        $time = date("h:i:sa");
        $arr = array();
        $arr = array_merge($arr, ['product name' => $order['pname']]);
        $arr = array_merge($arr, ['customer name' => $order['customername']]);
        $arr = array_merge($arr, ['quantity' => $order['qty']]);
        $arr = array_merge($arr, ['date' => $date]);
        $arr = array_merge($arr, ['time' => $time]);
        $arr = array_merge($arr, ['status' => 'paid']);
        $products = new Orders();
        $products->insert($arr);
        $this->response->redirect('/orders/orderlist/');
    }
    public function orderlistAction()
    {
        $orderlist = $this->mongo->store->orders->find();
        foreach ($orderlist as $k => $val) {
            $value = $val;
        }
        $val = json_decode(json_encode($value), true);
        $this->view->orderlist = $val;

        $filter=$this->request->getPost();
        echo "<pre>";
        print_r($filter);
        // die;
    }
}
