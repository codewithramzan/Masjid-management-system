<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');

$from_date = '';
$to_date = '';
$category_id = '';

$where = " WHERE 1=1 ";

if(isset($_GET['filter']))
{
    $from_date = $_GET['from_date'];
    $to_date = $_GET['to_date'];
    $category_id = $_GET['category_id'];

    if(!empty($from_date))
    {
        $where .= "
        AND expenses.expense_date >= '$from_date'
        ";
    }

    if(!empty($to_date))
    {
        $where .= "
        AND expenses.expense_date <= '$to_date'
        ";
    }

    if(!empty($category_id))
    {
        $where .= "
        AND expenses.category_id='$category_id'
        ";
    }
}

$query = "

SELECT

expenses.*,
expense_categories.category_name

FROM expenses

LEFT JOIN expense_categories

ON expenses.category_id =
expense_categories.category_id

$where

ORDER BY expenses.expense_date DESC

";

$result = mysqli_query($conn,$query);

?>

<div class="main-content">

<div class="card shadow p-4">

<h3 class="mb-4">

📊 Expense Report

</h3>

<form method="GET">

<div class="row">

<div class="col-md-3">

<label>From Date</label>

<input
type="date"
name="from_date"
value="<?php echo $from_date; ?>"
class="form-control">

</div>

<div class="col-md-3">

<label>To Date</label>

<input
type="date"
name="to_date"
value="<?php echo $to_date; ?>"
class="form-control">

</div>

<div class="col-md-3">

<label>Category</label>

<select
name="category_id"
class="form-control">

<option value="">
All Categories
</option>

<?php

$catQuery =
mysqli_query(
$conn,
"SELECT * FROM expense_categories"
);

while($cat =
mysqli_fetch_assoc($catQuery))
{

?>

<option

value="<?php echo $cat['category_id']; ?>"

<?php

if($category_id ==
$cat['category_id'])
{
    echo "selected";
}

?>

>

<?php echo $cat['category_name']; ?>

</option>

<?php } ?>

</select>

</div>

<div class="col-md-3">

<label>&nbsp;</label>

<button
type="submit"
name="filter"
class="btn btn-primary w-100">

Filter Report

</button>

</div>

</div>

</form>

<hr>

<div class="table-responsive">

<table class="table table-bordered">

<thead class="table-dark">

<tr>

<th>ID</th>
<th>Category</th>
<th>Title</th>
<th>Amount</th>
<th>Date</th>

</tr>

</thead>

<tbody>

<?php

$totalExpense = 0;

while($row =
mysqli_fetch_assoc($result))
{

$totalExpense +=
$row['amount'];

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

</tr>

<?php

}

?>

</tbody>

<tfoot>

<tr>

<th colspan="3">

Total Expense

</th>

<th colspan="2">

Rs.
<?php echo number_format($totalExpense); ?>

</th>

</tr>

</tfoot>

</table>

</div>

<button
onclick="window.print()"
class="btn btn-success">

🖨 Print Report

</button>

</div>

</div>

<?php
include('../../includes/footer.php');
?>