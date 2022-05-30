<?php

include "connect.php";

$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * FROM tbl_customer where customer_email = '$email' ";
$data = mysqli_query($conn, $query);

$pass = md5("$password");

if (mysqli_num_rows($data) == 0) {
   echo 0;
} else {
    while ($row = mysqli_fetch_assoc($data)) {
        if ($row['customer_password'] == $pass ) {
            $account = new account(
               (int) $row['customer_id'],
                $row['customer_name'],
                $row['customer_password'],
                $row['customer_email'],
                $row['customer_phone'],
                $row['created_at'],
                $row['updated_at']
            );

           echo json_encode( $account, JSON_UNESCAPED_UNICODE );
        }
        else echo 2;
    }
}

class account
{
    function account($customer_id, $customer_name, $customer_password, $customer_email, $customer_phone, $created_at, $updated_at)
    {
        $this->customer_id = $customer_id;
        $this->customer_name = $customer_name;
        $this->customer_password = $customer_password;
        $this->customer_phone = $customer_phone;
        $this->customer_email = $customer_email;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}

?>