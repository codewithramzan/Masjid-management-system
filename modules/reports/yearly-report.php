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

<h2 class="mb-4">

📊 Yearly Financial Report

</h2>

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