<?php 
include "connect.php";
$idCustomer = $_POST['customer_id'];

$query = "SELECT * FROM tbl_customer where customer_id = '$idCustomer' ";

$data = mysqli_query($conn, $query);

if (mysqli_num_rows($data) == 0) {
   echo 0;
} else {
    while ($row = mysqli_fetch_assoc($data)) {
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