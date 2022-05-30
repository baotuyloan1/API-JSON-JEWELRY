<?php 
include "connect.php";

$discountArray = array();
$queryDiscount = "SELECT * FROM tbl_discount WHERE discount_percent > 0 AND discount_percent <= 100 AND status = 1 ORDER BY discount_percent DESC";

$dataDiscount = mysqli_query($conn, $queryDiscount);

if (mysqli_num_rows($dataDiscount) == 0) {
    echo 0;
} else {
    while ($row = mysqli_fetch_assoc($dataDiscount)) {
       array_push($discountArray, new Discount(
           $row['discount_id'],
           $row['discount_name'],
           (int)$row['discount_percent'],
           $row['discount_image'],
           $row['status'],
           $row['discount_object'],
       ));
    }
}

echo json_encode($discountArray);


class Discount{
    function Discount($discount_id, $discount_name, $discount_percent, $discount_image , $status , $discount_object)
    {
        $this->discount_id = $discount_id;
        $this->discount_name = $discount_name;
        $this->discount_percent = $discount_percent;
        $this->discount_image = $discount_image;
        $this->status = $status;
        $this->discount_object = $discount_object;
    }
}



?>