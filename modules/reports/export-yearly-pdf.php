<?php

require '../../vendor/autoload.php';

include('../../config/session.php');
include('../../config/database.php');

use Dompdf\Dompdf;

$year =
$_GET['year'] ?? date('Y');

/* Collection */

$collection =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT SUM(amount) total
 FROM monthly_payments
 WHERE payment_year='$year'"
));

$totalCollection =
$collection['total'] ?? 0;

/* Friday */

$friday =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT SUM(amount) total
 FROM friday_collections
 WHERE YEAR(collection_date)='$year'"
));

$totalFriday =
$friday['total'] ?? 0;

/* Donation */

$donation =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT SUM(amount) total
 FROM donations
 WHERE YEAR(donation_date)='$year'"
));

$totalDonation =
$donation['total'] ?? 0;

/* Expense */

$expense =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT SUM(amount) total
 FROM expenses
 WHERE YEAR(expense_date)='$year'"
));

$totalExpense =
$expense['total'] ?? 0;

/* Salary */

$salary =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT SUM(amount) total
 FROM imam_salary
 WHERE salary_year='$year'
 AND payment_status='Paid'"
));

$totalSalary =
$salary['total'] ?? 0;

$totalIncome =
$totalCollection +
$totalFriday +
$totalDonation;

$netFund =
$totalIncome -
$totalExpense -
$totalSalary;

$html = "

<h1 style='text-align:center'>
Masjid Financial Report $year
</h1>

<hr>

<table
border='1'
cellpadding='8'
width='100%'>

<tr>
<th>Total Collection</th>
<td>Rs. ".number_format($totalCollection)."</td>
</tr>

<tr>
<th>Friday Chanda</th>
<td>Rs. ".number_format($totalFriday)."</td>
</tr>

<tr>
<th>Donations</th>
<td>Rs. ".number_format($totalDonation)."</td>
</tr>

<tr>
<th>Total Income</th>
<td>Rs. ".number_format($totalIncome)."</td>
</tr>

<tr>
<th>Total Expenses</th>
<td>Rs. ".number_format($totalExpense)."</td>
</tr>

<tr>
<th>Imam Salary</th>
<td>Rs. ".number_format($totalSalary)."</td>
</tr>

<tr>
<th>Net Fund</th>
<td>Rs. ".number_format($netFund)."</td>
</tr>

</table>

";

$dompdf =
new Dompdf();

$dompdf->loadHtml($html);

$dompdf->setPaper(
'A4',
'portrait'
);

$dompdf->render();

$dompdf->stream(

'Yearly_Report_'.$year.'.pdf',

[
'Attachment'=>true
]

);