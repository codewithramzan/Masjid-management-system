<?php 
$query = "

SELECT

expenses.*,

expense_categories.category_name

FROM expenses

INNER JOIN expense_categories

ON expenses.category_id =
expense_categories.category_id

ORDER BY expense_id DESC

";

$result =
mysqli_query($conn,$query);
?>
<table class="table table-bordered">

<thead>

<tr>

<th>ID</th>
<th>Category</th>
<th>Title</th>
<th>Amount</th>
<th>Date</th>

</tr>

</thead>

<tbody>

<?php while($row=
mysqli_fetch_assoc($result))
{ ?>

<tr>

<td>
<?php echo $row['expense_id']; ?>
</td>

<td>
<?php echo $row['category_name']; ?>
</td>

<td>
<?php echo $row['title']; ?>
</td>

<td>

Rs.
<?php echo $row['amount']; ?>

</td>

<td>
<?php echo $row['expense_date']; ?>
</td>

</tr>

<?php } ?>

</tbody>

</table>