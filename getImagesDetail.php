<?php
include "connect.php";

$productArray = array();

$query = "SELECT * FROM tbl_product ORDER BY product_id DESC";

$data = mysqli_query($conn, $query);
if (mysqli_num_rows($data) == 0) {
    echo 0;
} else {
    while ($row = mysqli_fetch_assoc($data)) {
        $imagesDetail = array();
        $product_id = $row['product_id'];

        $query1 = "SELECT * FROM tbl_images_detail WHERE product_id LIKE '$product_id'";
        $data1 = mysqli_query($conn, $query1);
        while ($row1 = mysqli_fetch_assoc($data1)) {
            array_push ($imagesDetail , new ImagesDetail(
                   $row1['name']
               ));
           }
        array_push($productArray, new Product(
  (int)$row['product_id'],
        (int)$row['categor_id'],
        $row['product_name'],
        $row['product_desc'],
        $row['product_spec'],
        $row['product_image'],
        (double)$row['product_price'],
        (int)$row['product_status'],
        $row['created_at'],
        $row['updated_at'],
        $imagesDetail
    ));
        
  

    }
}
echo json_encode($productArray);




class Product
{
    function Product($product_id, $categor_id, $product_name, $product_desc, $product_spec, $product_image , $product_price ,  $product_status , $created_at , $updated_at  ,$imagesDetail )
    {
        $this->product_id = $product_id;
        $this->categor_id = $categor_id;
        $this->product_name = $product_name;
        $this->product_desc = $product_desc;
        $this->product_spec = $product_spec;
        $this->product_image = $product_image;
        $this->product_price = $product_price;
        $this->product_status = $product_status;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->images_detail = $imagesDetail;
    }
}

class ImagesDetail
{
    function ImagesDetail($name)
    {
        $this->name = $name;
    }
}