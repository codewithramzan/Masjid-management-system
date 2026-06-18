<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');

/* ==========================
	 TOTAL MEMBERS
========================== */

$membersQuery =
mysqli_query(
$conn,
"SELECT COUNT(*) total_members
FROM members"
);

$membersData =
mysqli_fetch_assoc($membersQuery);

$totalMembers =
$membersData['total_members'] ?? 0;

/* ==========================
	 MONTHLY COLLECTION
========================== */

$collectionQuery =
mysqli_query(
$conn,
"SELECT SUM(amount) total_collection
FROM monthly_payments"
);

$collectionData =
mysqli_fetch_assoc($collectionQuery);

$totalCollection =
$collectionData['total_collection'] ?? 0;

/* ==========================
	 FRIDAY CHANDA
========================== */

$fridayQuery =
mysqli_query(
$conn,
"SELECT SUM(amount) friday_total
FROM friday_collections"
);

$fridayData =
mysqli_fetch_assoc($fridayQuery);

$totalFriday =
$fridayData['friday_total'] ?? 0;

/* ==========================
	 DONATIONS
========================== */

$donationQuery =
mysqli_query(
$conn,
"SELECT SUM(amount) total_donation
FROM donations"
);

$donationData =
mysqli_fetch_assoc($donationQuery);

$totalDonation =
$donationData['total_donation'] ?? 0;

/* ==========================
	 EXPENSES
========================== */

$expenseQuery =
mysqli_query(
$conn,
"SELECT SUM(amount) total_expense
FROM expenses"
);

$expenseData =
mysqli_fetch_assoc($expenseQuery);

$totalExpense =
$expenseData['total_expense'] ?? 0;

/* ==========================
	 IMAM SALARY
========================== */

$salaryQuery =
mysqli_query(
$conn,
"
SELECT SUM(amount) total_salary

FROM imam_salary

WHERE payment_status='Paid'
"
);

$salaryData =
mysqli_fetch_assoc($salaryQuery);

$totalSalary =
$salaryData['total_salary'] ?? 0;

/* ==========================
	 FUND CALCULATIONS
========================== */

/* Salary Fund */

$salaryFund =
$totalCollection -
$totalSalary;

/* General Fund */

$generalFund =
(
$totalFriday +
$totalDonation
)
-
$totalExpense;

/* Net Fund */

$netFund =
$salaryFund +
$generalFund;

?>

<div class="main-content">

<div class="container-fluid">

<div class="d-flex justify-content-between mb-4">

<h2>

📊 Financial Summary Report

</h2>
<div class="col-md-6 text-end">

<button
onclick="window.print()"
class="btn btn-success">

🖨 Print Report

</button>
	 <a
				href="export-excel.php?month=<?php echo $month; ?>&year=<?php echo $year; ?>"
				class="btn btn-primary">

						<i class="fa fa-file-excel"></i>
						Export Excel

				</a>

				<a
				href="export-pdf.php?month=<?php echo $month; ?>&year=<?php echo $year; ?>"
				class="btn btn-danger">

						<i class="fa fa-file-pdf"></i>
						Export PDF

				</a>
				</div>

</div>

<!-- ROW 1 -->

<div class="row">

<div class="col-md-3 mb-4">

<div class="card bg-primary text-white shadow">

<div class="card-body">

<h6>Total Members</h6>

<h2>

<?php echo number_format($totalMembers); ?>

</h2>

</div>

</div>

</div>

<div class="col-md-3 mb-4">

<div class="card bg-success text-white shadow">

<div class="card-body">

<h6>Total Collection</h6>

<h2>

Rs.
<?php echo number_format($totalCollection); ?>

</h2>

</div>

</div>

</div>

<div class="col-md-3 mb-4">

<div class="card bg-warning shadow">

<div class="card-body">

<h6>Total Friday Chanda</h6>

<h2>

Rs.
<?php echo number_format($totalFriday); ?>

</h2>

</div>

</div>

</div>

<div class="col-md-3 mb-4">

<div class="card bg-info text-white shadow">

<div class="card-body">

<h6>Total Donations</h6>

<h2>

Rs.
<?php echo number_format($totalDonation); ?>

</h2>

</div>

</div>

</div>

</div>

<!-- ROW 2 -->

<div class="row">

<div class="col-md-4 mb-4">

<div class="card bg-danger text-white shadow">

<div class="card-body">

<h6>Total Expenses</h6>

<h2>

Rs.
<?php echo number_format($totalExpense); ?>

</h2>

</div>

</div>

</div>

<div class="col-md-4 mb-4">

<div class="card bg-secondary text-white shadow">

<div class="card-body">

<h6>Total Salary Paid</h6>

<h2>

Rs.
<?php echo number_format($totalSalary); ?>

</h2>

</div>

</div>

</div>

<div class="col-md-4 mb-4">

<div class="card bg-dark text-white shadow">

<div class="card-body">

<h6>Net Mosque Fund</h6>

<h2>

Rs.
<?php echo number_format($netFund); ?>

</h2>

</div>

</div>

</div>

</div>

<!-- FUND DETAILS -->

<div class="card shadow mt-3">

<div class="card-header bg-dark text-white">

Fund Summary

</div>

<div class="card-body">

<table class="table table-bordered">

<tr>

<th width="40%">

Salary Fund Balance

</th>

<td>

Rs.
<?php echo number_format($salaryFund); ?>

</td>

</tr>

<tr>

<th>

General Fund Balance

</th>

<td>

Rs.
<?php echo number_format($generalFund); ?>

</td>

</tr>

<tr>

<th>

Net Mosque Fund

</th>

<td>

Rs.
<?php echo number_format($netFund); ?>

</td>

</tr>

</table>

</div>

</div>

<!-- CHART -->

<div class="card shadow mt-4">

<div class="card-header">

Financial Overview

</div>

<div class="card-body">

<canvas id="financeChart"></canvas>

</div>

</div>

</div>

</div>

<script>

const financeChart =
document.getElementById('financeChart');

new Chart(financeChart, {

type:'bar',

data:{

labels:[

'Collection',
'Friday Chanda',
'Donations',
'Expenses',
'Salary'

],

datasets:[{

label:'Financial Summary',

data:[

<?php echo $totalCollection; ?>,
<?php echo $totalFriday; ?>,
<?php echo $totalDonation; ?>,
<?php echo $totalExpense; ?>,
<?php echo $totalSalary; ?>

]

}]

},

options:{
responsive:true
}

});

</script>

<?php
include('../../includes/footer.php');
?>