<!DOCTYPE html>
<html>
<head>
<title>Worker Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<style>
body{
    background:#f6f8fc;
    font-family:'Inter',sans-serif;
}

.container-custom{
    max-width:1100px;
    margin:auto;
    padding:40px 20px;
}

.topbar{
    background:white;
    padding:20px 30px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.05);
    margin-bottom:40px;
}

.gradient-card{
    background:linear-gradient(135deg,#6A5AE0,#8E5CFF);
    color:white;
    border-radius:22px;
    padding:30px;
    box-shadow:0 10px 30px rgba(106,90,224,0.3);
}

.card-soft{
    background:white;
    border-radius:22px;
    padding:30px;
    box-shadow:0 10px 30px rgba(0,0,0,0.06);
}

.stat-number{
    font-size:28px;
    font-weight:700;
}

.status-badge{
    padding:6px 14px;
    border-radius:30px;
    font-size:13px;
}

.btn-modern{
    border-radius:30px;
    padding:10px 20px;
}

.section-title{
    font-weight:700;
    margin-bottom:20px;
}
</style>
</head>

<body>

<div class="container-custom">

<!-- TOPBAR -->
<div class="topbar d-flex justify-content-between align-items-center">
    <div>
        <h5 class="fw-bold mb-0">Hello, <?php echo $_SESSION['worker_name']; ?> 👋</h5>
        <small class="text-muted">Manage your service & track your activity</small>
    </div>
    <div>
        <a href="../index.php" class="btn btn-outline-dark btn-sm btn-modern me-2">Home</a>
        <a href="logout.php" class="btn btn-dark btn-sm btn-modern">Logout</a>
    </div>
</div>

<!-- STAT CARDS -->
<div class="row g-4 mb-5">

    <div class="col-md-4">
        <div class="gradient-card text-center">
            <p>Total Calls</p>
            <div class="stat-number"><?php echo $totalCalls; ?></div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-soft text-center">
            <p>Emergency Calls</p>
            <div class="stat-number text-danger"><?php echo $emergencyCalls; ?></div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-soft text-center">
            <p>Current Status</p>

            <?php
            if($worker['availability']=="Available"){
                echo '<span class="status-badge bg-success text-white">Available</span>';
            } elseif($worker['availability']=="Busy"){
                echo '<span class="status-badge bg-warning text-dark">Busy</span>';
            } else{
                echo '<span class="status-badge bg-danger text-white">Not Available</span>';
            }
            ?>
        </div>
    </div>

</div>

<!-- UPDATE STATUS -->
<div class="card-soft mb-5">
<h5 class="section-title">Update Availability</h5>

<form method="POST" action="update_status.php">
<div class="row g-3">

<div class="col-md-4">
<select name="availability" class="form-select btn-modern">
<option value="Available" <?php if($worker['availability']=='Available') echo 'selected'; ?>>Available</option>
<option value="Busy" <?php if($worker['availability']=='Busy') echo 'selected'; ?>>Busy</option>
<option value="Not Available" <?php if($worker['availability']=='Not Available') echo 'selected'; ?>>Not Available</option>
</select>
</div>

<div class="col-md-4">
<select name="emergency_available" class="form-select btn-modern">
<option value="1" <?php if($worker['emergency_available']==1) echo 'selected'; ?>>Emergency ON</option>
<option value="0" <?php if($worker['emergency_available']==0) echo 'selected'; ?>>Emergency OFF</option>
</select>
</div>

<div class="col-md-4">
<button type="submit" class="btn btn-dark w-100 btn-modern">
Update Status
</button>
</div>

</div>
</form>
</div>

<!-- LOCATION UPDATE -->
<div class="card-soft mb-5">
<h5 class="section-title">Update Location</h5>
<button onclick="refreshLocation()" class="btn btn-primary btn-modern">
📍 Refresh GPS
</button>
<div id="locStatus" class="mt-2 text-success"></div>
</div>

<!-- CALL HISTORY -->
<div class="card-soft">
<h5 class="section-title">Recent Call History</h5>

<?php if($callHistory && $callHistory->num_rows > 0): ?>

<div class="table-responsive">
<table class="table table-borderless align-middle">
<thead class="text-muted">
<tr>
<th>Date</th>
<th>Service</th>
<th>Type</th>
</tr>
</thead>
<tbody>

<?php while($call = $callHistory->fetch_assoc()): ?>
<tr>
<td><?php echo date("d M Y, h:i A", strtotime($call['call_time'])); ?></td>
<td><?php echo $call['service_type']; ?></td>
<td>
<?php if($call['emergency_mode'] == 1): ?>
<span class="badge bg-danger rounded-pill">Emergency</span>
<?php else: ?>
<span class="badge bg-secondary rounded-pill">Normal</span>
<?php endif; ?>
</td>
</tr>
<?php endwhile; ?>

</tbody>
</table>
</div>

<?php else: ?>
<p class="text-muted">No calls received yet.</p>
<?php endif; ?>

</div>

</div>

<script>
function refreshLocation(){
if(navigator.geolocation){
navigator.geolocation.getCurrentPosition(function(position){
fetch("update_location.php",{
method:"POST",
headers:{"Content-Type":"application/x-www-form-urlencoded"},
body:"lat="+position.coords.latitude+"&lng="+position.coords.longitude
}).then(()=>{
document.getElementById("locStatus").innerHTML="Location updated successfully ✔";
});
});
}else{
alert("Geolocation not supported.");
}
}
</script>

</body>
</html>