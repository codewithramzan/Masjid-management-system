<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');

$query = "

SELECT *
FROM imam_salary

ORDER BY

salary_year DESC,
salary_id DESC

";

$result = mysqli_query($conn,$query);

?>

<div class="main-content">

<div class="card shadow">

<div class="card-header bg-info text-white">

<h4>Salary History</h4>

</div>

<div class="card-body">

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>ID</th>
<th>Imam Name</th>
<th>Month</th>
<th>Year</th>
<th>Amount</th>
<th>Status</th>
<th>Payment Date</th>
<th>Created At</th>

</tr>

</thead>

<tbody>

<?php while($row=mysqli_fetch_assoc($result)) { ?>

<tr>

<td><?php echo $row['salary_id']; ?></td>

<td><?php echo $row['imam_name']; ?></td>

<td><?php echo $row['salary_month']; ?></td>

<td><?php echo $row['salary_year']; ?></td>

<td>
Rs.
<?php echo number_format($row['amount']); ?>
</td>

<td>

<?php

if($row['payment_status']=="Paid")
{
    echo '<span class="badge bg-success">Paid</span>';
}
else
{
    echo '<span class="badge bg-danger">Pending</span>';
}

?>

</td>

<td>
<?php echo $row['payment_date']; ?>
</td>

<td>
<?php echo $row['created_at']; ?>
</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

<?php include('../../includes/footer.php'); ?>