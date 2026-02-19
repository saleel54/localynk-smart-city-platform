<?php
include("config/db.php");

$name = $_POST['name'];
$phone = $_POST['phone'];
if ($_POST['service_type'] === "Other" && !empty($_POST['custom_service'])) {
    $service_type = $_POST['custom_service'];
} else {
    $service_type = $_POST['service_type'];
}
$area = $_POST['area'];
$availability = $_POST['availability'];
$shop_location = isset($_POST['shop_location']) ? $_POST['shop_location'] : "";
// File upload
$target_dir = "uploads/";
$file_name = time() . "_" . basename($_FILES["id_proof"]["name"]);
$target_file = $target_dir . $file_name;
$latitude  = isset($_POST['latitude']) && $_POST['latitude'] != '' ? $_POST['latitude'] : NULL;
$longitude = isset($_POST['longitude']) && $_POST['longitude'] != '' ? $_POST['longitude'] : NULL;
$service_type = $_POST['service_type'];

if($service_type == "Other"){
    $service_type = $_POST['other_service'];
}
move_uploaded_file($_FILES["id_proof"]["tmp_name"], $target_file);
// Backend Phone Validation
if (!preg_match("/^[6-9][0-9]{9}$/", $phone)) {
    die("Invalid phone number format.");
}
if (!empty($shop_location) && !filter_var($shop_location, FILTER_VALIDATE_URL)) {
    die("Invalid location URL.");
}
// Insert into database
$sql = "INSERT INTO workers 
(name, phone, service_type, area, availability, id_proof, shop_location, status,latitude, longitude)
VALUES 
('$name', '$phone', '$service_type', '$area', '$availability', '$target_file', '$shop_location', 'pending','$latitude','$longitude')";

if ($conn->query($sql) === TRUE) {
    echo "<script>
            alert('Registration submitted successfully! Waiting for admin approval.');
            window.location='index.php';
          </script>";
} else {
    echo "Error: " . $conn->error;
}
