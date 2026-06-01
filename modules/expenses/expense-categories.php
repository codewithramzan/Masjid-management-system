<?php
if(isset($_POST['add_category']))
{
    $category_name =
    $_POST['category_name'];

    $description =
    $_POST['description'];

    mysqli_query(

        $conn,

        "

        INSERT INTO
        expense_categories

        (
            category_name,
            description
        )

        VALUES

        (
            '$category_name',
            '$description'
        )

        "

    );
}
?>
<form method="POST">

<input
type="text"
name="category_name"
placeholder="Category Name"
class="form-control mb-3">

<textarea
name="description"
class="form-control mb-3">
</textarea>

<button
type="submit"
name="add_category"
class="btn btn-primary">

Add Category

</button>

</form>