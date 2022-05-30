<?php

include "connect.php";

$domainImg = "https://baonguyenduc.com/public/uploads/product/";
$productArray = array();




$order_id =$_POST['order_id'];
$billing_id = $_POST['billing_id'];
$customer_email = $_POST['customer_email'];
$query = "SELECT * FROM tbl_detail where order_id = '$order_id' ";

$mangOrder = array();
$queryOrder = "SELECT * FROM tbl_order where order_id LIKE '$order_id'  ";
$data = mysqli_query($conn, $queryOrder);

    while ($row = mysqli_fetch_assoc($data)) {
        
        array_push($mangOrder, new order(
            (int)$row['order_id'],
            (int)$row['customer_id'],
            (int)$row['billing_id'],
            (int)$row['payment_id'],
        floatval($row['order_total']),
            $row['order_status_id'],
            $row['created_at']
        ));
     
      
    }
    echo json_encode($mangOrder);





class order
{
    function order($order_id, $customer_id, $billing_id, $payment_id, $order_total, $order_status,$created_at)
    {
        $this->order_id = $order_id;
        $this->customer_id = $customer_id;
        $this->billing_id = $billing_id;
        $this->payment_id = $payment_id;
        $this->order_total = $order_total;
        $this->order_status = $order_status;
        $this->created_at = $created_at;
        
    }
}



$orderDetailArray = array(); 
$data = mysqli_query($conn, $query);
if (mysqli_num_rows($data) == 0) {

} else {
    while ($row = mysqli_fetch_assoc($data)) {
        
        $productArray = array();


        $product_id = $row['product_id'];

        $query1 = "SELECT * FROM tbl_product WHERE product_id LIKE '$product_id'";
        $data1 = mysqli_query($conn, $query1);
        
        while ($row1 = mysqli_fetch_assoc($data1)) {
            array_push ($productArray , new Image(
                $row1['product_image'],
               ));
           }
        array_push($orderDetailArray, new OrderDetail(
        $row['detail_id'],
        $row['order_id'],
        $row['product_id'],
        $row['product_name'],
        $row['product_price'],
        $row['product_sales_quantity'],
        $row['created_at'],
        $row['updated_at'],
        $productArray

    ));
    }
    
}

$billingQuerry = "SELECT * FROM tbl_billing where billing_id = '$billing_id' ";
$billingArray = array(); 


$databilling = mysqli_query($conn, $billingQuerry);
if (mysqli_num_rows($databilling) == 0) {

    
} else {
    while ($row = mysqli_fetch_assoc($databilling)) {
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


}





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


class OrderDetail
{
    function OrderDetail($detail_id, $order_id, $product_id,  $product_name  ,$product_price , $product_sales_quantity ,  $created_at , $updated_at , $image )
    {
        $this->detail_id = $detail_id;
        $this->order_id = $order_id;
        $this->product_id = $product_id;
        $this->product_name = $product_name;
        $this->product_price = $product_price;
        $this->product_sales_quantity = $product_sales_quantity;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->image = $image;
    }
}

class Image
{
    function Image($name)
    {
        $this->name = $name;
    }
}

$to_email = $customer_email;
$subject = "Order Confirmation";
$body = '
<table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="background-color: #eeeeee;" bgcolor="#eeeeee">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                    <tr>
                        <td align="center" valign="top" style="font-size:0; padding: 35px;" bgcolor="#F44336">
                            <div style="display:inline-block; max-width:50%; min-width:100px; vertical-align:top; width:100%;">
                                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:300px;">
                                    <tr>
                                        <td align="left" valign="top" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 36px; font-weight: 800; line-height: 48px;" class="mobile-center">
                                            <h1 style="font-size: 36px; font-weight: 800; margin: 0; color: #ffffff;">Furniture</h1>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div style="display:inline-block; max-width:50%; min-width:100px; vertical-align:top; width:100%;" class="mobile-hide">
                                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:300px;">
                                    <tr>
                                        <td align="right" valign="top" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; line-height: 48px;">
                                            <table cellspacing="0" cellpadding="0" border="0" align="right">
                                                <tr>
                                                    <td style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400;">
                                                        <p style="font-size: 18px; font-weight: 400; margin: 0; color: #ffffff;"><a href="#" target="_blank" style="color: #ffffff; text-decoration: none;">Shop &nbsp;</a></p>
                                                    </td>
                                                    <td style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 24px;"> <a href="#" target="_blank" style="color: #ffffff; text-decoration: none;"><img src="https://img.icons8.com/color/48/000000/small-business.png" width="27" height="23" style="display: block; border: 0px;" /></a> </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 35px 35px 20px 35px; background-color: #ffffff;" bgcolor="#ffffff">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                                <tr>
                                    <td align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;"> <img src="https://img.icons8.com/carbon-copy/100/000000/checked-checkbox.png" width="125" height="120" style="display: block; border: 0px;" /><br>
                                        <h2 style="font-size: 30px; font-weight: 800; line-height: 36px; color: #333333; margin: 0;"> Thank You For Your Order! </h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 10px;">
                                        <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;"> Hello '.$billingArray[0]->billing_name.'
                                        <br>Below are the order details you have placed. <br>Have a good day</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="padding-top: 20px;">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%"> 
                                            <tr>
                                            <td width="25%" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;"> #'.$mangOrder[0]->order_id.' </td>
                                                <td width="50%" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">Product </td>
                                                <td width="25%" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">Quantity </td>
                                                <td width="25%" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">Price  </td>
                                            </tr>';
                                            foreach ($orderDetailArray as $item){
                                                $body .= '  <tr>
                                                <td> <img src="'.$domainImg.$item->image[0]->name.'" alt="Girl in a jacket" width="100" height="100"> </td>
                                                <td width="50%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> '.$item->product_name .'</td>
                                                <td width="25%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> '.$item->product_sales_quantity .'</td>
                                                <td width="25%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> $'.$item->product_price .'</td>
                                            </tr>';
                                            }
                                           
                                          
                                           $body .='
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="padding-top: 20px;">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;"> TOTAL </td>
                                                <td width="25%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;"> $'.$mangOrder[0]->order_total .' </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" height="100%" valign="top" width="100%" style="padding: 0 35px 35px 35px; background-color: #ffffff;" bgcolor="#ffffff">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:660px;">
                                <tr>
                                    <td align="center" valign="top" style="font-size:0;">
                                        <div style="display:inline-block; max-width:50%; min-width:240px; vertical-align:top; width:100%;">
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:300px;">
                                                <tr>
                                                    <td align="left" valign="top" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px;">
                                                        <p style="font-weight: 800;">Delivery Address</p>
                                                        <p>'.$billingArray[0]->billing_address .'</p>
                                                        <p> Your phone: '.$billingArray[0]->billing_phone .'</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div style="display:inline-block; max-width:50%; min-width:240px; vertical-align:top; width:100%;">
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:300px;">
                                                <tr>
                                                    <td align="left" valign="top" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px;">
                                                        <p style="font-weight: 800;">Estimated Delivery Date</p>
                                                        <p>'.$mangOrder[0]->created_at.'</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style=" padding: 35px; background-color: #ff7361;" bgcolor="#1b9ba3">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                                <tr>
                                    <td align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;">
                                        <h2 style="font-size: 24px; font-weight: 800; line-height: 30px; color: #ffffff; margin: 0;"> Get 30% off your next order. </h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding: 25px 0 15px 0;">
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center" style="border-radius: 5px;" bgcolor="#66b3b7"> <a href="https://baonguyenduc.com/" target="_blank" style="font-size: 18px; font-family: Open Sans, Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; border-radius: 5px; background-color: #F44336; padding: 15px 30px; border: 1px solid #F44336; display: block;">Shop Again</a> </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 35px; background-color: #ffffff;" bgcolor="#ffffff">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                                <tr>
                                     <td align="center"> Hotline : 0788 049 042</td>
                                </tr>
                                <tr>
                                    <td align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 24px; padding: 5px 0 10px 0;">
                                        <p style="font-size: 14px; font-weight: 800; line-height: 18px; color: #333333;">Dương Lâm 1, Hòa Phong, Hòa Vang, Đà Nẵng </p>
                                    </td>
                                </tr>
                           
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>';
$headers = "From: shopcoffee.doan2@gmail.com.vm \r \n";
$headers .= "Content-type: text/html; charset=utf-8 \r \n";
mail($to_email, $subject, $body, $headers) 
?>
