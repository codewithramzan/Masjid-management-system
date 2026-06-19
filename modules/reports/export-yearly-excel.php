<?php

require '../../vendor/autoload.php';

include('../../config/session.php');
include('../../config/database.php');

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

$year = $_GET['year'] ?? date('Y');

/* Start Spout Writer */
$writer = WriterEntityFactory::createXLSXWriter();
$writer->openToBrowser("Yearly_Report_" . $year . ".xlsx");

/* Title Row (same as your sheet A1 + B1) */
$writer->addRow(
    WriterEntityFactory::createRowFromArray([
        'Masjid Yearly Report',
        $year
    ])
);

/* Helper function (UNCHANGED LOGIC) */
function getSum($conn, $query) {
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'] ?? 0;
}

/* Data (UNCHANGED) */
$collection = getSum($conn, "
    SELECT SUM(amount) AS total
    FROM monthly_payments
    WHERE payment_year='$year'
");

$friday = getSum($conn, "
    SELECT SUM(amount) AS total
    FROM friday_collections
    WHERE YEAR(collection_date)='$year'
");

$donation = getSum($conn, "
    SELECT SUM(amount) AS total
    FROM donations
    WHERE YEAR(donation_date)='$year'
");

$expense = getSum($conn, "
    SELECT SUM(amount) AS total
    FROM expenses
    WHERE YEAR(expense_date)='$year'
");

$salary = getSum($conn, "
    SELECT SUM(amount) AS total
    FROM imam_salary
    WHERE salary_year='$year'
    AND payment_status='Paid'
");

/* Write rows (same order as your Excel sheet) */

$writer->addRow(WriterEntityFactory::createRowFromArray([
    'Collection',
    $collection
]));

$writer->addRow(WriterEntityFactory::createRowFromArray([
    'Friday Chanda',
    $friday
]));

$writer->addRow(WriterEntityFactory::createRowFromArray([
    'Donations',
    $donation
]));

$writer->addRow(WriterEntityFactory::createRowFromArray([
    'Expenses',
    $expense
]));

$writer->addRow(WriterEntityFactory::createRowFromArray([
    'Imam Salary',
    $salary
]));

/* Close file */
$writer->close();
exit;