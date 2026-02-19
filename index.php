<?php
include("config/db.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartTaluk - Minimal</title>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="container d-flex justify-between align-center" style="width: 100%;">
            <a href="index.php" class="nav-brand">Localynk.</a>

            <div class="nav-links">
                <a href="index.php" class="nav-link active">Home</a>
                <a href="#categories" class="nav-link">Services</a>
                <a href="register.php" class="nav-link">For Professionals</a>
            </div>

            <div class="d-flex gap-2">
                <a href="admin/login.php" class="btn btn-ghost">Admin</a>
                <a href="worker/login.php" class="btn btn-ghost">Worker Login</a>
                <a href="register.php" class="btn btn-primary">Join Now</a>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero animate">
        <div class="container">
            <span class="hero-tag">Trusted Local Services</span>
            <h1>Find the right expert,<br>right around the corner.</h1>
            <p style="max-width: 600px; margin: 0 auto 40px auto;">
                Connect with skilled professionals in your neighborhood. Simple, fast, and reliable.
            </p>

            <div class="search-wrapper">
                <i class="ph-magnifying-glass search-icon"></i>
                <input type="text" class="search-input" placeholder="Try 'Electrician' or 'Plumber'...">
            </div>
        </div>
    </section>

    <!-- CATEGORIES -->
    <section class="section" id="categories">
        <div class="container">
            <div class="d-flex justify-between align-center" style="margin-bottom: 40px;">
                <h3>Browse Categories</h3>
                <a href="#" class="btn btn-ghost">View All <i class="ph-arrow-right" style="margin-left: 6px;"></i></a>
            </div>

            <div class="grid grid-cols-3 animate delay-100">
                <?php
                $services = $conn->query("SELECT DISTINCT service_type FROM workers WHERE status='approved' LIMIT 6");
                $icon_map = [
                    'Electrician' => 'ph-lightning',
                    'Plumber' => 'ph-drop',
                    'Welder' => 'ph-fire',
                    'Painter' => 'ph-paint-brush',
                    'Auto Mechanic' => 'ph-wrench',
                    'Vehicle Washer' => 'ph-car',
                    'Other' => 'ph-dots-three-circle'
                ];

                if ($services && $services->num_rows > 0) {
                    while ($row = $services->fetch_assoc()) {
                        $service = $row['service_type'];
                        $icon = isset($icon_map[$service]) ? $icon_map[$service] : 'ph-briefcase';
                        ?>
                        <a href="workers.php?service=<?php echo urlencode($service); ?>" class="category-item">
                            <i class="<?php echo $icon; ?>"></i>
                            <h4><?php echo $service; ?></h4>
                            <small>View Experts</small>
                        </a>
                        <?php
                    }
                } else {
                    echo "<div class='text-center' style='width:100%; grid-column:1/-1;'>No services available yet.</div>";
                }
                ?>

                <!-- 'Other' Placeholder -->
                <a href="workers.php?service=Other" class="category-item"
                    style="background: var(--bg-body); border-style: dashed;">
                    <i class="ph-squares-four"></i>
                    <h4>More</h4>
                    <small>See all services</small>
                </a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer style="border-top: 1px solid var(--border); padding: 40px 0; margin-top: 80px;">
        <div class="container text-center">
            <p style="margin-bottom: 0;">&copy; <?php echo date('Y'); ?> Localynk. Simple Local Services.</p>
        </div>
    </footer>

    <script>
        // Simple search redirect
        document.querySelector('.search-input').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                window.location.href = 'workers.php?service=' + encodeURIComponent(this.value); // ideally fuzzy search
            }
        });
    </script>
</body>


</html>