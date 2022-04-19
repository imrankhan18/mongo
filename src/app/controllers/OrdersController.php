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
        // print_r($order);
        // die;
        $date = new \MongoDB\BSON\UTCDateTime(new \DateTime());
        // $status='paid';
        // ['order date' => ['$gt' => new MongoDB\BSON\UTCDateTime(new \DateTimeImmutable(date("Y-m-d H:i:s", strtotime("this week")))), '$lt' => new MongoDB\BSON\UTCDateTime(new \DateTimeImmutable(date("Y-m-d H:i:s", strtotime("this week +6 day"))))]]
        $time = date("h:i:sa");
        $arr = array();
        $arr = array_merge($arr, ['product name' => $order['pname']]);
        $arr = array_merge($arr, ['customer name' => $order['customername']]);
        $arr = array_merge($arr, ['quantity' => $order['qty']]);
        $arr = array_merge($arr, ['price' => $order['price']]);
        $arr = array_merge($arr, ['variations' => $order['var']]);
        $arr = array_merge($arr, ['date' => $date]);
        $arr = array_merge($arr, ['time' => $time]);
        $arr = array_merge($arr, ['status' => 'paid']);
        $products = new Orders();
        $products->insert($arr);
        $this->response->redirect('/orders/orderlist/');
    }
    public function orderlistAction()
    {
        $filter = $this->request->getPost();
        $order = new Orders;
        if (($filter['from date']) != '') {
            $result = $order->search($filter["status"], $filter["from date"], $filter["to date"]);
        } else {
            if ($filter['dropdowndate'] == "today") {

                $result = $order->search($filter["status"], date("Y-m-d"), date("Y-m-d"));
            } elseif ($filter['dropdowndate'] == "this week") {

                $result = $order->search($filter["status"], date("Y-m-d"), date("Y-m-d", strtotime("+6 day")));
            } else {

                $result = $order->search($filter["status"], date("Y-m-d", strtotime("first day of this month")), date("Y-m-d", strtotime("last day of this month")));
            }
        }
        $this->view->orderlist = $result->toArray();
    }
    public function getVarAction()
    {
        $id = $this->request->getPost('id');
        $cursor = $this->mongo->store->products->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
        // $cursor=json_decode(json_encode($cursor), true);
        // echo "<pre>";
        // 
        // die;
        echo "<select name='var'>";

        foreach ($cursor as $key => $value) {

            foreach ($value as $k => $v) {


                foreach ($v as $kk => $vv) {
                    echo ('<option>' . $kk . ' ' . $vv . '</option>');
                }
            }
        };
        echo "</select>";
        // echo "<select>";
        // print_r('<option>'.$cursor->price.'<option>');
        // echo "</select>";
    }
    public function statusAction()
    {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');
        if ($this->request->getPost('status')) {
            $this->mongo->store->orders->updateOne(
                ['_id' => new MongoDB\BSON\ObjectId($id)],
                [
                    '$set' => [
                        'status' => $status,
                    ]
                ]
            );
            $this->response->redirect('/orders/orderlist/');
        }
    }
}
