<?php

include('../../config/session.php');
include('../../config/database.php');

$id = $_GET['id'];

$query = "
DELETE FROM members
WHERE member_id='$id'
";

mysqli_query($conn, $query);

header("Location: manage-members.php");

?>