<?php 


include "connect.php";

$customer_id = $_POST['customer_id'];
$billing_name = $_POST['billing_name'];
$billing_address = $_POST['billing_address'];
$billing_phone = $_POST['billing_phone'];

$query = "INSERT INTO tbl_billing (customer_id,billing_name,billing_address,billing_phone, billing_status) VALUES ('$customer_id','$billing_name','$billing_address' , '$billing_phone',1)";

 $DATA = mysqli_query($conn, $query);
 if ($DATA) {
    echo "1";
} else {
    echo "0";
}
?>