<?php

include('../../config/session.php');
include('../../config/permissions.php');

memberManageAccess();

include('../../config/database.php');

$id = $_GET['id'];

/* Prevent Self Delete */

if($id == $_SESSION['user_id'])
{
    die("You cannot delete your own account.");
}

/* Check User Exists */

$check = mysqli_query(
$conn,
"SELECT * FROM users
WHERE user_id='$id'"
);

if(mysqli_num_rows($check)==0)
{
    die("User Not Found");
}

mysqli_query(
$conn,
"DELETE FROM users
WHERE user_id='$id'"
);

header("Location: manage-users.php");

exit();
?>