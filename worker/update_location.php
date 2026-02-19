<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['worker_id'])){
    exit();
}

$worker_id = $_SESSION['worker_id'];
$lat = $_POST['lat'];
$lng = $_POST['lng'];

$conn->query("UPDATE workers 
              SET latitude='$lat',
                  longitude='$lng'
              WHERE id=$worker_id");

echo "success";