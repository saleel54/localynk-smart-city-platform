<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['otp']) || !isset($_SESSION['otp_expiry'])) {
    header("Location: login.php");
    exit();
}

$entered = $_POST['entered_otp'];

// Check expiry
if (time() > $_SESSION['otp_expiry']) {
    unset($_SESSION['otp']);
    unset($_SESSION['otp_expiry']);
    $error_msg = "OTP expired. Please request a new OTP.";
} elseif ((int) $entered !== (int) $_SESSION['otp']) {
    $error_msg = "Invalid OTP. Please check and try again.";
} else {
    // Success
    $phone = $_SESSION['worker_phone'];
    $result = $conn->query("SELECT * FROM workers WHERE phone='$phone' AND status='approved'");
    if ($result->num_rows > 0) {
        $worker = $result->fetch_assoc();
        $_SESSION['worker_id'] = $worker['id'];
        $_SESSION['worker_name'] = $worker['name'];

        unset($_SESSION['otp']);
        unset($_SESSION['otp_expiry']);
        unset($_SESSION['worker_phone']);

        header("Location: dashboard.php");
        exit();
    } else {
        $error_msg = "Worker not found or not approved.";
    }
}

// If we reach here, there was an error
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Failed - SmartTaluk</title>
    <link href="../assets/css/style.css" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body class="d-flex align-center justify-center" style="min-height: 100vh; background: var(--bg-body);">
    <div class="card animate text-center" style="max-width: 400px; padding: 40px;">
        <i class="ph-warning-circle" style="font-size: 3rem; color: var(--danger); margin-bottom: 1rem;"></i>
        <h3 class="mb-4">Verification Failed</h3>
        <p class="mb-6"><?php echo isset($error_msg) ? $error_msg : "An unknown error occurred."; ?></p>
        <a href="login.php" class="btn btn-primary w-full">Back to Login</a>
    </div>
</body>

</html>