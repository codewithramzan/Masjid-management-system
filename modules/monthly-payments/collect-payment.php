<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');

$message = "";

/* ==========================
   COLLECT PAYMENT
========================== */

if(isset($_GET['collect']))
{
    $payment_id =
    (int)$_GET['collect'];

    $user_id =
    $_SESSION['user_id'];

    $updateQuery = "

    UPDATE monthly_payments

    SET

    payment_status='Paid',
    payment_date=CURDATE(),
    received_by='$user_id'

    WHERE payment_id='$payment_id'

    AND payment_status='Unpaid'

    ";

    if(mysqli_query($conn,$updateQuery))
    {
        $message =
        "Payment Collected Successfully";
    }
}

/* ==========================
   FILTERS
========================== */

$month =
$_GET['month'] ??
date('F');

$year =
$_GET['year'] ??
date('Y');

/* ==========================
   PAYMENTS LIST
========================== */

$query = "

SELECT

mp.*,
m.member_name,
m.phone

FROM monthly_payments mp

INNER JOIN members m

ON mp.member_id =
m.member_id

WHERE mp.payment_month='$month'

AND mp.payment_year='$year'

ORDER BY

mp.payment_status ASC,
m.member_name ASC

";

$result =
mysqli_query($conn,$query);

?>

<div class="main-content">

<div class="container-fluid">

<h3 class="mb-4">

💰 Collect Monthly Payments

</h3>

<?php if($message!="") { ?>

<div class="alert alert-success">

<?php echo $message; ?>

</div>

<?php } ?>

<!-- FILTER -->

<div class="card mb-4">

<div class="card-body">

<form method="GET">

<div class="row">

<div class="col-md-4">

<label>Month</label>

<select
name="month"
class="form-control">

<?php

$months = [

'January',
'February',
'March',
'April',
'May',
'June',
'July',
'August',
'September',
'October',
'November',
'December'

];

foreach($months as $m)
{

?>

<option
value="<?php echo $m; ?>"

<?php

if($month==$m)
echo "selected";

?>

>

<?php echo $m; ?>

</option>

<?php

}

?>

</select>

</div>

<div class="col-md-4">

<label>Year</label>

<select
name="year"
class="form-control">

<?php

for(
$y=date('Y')-2;
$y<=date('Y')+5;
$y++
)
{

?>

<option
value="<?php echo $y; ?>"

<?php

if($year==$y)
echo "selected";

?>

>

<?php echo $y; ?>

</option>

<?php

}

?>

</select>

</div>

<div class="col-md-4">

<label>&nbsp;</label>

<button
type="submit"
class="btn btn-primary w-100">

Filter

</button>

</div>

</div>

</form>

</div>

</div>

<!-- PAYMENTS TABLE -->

<div class="card shadow">

<div class="card-header bg-success text-white">

<h5>

<?php echo $month; ?>

-

<?php echo $year; ?>

Collection

</h5>

</div>

<div class="card-body">

<div class="table-responsive">

<table
class="table table-bordered table-hover">

<thead>

<tr>

<th>ID</th>
<th>Member</th>
<th>Phone</th>
<th>Amount</th>
<th>Status</th>
<th>Payment Date</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php

while(
$row =
mysqli_fetch_assoc($result)
)
{

?>

<tr>

<td>

<?php
echo $row['payment_id'];
?>

</td>

<td>

<?php
echo $row['member_name'];
?>

</td>

<td>

<?php
echo $row['phone'];
?>

</td>

<td>

Rs.
<?php
echo number_format(
$row['amount']
);
?>

</td>

<td>

<?php

if(
$row['payment_status']
=='Paid'
)
{

?>

<span
class="badge bg-success">

Paid

</span>

<?php

}
else
{

?>

<span
class="badge bg-danger">

Unpaid

</span>

<?php

}

?>

</td>

<td>

<?php

echo
$row['payment_date']
?: '-';

?>

</td>

<td>

<?php

if(
$row['payment_status']
=='Unpaid'
)
{

?>

<a

href="?collect=<?php echo $row['payment_id']; ?>&month=<?php echo $month; ?>&year=<?php echo $year; ?>"

class="btn btn-success btn-sm"

onclick="return confirm('Collect Payment?')"

>

Collect

</a>

<?php

}
else
{

?>

<button
class="btn btn-secondary btn-sm"
disabled>

Collected

</button>

<?php

}

?>

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

</div>

</div>

<?php

include('../../includes/footer.php');

?>