<?php

include('config/session.php');
include('config/database.php');

include('includes/header.php');
include('includes/sidebar.php');

/* ==========================
   TOTAL MEMBERS
========================== */

$totalMembers =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT COUNT(*) total FROM members"
)
)['total'] ?? 0;

/* ==========================
   MONTHLY COLLECTION
========================== */

$monthlyCollection =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT SUM(amount) total FROM monthly_payments"
)
)['total'] ?? 0;

/* ==========================
   THIS MONTH COLLECTION
========================== */

$thisMonthCollection =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"
SELECT SUM(amount) total

FROM monthly_payments

WHERE MONTH(payment_date)=MONTH(CURDATE())

AND YEAR(payment_date)=YEAR(CURDATE())
"
)
)['total'] ?? 0;

/* ==========================
   TODAY COLLECTION
========================== */

$todayCollection =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"
SELECT SUM(amount) total

FROM monthly_payments

WHERE DATE(payment_date)=CURDATE()
"
)
)['total'] ?? 0;

/* ==========================
   FRIDAY CHANDA
========================== */

$fridayChanda =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"
SELECT SUM(amount) total

FROM friday_collections
"
)
)['total'] ?? 0;

/* ==========================
   TODAY FRIDAY CHANDA
========================== */

$todayFriday =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"
SELECT SUM(amount) total

FROM friday_collections

WHERE DATE(collection_date)=CURDATE()
"
)
)['total'] ?? 0;

/* ==========================
   DONATIONS
========================== */

$totalDonation =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"
SELECT SUM(amount) total

FROM donations
"
)
)['total'] ?? 0;

/* ==========================
   TODAY DONATION
========================== */

$todayDonation =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"
SELECT SUM(amount) total

FROM donations

WHERE DATE(donation_date)=CURDATE()
"
)
)['total'] ?? 0;

/* ==========================
   EXPENSES
========================== */

$totalExpenses =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"
SELECT SUM(amount) total

FROM expenses
"
)
)['total'] ?? 0;

/* ==========================
   UNPAID MEMBERS
========================== */

$unpaidMembers =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"
SELECT COUNT(*) total

FROM members

WHERE member_id NOT IN
(
SELECT member_id
FROM monthly_payments

WHERE MONTH(payment_date)=MONTH(CURDATE())

AND YEAR(payment_date)=YEAR(CURDATE())
)
"
)
)['total'] ?? 0;

/* ==========================
   IMAM PAID SALARY
========================== */

$currentMonth = date('F');
$currentYear = date('Y');

$imamPaidSalary =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"
SELECT SUM(amount) total

FROM imam_salary

WHERE salary_month='$currentMonth'

AND salary_year='$currentYear'

AND payment_status='Paid'
"
)
)['total'] ?? 0;

/* ==========================
   PENDING SALARY
========================== */

$pendingSalary =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"
SELECT SUM(amount) total

FROM imam_salary

WHERE payment_status='Pending'
"
)
)['total'] ?? 0;

/* ==========================
   TOTAL DONORS
========================== */

$totalDonors =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"
SELECT COUNT(*) total

FROM donations
"
)
)['total'] ?? 0;

/* ==========================
   TOP DONOR
========================== */

$topDonorQuery = mysqli_query(
$conn,
"
SELECT donor_name,
SUM(amount) total

FROM donations

GROUP BY donor_name

ORDER BY total DESC

LIMIT 1
"
);

$topDonorData =
mysqli_fetch_assoc($topDonorQuery);

$topDonor =
$topDonorData['donor_name'] ?? 'N/A';

/* ==========================
   FUNDS
========================== */

$salaryFund =
$monthlyCollection;

$generalFund =
$fridayChanda
+
$totalDonation
-
$totalExpenses;

$totalMosqueFund =
$salaryFund
+
$generalFund;

/* ==========================
   COLLECTION EFFICIENCY
========================== */

$paidMembers =
$totalMembers
-
$unpaidMembers;

$collectionEfficiency =
($totalMembers > 0)
?
round(($paidMembers/$totalMembers)*100)
:
0;
?>
<div class="main-content">

<h2 class="mb-4">
📊 Masjid Dashboard
</h2>

<div class="row">

<div class="col-md-3 mb-3">
<div class="card-box bg-success">
<h6>Total Members</h6>
<h2><?php echo $totalMembers; ?></h2>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card-box bg-primary">
<h6>Monthly Collection</h6>
<h2>Rs. <?php echo number_format($monthlyCollection); ?></h2>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card-box bg-warning">
<h6>Friday Chanda</h6>
<h2>Rs. <?php echo number_format($fridayChanda); ?></h2>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card-box bg-info">
<h6>Total Donations</h6>
<h2>Rs. <?php echo number_format($totalDonation); ?></h2>
</div>
</div>

</div>

<div class="row">

<div class="col-md-3 mb-3">
<div class="card-box bg-secondary">
<h6>Salary Fund</h6>
<h2>Rs. <?php echo number_format($salaryFund); ?></h2>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card-box bg-dark">
<h6>General Fund</h6>
<h2>Rs. <?php echo number_format($generalFund); ?></h2>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card-box bg-danger">
<h6>Total Expenses</h6>
<h2>Rs. <?php echo number_format($totalExpenses); ?></h2>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card-box bg-success">
<h6>Total Mosque Fund</h6>
<h2>Rs. <?php echo number_format($totalMosqueFund); ?></h2>
</div>
</div>

</div>

<div class="row">

<div class="col-md-3 mb-3">
<div class="card-box bg-danger">
<h6>Unpaid Members</h6>
<h2><?php echo $unpaidMembers; ?></h2>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card-box bg-primary">
<h6>This Month Collection</h6>
<h2>Rs. <?php echo number_format($thisMonthCollection); ?></h2>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card-box bg-info">
<h6>Today's Collection</h6>
<h2>Rs. <?php echo number_format($todayCollection); ?></h2>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card-box bg-warning">
<h6>Today's Donation</h6>
<h2>Rs. <?php echo number_format($todayDonation); ?></h2>
</div>
</div>

</div>

<div class="row">

<div class="col-md-3 mb-3">
<div class="card-box bg-primary">
<h6>Today's Friday Chanda</h6>
<h2>Rs. <?php echo number_format($todayFriday); ?></h2>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card-box bg-success">
<h6>Salary Paid</h6>
<h2>Rs. <?php echo number_format($imamPaidSalary); ?></h2>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card-box bg-danger">
<h6>Pending Salary</h6>
<h2>Rs. <?php echo number_format($pendingSalary); ?></h2>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card-box bg-secondary">
<h6>Total Donors</h6>
<h2><?php echo $totalDonors; ?></h2>
</div>
</div>

</div>

<div class="row">

<div class="col-md-6 mb-4">

<div class="card p-4">

<h5>🏆 Top Donor</h5>

<h3>
<?php echo $topDonor; ?>
</h3>

</div>

</div>

<div class="col-md-6 mb-4">

<div class="card p-4">

<h5>Collection Efficiency</h5>

<div class="progress" style="height:30px;">

<div
class="progress-bar bg-success"
style="width:<?php echo $collectionEfficiency; ?>%;">

<?php echo $collectionEfficiency; ?>%

</div>

</div>

</div>

</div>

</div>

<?php

$totalIncome =
$monthlyCollection +
$fridayChanda +
$totalDonation;

$healthPercent = 0;

if($totalIncome > 0)
{
    $healthPercent =
    (($totalIncome - $totalExpenses)
    /
    $totalIncome)
    * 100;
}

$healthPercent =
max(0,min(100,$healthPercent));

?>
<div class="card shadow-sm mb-4">

    <div class="card-body">

        <h5>

            Financial Health

        </h5>

        <div class="progress">

            <div
            class="progress-bar bg-success"

            style="
            width:
            <?php echo $healthPercent; ?>%;
            ">

            <?php

            echo round(
            $healthPercent
            );
            ?>%

            </div>

        </div>

    </div>

</div>
<!-- ==========================
     CHARTS SECTION
========================== -->
<!-- monthly trend query chart -->
<?php

$trendQuery = mysqli_query($conn, "

SELECT

MONTH(payment_date) AS month_no,

SUM(amount) AS total

FROM monthly_payments

GROUP BY MONTH(payment_date)

ORDER BY MONTH(payment_date)

");

$monthLabels = [];
$monthAmounts = [];

while($row = mysqli_fetch_assoc($trendQuery))
{
    $monthLabels[] = date("M", mktime(0,0,0,$row['month_no'],1));
    $monthAmounts[] = $row['total'];
}

?>
<!-- expense category query -->
<?php

$expenseCategoryQuery = mysqli_query($conn, "

SELECT

expense_categories.category_name,

SUM(expenses.amount) AS total

FROM expenses

INNER JOIN expense_categories

ON expenses.category_id =
expense_categories.category_id

GROUP BY expenses.category_id

");

$expenseLabels = [];
$expenseAmounts = [];

while($row = mysqli_fetch_assoc($expenseCategoryQuery))
{
    $expenseLabels[] =
    $row['category_name'];

    $expenseAmounts[] =
    $row['total'];
}

?>

<div class="row">

    <div class="col-lg-6 mb-4">

        <div class="card shadow-sm">

            <div class="card-header">

                <h5 class="mb-0">
                    Income vs Expenses
                </h5>

            </div>

            <div class="card-body">

                <canvas id="incomeExpenseChart"></canvas>

            </div>

        </div>

    </div>

    <div class="col-lg-6 mb-4">

        <div class="card shadow-sm">

            <div class="card-header">

                <h5 class="mb-0">
                    Fund Sources
                </h5>

            </div>

            <div class="card-body">

                <canvas id="fundSourceChart"></canvas>

            </div>

        </div>

    </div>

</div>

<div class="row">

    <div class="col-lg-6 mb-4">

        <div class="card shadow-sm">

            <div class="card-header">

                <h5 class="mb-0">
                    Monthly Collection Trend
                </h5>

            </div>

            <div class="card-body">

                <canvas id="monthlyTrendChart"></canvas>

            </div>

        </div>

    </div>

    <div class="col-lg-6 mb-4">

        <div class="card shadow-sm">

            <div class="card-header">

                <h5 class="mb-0">
                    Expense Categories
                </h5>

            </div>

            <div class="card-body">

                <canvas id="expenseCategoryChart"></canvas>

            </div>

        </div>

    </div>

</div>
<!-- Chart 1 - Income vs Expense -->
 <script>

new Chart(
document.getElementById('incomeExpenseChart'),
{
    type:'bar',

    data:
    {
        labels:
        [
            'Monthly Collection',
            'Friday Chanda',
            'Donations',
            'Expenses'
        ],

        datasets:
        [{
            label:'Amount',

            data:
            [
                <?php echo $monthlyCollection; ?>,
                <?php echo $fridayChanda; ?>,
                <?php echo $totalDonation; ?>,
                <?php echo $totalExpenses; ?>
            ]
        }]
    }
});

</script>
<!-- Chart 2 - Fund Sources -->
 <script>

new Chart(
document.getElementById('fundSourceChart'),
{
    type:'doughnut',

    data:
    {
        labels:
        [
            'Monthly Collection',
            'Friday Chanda',
            'Donations'
        ],

        datasets:
        [{
            data:
            [
                <?php echo $monthlyCollection; ?>,
                <?php echo $fridayChanda; ?>,
                <?php echo $totalDonation; ?>
            ]
        }]
    }
});

</script>
<!-- Chart 3 - Monthly Trend -->
 <script>

new Chart(
document.getElementById('monthlyTrendChart'),
{
    type:'line',

    data:
    {
        labels:
        <?php echo json_encode($monthLabels); ?>,

        datasets:
        [{
            label:'Monthly Collection',

            data:
            <?php echo json_encode($monthAmounts); ?>,

            tension:0.4,

            fill:false
        }]
    }
});

</script>
<!-- Chart 4 - Expense Categories -->
 <script>

new Chart(
document.getElementById('expenseCategoryChart'),
{
    type:'pie',

    data:
    {
        labels:
        <?php echo json_encode($expenseLabels); ?>,

        datasets:
        [{
            data:
            <?php echo json_encode($expenseAmounts); ?>
        }]
    }
});

</script>
<!-- 1. Recent Payments Query -->
 <?php

$recentPaymentsQuery = mysqli_query($conn, "

SELECT

m.member_name,
mp.amount,
mp.payment_date

FROM monthly_payments mp

INNER JOIN members m

ON mp.member_id = m.member_id

ORDER BY mp.payment_id DESC

LIMIT 5

");

?>
<!-- 2. Recent Donations Query -->
 <?php

$recentDonationsQuery = mysqli_query($conn, "

SELECT

donor_name,
amount,
donation_date

FROM donations

ORDER BY donation_id DESC

LIMIT 5

");

?>
<!-- 3. Recent Friday Chanda Query -->
 <?php

$recentFridayQuery = mysqli_query($conn, "

SELECT

amount,
collection_date

FROM friday_collections

ORDER BY friday_id DESC

LIMIT 5

");

?>
<!-- 4. Recent Salary Query -->
 <?php

$recentSalaryQuery = mysqli_query($conn, "

SELECT

imam_name,
amount,
payment_date

FROM imam_salary

WHERE payment_status='Paid'

ORDER BY salary_id DESC

LIMIT 5

");

?>
<!-- 5. Dashboard Tables Section -->
 <!-- ==========================
     RECENT ACTIVITIES
========================== -->

<div class="row mt-4">

    <!-- Recent Payments -->

    <div class="col-lg-6 mb-4">

        <div class="card shadow-sm">

            <div class="card-header bg-primary text-white">

                Recent Payments

            </div>

            <div class="card-body">

                <table class="table table-sm table-bordered">

                    <thead>

                        <tr>

                            <th>Member</th>
                            <th>Amount</th>
                            <th>Date</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php while($row = mysqli_fetch_assoc($recentPaymentsQuery)){ ?>

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

    </div>

    <!-- Recent Donations -->

    <div class="col-lg-6 mb-4">

        <div class="card shadow-sm">

            <div class="card-header bg-success text-white">

                Recent Donations

            </div>

            <div class="card-body">

                <table class="table table-sm table-bordered">

                    <thead>

                        <tr>

                            <th>Donor</th>
                            <th>Amount</th>
                            <th>Date</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php while($row = mysqli_fetch_assoc($recentDonationsQuery)){ ?>

                        <tr>

                            <td>
                                <?php echo $row['donor_name']; ?>
                            </td>

                            <td>
                                Rs. <?php echo number_format($row['amount']); ?>
                            </td>

                            <td>
                                <?php echo $row['donation_date']; ?>
                            </td>

                        </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>
<?php include("includes/footer.php"); ?>