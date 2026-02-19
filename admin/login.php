<?php
session_start();
include("../config/db.php");

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $result = $conn->query("SELECT * FROM admin WHERE username='$username' AND password='$password'");

    if ($result->num_rows > 0) {
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php");
    } else {
        $error = "Invalid credentials.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - SmartTaluk</title>
    <link href="../assets/css/style.css" rel="stylesheet">
</head>

<body style="min-height: 100vh; display: flex; align-items: center; justify-content: center;">

    <div class="card animate" style="width: 100%; max-width: 400px; padding: 40px;">
        <div class="text-center" style="margin-bottom: 32px;">
            <h3>Admin Access</h3>
            <p style="margin-bottom: 0;">Secure dashboard login</p>
        </div>

        <?php if (isset($error)): ?>
            <div
                style="color: var(--danger); background: #FEF2F2; padding: 12px; border-radius: var(--radius-sm); font-size: 0.9rem; text-align: center; margin-bottom: 24px;">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required autofocus>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" name="login" class="btn btn-primary" style="width: 100%;">
                Log In
            </button>
        </form>

        <div class="text-center" style="margin-top: 24px;">
            <a href="../index.php" class="btn btn-ghost" style="font-size: 0.9rem;">Back to Home</a>
        </div>
    </div>

</body>

</html>