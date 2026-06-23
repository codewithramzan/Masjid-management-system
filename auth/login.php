<?php

include('../config/database.php');

session_start();
$error = "";

if(isset($_POST['login']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "

        SELECT

        u.*,
        r.role_name

        FROM users u

        INNER JOIN roles r

        ON u.role_id = r.role_id

        WHERE u.username='$username'

        LIMIT 1

        ";

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0)
    {
        $user = mysqli_fetch_assoc($result);

        if($password == $user['password'])
        {
            include('../config/activity-log.php');

            addLog(
                $conn,
                $user['user_id'],
                'LOGIN',
                'Authentication',
                'User Logged In'
            );

            $_SESSION['user_id']       = $user['user_id'];

            $_SESSION['full_name']     = $user['full_name'];

            $_SESSION['role_id']       = $user['role_id'];

            $_SESSION['role']          = $user['role_name'];

            // ✅ ADDED: Save username to session
            $_SESSION['username']      = $user['username'];

            // ✅ ADDED: Save profile image to session
            $_SESSION['profile_image'] = $user['profile_image'] ?? '';

            header("Location: ../dashboard.php");

            exit();
        }
        else
        {
            $error = "Invalid Password";
        }
    }
    else
    {
        $error = "User Not Found";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Login</title>

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

<style>

body{
    background:#f4f6f9;
}

.login-box{
    width:400px;
    margin:100px auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

</style>

</head>

<body>

<div class="login-box">

    <h3 class="text-center mb-4">
        Masjid Management System
    </h3>

    <?php if($error != ""){ ?>

        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>

    <?php } ?>

    <form method="POST">

        <div class="mb-3">

            <label>
                Username
            </label>

            <input type="text"
                   name="username"
                   class="form-control"
                   required>

        </div>

        <div class="mb-3">

            <label>
                Password
            </label>

            <input type="password"
                   name="password"
                   class="form-control"
                   required>

        </div>

        <button type="submit"
                name="login"
                class="btn btn-success w-100">

            Login

        </button>

    </form>

</div>

</body>
</html>