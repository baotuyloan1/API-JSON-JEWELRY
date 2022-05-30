<?php 

include "connect.php";

$idCustomer = $_POST['customer_id'];
$customerPhone = $_POST['customer_phone'];
$cusName = $_POST['customer_name'];
$password = $_POST['password'];

if (strlen($password) <8) {
  echo 3;
}
else{

$pass = md5("$password");

$query = "UPDATE tbl_customer SET customer_name = '$cusName', customer_phone = '$customerPhone' , customer_password = '$pass'  where customer_id = '$idCustomer' ";

if ($conn->query($query) === TRUE) {
    echo 1;
  } else {
    echo 0;
  }
}

?>