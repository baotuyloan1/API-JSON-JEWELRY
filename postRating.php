<?php 


include "connect.php";

$product_id = $_POST['product_id'];
$customer_id = $_POST['customer_id'];
$rating = $_POST['rating'];
$comments = $_POST['comments'];
$love = 0;
// $status =  $_POST['status'];

$query = "INSERT INTO tbl_rating (product_id,customer_id,rating,comments,love,status) VALUES ('$product_id','$customer_id','$rating' , '$comments','$love',1)";

 $DATA = mysqli_query($conn, $query);
 if ($DATA) {
    echo "1";
} else {
    echo "0";
}
