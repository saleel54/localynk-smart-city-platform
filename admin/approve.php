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

$id = (int) $_GET['id']; // Prevent injection

/* ---------- UPDATE STATUS ---------- */
$update = $conn->query("UPDATE workers SET status='approved' WHERE id=$id");

/* ---------- PRESERVE UI STATE ---------- */
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'pending';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : 1;

/* ---------- REDIRECT BACK ---------- */
header("Location: dashboard.php?active_tab=$tab&search=$search&page=$page");
exit();
?>