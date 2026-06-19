<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');


$member_id = $_GET['member_id'] ?? '';

?>

<div class="main-content">

<div class="container-fluid">


<h3 class="mb-4">

📒 Member Ledger

</h3>



<div class="card mb-4 shadow">

<div class="card-body">


<form method="GET">


<div class="row">


<div class="col-md-10">


<label>Select Member</label>


<select 
name="member_id"
class="form-control"
required>


<option value="">
Choose Member
</option>


<?php


$members = mysqli_query(
$conn,
"SELECT * FROM members
WHERE status='Active'
ORDER BY member_name"
);


while($m=mysqli_fetch_assoc($members))
{


?>


<option

value="<?php echo $m['member_id'];?>"

<?php

if($member_id==$m['member_id'])
echo "selected";

?>

>

<?php echo $m['member_name']; ?>

</option>


<?php } ?>


</select>


</div>



<div class="col-md-2">


<label>&nbsp;</label>


<button class="btn btn-primary w-100">

View

</button>


</div>


</div>


</form>


</div>

</div>





<?php


if($member_id!="")
{


/* MEMBER */

$memberQ=mysqli_query(
$conn,
"SELECT *
FROM members
WHERE member_id='$member_id'"
);


$member=mysqli_fetch_assoc($memberQ);



/* TOTAL PAID */

$paidQ=mysqli_query(
$conn,
"
SELECT SUM(amount) total
FROM monthly_payments
WHERE member_id='$member_id'
AND payment_status='Paid'
"
);


$paid=mysqli_fetch_assoc($paidQ);

$totalPaid=$paid['total'] ?? 0;



/* PENDING */

$pendingQ=mysqli_query(
$conn,
"
SELECT SUM(amount) total
FROM monthly_payments
WHERE member_id='$member_id'
AND payment_status='Unpaid'
"
);


$pending=mysqli_fetch_assoc($pendingQ);

$totalPending=$pending['total'] ?? 0;



/* MONTHS */

$countQ=mysqli_query(
$conn,
"
SELECT

COUNT(*) total_months,

SUM(
CASE
WHEN payment_status='Paid'
THEN 1
ELSE 0
END
) paid_months

FROM monthly_payments

WHERE member_id='$member_id'
"
);


$count=mysqli_fetch_assoc($countQ);


$percentage =
$count['total_months']>0
?
($count['paid_months']/$count['total_months'])*100
:
0;


?>



<!-- EXPORT BUTTON -->


<a href="export-ledger-pdf.php?member_id=<?php echo $member_id;?>"

class="btn btn-danger mb-3">

<i class="fa fa-file-pdf"></i>

Export PDF

</a>





<div class="row">


<div class="col-md-3">

<div class="card-box bg-success">

<h6>Total Paid</h6>

<h3>

Rs.
<?php echo number_format($totalPaid);?>

</h3>

</div>

</div>




<div class="col-md-3">

<div class="card-box bg-danger">

<h6>Pending</h6>

<h3>

Rs.
<?php echo number_format($totalPending);?>

</h3>

</div>

</div>




<div class="col-md-3">

<div class="card-box bg-primary">

<h6>Paid Months</h6>

<h3>

<?php echo $count['paid_months'];?>

</h3>

</div>

</div>




<div class="col-md-3">

<div class="card-box bg-warning">

<h6>Collection %</h6>

<h3>

<?php echo number_format($percentage,1);?>%

</h3>

</div>

</div>



</div>





<div class="card mt-4 shadow">


<div class="card-header bg-dark text-white">


<h5>

Payment History

-
<?php echo $member['member_name'];?>

</h5>


</div>



<div class="card-body">



<table class="table table-bordered">


<thead>

<tr>

<th>Month</th>
<th>Year</th>
<th>Amount</th>
<th>Status</th>
<th>Date</th>

</tr>

</thead>



<tbody>



<?php


$history=mysqli_query(
$conn,
"
SELECT *

FROM monthly_payments

WHERE member_id='$member_id'

ORDER BY payment_year DESC,
payment_id DESC
"
);



while($row=mysqli_fetch_assoc($history))
{


?>


<tr>


<td>

<?php echo $row['payment_month'];?>

</td>



<td>

<?php echo $row['payment_year'];?>

</td>



<td>

Rs.
<?php echo number_format($row['amount']);?>

</td>




<td>


<?php if($row['payment_status']=="Paid")
{ ?>

<span class="badge bg-success">
Paid
</span>


<?php } else { ?>


<span class="badge bg-danger">
Unpaid
</span>


<?php } ?>


</td>



<td>

<?php echo $row['payment_date'] ?? '-';?>

</td>


</tr>


<?php } ?>



</tbody>


</table>


</div>

</div>



<?php } ?>



</div>

</div>


<?php include('../../includes/footer.php'); ?>