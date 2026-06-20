<?php

include('../../config/session.php');
include('../../config/database.php');
memberManageAccess();
include('../../includes/header.php');
include('../../includes/sidebar.php');

$user_id = $_SESSION['user_id'];

$query = mysqli_query(
$conn,
"SELECT * FROM users
WHERE user_id='$user_id'"
);

$user = mysqli_fetch_assoc($query);

$message = "";

if(isset($_POST['update_profile']))
{
    $full_name = mysqli_real_escape_string(
    $conn,
    $_POST['full_name']
    );

    $username = mysqli_real_escape_string(
    $conn,
    $_POST['username']
    );

    $update = "

    UPDATE users

    SET

    full_name='$full_name',
    username='$username'

    WHERE user_id='$user_id'

    ";

    if(mysqli_query($conn,$update))
    {
        $_SESSION['full_name'] = $full_name;

        $message =
        "<div class='alert alert-success'>
        Profile Updated Successfully
        </div>";
    }
}

?>

<div class="main-content">

<div class="card shadow p-4">

<h3>Edit Profile</h3>

<?php echo $message; ?>

<form method="POST">

<div class="mb-3">

<label>Full Name</label>

<input
type="text"
name="full_name"
class="form-control"
value="<?php echo $user['full_name']; ?>"
required>

</div>

<div class="mb-3">

<label>Username</label>

<input
type="text"
name="username"
class="form-control"
value="<?php echo $user['username']; ?>"
required>

</div>

<button
type="submit"
name="update_profile"
class="btn btn-primary">

Update Profile

</button>

</form>

</div>

</div>

<?php include('../../includes/footer.php'); ?>