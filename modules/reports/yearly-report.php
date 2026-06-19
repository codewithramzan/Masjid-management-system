<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');

include('../../includes/sidebar.php');

$year =
isset($_GET['year'])
?
$_GET['year']
:
date('Y');

/* ==========================
   MEMBERS
========================== */

$memberQuery = "

SELECT COUNT(*) total_members

FROM members

";

$memberData =
mysqli_fetch_assoc(
mysqli_query($conn,$memberQuery)
);

$totalMembers =
$memberData['total_members'] ?? 0;

/* ==========================
   MONTHLY COLLECTION
========================== */

$collectionQuery = "

SELECT
SUM(amount) total_collection

FROM monthly_payments

WHERE payment_year='$year'

";

$collectionData =
mysqli_fetch_assoc(
mysqli_query($conn,$collectionQuery)
);

$totalCollection =
$collectionData['total_collection'] ?? 0;

/* ==========================
   FRIDAY CHANDA
========================== */

$fridayQuery = "

SELECT
SUM(amount) total_friday

FROM friday_collections

WHERE YEAR(collection_date)='$year'

";

$fridayData =
mysqli_fetch_assoc(
mysqli_query($conn,$fridayQuery)
);

$totalFriday =
$fridayData['total_friday'] ?? 0;

/* ==========================
   DONATIONS
========================== */

$donationQuery = "

SELECT
SUM(amount) total_donation

FROM donations

WHERE YEAR(donation_date)='$year'

";

$donationData =
mysqli_fetch_assoc(
mysqli_query($conn,$donationQuery)
);

$totalDonation =
$donationData['total_donation'] ?? 0;

/* ==========================
   EXPENSES
========================== */

$expenseQuery = "

SELECT
SUM(amount) total_expense

FROM expenses

WHERE YEAR(expense_date)='$year'

";

$expenseData =
mysqli_fetch_assoc(
mysqli_query($conn,$expenseQuery)
);

$totalExpense =
$expenseData['total_expense'] ?? 0;

/* ==========================
   IMAM SALARY
========================== */

$salaryQuery = "

SELECT
SUM(amount) total_salary

FROM imam_salary

WHERE salary_year='$year'

AND payment_status='Paid'

";

$salaryData =
mysqli_fetch_assoc(
mysqli_query($conn,$salaryQuery)
);

$totalSalary =
$salaryData['total_salary'] ?? 0;

/* ==========================
   CALCULATIONS
========================== */

$totalIncome =
$totalCollection
+
$totalFriday
+
$totalDonation;

$netFund =
$totalIncome
-
$totalExpense
-
$totalSalary;

?>

<div class="main-content">

<div class="container-fluid">
<div class="d-flex justify-content-between">
<h2 class="mb-4">

📊 Yearly Financial Report

</h2>

<div class="mb-3">

<a
href="export-yearly-pdf.php?year=<?php echo $year; ?>"
class="btn btn-danger">

<i class="fa fa-file-pdf"></i>
Export PDF

</a>

<a
href="export-yearly-excel.php?year=<?php echo $year; ?>"
class="btn btn-success">

<i class="fa fa-file-excel"></i>
Export Excel

</a>

<button
onclick="window.print();"
class="btn btn-primary">

<i class="fa fa-print"></i>
Print Report

</button>

</div>
</div>




<div class="card shadow mb-4">

<div class="card-body">

<form method="GET">

<div class="row">

<div class="col-md-4">

<label>

Select Year

</label>

<select
name="year"
class="form-control">

<?php

for($i=2024;$i<=2035;$i++)
{

?>

<option
value="<?php echo $i; ?>"

<?php
if($year==$i)
{
echo "selected";
}
?>

>

<?php echo $i; ?>

</option>

<?php

}

?>

</select>

</div>

<div class="col-md-3">

<label>&nbsp;</label>

<button
class="btn btn-primary w-100">

Generate Report

</button>

</div>

</div>

</form>

</div>

</div>
<!-- ===================================
	 YEARLY KPI CARDS
=================================== -->

<div class="row">

	<!-- Total Members -->

	<div class="col-md-3 mb-4">

		<div class="card bg-primary text-white shadow border-0">

			<div class="card-body">

				<h6>👥 Total Members</h6>

				<h2>

					<?php echo number_format($totalMembers); ?>

				</h2>

			</div>

		</div>

	</div>

	<!-- Total Collection -->

	<div class="col-md-3 mb-4">

		<div class="card bg-success text-white shadow border-0">

			<div class="card-body">

				<h6>💰 Total Collection</h6>

				<h2>

					Rs.
					<?php echo number_format($totalCollection); ?>

				</h2>

			</div>

		</div>

	</div>

	<!-- Friday Chanda -->

	<div class="col-md-3 mb-4">

		<div class="card bg-warning shadow border-0">

			<div class="card-body">

				<h6>🕌 Friday Chanda</h6>

				<h2>

					Rs.
					<?php echo number_format($totalFriday); ?>

				</h2>

			</div>

		</div>

	</div>

	<!-- Donations -->

	<div class="col-md-3 mb-4">

		<div class="card bg-info text-white shadow border-0">

			<div class="card-body">

				<h6>🎁 Donations</h6>

				<h2>

					Rs.
					<?php echo number_format($totalDonation); ?>

				</h2>

			</div>

		</div>

	</div>

</div>

<div class="row">

	<!-- Expenses -->

	<div class="col-md-4 mb-4">

		<div class="card bg-danger text-white shadow border-0">

			<div class="card-body">

				<h6>💸 Total Expenses</h6>

				<h2>

					Rs.
					<?php echo number_format($totalExpense); ?>

				</h2>

			</div>

		</div>

	</div>

	<!-- Imam Salary -->

	<div class="col-md-4 mb-4">

		<div class="card bg-secondary text-white shadow border-0">

			<div class="card-body">

				<h6>👳 Imam Salary Paid</h6>

				<h2>

					Rs.
					<?php echo number_format($totalSalary); ?>

				</h2>

			</div>

		</div>

	</div>

	<!-- Net Fund -->

	<div class="col-md-4 mb-4">

		<div class="card bg-dark text-white shadow border-0">

			<div class="card-body">

				<h6>🏦 Net Fund Balance</h6>

				<h2>

					Rs.
					<?php echo number_format($netFund); ?>

				</h2>

			</div>

		</div>

	</div>

</div>
<div class="row">

	<div class="col-md-12 mb-4">

		<div class="card shadow border-0">

			<div class="card-body text-center">

				<h3>

					📊 Total Annual Income

				</h3>

				<h1 class="mt-3">

					Rs.
					<?php echo number_format($totalIncome); ?>

				</h1>

			</div>

		</div>

	</div>

</div>
<?php

$monthlyData = [];

$monthNames = [

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

foreach($monthNames as $monthName)
{

	$query = "

	SELECT
	SUM(amount) total

	FROM monthly_payments

	WHERE payment_month='$monthName'

	AND payment_year='$year'

	";

	$result =
	mysqli_query($conn,$query);

	$data =
	mysqli_fetch_assoc($result);

	$monthlyData[] =
	$data['total'] ?? 0;
}

?>
<div class="row">

	<!-- Collection Trend -->

	<div class="col-md-8 mb-4">

		<div class="card shadow">

			<div class="card-header">

				<h5>

					📈 Monthly Collection Trend

				</h5>

			</div>

			<div class="card-body">

				<canvas
				id="collectionTrendChart"
				height="100">
				</canvas>

			</div>

		</div>

	</div>

	<!-- Income Sources -->

	<div class="col-md-4 mb-4">

		<div class="card shadow">

			<div class="card-header">

				<h5>

					🥧 Income Sources

				</h5>

			</div>

			<div class="card-body">

				<canvas
				id="incomePieChart"
				height="200">
				</canvas>

			</div>

		</div>

	</div>

</div>

<div class="row">

	<div class="col-md-12 mb-4">

		<div class="card shadow">

			<div class="card-header">

				<h5>

					📊 Income vs Expenses vs Salary

				</h5>

			</div>

			<div class="card-body">

				<canvas
				id="comparisonChart"
				height="100">
				</canvas>

			</div>

		</div>

	</div>

</div>
<div class="card shadow mb-4">

<div class="card-header">

<h5>

📋 Monthly Collection Breakdown

</h5>

</div>

<div class="card-body">

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Month</th>
<th>Collection</th>

</tr>

</thead>

<tbody>

<?php

for($i=0;$i<12;$i++)
{

?>

<tr>

<td>

<?php
echo $monthNames[$i];
?>

</td>

<td>

Rs.
<?php
echo number_format(
$monthlyData[$i]
);
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
<script>
	<?php

$recentDonations = "

SELECT *

FROM donations

WHERE YEAR(donation_date)='$year'

ORDER BY donation_date DESC

LIMIT 10

";

$donationResult =
mysqli_query($conn,$recentDonations);

?>

<div class="card shadow mb-4">

<div class="card-header bg-success text-white">

<h5>

🎁 Recent Donations

</h5>

</div>

<div class="card-body">

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>ID</th>
<th>Donor Name</th>
<th>Amount</th>
<th>Type</th>
<th>Date</th>

</tr>

</thead>

<tbody>

<?php while($row=mysqli_fetch_assoc($donationResult)){ ?>

<tr>

<td><?php echo $row['donation_id']; ?></td>

<td><?php echo $row['donor_name']; ?></td>

<td>
Rs. <?php echo number_format($row['amount']); ?>
</td>

<td><?php echo $row['donation_type']; ?></td>

<td><?php echo $row['donation_date']; ?></td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>
<?php

$recentExpenses = "

SELECT
expenses.*,
expense_categories.category_name

FROM expenses

LEFT JOIN expense_categories

ON expenses.category_id =
expense_categories.category_id

WHERE YEAR(expense_date)='$year'

ORDER BY expense_date DESC

LIMIT 10

";

$expenseResult =
mysqli_query($conn,$recentExpenses);

?>

<div class="card shadow mb-4">

<div class="card-header bg-danger text-white">

<h5>

💸 Recent Expenses

</h5>

</div>

<div class="card-body">

<table class="table table-bordered table-striped">

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

<?php while($row=mysqli_fetch_assoc($expenseResult)){ ?>

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

<?php } ?>

</tbody>

</table>

</div>

</div>
<?php

$salaryHistory = "

SELECT *

FROM imam_salary

WHERE salary_year='$year'

ORDER BY payment_date DESC

LIMIT 10

";

$salaryResult =
mysqli_query($conn,$salaryHistory);

?>

<div class="card shadow mb-4">

<div class="card-header bg-primary text-white">

<h5>

👳 Recent Salary Payments

</h5>

</div>

<div class="card-body">

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>ID</th>
<th>Imam Name</th>
<th>Amount</th>
<th>Month</th>
<th>Status</th>
<th>Date</th>

</tr>

</thead>

<tbody>

<?php while($row=mysqli_fetch_assoc($salaryResult)){ ?>

<tr>

<td>

<?php echo $row['salary_id']; ?>

</td>

<td>

<?php echo $row['imam_name']; ?>

</td>

<td>

Rs.
<?php echo number_format($row['amount']); ?>

</td>

<td>

<?php echo $row['salary_month']; ?>

</td>

<td>

<?php echo $row['payment_status']; ?>

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
<div class="card shadow mb-4">

<div class="card-header bg-dark text-white">

<h4>

📑 Annual Financial Summary

</h4>

</div>

<div class="card-body">

<table class="table table-bordered">

<tr>

<th>Total Collection</th>

<td>

Rs.
<?php echo number_format($totalCollection); ?>

</td>

</tr>

<tr>

<th>Friday Chanda</th>

<td>

Rs.
<?php echo number_format($totalFriday); ?>

</td>

</tr>

<tr>

<th>Total Donations</th>

<td>

Rs.
<?php echo number_format($totalDonation); ?>

</td>

</tr>

<tr>

<th>Total Income</th>

<td>

Rs.
<?php echo number_format($totalIncome); ?>

</td>

</tr>

<tr>

<th>Total Expenses</th>

<td>

Rs.
<?php echo number_format($totalExpense); ?>

</td>

</tr>

<tr>

<th>Imam Salary</th>

<td>

Rs.
<?php echo number_format($totalSalary); ?>

</td>

</tr>

<tr class="table-success">

<th>Net Fund Balance</th>

<td>

Rs.
<?php echo number_format($netFund); ?>

</td>

</tr>

</table>

</div>

</div>

/* Collection Trend */

new Chart(
document.getElementById('collectionTrendChart'),
{

	type:'line',

	data:{

		labels:[

			'Jan',
			'Feb',
			'Mar',
			'Apr',
			'May',
			'Jun',
			'Jul',
			'Aug',
			'Sep',
			'Oct',
			'Nov',
			'Dec'

		],

		datasets:[{

			label:'Collection',

			data:

			<?php
			echo json_encode($monthlyData);
			?>

		}]

	}

});


/* Income Pie */

new Chart(
document.getElementById('incomePieChart'),
{

	type:'pie',

	data:{

		labels:[

			'Collection',
			'Friday',
			'Donation'

		],

		datasets:[{

			data:[

				<?php echo $totalCollection; ?>,
				<?php echo $totalFriday; ?>,
				<?php echo $totalDonation; ?>

			]

		}]

	}

});


/* Comparison */

new Chart(
document.getElementById('comparisonChart'),
{

	type:'bar',

	data:{

		labels:[

			'Income',
			'Expenses',
			'Salary'

		],

		datasets:[{

			label:'Amount',

			data:[

				<?php echo $totalIncome; ?>,
				<?php echo $totalExpense; ?>,
				<?php echo $totalSalary; ?>

			]

		}]

	}

});

</script>
<div class="card shadow mb-4">

<div class="card-header bg-dark text-white">

<h4>

📑 Annual Financial Summary

</h4>

</div>

<div class="card-body">

<table class="table table-bordered">

<tr>

<th>Total Collection</th>

<td>

Rs.
<?php echo number_format($totalCollection); ?>

</td>

</tr>

<tr>

<th>Friday Chanda</th>

<td>

Rs.
<?php echo number_format($totalFriday); ?>

</td>

</tr>

<tr>

<th>Total Donations</th>

<td>

Rs.
<?php echo number_format($totalDonation); ?>

</td>

</tr>

<tr>

<th>Total Income</th>

<td>

Rs.
<?php echo number_format($totalIncome); ?>

</td>

</tr>

<tr>

<th>Total Expenses</th>

<td>

Rs.
<?php echo number_format($totalExpense); ?>

</td>

</tr>

<tr>

<th>Imam Salary</th>

<td>

Rs.
<?php echo number_format($totalSalary); ?>

</td>

</tr>

<tr class="table-success">

<th>Net Fund Balance</th>

<td>

Rs.
<?php echo number_format($netFund); ?>

</td>

</tr>

</table>

</div>

</div>