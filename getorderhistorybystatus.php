<?php
include "connect.php";
$customer_id = $_POST['customer_id'];
$status = $_POST['status'];

$mangOrder = array();
$query = "SELECT * FROM tbl_order where customer_id LIKE '$customer_id' AND  order_status_id LIKE '$status' ";
$data = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($data)) {
        $billing = array();
        $billing_id = $row['billing_id'];
        $query1 = "SELECT * FROM tbl_billing WHERE billing_id LIKE '$billing_id'";
        $data1 = mysqli_query($conn, $query1);
        while ($row1 = mysqli_fetch_assoc($data1)) {
            array_push ($billing , new Billing(
                   $row1['billing_id'],
                   $row1['customer_id'],
                   $row1['billing_name'],
                   $row1['billing_address'],
                   $row1['billing_phone'],
                   $row1['created_at'],
                   $row1['updated_at']
               ));
        }
        array_push($mangOrder, new order(
            (int)$row['order_id'],
            (int)$row['customer_id'],
            (int)$row['billing_id'],
            (int)$row['payment_id'],
        floatval($row['order_total']),
            $row['order_status_id'],
            $row['created_at'],
            $billing
        ));
     
      
    }
    echo json_encode($mangOrder);





class order
{
    function order($order_id, $customer_id, $billing_id, $payment_id, $order_total, $order_status,$created_at, $billing )
    {
        $this->order_id = $order_id;
        $this->customer_id = $customer_id;
        $this->billing_id = $billing_id;
        $this->payment_id = $payment_id;
        $this->order_total = $order_total;
        $this->order_status = $order_status;
        $this->created_at = $created_at;
        $this->billing = $billing;
        
    }
}

class Billing
{
    function Billing($billing_id, $customer_id, $billing_name, $billing_address, $billing_phone, $created_at, $updated_at)
    {
        $this->billing_id = $billing_id;
        $this->customer_id = $customer_id;
        $this->billing_name = $billing_name;
        $this->billing_address = $billing_address;
        $this->billing_phone = $billing_phone;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}