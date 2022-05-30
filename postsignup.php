<?php
include "connect.php";


$customer_name =  $_POST['customer_name'];
$customer_password =  $_POST['customer_password'];
$customer_email =  $_POST['customer_email'];
$customer_phone =  $_POST['customer_phone'];



$pass = md5("$customer_password");

$query1 = "SELECT * FROM tbl_customer WHERE customer_email = '$customer_email' ";
$data = mysqli_query($conn, $query1);

if (mysqli_num_rows($data) == 0) {
  $query = "INSERT INTO tbl_customer (customer_name, customer_password, customer_email, customer_phone) VALUES ('$customer_name', '$pass','$customer_email', '$customer_phone')";
  
if (mysqli_query($conn, $query)) {
    $idAccount = $conn -> insert_id;
    echo 1;
} else {
  echo 0;
}
}else {
  echo 2;
}

?>