<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['worker_id'])){
    header("Location: login.php");
    exit();
}

$worker_id = $_SESSION['worker_id'];
$availability = $_POST['availability'];
$emergency_available = $_POST['emergency_available'];

$conn->query("UPDATE workers 
              SET availability='$availability',
                  emergency_available='$emergency_available'
              WHERE id=$worker_id");

header("Location: dashboard.php");
exit();