<?php
session_start();
include("../config/db.php");

/* ---------- SESSION CHECK ---------- */
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

/* ---------- VALIDATE ID ---------- */
if(!isset($_GET['id'])){
    header("Location: dashboard.php");
    exit();
}

$id = (int) $_GET['id']; // Prevent SQL injection

/* ---------- FETCH IMAGE BEFORE DELETE ---------- */
$result = $conn->query("SELECT id_proof FROM workers WHERE id=$id");

if($result && $result->num_rows > 0){
    $row = $result->fetch_assoc();

    if(!empty($row['id_proof'])){
        $filePath = "../" . $row['id_proof'];
        if(file_exists($filePath)){
            unlink($filePath); // Delete image from uploads folder
        }
    }
}

/* ---------- DELETE WORKER RECORD ---------- */
$conn->query("DELETE FROM workers WHERE id=$id");

/* ---------- PRESERVE UI STATE ---------- */
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'pending';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : 1;

/* ---------- REDIRECT BACK ---------- */
header("Location: dashboard.php?active_tab=$tab&search=$search&page=$page");
exit();
?>