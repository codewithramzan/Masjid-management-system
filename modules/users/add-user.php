<?php

include('../../config/session.php');
include('../../config/permission.php');

memberManageAccess();

$message = "";

if(isset($_POST['save_user']))
{
    $full_name = $_POST['full_name'];
    $username  = $_POST['username'];
    $password  = $_POST['password'];
    $role_id   = $_POST['role_id'];
    $status    = $_POST['status'];

    $check = mysqli_query(
    $conn,
    "SELECT * FROM users
     WHERE username='$username'"
    );

    if(mysqli_num_rows($check)>0)
    {
        $message =
        "<div class='alert alert-danger'>
        Username already exists
        </div>";
    }
    else
    {
        $query = "

        INSERT INTO users
        (
        full_name,
        username,
        password,
        role_id,
        status
        )

        VALUES
        (
        '$full_name',
        '$username',
        '$password',
        '$role_id',
        '$status'
        )

        ";

        mysqli_query($conn,$query);

        $message =
        "<div class='alert alert-success'>
        User Added Successfully
        </div>";
    }
}

include('../../includes/header.php');
include('../../includes/sidebar.php');

?>

<div class="main-content">

<div class="card p-4">

<h3>Add User</h3>

<?php echo $message; ?>

<form method="POST">

<div class="mb-3">

<label>Full Name</label>

<input type="text"
name="full_name"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Username</label>

<input type="text"
name="username"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Password</label>

<input type="password"
name="password"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Role</label>

<select
name="role_id"
class="form-control"
required>

<?php

$roles = mysqli_query(
$conn,
"SELECT * FROM roles"
);

while($role =
mysqli_fetch_assoc($roles))
{

?>

<option
value="<?php echo $role['role_id']; ?>">

<?php echo $role['role_name']; ?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label>Status</label>

<select
name="status"
class="form-control">

<option value="Active">
Active
</option>

<option value="Inactive">
Inactive
</option>

</select>

</div>

<button
type="submit"
name="save_user"
class="btn btn-success">

Save User

</button>

</form>

</div>

</div>