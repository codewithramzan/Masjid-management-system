<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');

$query = "

SELECT

monthly_payments.*,

members.member_name,
members.monthly_amount

FROM monthly_payments

INNER JOIN members

ON monthly_payments.member_id =
members.member_id

ORDER BY payment_id DESC

";

$result =
mysqli_query($conn, $query);

?>
<div class="main-content">

<div class="card p-4">

<h3 class="mb-4">

Manage Payments

</h3>

<table class="table table-bordered table-hover">

<thead>

<tr>

<th>Member</th>
<th>Required</th>
<th>Paid</th>
<th>Remaining</th>
<th>Status</th>
<th>Month</th>
<th>Date</th>

</tr>

</thead>

<tbody>

<?php while($row =
mysqli_fetch_assoc($result)) {

$remaining =
$row['monthly_amount']
-
$row['amount'];

?>

<tr>

<td>

<?php echo $row['member_name']; ?>

</td>

<td>

Rs.
<?php echo $row['monthly_amount']; ?>

</td>

<td>

Rs.
<?php echo $row['amount']; ?>

</td>

<td>

Rs.
<?php echo $remaining; ?>

</td>

<td>

<?php echo $row['payment_status']; ?>

</td>

<td>

<?php echo $row['payment_month']; ?>

</td>

<td>

<?php echo $row['payment_date']; ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>