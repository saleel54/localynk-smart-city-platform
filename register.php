<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join - SmartTaluk</title>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body style="min-height: 100vh; display: flex; flex-direction: column;">

    <nav class="navbar" style="position: relative;">
        <div class="container d-flex justify-between align-center" style="width: 100%;">
            <a href="index.php" class="nav-brand">Localynk.</a>
            <a href="index.php" class="btn btn-ghost">
                <i class="ph-x" style="font-size: 1.2rem;"></i> Close
            </a>
        </div>
    </nav>

    <div class="container"
        style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px 24px;">
        <div style="width: 100%; max-width: 480px;">

            <div class="text-center animate" style="margin-bottom: 32px;">
                <h2>Create Profile</h2>
                <p>Join our network of trusted local professionals.</p>
            </div>

            <form action="submit_worker.php" method="POST" enctype="multipart/form-data" class="animate delay-100">

                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. John Doe" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control" pattern="[6-9]{1}[0-9]{9}" maxlength="10"
                        placeholder="10-digit mobile number" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Profession</label>
                    <select name="service_type" id="serviceSelect" class="form-control" required
                        onchange="checkOtherService()">
                        <option value="" selected disabled>Select your profession</option>
                        <option value="Electrician">Electrician</option>
                        <option value="Plumber">Plumber</option>
                        <option value="Welder">Welder</option>
                        <option value="Painter">Painter</option>
                        <option value="Auto Mechanic">Auto Mechanic</option>
                        <option value="Vehicle Washer">Vehicle Washer</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div id="otherServiceDiv" class="form-group" style="display:none;">
                    <label class="form-label">Specify Service</label>
                    <input type="text" name="other_service" class="form-control" placeholder="e.g. Carpenter">
                </div>

                <div class="form-group">
                    <label class="form-label">Service Area</label>
                    <input type="text" name="area" class="form-control" placeholder="e.g. Downtown" required>
                </div>

                <div class="form-group">
                    <div
                        style="background: var(--bg-surface); border: 1px solid var(--border); padding: 16px; border-radius: var(--radius-md);">
                        <div class="d-flex justify-between align-center">
                            <div>
                                <span style="display: block; font-weight: 500; font-size: 0.9rem;">GPS Location</span>
                                <small>Required for "Nearby" discovery.</small>
                            </div>
                            <button type="button" id="locBtn" onclick="getLocation()" class="btn btn-outline"
                                style="padding: 6px 16px; font-size: 0.85rem;">
                                Detect
                            </button>
                        </div>
                        <span id="locationStatus"
                            style="display: block; font-size: 0.8rem; color: var(--success); margin-top: 8px;"></span>
                    </div>
                </div>

                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">

                <div class="form-group">
                    <label class="form-label">ID Proof (Document)</label>
                    <input type="file" name="id_proof" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 16px; font-size: 1rem;">
                    Complete Registration
                </button>

                <p style="text-align: center; margin-top: 24px;">
                    <small>By clicking button, you agree to our <a href="#" style="text-decoration: underline;">Terms of
                            Service</a>.</small>
                </p>

            </form>
        </div>
    </div>

    <script>
        function checkOtherService() {
            const select = document.getElementById("serviceSelect");
            const otherDiv = document.getElementById("otherServiceDiv");
            otherDiv.style.display = (select.value === "Other") ? "block" : "none";
        }

        function getLocation() {
            const btn = document.getElementById("locBtn");
            const status = document.getElementById("locationStatus");
            btn.innerHTML = "Detecting...";
            btn.disabled = true;

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        document.getElementById("latitude").value = position.coords.latitude;
                        document.getElementById("longitude").value = position.coords.longitude;
                        btn.innerHTML = "Captured";
                        btn.style.borderColor = "var(--success)";
                        btn.style.color = "var(--success)";
                        status.innerText = "Location coordinates saved successfully.";
                    },
                    function (error) {
                        alert("Permission denied or unavailable.");
                        btn.innerHTML = "Retry";
                        btn.disabled = false;
                    }
                );
            } else {
                alert("Geolocation not supported.");
            }
        }
    </script>

</body>

</html>