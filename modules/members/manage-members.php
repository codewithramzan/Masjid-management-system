
<?php

include('../../config/session.php');
include('../../config/permission.php');
include('../../config/database.php');
$role = $_SESSION['role'] ?? '';
include('../../includes/header.php');
include('../../includes/sidebar.php');

$query = "
SELECT *
FROM members
ORDER BY member_id DESC
";

$result = mysqli_query($conn, $query);

?>

<div class="main-content">

<div class="card p-4">

<h3 class="mb-4">

Manage Members

</h3>

<table class="table table-bordered table-hover">

<thead>

<tr>

<th>ID</th>
<th>Name</th>
<th>Phone</th>
<th>Monthly Amount</th>
<th>Status</th>
<?php
if($role== 'Super Admin' || $role== 'Admin' || $role == 'accountant')
   {
    
?>

 <th>Actions</th>
<?php }?>
</tr>

</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>

<td>
<?php echo $row['member_id']; ?>
</td>

<td>
<?php echo $row['member_name']; ?>
</td>

<td>
<?php echo $row['phone']; ?>
</td>

<td>

Rs.
<?php echo $row['monthly_amount']; ?>

</td>

<td>

<?php echo $row['status']; ?>

</td>

<td>
<?php
if($role== 'Super Admin' || $role== 'Admin' || $role == 'accountant')
   {
    
?>
<a href="edit-member.php?id=<?php echo $row['member_id']; ?>"
   class="btn btn-primary btn-sm">

Edit

</a>

<a href="delete-member.php?id=<?php echo $row['member_id']; ?>"
   class="btn btn-danger btn-sm">

Delete

</a>

</td>
<?php } ?>
<?php } ?>

</tr>



</tbody>

</table>

</div>

</div>
<?php include('../../includes/footer.php'); ?>