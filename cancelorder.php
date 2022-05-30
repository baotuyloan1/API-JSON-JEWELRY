<?php
include "connect.php";
$order_id = $_POST['order_id'];

$query = "UPDATE tbl_order SET order_status_id = 3 WHERE order_id = '$order_id' ";

if (mysqli_query($conn, $query) ){
    echo 1;
}else {
    echo 0;
}

?>