<?php 

include "connect.php";

$rating_id = $_POST['ratingId'];
$rating = $_POST['rating'];
$comments = $_POST['comments'];




$query = "UPDATE tbl_rating SET rating = '$rating', comments = '$comments'   where rating_id = '$rating_id' ";

if ($conn->query($query) === TRUE) {
    echo 1;
  } else {
    echo 0;
  }

