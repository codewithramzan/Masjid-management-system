<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');

$query = "
SELECT *
FROM donations
ORDER BY donation_id DESC
";

$result = mysqli_query($conn,$query);

?>

<div class="main-content">

<div class="card p-4">

<h3>Manage Donations</h3>

<table class="table table-bordered">

<thead>

<tr>

<th>ID</th>
<th>Donor</th>
<th>Amount</th>
<th>Type</th>
<th>Date</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $row['donation_id']; ?></td>

<td><?php echo $row['donor_name']; ?></td>

<td>Rs. <?php echo number_format($row['amount']); ?></td>

<td><?php echo $row['donation_type']; ?></td>

<td><?php echo $row['donation_date']; ?></td>

<td>

<a href="edit-donation.php?id=<?php echo $row['donation_id']; ?>"
class="btn btn-primary btn-sm">

Edit

</a>

<a href="delete-donation.php?id=<?php echo $row['donation_id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete Donation?')">

Delete

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

<?php include('../../includes/footer.php'); ?>