<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');

$id = $_GET['id'];

$query = "
SELECT *
FROM imam_salary
WHERE salary_id='$id'
";

$result = mysqli_query($conn,$query);


$row = mysqli_fetch_assoc($result);
if(!$row){
    die("salary  record not found.");
}
if(isset($_POST['update_salary']))
{
    $imam_name = $_POST['imam_name'];
    $amount = $_POST['amount'];
    $salary_month = $_POST['salary_month'];
    $salary_year = $_POST['salary_year'];
    $payment_status = $_POST['payment_status'];
    $payment_date = $_POST['payment_date'];

    $updateQuery = "

    UPDATE imam_salary

    SET

    imam_name='$imam_name',
    amount='$amount',
    salary_month='$salary_month',
    salary_year='$salary_year',
    payment_status='$payment_status',
    payment_date='$payment_date'

    WHERE salary_id='$id'

    ";

    mysqli_query($conn,$updateQuery);

    echo "
    <script>
    alert('Salary Updated Successfully');
    window.location='manage-salary.php';
    </script>
    ";
}

?>

<div class="main-content">

<div class="container">

<div class="card">

<div class="card-header bg-warning">

<h4>Edit Salary</h4>

</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">

<label>Imam Name</label>

<input
type="text"
name="imam_name"
class="form-control"
value="<?php echo $row['imam_name']; ?>"
required>

</div>

<div class="mb-3">

<label>Amount</label>

<input
type="number"
name="amount"
class="form-control"
value="<?php echo $row['amount']; ?>"
required>

</div>

<div class="mb-3">

<label>Month</label>

<input
type="text"
name="salary_month"
class="form-control"
value="<?php echo $row['salary_month']; ?>"
required>

</div>

<div class="mb-3">

<label>Year</label>

<input
type="number"
name="salary_year"
class="form-control"
value="<?php echo $row['salary_year']; ?>"
required>

</div>

<div class="mb-3">

<label>Status</label>

<select
name="payment_status"
class="form-control">

<option value="Paid"
<?php if($row['payment_status']=="Paid") echo "selected"; ?>>
Paid
</option>

<option value="Pending"
<?php if($row['payment_status']=="Pending") echo "selected"; ?>>
Pending
</option>

</select>

</div>

<div class="mb-3">

<label>Payment Date</label>

<input
type="date"
name="payment_date"
class="form-control"
value="<?php echo $row['payment_date']; ?>">

</div>

<button
type="submit"
name="update_salary"
class="btn btn-warning">

Update Salary

</button>

</form>

</div>

</div>

</div>

</div>

<?php include('../../includes/footer.php'); ?>