<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');

/* ==================================
   DEFAULT MONTH & YEAR
================================== */

$month =
isset($_GET['month'])
?
$_GET['month']
:
date('F');

$year =
isset($_GET['year'])
?
$_GET['year']
:
date('Y');

/* ==================================
   MONTHLY COLLECTION
================================== */

$collectionQuery = "

SELECT
SUM(amount) AS total_collection

FROM monthly_payments

WHERE payment_month='$month'

AND payment_year='$year'

";

$collectionResult =
mysqli_query($conn,$collectionQuery);

$collectionData =
mysqli_fetch_assoc($collectionResult);

$monthlyCollection =
$collectionData['total_collection'] ?? 0;

/* ==================================
   FRIDAY CHANDA
================================== */

$fridayQuery = "

SELECT
SUM(amount) AS total_friday

FROM friday_collections

WHERE MONTH(collection_date)=
MONTH(
STR_TO_DATE('$month','%M')
)

AND YEAR(collection_date)='$year'

";

$fridayResult =
mysqli_query($conn,$fridayQuery);

$fridayData =
mysqli_fetch_assoc($fridayResult);

$fridayCollection =
$fridayData['total_friday'] ?? 0;

/* ==================================
   DONATIONS
================================== */

$donationQuery = "

SELECT
SUM(amount) AS total_donation

FROM donations

WHERE MONTH(donation_date)=
MONTH(
STR_TO_DATE('$month','%M')
)

AND YEAR(donation_date)='$year'

";

$donationResult =
mysqli_query($conn,$donationQuery);

$donationData =
mysqli_fetch_assoc($donationResult);

$totalDonation =
$donationData['total_donation'] ?? 0;

/* ==================================
   EXPENSES
================================== */

$expenseQuery = "

SELECT
SUM(amount) AS total_expense

FROM expenses

WHERE MONTH(expense_date)=
MONTH(
STR_TO_DATE('$month','%M')
)

AND YEAR(expense_date)='$year'

";

$expenseResult =
mysqli_query($conn,$expenseQuery);

$expenseData =
mysqli_fetch_assoc($expenseResult);

$totalExpense =
$expenseData['total_expense'] ?? 0;

/* ==================================
   IMAM SALARY
================================== */

$salaryQuery = "

SELECT
SUM(amount) AS total_salary

FROM imam_salary

WHERE salary_month='$month'

AND salary_year='$year'

AND payment_status='Paid'

";

$salaryResult =
mysqli_query($conn,$salaryQuery);

$salaryData =
mysqli_fetch_assoc($salaryResult);

$totalSalary =
$salaryData['total_salary'] ?? 0;

/* ==================================
   FUND CALCULATIONS
================================== */

$salaryFund =
$monthlyCollection -
$totalSalary;

$generalFund =
(
$fridayCollection
+
$totalDonation
)
-
$totalExpense;

$netBalance =
$salaryFund +
$generalFund;

?>

<div class="main-content">

<div class="container-fluid">

<h2 class="mb-4">

📊 Monthly Financial Report

</h2>

<div class="card shadow mb-4">

<div class="card-body">

<form method="GET">

<div class="row">

<div class="col-md-4">

<label>

Month

</label>

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
{
echo "selected";
}

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

<label>

Year

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

<div class="col-md-4">

<label>&nbsp;</label>

<button
type="submit"
class="btn btn-primary w-100">

Generate Report

</button>

</div>

</div>

</form>

</div>

</div>
<!-- ==================================
     FINANCIAL SUMMARY CARDS
================================== -->

<div class="row">

    <!-- Monthly Collection -->

    <div class="col-md-3 mb-4">

        <div class="card text-white bg-primary shadow">

            <div class="card-body">

                <h6 class="card-title">
                    💰 Monthly Collection
                </h6>

                <h3>

                    Rs.
                    <?php echo number_format($monthlyCollection); ?>

                </h3>

            </div>

        </div>

    </div>

    <!-- Friday Chanda -->

    <div class="col-md-3 mb-4">

        <div class="card text-dark bg-warning shadow">

            <div class="card-body">

                <h6 class="card-title">
                    🕌 Friday Chanda
                </h6>

                <h3>

                    Rs.
                    <?php echo number_format($fridayCollection); ?>

                </h3>

            </div>

        </div>

    </div>

    <!-- Donations -->

    <div class="col-md-3 mb-4">

        <div class="card text-white bg-success shadow">

            <div class="card-body">

                <h6 class="card-title">
                    🎁 Donations
                </h6>

                <h3>

                    Rs.
                    <?php echo number_format($totalDonation); ?>

                </h3>

            </div>

        </div>

    </div>

    <!-- Expenses -->

    <div class="col-md-3 mb-4">

        <div class="card text-white bg-danger shadow">

            <div class="card-body">

                <h6 class="card-title">
                    💸 Expenses
                </h6>

                <h3>

                    Rs.
                    <?php echo number_format($totalExpense); ?>

                </h3>

            </div>

        </div>

    </div>

</div>


<!-- ==================================
     SECOND ROW
================================== -->

<div class="row">

    <!-- Salary Paid -->

    <div class="col-md-4 mb-4">

        <div class="card text-white bg-info shadow">

            <div class="card-body">

                <h6 class="card-title">
                    👳 Imam Salary Paid
                </h6>

                <h3>

                    Rs.
                    <?php echo number_format($totalSalary); ?>

                </h3>

            </div>

        </div>

    </div>

    <!-- Salary Fund -->

    <div class="col-md-4 mb-4">

        <div class="card text-white bg-secondary shadow">

            <div class="card-body">

                <h6 class="card-title">
                    💼 Salary Fund Balance
                </h6>

                <h3>

                    Rs.
                    <?php echo number_format($salaryFund); ?>

                </h3>

            </div>

        </div>

    </div>

    <!-- General Fund -->

    <div class="col-md-4 mb-4">

        <div class="card text-white bg-dark shadow">

            <div class="card-body">

                <h6 class="card-title">
                    🏦 General Fund Balance
                </h6>

                <h3>

                    Rs.
                    <?php echo number_format($generalFund); ?>

                </h3>

            </div>

        </div>

    </div>

</div>


<!-- ==================================
     NET BALANCE CARD
================================== -->

<div class="row">

    <div class="col-md-12 mb-4">

        <div class="card shadow border-0">

            <div class="card-body text-center">

                <h4>

                    📊 Net Mosque Balance

                </h4>

                <h1 class="mt-3">

                    Rs.
                    <?php echo number_format($netBalance); ?>

                </h1>

            </div>

        </div>

    </div>

</div>
<!-- ==================================
     FINANCIAL SUMMARY CARDS
================================== -->

<div class="row">

    <!-- Monthly Collection -->

    <div class="col-md-3 mb-4">

        <div class="card text-white bg-primary shadow">

            <div class="card-body">

                <h6 class="card-title">
                    💰 Monthly Collection
                </h6>

                <h3>

                    Rs.
                    <?php echo number_format($monthlyCollection); ?>

                </h3>

            </div>

        </div>

    </div>

    <!-- Friday Chanda -->

    <div class="col-md-3 mb-4">

        <div class="card text-dark bg-warning shadow">

            <div class="card-body">

                <h6 class="card-title">
                    🕌 Friday Chanda
                </h6>

                <h3>

                    Rs.
                    <?php echo number_format($fridayCollection); ?>

                </h3>

            </div>

        </div>

    </div>

    <!-- Donations -->

    <div class="col-md-3 mb-4">

        <div class="card text-white bg-success shadow">

            <div class="card-body">

                <h6 class="card-title">
                    🎁 Donations
                </h6>

                <h3>

                    Rs.
                    <?php echo number_format($totalDonation); ?>

                </h3>

            </div>

        </div>

    </div>

    <!-- Expenses -->

    <div class="col-md-3 mb-4">

        <div class="card text-white bg-danger shadow">

            <div class="card-body">

                <h6 class="card-title">
                    💸 Expenses
                </h6>

                <h3>

                    Rs.
                    <?php echo number_format($totalExpense); ?>

                </h3>

            </div>

        </div>

    </div>

</div>


<!-- ==================================
     SECOND ROW
================================== -->

<div class="row">

    <!-- Salary Paid -->

    <div class="col-md-4 mb-4">

        <div class="card text-white bg-info shadow">

            <div class="card-body">

                <h6 class="card-title">
                    👳 Imam Salary Paid
                </h6>

                <h3>

                    Rs.
                    <?php echo number_format($totalSalary); ?>

                </h3>

            </div>

        </div>

    </div>

    <!-- Salary Fund -->

    <div class="col-md-4 mb-4">

        <div class="card text-white bg-secondary shadow">

            <div class="card-body">

                <h6 class="card-title">
                    💼 Salary Fund Balance
                </h6>

                <h3>

                    Rs.
                    <?php echo number_format($salaryFund); ?>

                </h3>

            </div>

        </div>

    </div>

    <!-- General Fund -->

    <div class="col-md-4 mb-4">

        <div class="card text-white bg-dark shadow">

            <div class="card-body">

                <h6 class="card-title">
                    🏦 General Fund Balance
                </h6>

                <h3>

                    Rs.
                    <?php echo number_format($generalFund); ?>

                </h3>

            </div>

        </div>

    </div>

</div>


<!-- ==================================
     NET BALANCE CARD
================================== -->

<div class="row">

    <div class="col-md-12 mb-4">

        <div class="card shadow border-0">

            <div class="card-body text-center">

                <h4>

                    📊 Net Mosque Balance

                </h4>

                <h1 class="mt-3">

                    Rs.
                    <?php echo number_format($netBalance); ?>

                </h1>

            </div>

        </div>

    </div>

</div>
<!-- ==================================
     CHARTS SECTION
================================== -->

<div class="row">

    <!-- Income vs Expense -->

    <div class="col-md-6 mb-4">

        <div class="card shadow">

            <div class="card-header">

                <h5 class="mb-0">

                    📊 Income vs Expense

                </h5>

            </div>

            <div class="card-body">

                <canvas
                    id="incomeExpenseChart"
                    height="130">
                </canvas>

            </div>

        </div>

    </div>

    <!-- Income Sources -->

    <div class="col-md-6 mb-4">

        <div class="card shadow">

            <div class="card-header">

                <h5 class="mb-0">

                    🎯 Income Sources

                </h5>

            </div>

            <div class="card-body">

                <canvas
                    id="incomeSourceChart"
                    height="130">
                </canvas>

            </div>

        </div>

    </div>

</div>


<div class="row">

    <!-- Fund Distribution -->

    <div class="col-md-12 mb-4">

        <div class="card shadow">

            <div class="card-header">

                <h5 class="mb-0">

                    🏦 Fund Distribution

                </h5>

            </div>

            <div class="card-body">

                <canvas
                    id="fundChart"
                    height="90">
                </canvas>

            </div>

        </div>

    </div>

</div>
<?php

/* ==================================
   RECENT DONATIONS
================================== */

$recentDonationsQuery = "

SELECT *

FROM donations

WHERE MONTH(donation_date)=
MONTH(
STR_TO_DATE('$month','%M')
)

AND YEAR(donation_date)='$year'

ORDER BY donation_date DESC

LIMIT 10

";

$recentDonationsResult =
mysqli_query($conn,$recentDonationsQuery);

/* ==================================
   RECENT EXPENSES
================================== */

$recentExpensesQuery = "

SELECT
expenses.*,
expense_categories.category_name

FROM expenses

LEFT JOIN expense_categories

ON expenses.category_id =
expense_categories.category_id

WHERE MONTH(expense_date)=
MONTH(
STR_TO_DATE('$month','%M')
)

AND YEAR(expense_date)='$year'

ORDER BY expense_date DESC

LIMIT 10

";

$recentExpensesResult =
mysqli_query($conn,$recentExpensesQuery);

?>

<!-- ==================================
     EXPORT BUTTONS
================================== -->

<div class="row mb-4">

    <div class="col-md-12 text-end">

        <button
            onclick="window.print();"
            class="btn btn-dark">

            <i class="fa fa-print"></i>
            Print Report

        </button>

        <a
        href="export-excel.php?month=<?php echo $month; ?>&year=<?php echo $year; ?>"
        class="btn btn-success">

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


<div class="row">

    <!-- RECENT DONATIONS -->

    <div class="col-md-6 mb-4">

        <div class="card shadow">

            <div class="card-header">

                <h5>

                    🎁 Recent Donations

                </h5>

            </div>

            <div class="card-body">

                <table
                class="table table-bordered table-striped">

                    <thead>

                        <tr>

                            <th>Donor</th>
                            <th>Amount</th>
                            <th>Date</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php

                    while(
                    $donation =
                    mysqli_fetch_assoc(
                    $recentDonationsResult
                    ))
                    {

                    ?>

                    <tr>

                        <td>

                        <?php
                        echo $donation['donor_name'];
                        ?>

                        </td>

                        <td>

                        Rs.
                        <?php
                        echo number_format(
                        $donation['amount']
                        );
                        ?>

                        </td>

                        <td>

                        <?php
                        echo $donation['donation_date'];
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


    <!-- RECENT EXPENSES -->

    <div class="col-md-6 mb-4">

        <div class="card shadow">

            <div class="card-header">

                <h5>

                    💸 Recent Expenses

                </h5>

            </div>

            <div class="card-body">

                <table
                class="table table-bordered table-striped">

                    <thead>

                        <tr>

                            <th>Category</th>
                            <th>Amount</th>
                            <th>Date</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php

                    while(
                    $expense =
                    mysqli_fetch_assoc(
                    $recentExpensesResult
                    ))
                    {

                    ?>

                    <tr>

                        <td>

                        <?php
                        echo $expense['category_name'];
                        ?>

                        </td>

                        <td>

                        Rs.
                        <?php
                        echo number_format(
                        $expense['amount']
                        );
                        ?>

                        </td>

                        <td>

                        <?php
                        echo $expense['expense_date'];
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