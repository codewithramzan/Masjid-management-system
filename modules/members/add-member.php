<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');

$message = "";

if(isset($_POST['add_member']))
{
    $member_name = $_POST['member_name'];

    $phone = $_POST['phone'];

    $address = $_POST['address'];

    $monthly_amount = $_POST['monthly_amount'];

    $query = "
    INSERT INTO members
    (
        member_name,
        phone,
        address,
        monthly_amount
    )

    VALUES
    (
        '$member_name',
        '$phone',
        '$address',
        '$monthly_amount'
    )
    ";

    $result = mysqli_query($conn, $query);

    if($result)
    {
        $message = "Member Added Successfully";
    }
}

?>
<div class="main-content">

<div class="card p-4">

<h3 class="mb-4">

Add Member

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

Name / نام

</label>

<input type="text"
       name="member_name"
       class="form-control"
       required>

</div>

<div class="col-md-6 mb-3">

<label>

Phone

</label>

<input type="text"
       name="phone"
       class="form-control">

</div>

</div>

<div class="mb-3">

<label>

Address / پتہ

</label>

<textarea name="address"
          class="form-control"></textarea>

</div>

<div class="mb-3">

<label>

Monthly Amount

</label>

<input type="number"
       name="monthly_amount"
       class="form-control"
       required>

</div>

<button type="submit"
        name="add_member"
        class="btn btn-success">

Add Member

</button>

</form>

</div>

</div>
<?php

include('../../includes/footer.php');

?>