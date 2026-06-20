<?php

include('../../config/session.php');
include('../../config/permission.php');

memberViewAccess();

include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');

?>

<div class="main-content">

<div class="card p-4">

<h3>User Management</h3>

<table class="table table-bordered">

<thead>

<tr>

<th>ID</th>
<th>Name</th>
<th>Username</th>
<th>Role</th>
<th>Status</th>
<th>Actions</th>

</tr>

</thead>

<tbody>

<?php

$query = "

SELECT

u.*,
r.role_name

FROM users u

INNER JOIN roles r

ON u.role_id=r.role_id

ORDER BY user_id DESC

";

$result =
mysqli_query($conn,$query);

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td><?php echo $row['user_id']; ?></td>

<td><?php echo $row['full_name']; ?></td>

<td><?php echo $row['username']; ?></td>

<td><?php echo $row['role_name']; ?></td>

<td><?php echo $row['status']; ?></td>

<td>

<a href="edit-user.php?id=<?php echo $row['user_id']; ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<a href="delete-user.php?id=<?php echo $row['user_id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete User?')">

Delete

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>