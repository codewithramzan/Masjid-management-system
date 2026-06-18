<?php

include('../../config/session.php');
include('../../config/database.php');

$month =
$_GET['month'];

$year =
$_GET['year'];

header("Content-Type: application/vnd.ms-excel");

header(
"Content-Disposition: attachment; filename=Monthly_Report_".$month."_".$year.".xls"
);

?>

<table border="1">

<tr>

<th colspan="2">

Masjid Financial Report

</th>

</tr>

<tr>

<td>Month</td>
<td><?php echo $month; ?></td>

</tr>

<tr>

<td>Year</td>
<td><?php echo $year; ?></td>

</tr>

<?php

/* COLLECTION */

$query = "

SELECT
SUM(amount) total

FROM monthly_payments

WHERE payment_month='$month'

AND payment_year='$year'

";

$data =
mysqli_fetch_assoc(
mysqli_query($conn,$query)
);

?>

<tr>

<td>Monthly Collection</td>

<td>

<?php
echo $data['total'] ?? 0;
?>

</td>

</tr>

<?php

/* FRIDAY CHANDA */

$query = "

SELECT
SUM(amount) total

FROM friday_collections

WHERE MONTH(collection_date)=
MONTH(
STR_TO_DATE('$month','%M')
)

AND YEAR(collection_date)='$year'

";

$data =
mysqli_fetch_assoc(
mysqli_query($conn,$query)
);

?>

<tr>

<td>Friday Chanda</td>

<td>

<?php
echo $data['total'] ?? 0;
?>

</td>

</tr>

<?php

/* DONATION */

$query = "

SELECT
SUM(amount) total

FROM donations

WHERE MONTH(donation_date)=
MONTH(
STR_TO_DATE('$month','%M')
)

AND YEAR(donation_date)='$year'

";

$data =
mysqli_fetch_assoc(
mysqli_query($conn,$query)
);

?>

<tr>

<td>Donations</td>

<td>

<?php
echo $data['total'] ?? 0;
?>

</td>

</tr>

<?php

/* EXPENSES */

$query = "

SELECT
SUM(amount) total

FROM expenses

WHERE MONTH(expense_date)=
MONTH(
STR_TO_DATE('$month','%M')
)

AND YEAR(expense_date)='$year'

";

$data =
mysqli_fetch_assoc(
mysqli_query($conn,$query)
);

?>

<tr>

<td>Expenses</td>

<td>

<?php
echo $data['total'] ?? 0;
?>

</td>

</tr>

</table>