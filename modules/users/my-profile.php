<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');

$user_id = $_SESSION['user_id'];

$query = "

SELECT

u.*,
r.role_name

FROM users u

INNER JOIN roles r

ON u.role_id = r.role_id

WHERE u.user_id='$user_id'

LIMIT 1

";

$result = mysqli_query($conn,$query);

$user = mysqli_fetch_assoc($result);

?>

<div class="main-content">

<div class="container-fluid">

<div class="row">

<div class="col-lg-8 mx-auto">

<div class="card shadow border-0">

<div class="card-header bg-success text-white">

<h4 class="mb-0">

👤 My Profile

</h4>

</div>

<div class="card-body">

<div class="row">

<div class="col-md-4 text-center">

<div class="mb-3">

<i class="fas fa-user-circle"
style="font-size:120px;color:#198754;">
</i>

</div>

<h5>

<?php echo htmlspecialchars($user['full_name']); ?>

</h5>

<p class="text-muted">

<?php echo htmlspecialchars($user['role_name']); ?>

</p>

</div>

<div class="col-md-8">

<table class="table table-bordered">

<tr>

<th width="35%">
User ID
</th>

<td>

<?php echo $user['user_id']; ?>

</td>

</tr>

<tr>

<th>
Full Name
</th>

<td>

<?php echo htmlspecialchars($user['full_name']); ?>

</td>

</tr>

<tr>

<th>
Username
</th>

<td>

<?php echo htmlspecialchars($user['username']); ?>

</td>

</tr>

<tr>

<th>
Role
</th>

<td>

<span class="badge bg-primary">

<?php echo htmlspecialchars($user['role_name']); ?>

</span>

</td>

</tr>

<tr>

<th>
Status
</th>

<td>

<?php

if($user['status']=='Active')
{
    echo '<span class="badge bg-success">Active</span>';
}
else
{
    echo '<span class="badge bg-danger">Inactive</span>';
}

?>

</td>

</tr>

<tr>

<th>
Created At
</th>

<td>

<?php echo date(
'd M Y h:i A',
strtotime($user['created_at'])
); ?>

</td>

</tr>

</table>

<div class="mt-4">

<a href="edit-profile.php"
class="btn btn-warning">

<i class="fas fa-edit"></i>

Edit Profile

</a>

<a href="change-password.php"
class="btn btn-primary">

<i class="fas fa-key"></i>

Change Password

</a>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

<?php

include('../../includes/footer.php');

?>