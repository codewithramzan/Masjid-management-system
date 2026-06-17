<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');

$message = "";

if(isset($_POST['add_donation']))
{
    $donor_name = $_POST['donor_name'];
    $amount = $_POST['amount'];
    $donation_type = $_POST['donation_type'];
    $notes = $_POST['notes'];
    $donation_date = $_POST['donation_date'];

    $created_by = $_SESSION['user_id'];

    $query = "

    INSERT INTO donations
    (
        donor_name,
        amount,
        donation_type,
        notes,
        donation_date,
        created_by
    )

    VALUES
    (
        '$donor_name',
        '$amount',
        '$donation_type',
        '$notes',
        '$donation_date',
        '$created_by'
    )

    ";

    if(mysqli_query($conn,$query))
    {
        $last_id = mysqli_insert_id($conn);

        if($donation_type == "Construction")
        {
            $fund_type = "Construction Fund";
            $transaction_type = "Construction Donation";
        }
        else
        {
            $fund_type = "General Fund";
            $transaction_type = $donation_type;
        }

        mysqli_query($conn,"

        INSERT INTO fund_transactions
        (
            transaction_type,
            fund_type,
            amount,
            transaction_date,
            reference_id,
            reference_table,
            notes,
            created_by
        )

        VALUES
        (
            '$transaction_type',
            '$fund_type',
            '$amount',
            '$donation_date',
            '$last_id',
            'donations',
            '$notes',
            '$created_by'
        )

        ");

        $message = "Donation Added Successfully";
    }
}
?>

<div class="main-content">

<div class="card p-4">

<h3>Add Donation</h3>

<?php if($message!=""){ ?>

<div class="alert alert-success">

<?php echo $message; ?>

</div>

<?php } ?>

<form method="POST">

<div class="mb-3">

<label>Donor Name</label>

<input type="text"
       name="donor_name"
       class="form-control">

</div>

<div class="mb-3">

<label>Amount</label>

<input type="number"
       step="0.01"
       name="amount"
       class="form-control"
       required>

</div>

<div class="mb-3">

<label>Donation Type</label>

<select name="donation_type"
        class="form-control">

<option value="General">General</option>
<option value="Sadqa">Sadqa</option>
<option value="Zakat">Zakat</option>
<option value="Construction">Construction</option>

</select>

</div>

<div class="mb-3">

<label>Date</label>

<input type="date"
       name="donation_date"
       value="<?php echo date('Y-m-d'); ?>"
       class="form-control">

</div>

<div class="mb-3">

<label>Notes</label>

<textarea name="notes"
          class="form-control"></textarea>

</div>

<button type="submit"
        name="add_donation"
        class="btn btn-success">

Save Donation

</button>

</form>

</div>

</div>

<?php include('../../includes/footer.php'); ?>