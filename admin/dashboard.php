<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<style>
body{
    background:#f6f8fc;
    font-family:'Inter',sans-serif;
}

.container-custom{
    max-width:1200px;
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

.brand{
    font-weight:700;
    font-size:22px;
    background:linear-gradient(135deg,#6A5AE0,#8E5CFF);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

.card-soft{
    background:white;
    border-radius:20px;
    padding:25px;
    box-shadow:0 10px 30px rgba(0,0,0,0.06);
}

.card-gradient{
    background:linear-gradient(135deg,#6A5AE0,#8E5CFF);
    color:white;
    border-radius:20px;
    padding:25px;
    box-shadow:0 10px 30px rgba(106,90,224,0.3);
}

.section-title{
    font-weight:700;
    margin:50px 0 20px;
}

.stat-number{
    font-size:28px;
    font-weight:700;
}

.badge-status{
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
}

.tab-link{
    padding:8px 18px;
    border-radius:30px;
    text-decoration:none;
    margin-right:10px;
    background:#eef1ff;
    color:#6A5AE0;
    font-weight:600;
}

.tab-link.active{
    background:linear-gradient(135deg,#6A5AE0,#8E5CFF);
    color:white;
}

.table-custom{
    background:white;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,0.06);
}

.table-custom th{
    background:#f2f4ff;
    font-weight:600;
}

.btn-soft{
    border-radius:30px;
}
</style>
</head>

<body>

<div class="container-custom">

<!-- TOPBAR -->
<div class="topbar d-flex justify-content-between align-items-center">
    <div class="brand">Localynk.</div>
    <div>
        <span class="me-3 text-muted">Welcome, <?php echo htmlspecialchars($_SESSION['admin']); ?></span>
        <a href="logout.php" class="btn btn-dark btn-sm btn-soft">Logout</a>
    </div>
</div>

<h2 class="fw-bold">Admin Dashboard</h2>
<p class="text-muted mb-4">Monitor platform performance and manage workforce operations.</p>

<!-- OVERVIEW STATS -->
<div class="row g-4">

<div class="col-md-3">
<div class="card-gradient">
<p>Total Workers</p>
<div class="stat-number"><?php echo $totalWorkers; ?></div>
</div>
</div>

<div class="col-md-3">
<div class="card-soft text-center">
<p>Approved</p>
<div class="stat-number text-success"><?php echo $approvedCount; ?></div>
</div>
</div>

<div class="col-md-3">
<div class="card-soft text-center">
<p>Pending</p>
<div class="stat-number text-warning"><?php echo $pendingCount; ?></div>
</div>
</div>

<div class="col-md-3">
<div class="card-soft text-center">
<p>Calls Today</p>
<div class="stat-number text-primary"><?php echo $callsToday; ?></div>
</div>
</div>

</div>

<!-- AVAILABILITY -->
<h4 class="section-title">Availability Overview</h4>
<div class="row g-4">

<div class="col-md-4">
<div class="card-soft text-center">
<p>Available Now</p>
<div class="stat-number text-success"><?php echo $availableCount; ?></div>
</div>
</div>

<div class="col-md-4">
<div class="card-soft text-center">
<p>Busy</p>
<div class="stat-number text-warning"><?php echo $busyCount; ?></div>
</div>
</div>

<div class="col-md-4">
<div class="card-soft text-center">
<p>Not Available</p>
<div class="stat-number text-danger"><?php echo $notAvailableCount; ?></div>
</div>
</div>

</div>

<!-- SERVICE + CALL ANALYTICS -->
<h4 class="section-title">Call Analytics</h4>

<div class="row g-4">

<div class="col-md-4">
<div class="card-soft">
<p>Total Calls</p>
<div class="stat-number"><?php echo $totalCalls; ?></div>
</div>
</div>

<div class="col-md-4">
<div class="card-soft">
<p>Emergency Calls</p>
<div class="stat-number text-danger"><?php echo $emergencyCalls; ?></div>
</div>
</div>

<div class="col-md-4">
<div class="card-soft">
<p>Most Contacted Worker</p>
<div class="fw-bold"><?php echo htmlspecialchars($topWorkerName); ?></div>
</div>
</div>

</div>

<h4 class="section-title">Most Demanded Service</h4>
<div class="card-soft mb-5">
<h5 class="fw-bold"><?php echo htmlspecialchars($topService); ?></h5>
</div>

<!-- WORKERS SECTION -->
<h4 class="section-title">Workers</h4>

<form method="GET" class="mb-4 d-flex gap-3">
<input type="hidden" name="type" value="<?php echo htmlspecialchars($type); ?>">
<input type="text" name="search" class="form-control rounded-pill" placeholder="Search name, phone, service…" value="<?php echo htmlspecialchars($searchValue); ?>">
<button type="submit" class="btn btn-dark btn-soft">Search</button>
</form>

<div class="mb-4">
<a href="?type=pending" class="tab-link <?php if($type=='pending') echo 'active'; ?>">Pending (<?php echo $pendingCount; ?>)</a>
<a href="?type=approved" class="tab-link <?php if($type=='approved') echo 'active'; ?>">Approved (<?php echo $approvedCount; ?>)</a>
<a href="?type=rejected" class="tab-link <?php if($type=='rejected') echo 'active'; ?>">Rejected (<?php echo $rejectedCount; ?>)</a>
</div>

<div class="table-responsive table-custom">
<table class="table table-borderless mb-0">
<thead>
<tr>
<th>Worker</th>
<th>Service</th>
<th>Area</th>
<th>Status</th>
<th>Actions</th>
</tr>
</thead>
<tbody>

<?php if ($result && $result->num_rows > 0): ?>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
<td><?php echo htmlspecialchars($row['name']); ?></td>
<td><?php echo htmlspecialchars($row['service_type']); ?></td>
<td><?php echo htmlspecialchars($row['area']); ?></td>
<td>
<span class="badge-status bg-light text-dark">
<?php echo ucfirst($row['status']); ?>
</span>
</td>
<td>
<a href="approve.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success btn-soft">Approve</a>
<a href="reject.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning btn-soft">Reject</a>
<a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary btn-soft">Edit</a>
<a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger btn-soft">Delete</a>
</td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr>
<td colspan="5" class="text-center py-4 text-muted">No workers found.</td>
</tr>
<?php endif; ?>

</tbody>
</table>
</div>

<!-- PAGINATION -->
<?php if ($totalPages > 1): ?>
<div class="mt-4">
<?php for ($i = 1; $i <= $totalPages; $i++): ?>
<a href="?type=<?php echo $type; ?>&page=<?php echo $i; ?>&search=<?php echo urlencode($searchValue); ?>" 
class="btn btn-sm <?php echo ($page==$i)?'btn-dark':'btn-outline-dark'; ?> btn-soft">
<?php echo $i; ?>
</a>
<?php endfor; ?>
</div>
<?php endif; ?>

</div>

</body>
</html>