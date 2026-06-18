<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');

?>

<div class="main-content">

<div class="card shadow p-4">

<h3>

📒 Fund Transactions Ledger

</h3>

<div class="table-responsive mt-3">

<table class="table table-bordered table-striped">

<thead class="table-dark">

<tr>

<th>ID</th>

<th>Type</th>

<th>Fund</th>

<th>Amount</th>

<th>Date</th>

<th>Reference</th>

<th>Notes</th>

</tr>

</thead>

<tbody>

<?php

$query = "

SELECT *

FROM fund_transactions

ORDER BY transaction_id DESC

";

$result =
mysqli_query($conn,$query);

while($row =
mysqli_fetch_assoc($result))
{

?>

<tr>

<td>

<?php echo $row['transaction_id']; ?>

</td>

<td>

<?php echo $row['transaction_type']; ?>

</td>

<td>

<?php echo $row['fund_type']; ?>

</td>

<td>

Rs.
<?php echo number_format($row['amount']); ?>

</td>

<td>

<?php echo $row['transaction_date']; ?>

</td>

<td>

<?php echo $row['reference_table']; ?>

#<?php echo $row['reference_id']; ?>

</td>

<td>

<?php echo $row['notes']; ?>

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

</div>

<?php
include('../../includes/footer.php');
?>