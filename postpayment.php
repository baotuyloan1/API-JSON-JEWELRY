<?php
include "connect.php";

$payment_method = $_POST['payment_method'];
// $payment_status = $_POST['payment_status'];
$billing_note	 = $_POST['billing_note'];

$payment_status = 0;
$query = "INSERT INTO tbl_payment (payment_method , payment_status , billing_note) VALUES ('$payment_method' , '$payment_status', '$billing_note')";

$DATA = mysqli_query($conn , $query);

if ($DATA){
	$payment_id = $conn->insert_id ;
	echo $payment_id;
} else {
	echo 0;
}
?>