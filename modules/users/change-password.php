<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');

$user_id = $_SESSION['user_id'];

$message = "";

if(isset($_POST['change_password']))
{
    $current_password =
    $_POST['current_password'];

    $new_password =
    $_POST['new_password'];

    $confirm_password =
    $_POST['confirm_password'];

    $userQuery = mysqli_query(
    $conn,
    "SELECT * FROM users
    WHERE user_id='$user_id'"
    );

    $user =
    mysqli_fetch_assoc($userQuery);

    if($current_password != $user['password'])
    {
        $message =
        "<div class='alert alert-danger'>
        Current Password Incorrect
        </div>";
    }

    elseif($new_password != $confirm_password)
    {
        $message =
        "<div class='alert alert-danger'>
        Passwords Do Not Match
        </div>";
    }

    else
    {
        mysqli_query(

        $conn,

        "UPDATE users

        SET password='$new_password'

        WHERE user_id='$user_id'"

        );

        $message =
        "<div class='alert alert-success'>
        Password Changed Successfully
        </div>";
    }
}

?>

<div class="main-content">

<div class="card shadow p-4">

<h3>Change Password</h3>

<?php echo $message; ?>

<form method="POST">

<div class="mb-3">

<label>Current Password</label>

<input
type="password"
name="current_password"
class="form-control"
required>

</div>

<div class="mb-3">

<label>New Password</label>

<input
type="password"
name="new_password"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Confirm Password</label>

<input
type="password"
name="confirm_password"
class="form-control"
required>

</div>

<button
type="submit"
name="change_password"
class="btn btn-success">

Change Password

</button>

</form>

</div>

</div>

<?php include('../../includes/footer.php'); ?>