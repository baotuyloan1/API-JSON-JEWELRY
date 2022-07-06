<?php 

include "connect.php";
$idCustomer = $_POST['customer_id'];

$query = "SELECT * FROM tbl_billing where customer_id = '$idCustomer' AND billing_status = 1";
$data = mysqli_query($conn, $query);

$billingArray = array();


    while ($row = mysqli_fetch_assoc($data)) {
            array_push ($billingArray,new billing(
               (int) $row['billing_id'],
                (int)$row['customer_id'],
                $row['billing_name'],
                $row['billing_address'],
                $row['billing_phone'],
                $row['created_at'],
                $row['updated_at'],
            ));

         
    }
      echo json_encode( $billingArray, JSON_UNESCAPED_UNICODE );

class billing
{
    function billing($billing_id, $customer_id, $billing_name, $billing_address, $billing_phone, $created_at, $updated_at)
    {
        $this->billing_id = $billing_id;
        $this->customer_id = $customer_id;
        $this->billing_name = $billing_name;
        $this->billing_address = $billing_address;
        $this->billing_phone = $billing_phone;
       
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}


?>