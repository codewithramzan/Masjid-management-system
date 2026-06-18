<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');

$where = " WHERE 1=1 ";

if(isset($_GET['filter']))
{

$type =
$_GET['transaction_type'];

$from =
$_GET['from_date'];

$to =
$_GET['to_date'];

if($type != '')
{
    $where .= "
    AND transaction_type='$type'
    ";
}

if($from != '')
{
    $where .= "
    AND transaction_date>='$from'
    ";
}

if($to != '')
{
    $where .= "
    AND transaction_date<='$to'
    ";
}

}

$query = "

SELECT *

FROM fund_transactions

$where

ORDER BY transaction_date DESC

";

$result =
mysqli_query($conn,$query);

?>

<div class="main-content">

<div class="card p-4 shadow">

<h3>

📊 Fund Ledger Report

</h3>

<form method="GET">

<div class="row">

<div class="col-md-3">

<select
name="transaction_type"
class="form-control">

<option value="">

All Types

</option>

<option>

Monthly Collection

</option>

<option>

Friday Chanda

</option>

<option>

Donation

</option>

<option>

Expense

</option>

<option>

Imam Salary

</option>

</select>

</div>

<div class="col-md-3">

<input
type="date"
name="from_date"
class="form-control">

</div>

<div class="col-md-3">

<input
type="date"
name="to_date"
class="form-control">

</div>

<div class="col-md-3">

<button
type="submit"
name="filter"
class="btn btn-primary w-100">

Filter

</button>

</div>

</div>

</form>

<hr>

<table class="table table-bordered">

<thead>

<tr>

<th>Type</th>
<th>Fund</th>
<th>Amount</th>
<th>Date</th>

</tr>

</thead>

<tbody>

<?php

$total = 0;

while($row =
mysqli_fetch_assoc($result))
{

$total +=
$row['amount'];

?>

<tr>

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

</tr>

<?php } ?>

</tbody>

<tfoot>

<tr>

<th colspan="2">

Total

</th>

<th colspan="2">

Rs.
<?php echo number_format($total); ?>

</th>

</tr>

</tfoot>

</table>

<button
onclick="window.print()"
class="btn btn-success">

🖨 Print Ledger

</button>

</div>

</div>

<?php
include('../../includes/footer.php');
?>