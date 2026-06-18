<?php

include('../../config/session.php');
include('../../config/database.php');

$id = $_GET['id'];

$query =
mysqli_query(
$conn,
"SELECT * FROM expenses
WHERE expense_id='$id'"
);

$data =
mysqli_fetch_assoc($query);

if(isset($_POST['update_expense']))
{
    $category_id =
    $_POST['category_id'];

    $title =
    $_POST['title'];

    $description =
    $_POST['description'];

    $amount =
    $_POST['amount'];

    $expense_date =
    $_POST['expense_date'];

    mysqli_query($conn, "

    UPDATE expenses

    SET

    category_id='$category_id',
    title='$title',
    description='$description',
    amount='$amount',
    expense_date='$expense_date'

    WHERE expense_id='$id'

    ");

    header(
    "Location: manage-expenses.php"
    );

    exit;
}

include('../../includes/header.php');
include('../../includes/sidebar.php');

?>

<div class="main-content">

<div class="card p-4">

<h3>Edit Expense</h3>

<form method="POST">

<div class="mb-3">

<label>Category</label>

<select
name="category_id"
class="form-control">

<?php

$catQuery =
mysqli_query(
$conn,
"SELECT * FROM expense_categories"
);

while($cat =
mysqli_fetch_assoc($catQuery))
{

?>

<option

value="<?php echo $cat['category_id']; ?>"

<?php

if(
$cat['category_id']
==
$data['category_id']
)

echo "selected";

?>

>

<?php

echo $cat['category_name'];

?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label>Title</label>

<input
type="text"
name="title"
class="form-control"

value="<?php echo $data['title']; ?>">

</div>

<div class="mb-3">

<label>Description</label>

<textarea
name="description"
class="form-control"><?php echo $data['description']; ?></textarea>

</div>

<div class="mb-3">

<label>Amount</label>

<input
type="number"
name="amount"
class="form-control"

value="<?php echo $data['amount']; ?>">

</div>

<div class="mb-3">

<label>Date</label>

<input
type="date"
name="expense_date"
class="form-control"

value="<?php echo $data['expense_date']; ?>">

</div>

<button
type="submit"
name="update_expense"
class="btn btn-success">

Update Expense

</button>

</form>

</div>

</div>

<?php include('../../includes/footer.php'); ?>