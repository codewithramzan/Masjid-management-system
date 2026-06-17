<?php

include('../../config/database.php');

$id = $_GET['id'];

mysqli_query(
$conn,
"DELETE FROM imam_salary WHERE salary_id='$id'"
);

header("Location: manage-salary.php");

exit();