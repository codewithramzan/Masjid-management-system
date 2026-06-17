<?php

include('../../config/session.php');
include('../../config/database.php');

$id = $_GET['id'];

mysqli_query(

$conn,

"DELETE FROM fund_transactions

WHERE reference_id='$id'

AND reference_table='friday_collections'"

);

mysqli_query(

$conn,

"DELETE FROM friday_collections

WHERE friday_id='$id'"

);

header(

"Location: manage-chanda.php"

);

exit;

?>