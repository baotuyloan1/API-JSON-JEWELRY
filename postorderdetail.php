<?php
include "connect.php";

// $order_id = $_POST['order_id'];
// $product_id = $_POST['product_id'];
// $product_name = $_POST['product_name'];
// $product_price = $_POST['product_price'];
// $product_sales_quantity	 = $_POST['product_sales_quantity'];

$json = file_get_contents('php://input');

// Converts it into a PHP object
#true vì nó là array
$data = json_decode($json , true);


 foreach ($data as $value) {
    $madonhang = $value['order_id'];
    $masanpham = $value['product_id'];
    $tensanpham = $value['product_name'];
    $giasanpham = $value['product_price'];
    $soluong = $value['product_sales_quantity'];
    $query = "INSERT INTO tbl_detail (order_id, product_id,product_name, product_price ,product_sales_quantity) VALUES ('$madonhang','$masanpham', '$tensanpham','$giasanpham' ,'$soluong')";
    $DATA = mysqli_query($conn, $query);
 }
if ($DATA) {
    echo "1";
} else {
    echo "0";
}
?>