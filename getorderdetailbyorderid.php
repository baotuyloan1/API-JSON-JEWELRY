<?php

include "connect.php";

$order_id = $_POST['order_id'];
$query = "SELECT * FROM tbl_detail where order_id = '$order_id' ";

$orderDetailArray = array(); 
$data = mysqli_query($conn, $query);
if (mysqli_num_rows($data) == 0) {
    echo 0;
} else {
    while ($row = mysqli_fetch_assoc($data)) {
        
        $productArray = array();


        $product_id = $row['product_id'];

        $query1 = "SELECT * FROM tbl_product WHERE product_id LIKE '$product_id'";
        $data1 = mysqli_query($conn, $query1);
        
        while ($row1 = mysqli_fetch_assoc($data1)) {
            array_push ($productArray , new Image(
                $row1['product_image'],
               ));
           }


        array_push($orderDetailArray, new OrderDetail(
        $row['detail_id'],
        $row['order_id'],
        $row['product_id'],
        $row['product_name'],
        $row['product_price'],
        $row['product_sales_quantity'],
        $row['created_at'],
        $row['updated_at'],
        $productArray

    ));
    }
    echo json_encode($orderDetailArray);
}





class OrderDetail
{
    function OrderDetail($detail_id, $order_id, $product_id,  $product_name  ,$product_price , $product_sales_quantity ,  $created_at , $updated_at , $image )
    {
        $this->detail_id = $detail_id;
        $this->order_id = $order_id;
        $this->product_id = $product_id;
        $this->product_name = $product_name;
        $this->product_price = $product_price;
        $this->product_sales_quantity = $product_sales_quantity;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->image = $image;
    }
}

class Image
{
    function Image($name)
    {
        $this->name = $name;
    }
}