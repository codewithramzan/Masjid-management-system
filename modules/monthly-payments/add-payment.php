<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');

$message = "";

$membersQuery =
"SELECT * FROM members WHERE status='Active'";

$membersResult =
mysqli_query($conn, $membersQuery);
?>
<?php

if(isset($_POST['add_payment']))
{
    $member_id = $_POST['member_id'];

    $amount = $_POST['amount'];

    $payment_month = $_POST['payment_month'];

    $payment_year = $_POST['payment_year'];

    $payment_date = $_POST['payment_date'];

    $received_by = $_SESSION['user_id'];

    $memberQuery = "
    SELECT *
    FROM members
    WHERE member_id='$member_id'
    ";

    $memberResult =
    mysqli_query($conn, $memberQuery);

    $memberData =
    mysqli_fetch_assoc($memberResult);

    $requiredAmount =
    $memberData['monthly_amount'];

    if($amount >= $requiredAmount)
    {
        $status = "Paid";
    }
    elseif($amount > 0)
    {
        $status = "Partial";
    }
    else
    {
        $status = "Unpaid";
    }

    $insertQuery = "
    INSERT INTO monthly_payments
    (
        member_id,
        amount,
        payment_month,
        payment_year,
        payment_status,
        payment_date,
        received_by
    )

    VALUES
    (
        '$member_id',
        '$amount',
        '$payment_month',
        '$payment_year',
        '$status',
        '$payment_date',
        '$received_by'
    )
    ";

    $insertResult =
    mysqli_query($conn, $insertQuery);

    if($insertResult)
    {
        $last_id = mysqli_insert_id($conn);

        $fundQuery = "
        INSERT INTO fund_transactions
        (
            transaction_type,
            fund_type,
            amount,
            transaction_date,
            reference_id,
            reference_table,
            created_by
        )

        VALUES
        (
            'Monthly Payment',
            'Salary Fund',
            '$amount',
            '$payment_date',
            '$last_id',
            'monthly_payments',
            '$received_by'
        )
        ";

        mysqli_query($conn, $fundQuery);

        $message =
        "Payment Added Successfully";
    }
}

?>
<div class="main-content">

<div class="card p-4">

<h3 class="mb-4">

Add Monthly Payment

</h3>

<?php if($message != "") { ?>

<div class="alert alert-success">

<?php echo $message; ?>

</div>

<?php } ?>

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label>

Select Member

</label>

<select name="member_id"
        class="form-control"
        required>

<option value="">
Choose Member
</option>

<?php while($member =
mysqli_fetch_assoc($membersResult)) { ?>

<option value="<?php echo $member['member_id']; ?>">

<?php echo $member['member_name']; ?>

</option>

<?php } ?>

</select>

</div>

<div class="col-md-6 mb-3">

<label>

Amount

</label>

<input type="number"
       name="amount"
       class="form-control"
       required>

</div>

</div>
<div class="row">

<div class="col-md-4 mb-3">

<label>

Month

</label>

<select name="payment_month"
        class="form-control">

<option>January</option>
<option>February</option>
<option>March</option>
<option>April</option>
<option>May</option>
<option>June</option>
<option>July</option>
<option>August</option>
<option>September</option>
<option>October</option>
<option>November</option>
<option>December</option>

</select>

</div>

<div class="col-md-4 mb-3">

<label>

Year

</label>

<input type="number"
       name="payment_year"
       value="<?php echo date('Y'); ?>"
       class="form-control">

</div>

<div class="col-md-4 mb-3">

<label>

Payment Date

</label>

<input type="date"
       name="payment_date"
       value="<?php echo date('Y-m-d'); ?>"
       class="form-control">

</div>

</div>
<button type="submit"
        name="add_payment"
        class="btn btn-success">

Add Payment

</button>

</form>

</div>

</div>
<?php

include('../../includes/footer.php');

?>