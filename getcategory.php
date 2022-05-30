<?php

include "connect.php";
$cateogryArray = array();
$query = "SELECT * FROM tbl_category_product";
$data = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($data)) {
    array_push($cateogryArray, new Category(
        (int)$row['categor_id'],
        $row['categor_name'],
        $row['meta_keywords'],
        $row['categor_image'],
        $row['categor_desc'],
        (int)$row['categor_status'],
        $row['created_at'],
        $row['updated_at'],
    ));
}
echo json_encode($cateogryArray);


class Category
{
    function Category($categor_id, $categor_name , $meta_keywords, $categor_image ,$categor_desc, $categor_status, $created_at , $updated_at  )
    {
        $this->categor_id = $categor_id;
        $this->categor_name = $categor_name;
        $this->meta_keywords = $meta_keywords;
        $this->categor_image = $categor_image;
        $this->categor_desc = $categor_desc;
        $this->categor_status = $categor_status;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}