<?php

session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../auth/login.php");
    exit();
}

/*
Role Shortcuts
*/

$isSuperAdmin =
(
isset($_SESSION['role'])
&&
$_SESSION['role'] == 'Super Admin'
);

$isAdmin =
(
isset($_SESSION['role'])
&&
$_SESSION['role'] == 'Admin'
);

$isAccountant =
(
isset($_SESSION['role'])
&&
$_SESSION['role'] == 'Accountant'
);

$isImam =
(
isset($_SESSION['role'])
&&
$_SESSION['role'] == 'Imam'
);

$isViewer =
(
isset($_SESSION['role'])
&&
$_SESSION['role'] == 'Viewer'
);

?>