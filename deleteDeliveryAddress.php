<?php
include "connect.php";
$billing_id = $_POST['billing_id'];

$query = "UPDATE tbl_billing SET status = 0  WHERE billing_id = '$billing_id' ";

if (mysqli_query($conn, $query) ){
    echo 1;
}else {
    echo 0;
}
