<?php
include "connect.php";
class Product
{
    function Product($product_id, $categor_id, $product_name, $product_desc,  $product_image, $product_price,  $product_status, $created_at, $updated_at, $imagesDetail, $discount , $distance)
    {
        $this->product_id = $product_id;
        $this->categor_id = $categor_id;
        $this->product_name = $product_name;
        $this->product_desc = $product_desc;
        $this->product_image = $product_image;
        $this->product_price = $product_price;
        $this->product_status = $product_status;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->images_detail = $imagesDetail;
        $this->discount = $discount;
        $this->distance = $distance;
    }
}

class ImagesDetail
{
    function ImagesDetail($name)
    {
        $this->name = $name;
    }
}

class Discount
{
    function Discount($discount_id, $discount_name, $discount_percent, $discount_image, $discount_object, $status, $created_at, $updated_at)
    {
        $this->discount_id = $discount_id;
        $this->discount_name = $discount_name;
        $this->discount_percent = $discount_percent;
        $this->discount_image = $discount_image;
        $this->discount_object = $discount_object;
        $this->status = $status;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}

$link = "http://localhost/jewelry/API/recommender.py";

$data = file_get_contents($link);

$json_array = json_decode($data, true);
// print_r($json_array);



if (sizeof($json_array) > 0) {
    $productArray = array();
    foreach ($json_array as $index => $products) {
        $imagesDetail = array();
        $discountArray = array();
        $product_id = $json_array[$index]['id'];
        $discount_id =   $json_array[$index]['discountID'];
        $query =  "SELECT * FROM tbl_product WHERE product_id LIKE '$product_id'";
        $data = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($data) == 0) {
            echo 0;
        } else {
            while ($row = mysqli_fetch_assoc($data)) {
                $imagesDetail = array();
                $discountArray = array();
                $query1 = "SELECT * FROM tbl_imagesdetail WHERE id_product LIKE '$product_id'";
                $queryDiscount = "SELECT * FROM tbl_discount WHERE discount_id LIKE '$discount_id' ";

                $dataDiscount = mysqli_query($conn, $queryDiscount);

                if (mysqli_num_rows($dataDiscount) > 0) {
                    while ($rowDiscount = mysqli_fetch_assoc($dataDiscount)) {
                        array_push($discountArray, new Discount(
                            (int) $rowDiscount['discount_id'],
                            $rowDiscount['discount_name'],
                            (int) $rowDiscount['discount_percent'],
                            $rowDiscount['discount_image'],
                            $rowDiscount['discount_object'],
                            (int) $rowDiscount['status'],
                            $rowDiscount['created_at'],
                            $rowDiscount['updated_at'],
                        ));
                    }

                    $data1 = mysqli_query($conn, $query1);
                    while ($row1 = mysqli_fetch_assoc($data1)) {
                        array_push($imagesDetail, new ImagesDetail(
                            $row1['images_detail']
                        ));
                    }

                    array_push($productArray, new Product(
                        (int) $row['product_id'],
                        (int) $row['categor_id'],
                        $row['product_name'],
                        $row['product_desc'],
                        $row['product_image'],
                        $row['product_price'],
                        (int) $row['product_status'],
                        $row['created_at'],
                        $row['updated_at'],
                        $imagesDetail,
                        $discountArray,
                        $json_array[$index]['distance'],
                    ));
                    
                }
            }
        }
        

    }
    echo json_encode($productArray);
}
