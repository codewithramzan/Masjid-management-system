<?php 

include('config/session.php');
include('config/database.php');

include('includes/header.php');
include('includes/sidebar.php');
?>

<div class="main-content">

    <h2 class="mb-4">
        Dashboard
    </h2>

    <div class="row">
    <?php

        $memberQuery = "SELECT COUNT(*) AS total_members FROM members";
        $memberResult = mysqli_query($conn, $memberQuery);
        $memberData = mysqli_fetch_assoc($memberResult);

    ?>
<div class="col-md-3 mb-4">

    <div class="card-box bg-success">

        <h5>Total Members</h5>

        <h2>
            <?php echo $memberData['total_members']; ?>
        </h2>

    </div>

</div>
    <?php

    $collectionQuery = "
    SELECT SUM(amount) AS total_collection
    FROM monthly_payments
    ";

    $collectionResult = mysqli_query($conn, $collectionQuery);

    $collectionData = mysqli_fetch_assoc($collectionResult);

   ?>
<div class="col-md-3 mb-4">

    <div class="card-box bg-primary">

        <h5>Monthly Collection</h5>

        <h2>

            Rs.
            <?php
            echo $collectionData['total_collection'] ?? 0;
            ?>

        </h2>

    </div>

</div>
    <?php

    $fridayQuery = "
    SELECT SUM(amount) AS friday_total
    FROM friday_collections
    ";

    $fridayResult = mysqli_query($conn, $fridayQuery);

    $fridayData = mysqli_fetch_assoc($fridayResult);

    ?>
<div class="col-md-3 mb-4">

    <div class="card-box bg-warning">

        <h5>Friday Chanda</h5>

        <h2>

            Rs.
            <?php
            echo $fridayData['friday_total'] ?? 0;
            ?>

        </h2>

    </div>

</div>
    <?php

    $expenseQuery = "
    SELECT SUM(amount) AS total_expense
    FROM expenses
    ";

    $expenseResult = mysqli_query($conn, $expenseQuery);

    $expenseData = mysqli_fetch_assoc($expenseResult);

    ?>
<div class="col-md-3 mb-4">

    <div class="card-box bg-danger">

        <h5>Total Expenses</h5>

        <h2>

            Rs.
            <?php
            echo $expenseData['total_expense'] ?? 0;
            ?>

        </h2>

    </div>

</div>
</div>
    <?php

    $totalIncome =
    ($collectionData['total_collection'] ?? 0)
    +
    ($fridayData['friday_total'] ?? 0);

    $totalExpense =
    ($expenseData['total_expense'] ?? 0);

    $remainingFund =
    $totalIncome - $totalExpense;

    ?>
<div class="row">

<div class="col-md-12 mb-4">

    <div class="card-box bg-dark">

        <h4>
            Total Mosque Fund
        </h4>

        <h1>

            Rs.
            <?php echo number_format($remainingFund); ?>

        </h1>

    </div>

</div>

</div>
<div class="row">

    <div class="col-md-6">

        <div class="card p-3">

            <h5>
                Income vs Expenses
            </h5>

            <canvas id="incomeChart"></canvas>

        </div>

    </div>

    <div class="col-md-6">

        <div class="card p-3">

            <h5>
                Expense Breakdown
            </h5>

            <canvas id="expenseChart"></canvas>

        </div>

    </div>

</div>
<script>

const incomeChart =
document.getElementById('incomeChart');

new Chart(incomeChart, {

    type: 'bar',

    data: {

        labels: [

            'Monthly Collection',
            'Friday Chanda',
            'Expenses'

        ],

        datasets: [{

            label: 'Mosque Finance',

            data: [

                <?php echo $collectionData['total_collection'] ?? 0; ?>,

                <?php echo $fridayData['friday_total'] ?? 0; ?>,

                <?php echo $expenseData['total_expense'] ?? 0; ?>

            ]

        }]
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

            'Electricity',
            'Construction',
            'Maintenance'

        ],

        datasets: [{

            data: [

                15000,
                40000,
                10000

            ]

        }]
    }
});

</script>
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
Rs. <?php echo $row['amount']; ?>
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
<?php

include('includes/footer.php');

?>