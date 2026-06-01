<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');

$message = "";

$categoryQuery =
"SELECT * FROM expense_categories";

$categoryResult =
mysqli_query($conn,$categoryQuery);

?>
<?php

if(isset($_POST['add_expense']))
{
    $category_id = $_POST['category_id'];

    $title = $_POST['title'];

    $description = $_POST['description'];

    $amount = $_POST['amount'];

    $expense_date = $_POST['expense_date'];

    $added_by = $_SESSION['user_id'];

    $query = "
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

    $result = mysqli_query($conn,$query);

    if($result)
    {
        $expense_id =
        mysqli_insert_id($conn);

        mysqli_query(
            $conn,

            "

            INSERT INTO fund_transactions

            (
                transaction_type,
                amount,
                transaction_date,
                reference_id,
                reference_table,
                created_by
            )

            VALUES

            (
                'Expense',
                '$amount',
                '$expense_date',
                '$expense_id',
                'expenses',
                '$added_by'
            )

            "
        );

        $message =
        "Expense Added Successfully";
    }
}

?>
<div class="main-content">

<div class="card p-4">

<h3>Add Expense</h3>

<?php if($message!=""){ ?>

<div class="alert alert-success">

<?php echo $message; ?>

</div>

<?php } ?>

<form method="POST">

<label>
Category
</label>

<select
name="category_id"
class="form-control mb-3"
required>

<option value="">
Select Category
</option>

<?php while($cat =
mysqli_fetch_assoc($categoryResult))
{ ?>

<option value="<?php echo $cat['category_id']; ?>">

<?php echo $cat['category_name']; ?>

</option>

<?php } ?>

</select>

<label>
Expense Title
</label>

<input
type="text"
name="title"
class="form-control mb-3"
required>

<label>
تفصیل
</label>

<textarea
name="description"
class="form-control mb-3">
</textarea>

<label>
Amount
</label>

<input
type="number"
name="amount"
class="form-control mb-3"
required>

<label>
Date
</label>

<input
type="date"
name="expense_date"
value="<?php echo date('Y-m-d'); ?>"
class="form-control mb-3">

<button
type="submit"
name="add_expense"
class="btn btn-danger">

Save Expense

</button>

</form>

</div>

</div>