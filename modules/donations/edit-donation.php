<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');

$message = "";

/* ===========================
   GET DONATION ID
=========================== */

if(!isset($_GET['id']))
{
    header("Location: manage-donations.php");
    exit;
}

$id = $_GET['id'];

/* ===========================
   FETCH DONATION DATA
=========================== */

$query = "
SELECT *
FROM donations
WHERE donation_id='$id'
";

$result = mysqli_query($conn, $query);

$data = mysqli_fetch_assoc($result);

if(!$data)
{
    echo "<div class='alert alert-danger'>Donation Not Found</div>";
    exit;
}

/* ===========================
   UPDATE DONATION
=========================== */

if(isset($_POST['update_donation']))
{
    $donor_name =
    mysqli_real_escape_string(
    $conn,
    $_POST['donor_name']
    );

    $amount =
    $_POST['amount'];

    $donation_type =
    $_POST['donation_type'];

    $notes =
    mysqli_real_escape_string(
    $conn,
    $_POST['notes']
    );

    $donation_date =
    $_POST['donation_date'];

    /* Update Donation */

    $updateDonation = "

    UPDATE donations

    SET

    donor_name='$donor_name',
    amount='$amount',
    donation_type='$donation_type',
    notes='$notes',
    donation_date='$donation_date'

    WHERE donation_id='$id'

    ";

    if(mysqli_query($conn,$updateDonation))
    {

        /* Fund Logic */

        if($donation_type == "Construction")
        {
            $fund_type =
            "Construction Fund";

            $transaction_type =
            "Construction Donation";
        }
        else
        {
            $fund_type =
            "General Fund";

            $transaction_type =
            $donation_type;
        }

        /* Update Fund Transaction */

        $updateFund = "

        UPDATE fund_transactions

        SET

        transaction_type='$transaction_type',
        fund_type='$fund_type',
        amount='$amount',
        transaction_date='$donation_date',
        notes='$notes'

        WHERE

        reference_id='$id'

        AND

        reference_table='donations'

        ";

        mysqli_query($conn,$updateFund);

        $message =
        "Donation Updated Successfully";

        /* Reload Data */

        $query = "
        SELECT *
        FROM donations
        WHERE donation_id='$id'
        ";

        $result =
        mysqli_query($conn,$query);

        $data =
        mysqli_fetch_assoc($result);
    }
}

?>

<div class="main-content">

<div class="card p-4">

<h3 class="mb-4">

Edit Donation

</h3>

<?php if($message!=""){ ?>

<div class="alert alert-success">

<?php echo $message; ?>

</div>

<?php } ?>

<form method="POST">

<div class="mb-3">

<label>

Donor Name

</label>

<input type="text"
       name="donor_name"
       class="form-control"
       value="<?php echo $data['donor_name']; ?>">

</div>

<div class="mb-3">

<label>

Amount

</label>

<input type="number"
       step="0.01"
       name="amount"
       class="form-control"
       value="<?php echo $data['amount']; ?>"
       required>

</div>

<div class="mb-3">

<label>

Donation Type

</label>

<select name="donation_type"
        class="form-control">

<option value="General"
<?php if($data['donation_type']=="General") echo "selected"; ?>>
General
</option>

<option value="Sadqa"
<?php if($data['donation_type']=="Sadqa") echo "selected"; ?>>
Sadqa
</option>

<option value="Zakat"
<?php if($data['donation_type']=="Zakat") echo "selected"; ?>>
Zakat
</option>

<option value="Construction"
<?php if($data['donation_type']=="Construction") echo "selected"; ?>>
Construction
</option>

</select>

</div>

<div class="mb-3">

<label>

Donation Date

</label>

<input type="date"
       name="donation_date"
       class="form-control"
       value="<?php echo $data['donation_date']; ?>"
       required>

</div>

<div class="mb-3">

<label>

Notes

</label>

<textarea name="notes"
          class="form-control"
          rows="4"><?php echo $data['notes']; ?></textarea>

</div>

<button type="submit"
        name="update_donation"
        class="btn btn-primary">

<i class="fa fa-save"></i>

Update Donation

</button>

<a href="manage-donations.php"
   class="btn btn-secondary">

Back

</a>

</form>

</div>

</div>

<?php include('../../includes/footer.php'); ?>