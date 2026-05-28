<?php

include('../../config/session.php');
include('../../config/database.php');

$id = $_GET['id'];

$getData = "
SELECT *
FROM members
WHERE member_id='$id'
";

$dataResult = mysqli_query($conn, $getData);

$member = mysqli_fetch_assoc($dataResult);

if(isset($_POST['update_member']))
{
    $member_name = $_POST['member_name'];

    $phone = $_POST['phone'];

    $address = $_POST['address'];

    $monthly_amount = $_POST['monthly_amount'];

    $updateQuery = "
    UPDATE members

    SET

    member_name='$member_name',
    phone='$phone',
    address='$address',
    monthly_amount='$monthly_amount'

    WHERE member_id='$id'
    ";

    mysqli_query($conn, $updateQuery);

    header("Location: manage-members.php");
}

?>
<form method="POST">

<input type="text"
       name="member_name"
       value="<?php echo $member['member_name']; ?>"
       class="form-control mb-3">

<input type="text"
       name="phone"
       value="<?php echo $member['phone']; ?>"
       class="form-control mb-3">

<textarea name="address"
          class="form-control mb-3"><?php echo $member['address']; ?></textarea>

<input type="number"
       name="monthly_amount"
       value="<?php echo $member['monthly_amount']; ?>"
       class="form-control mb-3">

<button type="submit"
        name="update_member"
        class="btn btn-success">

Update Member

</button>

</form>