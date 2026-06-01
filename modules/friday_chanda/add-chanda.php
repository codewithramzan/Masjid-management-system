<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');

$message = "";

if(isset($_POST['add_chanda']))
{
    $amount = $_POST['amount'];

    $collection_date =
    $_POST['collection_date'];

    $notes = $_POST['notes'];

    $created_by =
    $_SESSION['user_id'];

    $query = "
    INSERT INTO friday_collections
    (
        amount,
        collection_date,
        notes,
        created_by
    )

    VALUES
    (
        '$amount',
        '$collection_date',
        '$notes',
        '$created_by'
    )
    ";

    $result =
    mysqli_query($conn, $query);

    if($result)
    {
        $last_id =
        mysqli_insert_id($conn);

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
            'Friday Chanda',
            'General Fund',
            '$amount',
            '$collection_date',
            '$last_id',
            'friday_collections',
            '$created_by'
            )
        ";

        mysqli_query($conn, $fundQuery);

        $message =
        'Friday Chanda Added Successfully';
    }
}

?>
<div class="main-content">

<div class="card p-4">

<h3 class="mb-4">

Friday Chanda Entry

</h3>

<?php if($message != "") { ?>

<div class="alert alert-success">

<?php echo $message; ?>

</div>

<?php } ?>

<form method="POST">

<div class="mb-3">

<label>

Amount / رقم

</label>

<input type="number"
       name="amount"
       class="form-control"
       required>

</div>

<div class="mb-3">

<label>

Collection Date

</label>

<input type="date"
       name="collection_date"
       value="<?php echo date('Y-m-d'); ?>"
       class="form-control">

</div>

<div class="mb-3">

<label>

Notes / تفصیل

</label>

<textarea name="notes"
          class="form-control"></textarea>

</div>

<button type="submit"
        name="add_chanda"
        class="btn btn-success">

Save Chanda

</button>

</form>

</div>

</div>
<?php

include('../../includes/footer.php');

?>