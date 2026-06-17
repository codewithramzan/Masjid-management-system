<?php

include('config/session.php');
include('config/database.php');

include('includes/header.php');
include('includes/sidebar.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

/* ===========================
   TOTAL MEMBERS
=========================== */

$memberQuery = "
SELECT COUNT(*) AS total_members
FROM members
";

$memberResult = mysqli_query($conn, $memberQuery);
$memberData = mysqli_fetch_assoc($memberResult);

/* ===========================
   MONTHLY COLLECTION
=========================== */

$collectionQuery = "
SELECT SUM(amount) AS total_collection
FROM monthly_payments
";

$collectionResult = mysqli_query($conn, $collectionQuery);
$collectionData = mysqli_fetch_assoc($collectionResult);

/* ===========================
   FRIDAY CHANDA
=========================== */

$fridayQuery = "
SELECT SUM(amount) AS friday_total
FROM friday_collections
";

$fridayResult = mysqli_query($conn, $fridayQuery);
$fridayData = mysqli_fetch_assoc($fridayResult);
/* ===========================
   total donation chanda
=========================== */

$donationChanda = "
SELECT SUM(amount) AS total_donation
FROM donations
";

$donationResult = mysqli_query($conn, $donationChanda);
$donationData = mysqli_fetch_assoc($donationResult);

/* ===========================
   TOTAL EXPENSES
=========================== */

$expenseQuery = "
SELECT SUM(amount) AS total_expense
FROM expenses
";

$expenseResult = mysqli_query($conn, $expenseQuery);
$expenseData = mysqli_fetch_assoc($expenseResult);

/* ===========================
   DASHBOARD CALCULATIONS
=========================== */

$monthlyCollection =
($collectionData['total_collection'] ?? 0);

$fridayChanda =
($fridayData['friday_total'] ?? 0);

$totalDonation = ($donationData['total_donation'] ?? 0);

$totalExpenses =
($expenseData['total_expense'] ?? 0);

/* Salary Fund */
$salaryFund = $monthlyCollection;


/* General Fund */

$generalFund =
$fridayChanda
+ 
$totalDonation
 -
$totalExpenses;

/* Total Mosque Fund */

$totalMosqueFund =
$salaryFund +
$generalFund;

/* ===========================
   UNPAID MEMBERS
=========================== */

$unpaidQuery = "
SELECT COUNT(*) AS unpaid_members
FROM members
WHERE member_id NOT IN
(
    SELECT member_id
    FROM monthly_payments
    WHERE MONTH(payment_date)=MONTH(CURDATE())
    AND YEAR(payment_date)=YEAR(CURDATE())
)
";

$unpaidResult = mysqli_query($conn,$unpaidQuery);
$unpaidData = mysqli_fetch_assoc($unpaidResult);

$unpaidMembers =
($unpaidData['unpaid_members'] ?? 0);
/* ===========================
    Salary Paid This Month
=========================== */

$currentMonth = date('F');
$currentYear  = date('Y');

$salaryPaidQuery = "

SELECT
SUM(amount) AS imam_salary

FROM imam_salary

WHERE salary_month = '$currentMonth'

AND salary_year = '$currentYear'

AND payment_status = 'Paid'

";

$ImamSalaryResult = mysqli_query($conn,$salaryPaidQuery);
$imamData = mysqli_fetch_assoc($ImamSalaryResult);

if(!$ImamSalaryResult)
{
    die(mysqli_error($conn));
}

$imamPaidSalaryData =
($imamData['imam_salary'] ?? 0);

/* ===========================
   THIS MONTH COLLECTION
=========================== */

$thisMonthQuery = "
SELECT SUM(amount) AS this_month_collection
FROM monthly_payments
WHERE MONTH(payment_date)=MONTH(CURDATE())
AND YEAR(payment_date)=YEAR(CURDATE())
";

$thisMonthResult =
mysqli_query($conn,$thisMonthQuery);

$thisMonthData =
mysqli_fetch_assoc($thisMonthResult);

$thisMonthCollection =
($thisMonthData['this_month_collection'] ?? 0);

?>

<div class="main-content">

    <h2 class="mb-4">
        Dashboard
    </h2>

    <!-- ROW 1 -->

    <div class="row">

        <div class="col-md-4 mb-4">

            <div class="card-box bg-success">

                <h5>Total Members</h5>

                <h2>
                    <?php echo $memberData['total_members']; ?>
                </h2>

            </div>

        </div>

        <div class="col-md-4 mb-4">

            <div class="card-box bg-info">

                <h5>Salary Fund</h5>

                <h2>

                    Rs.
                    <?php echo number_format($salaryFund); ?>

                </h2>

            </div>

        </div>

        <div class="col-md-4 mb-4">

            <div class="card-box bg-secondary">

                <h5>General Fund</h5>

                <h2>

                    Rs.
                    <?php echo number_format($generalFund); ?>

                </h2>

            </div>

        </div>

    </div>

    <!-- ROW 2 -->

    <div class="row">

        <div class="col-md-4 mb-4">

            <div class="card-box bg-primary">

                <h5>Monthly Collection</h5>

                <h2>

                    Rs.
                    <?php echo number_format($monthlyCollection); ?>

                </h2>

            </div>

        </div>

        <div class="col-md-4 mb-4">

            <div class="card-box bg-warning">

                <h5>Friday Chanda</h5>

                <h2>

                    Rs.
                    <?php echo number_format($fridayChanda); ?>

                </h2>

            </div>

        </div>

        <div class="col-md-4 mb-4">

            <div class="card-box bg-danger">

                <h5>Total Expenses</h5>

                <h2>

                    Rs.
                    <?php echo number_format($totalExpenses); ?>

                </h2>

            </div>

        </div>

    </div>

    <!-- ROW 3 -->

<div class="row">

    <div class="col-md-4 mb-4">

        <div class="card-box bg-info">

            <h5>Total Donations</h5>

            <h2>

                Rs.
                <?php echo number_format($totalDonation); ?>

            </h2>

        </div>

    </div>

    <div class="col-md-4 mb-4">

        <div class="card-box bg-danger">

            <h5>Unpaid Members</h5>

            <h2>

                <?php echo $unpaidMembers; ?>

            </h2>

        </div>

    </div>

    <div class="col-md-4 mb-4">

        <div class="card-box bg-success">

            <h5>This Month Collection</h5>

            <h2>

                Rs.
                <?php echo number_format($thisMonthCollection); ?>

            </h2>

        </div>

    </div>

</div>
    <!-- salary paid this month -->

    <div class="row">

        <div class="col-md-12 mb-4">

            <div class="card-box bg-primary">

                <h4>
                    👳 Salary Paid This Month
                </h4>

                <h1>

                    Rs.
                    <?php echo number_format($imamPaidSalaryData); ?>

                </h1>

            </div>

        </div>

    </div>
    <!-- TOTAL MOSQUE FUND -->

    <div class="row">

        <div class="col-md-12 mb-4">

            <div class="card-box bg-dark">

                <h4>
                    Total Mosque Fund
                </h4>

                <h1>

                    Rs.
                    <?php echo number_format($totalMosqueFund); ?>

                </h1>

            </div>

        </div>

    </div>

    <!-- CHARTS -->

    <div class="row">

        <div class="col-md-6">

            <div class="card p-3">

                <h5>
                    Income vs Expenses
                </h5>

                <canvas
                    id="incomeChart"
                    height="120">
                </canvas>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card p-3">

                <h5>
                    Expense Breakdown
                </h5>

                <canvas
                    id="expenseChart"
                    height="120">
                </canvas>

            </div>

        </div>

    </div>

    <!-- RECENT PAYMENTS -->

    <?php

    $recentPayments = "

    SELECT

    members.member_name,
    monthly_payments.amount,
    monthly_payments.payment_date

    FROM monthly_payments

    INNER JOIN members

    ON monthly_payments.member_id =
    members.member_id

    ORDER BY payment_id DESC

    LIMIT 5

    ";

    $recentResult =
    mysqli_query($conn, $recentPayments);

    ?>

    <div class="card mt-4 p-3">

        <h5>
            Recent Payments
        </h5>

        <table class="table table-bordered">

            <thead>

                <tr>

                    <th>Name</th>
                    <th>Amount</th>
                    <th>Date</th>

                </tr>

            </thead>

            <tbody>

                <?php while($row = mysqli_fetch_assoc($recentResult)) { ?>

                <tr>

                    <td>
                        <?php echo $row['member_name']; ?>
                    </td>

                    <td>
                        Rs. <?php echo number_format($row['amount']); ?>
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

<!-- CHART JS -->

<script>

const incomeChart =
document.getElementById('incomeChart');

new Chart(incomeChart, {

    type: 'bar',

    data: {

        labels: [

                'Monthly Collection',
                'Friday Chanda',
                'Donations',
                'Expenses'

                ],

        datasets: [{

            label: 'Mosque Finance',

            data: [

                <?php echo $monthlyCollection; ?>,
                <?php echo $fridayChanda; ?>,
                <?php echo $totalDonation; ?>,
                <?php echo $totalExpenses; ?>

             ]

        }]

    },

    options: {

        responsive: true,

        maintainAspectRatio: false

    }

});

</script>

<script>

const expenseChart =
document.getElementById('expenseChart');

new Chart(expenseChart, {

    type: 'pie',

    data: {

        labels: [

            'Total Expenses'

        ],

        datasets: [{

            data: [

                <?php echo $totalExpenses; ?>

            ]

        }]

    },

    options: {

        responsive: true,

        maintainAspectRatio: false

    }

});

</script>

<?php include('includes/footer.php'); ?>