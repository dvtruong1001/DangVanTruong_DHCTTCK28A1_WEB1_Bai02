<?php

$conn = new mysqli("localhost", "root", "", "baitap");

if($conn->connect_error)
    {
        die("". $conn->connect_error);
    }
?>