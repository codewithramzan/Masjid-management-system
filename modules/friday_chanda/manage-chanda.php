<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');

$query = "
SELECT *
FROM friday_collections
ORDER BY friday_id DESC
";

$result =
mysqli_query($conn, $query);

?>
<div class="main-content">

<div class="card p-4">

<h3 class="mb-4">

Manage Friday Chanda

</h3>

<table class="table table-bordered table-hover">

<thead>

<tr>

<th>ID</th>
<th>Amount</th>
<th>Date</th>
<th>Notes</th>

</tr>

</thead>

<tbody>

<?php while($row =
mysqli_fetch_assoc($result)) { ?>

<tr>

<td>

<?php echo $row['friday_id']; ?>

</td>

<td>

Rs.
<?php echo $row['amount']; ?>

</td>

<td>

<?php echo $row['collection_date']; ?>

</td>

<td>

<?php echo $row['notes']; ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>