<?php
include "connect.php";

$billing_id = $_POST['billing_id'];
$customer_id = $_POST['customer_id'];
$payment_id = $_POST['payment_id'];
$order_total = $_POST['order_total'];
$status = 1;
$order_note = $_POST['order_note'];

$query = "INSERT INTO tbl_order (customer_id , billing_id , payment_id , order_total , order_status_id, order_note) VALUES ('$customer_id' , '$billing_id', '$payment_id' ,'$order_total' , '$status', '$order_note')";

$DATA = mysqli_query($conn , $query);
if ($DATA){
	$idOrder = $conn->insert_id ;
	echo $idOrder;
} else {
	echo 0;
}
?>