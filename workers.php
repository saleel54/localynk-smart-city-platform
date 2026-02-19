<?php
include("config/db.php");

/* -------- GET PARAMETERS -------- */
$service = isset($_GET['service']) ? $_GET['service'] : null;
$user_lat = isset($_GET['user_lat']) ? $_GET['user_lat'] : null;
$user_lng = isset($_GET['user_lng']) ? $_GET['user_lng'] : null;
$radius = isset($_GET['radius']) ? (int) $_GET['radius'] : 10;
$emergency = isset($_GET['emergency']) ? 1 : 0;

/* Redirect if no service selected */
if (!$service) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($service); ?> - SmartTaluk</title>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="container d-flex justify-between align-center">
            <div class="d-flex align-center gap-3">
                <a href="index.php" class="btn btn-ghost" style="padding-left: 0;">
                    <i class="ph-arrow-left" style="font-size: 1.2rem;"></i>
                </a>
                <a href="index.php" class="nav-brand">Localynk.</a>
            </div>

            <div class="d-flex gap-2">
                <!-- Simple Radius Filter -->
                <select id="radiusSelect" class="form-control"
                    style="width: auto; padding: 8px 12px; font-size: 0.9rem;">
                    <option value="5" <?php if ($radius == 5)
                        echo "selected"; ?>>5 km</option>
                    <option value="10" <?php if ($radius == 10)
                        echo "selected"; ?>>10 km</option>
                    <option value="20" <?php if ($radius == 20)
                        echo "selected"; ?>>20 km</option>
                    <option value="50" <?php if ($radius == 50)
                        echo "selected"; ?>>50 km</option>
                </select>
                <button onclick="findNearby()" class="btn btn-primary" style="padding: 8px 16px;">
                    Find
                </button>
            </div>
        </div>
    </nav>

    <div class="container section">
        <div class="d-flex justify-between align-center" style="margin-bottom: 2rem;">
            <div>
                <small
                    style="text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600;">Professionals</small>
                <h2 style="margin: 0;"><?php echo htmlspecialchars($service); ?></h2>
            </div>
        </div>

        <div class="card animate delay-100" style="padding: 0; overflow: hidden;">
            <?php
            if ($user_lat && $user_lng) {
                $query = "
                SELECT *, 
                ( 6371 * acos( 
                cos( radians($user_lat) ) 
                * cos( radians(latitude) ) 
                * cos( radians(longitude) - radians($user_lng) ) 
                + sin( radians($user_lat) ) 
                * sin( radians(latitude) ) 
                ) ) AS distance 
                FROM workers
                WHERE status='approved'
                AND service_type LIKE '%$service%'
                AND latitude IS NOT NULL
                HAVING distance < $radius
                ORDER BY distance ASC
                ";
                $result = $conn->query($query);
            } else {
                $result = $conn->query("SELECT * FROM workers WHERE status='approved' AND service_type LIKE '%$service%'");
            }

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $initials = strtoupper(substr($row['name'], 0, 1));
                    $status = isset($row['availability']) ? $row['availability'] : 'Available';

                    $dotClass = 'status-dot'; // Green default
                    if ($status == 'Busy') {
                        $dotClass .= ' status-busy';
                    }
                    if ($status == 'Not Available') {
                        $dotClass .= ' status-offline';
                    }
                    ?>
                    <!-- Minimal Worker Item -->
                    <div class="worker-card">
                        <div class="avatar" style="overflow: hidden;">
                            <?php if(!empty($row['profile_image']) && file_exists("uploads/" . $row['profile_image'])): ?>
                                <img src="uploads/<?php echo $row['profile_image']; ?>" 
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else: ?>
                                <?php echo $initials; ?>
                            <?php endif; ?>
                        </div>

                        <div style="flex: 1;">
                            <div class="d-flex align-center gap-2" style="margin-bottom: 4px;">
                                <h4 style="margin: 0; font-size: 1.1rem;"><?php echo htmlspecialchars($row['name']); ?></h4>
                                <?php if (isset($row['distance'])) { ?>
                                    <small style="background: var(--bg-body); padding: 2px 6px; border-radius: 4px;">
                                        <?php echo round($row['distance'], 1); ?> km
                                    </small>
                                <?php } ?>
                            </div>

                            <div class="d-flex align-center gap-3">
                                <small class="d-flex align-center">
                                    <span class="<?php echo $dotClass; ?>"></span> <?php echo $status; ?>
                                </small>
                                <small class="d-flex align-center">
                                    <i class="ph-map-pin" style="margin-right: 4px;"></i>
                                    <?php echo htmlspecialchars($row['area']); ?>
                                </small>
                            </div>
                        </div>

                        <div>
                            <?php if ($status != 'Not Available'): ?>
                                <a href="call_worker.php?id=<?php echo $row['id']; ?><?php if ($emergency)
                                       echo '&emergency=1'; ?>" class="btn btn-outline">
                                    <i class="ph-phone" style="margin-right: 8px;"></i> Call
                                </a>
                            <?php else: ?>
                                <button class="btn btn-ghost" disabled>Unavailable</button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div style="padding: 60px; text-align: center;">
                    <i class="ph-magnifying-glass"
                        style="font-size: 3rem; color: var(--border-dark); margin-bottom: 1rem;"></i>
                    <p>No professionals found in this area.</p>
                    <button onclick="document.getElementById('radiusSelect').focus()" class="btn btn-ghost">Expand
                        Radius</button>
                </div>
            <?php } ?>
        </div>
    </div>

    <script>
        function findNearby() {
            const radius = document.getElementById("radiusSelect").value;
            const btn = document.querySelector('button[onclick="findNearby()"]');

            btn.innerHTML = 'Locating...';
            btn.disabled = true;

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    window.location.href = "workers.php?service=<?php echo urlencode($service); ?>" +
                        "&user_lat=" + position.coords.latitude +
                        "&user_lng=" + position.coords.longitude +
                        "&radius=" + radius;
                }, function (error) {
                    alert("Please allow location access to find nearby workers.");
                    btn.innerHTML = 'Find';
                    btn.disabled = false;
                });
            } else {
                alert("Geolocation is not supported.");
            }
        }
    </script>

</body>

</html>