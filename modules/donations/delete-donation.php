<?php

include('../../config/session.php');
include('../../config/database.php');

$id = $_GET['id'];

mysqli_query($conn,"

DELETE FROM fund_transactions

WHERE reference_id='$id'

AND reference_table='donations'

");

mysqli_query($conn,"

DELETE FROM donations

WHERE donation_id='$id'

");

header("Location: manage-donations.php");

exit;

?>