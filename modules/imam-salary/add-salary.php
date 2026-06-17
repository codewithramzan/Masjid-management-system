<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');

if(isset($_POST['save_salary']))
{
    $imam_name = mysqli_real_escape_string($conn,$_POST['imam_name']);
    $amount = $_POST['amount'];
    $salary_month = $_POST['salary_month'];
    $salary_year = $_POST['salary_year'];
    $payment_status = $_POST['payment_status'];
    $payment_date = $_POST['payment_date'];

    $added_by = $_SESSION['user_id'] ?? 1;

    $insertQuery = "
    INSERT INTO imam_salary
    (
        imam_name,
        amount,
        salary_month,
        salary_year,
        payment_status,
        payment_date,
        added_by
    )
    VALUES
    (
        '$imam_name',
        '$amount',
        '$salary_month',
        '$salary_year',
        '$payment_status',
        '$payment_date',
        '$added_by'
    )
    ";

    if(mysqli_query($conn,$insertQuery))
    {
        echo "
        <script>
        alert('Salary Added Successfully');
        window.location='manage-salary.php';
        </script>
        ";
    }
}

?>

<div class="main-content">

<div class="container-fluid">

<div class="card shadow">

<div class="card-header bg-success text-white">

<h4>👳 Add Imam Salary</h4>

</div>

<div class="card-body">

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label>Imam Name</label>

<input
type="text"
name="imam_name"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Amount</label>

<input
type="number"
name="amount"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Salary Month</label>

<select
name="salary_month"
class="form-control"
required>

<option value="">Select Month</option>

<?php
$months = [
"January","February","March",
"April","May","June",
"July","August","September",
"October","November","December"
];

foreach($months as $month)
{
    echo "<option>$month</option>";
}
?>

</select>

</div>

<div class="col-md-6 mb-3">

<label>Salary Year</label>

<input
type="number"
name="salary_year"
class="form-control"
value="<?php echo date('Y'); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label>Payment Status</label>

<select
name="payment_status"
class="form-control">

<option value="Paid">Paid</option>
<option value="Pending">Pending</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label>Payment Date</label>

<input
type="date"
name="payment_date"
class="form-control"
value="<?php echo date('Y-m-d'); ?>">

</div>

</div>

<button
type="submit"
name="save_salary"
class="btn btn-success">

Save Salary

</button>

</form>

</div>

</div>

</div>

</div>

<?php include('../../includes/footer.php'); ?>