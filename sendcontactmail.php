<?php

$name =$_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$content = $_POST['content'];



$to_email = $email;
$subject = "Contact from app";
$body = 'Name: '.$name.'\n
    Email: '.$email.'\n
    Phone: '.$phone.'\n
    Content: '.$content.'\n';
$headers = "From: shopcoffee.doan2@gmail.com.vn \r \n";
$headers .= "Content-type: text/html; charset=utf-8 \r \n";
mail($to_email, $subject, $body, $headers) 

?>