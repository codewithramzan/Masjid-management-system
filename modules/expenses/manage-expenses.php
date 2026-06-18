<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');

?>

<div class="main-content">

<div class="card shadow p-4">

<h3 class="mb-4">

💸 Manage Expenses

</h3>

<div class="row mb-3">

<div class="col-md-4">

<input
type="text"
id="expenseSearch"
class="form-control"
placeholder="Search Expense...">

</div>

</div>

<?php

$totalQuery = mysqli_query($conn, "

SELECT
SUM(amount) AS total_expense

FROM expenses

");

$totalData =
mysqli_fetch_assoc($totalQuery);

?>

<div class="alert alert-info">

<strong>

Total Expenses:

</strong>

Rs.
<?php

echo number_format(
$totalData['total_expense'] ?? 0
);

?>

</div>

<div class="table-responsive">

<table
class="table table-bordered table-hover"
id="expenseTable">

<thead class="table-dark">

<tr>

<th>ID</th>

<th>Category</th>

<th>Title</th>

<th>Amount</th>

<th>Date</th>

<th>Actions</th>

</tr>

</thead>

<tbody>

<?php

$query = "

SELECT

expenses.*,

expense_categories.category_name

FROM expenses

LEFT JOIN expense_categories

ON expenses.category_id =
expense_categories.category_id

ORDER BY expense_id DESC

";

$result =
mysqli_query($conn,$query);

while($row =
mysqli_fetch_assoc($result))
{

?>

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
<?php echo number_format($row['amount']); ?>

</td>

<td>

<?php echo $row['expense_date']; ?>

</td>

<td>

<a
href="edit-expense.php?id=<?php echo $row['expense_id']; ?>"
class="btn btn-primary btn-sm">

Edit

</a>

<a
href="delete-expense.php?id=<?php echo $row['expense_id']; ?>"
class="btn btn-danger btn-sm"

onclick="return confirm('Delete this expense?')">

Delete

</a>

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

<script>

document
.getElementById('expenseSearch')
.addEventListener('keyup', function(){

let value =
this.value.toLowerCase();

let rows =
document.querySelectorAll(
'#expenseTable tbody tr'
);

rows.forEach(function(row){

row.style.display =
row.innerText
.toLowerCase()
.includes(value)

? ''

: 'none';

});

});

</script>

<?php

include('../../includes/footer.php');

?>