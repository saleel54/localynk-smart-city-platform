<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM workers WHERE id=$id");
$worker = $result->fetch_assoc();

if (isset($_POST['update'])) {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $service_type = $_POST['service_type'];
    $area = $_POST['area'];
    $availability = $_POST['availability'];
    $shop_location = $_POST['shop_location'];

    // Logic for Image Upload
    $id_proof = $worker['id_proof']; // Default to existing

    if (!empty($_FILES['new_id_proof']['name'])) {
        $allowed = ['image/jpeg', 'image/png', 'image/jpg'];

        if (in_array($_FILES['new_id_proof']['type'], $allowed)) {
            $new_file = time() . "_" . basename($_FILES["new_id_proof"]["name"]);
            move_uploaded_file($_FILES["new_id_proof"]["tmp_name"], "../uploads/" . $new_file);

            if (file_exists("../" . $worker['id_proof'])) {
                unlink("../" . $worker['id_proof']);
            }
            $id_proof = "uploads/" . $new_file;
        } else {
            $error = "Only JPG and PNG allowed.";
        }
    }

    if (!isset($error)) {
        // Only update if phone is valid
        if (!preg_match("/^[6-9][0-9]{9}$/", $phone)) {
            $error = "Invalid phone number.";
        } else {
            $stmt = $conn->prepare("UPDATE workers SET name=?, phone=?, service_type=?, area=?, availability=?, shop_location=?, id_proof=? WHERE id=?");
            $stmt->bind_param("sssssssi", $name, $phone, $service_type, $area, $availability, $shop_location, $id_proof, $id);
            $stmt->execute();

            header("Location: dashboard.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Worker - SmartTaluk Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg fixed-top bg-white border-bottom"
        style="backdrop-filter: none; background: white !important;">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="dashboard.php">
                <span class="text-primary">Admin</span> Panel
            </a>
            <div class="d-flex align-items-center">
                <a href="dashboard.php" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Back to Dashboard</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="glass-card p-4 p-md-5 animate-fade-in mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="fw-bold m-0">Edit Worker Details</h3>
                    </div>

                    <?php if (isset($error)) { ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php } ?>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="<?php echo htmlspecialchars($worker['name']); ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control"
                                    value="<?php echo htmlspecialchars($worker['phone']); ?>" pattern="[6-9]{1}[0-9]{9}"
                                    maxlength="10" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Service Type</label>
                                <input type="text" name="service_type" class="form-control"
                                    value="<?php echo htmlspecialchars($worker['service_type']); ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Area</label>
                                <input type="text" name="area" class="form-control"
                                    value="<?php echo htmlspecialchars($worker['area']); ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Availability</label>
                                <select name="availability" class="form-select">
                                    <option <?php if ($worker['availability'] == "Available")
                                        echo "selected"; ?>>Available
                                    </option>
                                    <option <?php if ($worker['availability'] == "Not Available")
                                        echo "selected"; ?>>Not
                                        Available</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Shop Location URL</label>
                                <input type="text" name="shop_location" class="form-control"
                                    value="<?php echo htmlspecialchars($worker['shop_location']); ?>">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Current ID Proof</label>
                                <div class="mb-2">
                                    <a href="../<?php echo htmlspecialchars($worker['id_proof']); ?>" target="_blank"
                                        class="text-primary text-decoration-none">
                                        📄 View Current Document
                                    </a>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Upload New ID Proof (Optional)</label>
                                <input type="file" name="new_id_proof" class="form-control">
                                <div class="form-text">Upload only if you want to replace the existing one.</div>
                            </div>

                            <div class="col-12 mt-4 d-flex gap-2">
                                <button type="submit" name="update" class="btn btn-primary fw-bold px-4">Update
                                    Worker</button>
                                <a href="dashboard.php" class="btn btn-light px-4">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>