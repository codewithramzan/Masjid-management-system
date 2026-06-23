<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');


$message = '';

if(isset($_POST['add_expense']))

{
    $category_id =
    mysqli_real_escape_string(
    $conn,
    $_POST['category_id']
    );

    $title =
    mysqli_real_escape_string(
    $conn,
    $_POST['title']
    );

    $description =
    mysqli_real_escape_string(
    $conn,
    $_POST['description']
    );

    $amount =
    mysqli_real_escape_string(
    $conn,
    $_POST['amount']
    );

    $expense_date =
    mysqli_real_escape_string(
    $conn,
    $_POST['expense_date']
    );

    $added_by =
    $_SESSION['user_id'];

    $expenseQuery = "

    INSERT INTO expenses
    (
        category_id,
        title,
        description,
        amount,
        expense_date,
        added_by
    )

    VALUES
    (
        '$category_id',
        '$title',
        '$description',
        '$amount',
        '$expense_date',
        '$added_by'
    )

    ";

    $result =
    mysqli_query(
    $conn,
    $expenseQuery
    );

    if($result)
    {
        $expense_id =
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
            notes,
            created_by
        )

        VALUES
        (
            'Expense',
            'General Fund',
            '$amount',
            '$expense_date',
            '$expense_id',
            'expenses',
            '$title',
            '$added_by'
        )

        ";

        mysqli_query(
        $conn,
        $fundQuery
        );

        $message =
        'Expense Added Successfully';
    }
}

?>

<div class="main-content">

<div class="card shadow p-4">

<h3 class="mb-4">

💸 Add Expense

</h3>

<?php if($message != '') { ?>

<div class="alert alert-success">

<?php echo $message; ?>

</div>

<?php } ?>

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label>

Expense Category

</label>

<select
name="category_id"
class="form-control"
required>

<option value="">

Select Category

</option>

<?php

$categoryQuery =
mysqli_query(
$conn,
"SELECT * FROM expense_categories
WHERE status='Active'
ORDER BY category_name ASC"
);

while($cat =
mysqli_fetch_assoc($categoryQuery))
{

?>

<option
value="<?php echo $cat['category_id']; ?>">

<?php echo $cat['category_name']; ?>

</option>

<?php } ?>

</select>

</div>

<div class="col-md-6 mb-3">

<label>

Expense Date

</label>

<input
type="date"
name="expense_date"
class="form-control"
value="<?php echo date('Y-m-d'); ?>"
required>

</div>

</div>

<div class="mb-3">

<label>

Expense Title

</label>

<input
type="text"
name="title"
class="form-control"
required>

</div>

<div class="mb-3">

<label>

Description

</label>

<textarea
name="description"
class="form-control"
rows="4"></textarea>

</div>

<div class="mb-3">

<label>

Amount

</label>

<input
type="number"
step="0.01"
name="amount"
class="form-control"
required>

</div>

<button
type="submit"
name="add_expense"
class="btn btn-success">

Save Expense

</button>

</form>

</div>

</div>

<?php
include('../../includes/footer.php');
?>