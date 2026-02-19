<?php
session_start();
include("../config/db.php");

if (isset($_POST['send_otp']) || isset($_POST['resend_otp'])) {

    $phone = $_POST['phone'];

    $result = $conn->query("SELECT * FROM workers 
                            WHERE phone='$phone' 
                            AND status='approved'");

    if ($result->num_rows > 0) {

        $otp = rand(1000, 9999);

        $_SESSION['worker_phone'] = $phone;
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_expiry'] = time() + 60; // 60 seconds expiry

        $success = "OTP Generated: $otp (Demo Only - valid for 60 seconds)";
    } else {
        $error = "Phone not registered or not approved.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Login - SmartTaluk</title>
    <link href="../assets/css/style.css" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body class="d-flex align-center justify-center" style="min-height: 100vh; background: var(--bg-body);">

    <div class="container" style="max-width: 480px; width: 100%;">
        <div class="mb-4">
            <a href="../index.php" class="btn btn-ghost" style="padding-left: 0;">
                <i class="ph-arrow-left" style="margin-right: 8px;"></i> Back to Home
            </a>
        </div>

        <div class="card animate">
            <div class="text-center mb-6">
                <h3 style="margin-bottom: 0.5rem;">Worker Login</h3>
                <p style="margin-bottom: 0;">Access your dashboard via OTP</p>
            </div>

            <?php if (isset($error)): ?>
                <div class='alert alert-danger'>
                    <i class="ph-warning-circle" style="margin-right: 8px; font-size: 1.2rem;"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($success)): ?>
                <div class='alert alert-success'>
                    <i class="ph-check-circle" style="margin-right: 8px; font-size: 1.2rem;"></i>
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <div style="position: relative;">
                        <i class="ph-phone"
                            style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-light); font-size: 1.2rem;"></i>
                        <input type="text" name="phone" class="form-control" placeholder="Registered Number"
                            style="padding-left: 48px;" required>
                    </div>
                </div>

                <button type="submit" name="send_otp" class="btn btn-primary w-full mb-2">
                    Send OTP <i class="ph-paper-plane-right"></i>
                </button>

                <?php if (isset($_SESSION['otp'])): ?>
                    <button type="submit" name="resend_otp" class="btn btn-ghost w-full">Resend OTP</button>
                <?php endif; ?>
            </form>

            <hr style="margin: 24px 0; border: 0; border-top: 1px solid var(--border-light);">

            <form method="POST" action="verify_otp.php">
                <div class="form-group">
                    <label class="form-label">Enter OTP</label>
                    <div style="position: relative;">
                        <i class="ph-lock-key"
                            style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-light); font-size: 1.2rem;"></i>
                        <input type="text" name="entered_otp" class="form-control" placeholder="• • • •"
                            style="padding-left: 48px; letter-spacing: 4px;">
                    </div>
                </div>
                <button type="submit" class="btn btn-accent w-full">Verify & Login</button>
            </form>

            <?php if (isset($_SESSION['otp_expiry'])): ?>
                <div class="text-center mt-4 text-center">
                    <small style="color: var(--danger);">OTP expires in <span id="countdown"
                            style="font-weight: 700;"></span>s</small>
                </div>

                <script>
                    let expiry = <?php echo $_SESSION['otp_expiry']; ?>;
                    let now = Math.floor(Date.now() / 1000);
                    let remaining = expiry - now;

                    let timer = setInterval(function () {
                        if (remaining <= 0) {
                            clearInterval(timer);
                            document.getElementById("countdown").innerHTML = "0";
                            location.reload(); // Refresh to clear invalid OTP session
                        } else {
                            document.getElementById("countdown").innerHTML = remaining;
                            remaining--;
                        }
                    }, 1000);
                </script>
            <?php endif; ?>
        </div>

        <div class="text-center mt-6">
            <small>Not registered yet? <a href="../register.php" style="color: var(--accent); font-weight: 600;">Join as
                    a Professional</a></small>
        </div>
    </div>

</body>

</html>