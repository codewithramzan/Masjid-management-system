<?php

include('../../config/session.php');
include('../../config/database.php');

$id = $_GET['id'];

mysqli_query(
$conn,
"DELETE FROM expenses
WHERE expense_id='$id'"
);

mysqli_query(
$conn,
"DELETE FROM fund_transactions

WHERE reference_id='$id'

AND reference_table='expenses'"
);

header(
"Location: manage-expenses.php"
);

exit;