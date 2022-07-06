<?php

include "connect.php";

$ratingId = $_POST['ratingId'];

$query = "UPDATE tbl_rating SET status = 0  WHERE rating_id = '$ratingId' ";

if (mysqli_query($conn, $query)) {
    echo 1;
} else {
    echo 0;
}


?>