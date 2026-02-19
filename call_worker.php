<?php
include("config/db.php");

if(!isset($_GET['id'])){
    header("Location: index.php");
    exit();
}

$worker_id = (int)$_GET['id'];
$emergency = isset($_GET['emergency']) ? 1 : 0;

// Get worker
$result = $conn->query("SELECT * FROM workers WHERE id=$worker_id");

if($result && $result->num_rows > 0){

    $worker = $result->fetch_assoc();

    // Log call
    $stmt = $conn->prepare("INSERT INTO call_logs (worker_id, service_type, emergency_mode) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $worker_id, $worker['service_type'], $emergency);
    $stmt->execute();

    // Redirect to phone dialer
    header("Location: tel:" . $worker['phone']);
    exit();

} else {
    header("Location: index.php");
    exit();
}
?>