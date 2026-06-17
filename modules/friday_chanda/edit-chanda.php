<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');

$id = $_GET['id'];

$query = "
SELECT *
FROM friday_collections
WHERE friday_id='$id'
";

$result = mysqli_query($conn,$query);
$data = mysqli_fetch_assoc($result);

if(!$data){
    die("Friday Chanda record not found.");
}

$message = "";

if(isset($_POST['update_chanda']))
{
    $amount = $_POST['amount'];

    $collection_date =
    $_POST['collection_date'];

    $notes =
    $_POST['notes'];

    $updateQuery = "

    UPDATE friday_collections

    SET

    amount='$amount',
    collection_date='$collection_date',
    notes='$notes'

    WHERE friday_id='$id'

    ";

    if(mysqli_query($conn,$updateQuery))
    {
        $message =
        "Friday Chanda Updated Successfully";

        $data['amount'] = $amount;
        $data['collection_date'] = $collection_date;
        $data['notes'] = $notes;
    }
}

?>

<div class="main-content">

<div class="card p-4">

<h3>Edit Friday Chanda</h3>

<?php if($message!=""){ ?>

<div class="alert alert-success">

<?php echo $message; ?>

</div>

<?php } ?>

<form method="POST">

<div class="mb-3">

<label>Amount</label>

<input type="number"
       step="0.01"
       name="amount"
       class="form-control"
       value="<?php echo $data['amount']; ?>"
       required>

</div>

<div class="mb-3">

<label>Collection Date</label>

<input type="date"
       name="collection_date"
       class="form-control"
       value="<?php echo $data['collection_date']; ?>"
       required>

</div>

<div class="mb-3">

<label>Notes</label>

<textarea name="notes"
          class="form-control"><?php echo $data['notes']; ?></textarea>

</div>

<button type="submit"
        name="update_chanda"
        class="btn btn-primary">

Update Chanda

</button>

</form>

</div>

</div>

<?php include('../../includes/footer.php'); ?>