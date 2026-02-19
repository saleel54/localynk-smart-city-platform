<?php
$conn = new mysqli(
    "sql202.infinityfree.com",
    "if0_41162422",
    "h3yosCz9DCSj",
    "if0_41162422_smarttaluk"
);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>