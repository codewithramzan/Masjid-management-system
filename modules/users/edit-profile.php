<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');

$user_id = $_SESSION['user_id'];

$message = "";

/* ==========================
   GET USER DATA
========================== */

$query = "

SELECT *

FROM users

WHERE user_id = '$user_id'

LIMIT 1

";

$result = mysqli_query($conn,$query);

$user = mysqli_fetch_assoc($result);

/* ==========================
   UPDATE PROFILE
========================== */

if(isset($_POST['update_profile']))
{
    $full_name = mysqli_real_escape_string(
        $conn,
        trim($_POST['full_name'])
    );

    $username = mysqli_real_escape_string(
        $conn,
        trim($_POST['username'])
    );

    /* Check Duplicate Username */

    $checkUser = mysqli_query(

        $conn,

        "SELECT user_id

         FROM users

         WHERE username='$username'

         AND user_id != '$user_id'"

    );

    if(mysqli_num_rows($checkUser) > 0)
    {
        $message = '

        <div class="alert alert-danger">

        Username already exists.

        </div>

        ';
    }
    else
    {
        $updateQuery = "

        UPDATE users

        SET

        full_name='$full_name',
        username='$username'

        WHERE user_id='$user_id'

        ";

        if(mysqli_query($conn,$updateQuery))
        {
            $_SESSION['full_name'] = $full_name;

            $message = '

            <div class="alert alert-success">

            Profile Updated Successfully.

            </div>

            ';

            /* Refresh User Data */

            $result = mysqli_query($conn,$query);

            $user = mysqli_fetch_assoc($result);
        }
        else
        {
            $message = '

            <div class="alert alert-danger">

            Failed to Update Profile.

            </div>

            ';
        }
    }
}

?>

<div class="main-content">

<div class="container-fluid">

<div class="row">

<div class="col-lg-8 mx-auto">

<div class="card shadow border-0">

<div class="card-header bg-warning">

<h4 class="mb-0">

✏️ Edit Profile

</h4>

</div>

<div class="card-body">

<?php echo $message; ?>

<form method="POST">

<div class="mb-3">

<label class="form-label">

Full Name

</label>

<input
type="text"
name="full_name"
class="form-control"
value="<?php echo htmlspecialchars($user['full_name']); ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">

Username

</label>

<input
type="text"
name="username"
class="form-control"
value="<?php echo htmlspecialchars($user['username']); ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">

Role


<input
type="text"
class="form-control"
value="<?php echo $_SESSION['role']; ?>"
readonly>

</div>

<div class="mb-3">

<label class="form-label">

Account Status

</label>

<input
type="text"
class="form-control"
value="<?php echo $user['status']; ?>"
readonly>

</div>

<div class="d-flex gap-2">

<button
type="submit"
name="update_profile"
class="btn btn-success">

<i class="fas fa-save"></i>

Update Profile

</button>

<a
href="my-profile.php"
class="btn btn-secondary">

Back

</a>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

</div>

<?php

include('../../includes/footer.php');

?>