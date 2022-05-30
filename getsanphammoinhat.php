<?php

include "connect.php";
$mangspmoinhat = array();
$query = "SELECT * FROM tbl_product ORDER BY product_id DESC LIMIT 6 ";
$data = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($data)) {
    array_push($mangspmoinhat, new SanPhamMoiNhat(
        (int)$row['product_id'],
        (int)$row['categor_id'],
        $row['product_name'],
        $row['product_desc'],
        $row['product_spec'],
        $row['product_image'],
        (double)$row['product_price'],
        (int)$row['product_status'],
        (String)$row['created_at'],
        (String)$row['updated_at']
    ));
}
echo json_encode($mangspmoinhat );


class SanPhamMoiNhat
{
    function SanPhamMoiNhat($product_id, $categor_id, $product_name, $product_desc, $product_spec, $product_image , $product_price ,  $product_status , $created_at , $updated_at )
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
    }
}