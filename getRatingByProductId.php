<?php 

include "connect.php";
$idProduct = $_POST['product_id'];

$query = "SELECT * FROM tbl_rating INNER JOIN tbl_customer ON tbl_rating.customer_id = tbl_customer.customer_id where product_id = '$idProduct' AND status = 1 ORDER BY rating_id DESC";
$data = mysqli_query($conn, $query);

$ratingArray = array();


    while ($row = mysqli_fetch_assoc($data)) {
            array_push ($ratingArray,new Rating(
                (int) $row['rating_id'],
                (int)$row['product_id'],
                (int) $row['customer_id'],
                $row['customer_name'],
                $row['customer_img'],
                (int) $row['rating'],
                $row['comments'],
                (int)$row['status'],
                $row['created_at'],
                $row['updated_at']
            ));

         
    }
      echo json_encode($ratingArray, JSON_UNESCAPED_SLASHES );

class Rating
{
    function Rating($rating_id, $product_id, $customer_id, $customer_name, $customer_img, $rating, $comments, $status, $created_at , $updated_at)
    {
        $this->rating_id = $rating_id;
        $this->product_id = $product_id;
        $this->customer_id = $customer_id;
        $this->customer_name = $customer_name;
        $this->customer_img = $customer_img;
        $this->rating = $rating;
        $this->comments = $comments;
        $this->status = $status;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}
