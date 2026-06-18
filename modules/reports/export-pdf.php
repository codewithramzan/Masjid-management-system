<?php

include('../../config/session.php');
include('../../config/database.php');

require('../../libraries/fpdf/fpdf.php');

$month =
$_GET['month'];

$year =
$_GET['year'];

$pdf = new FPDF();

$pdf->AddPage();

$pdf->SetFont('Arial','B',16);

$pdf->Cell(
190,
10,
'Masjid Monthly Financial Report',
0,
1,
'C'
);

$pdf->Ln(5);

$pdf->SetFont('Arial','',12);

$pdf->Cell(
190,
10,
"Month: $month  Year: $year",
0,
1
);

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

$collection =
$data['total'] ?? 0;


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

$donation =
$data['total'] ?? 0;


/* FRIDAY */

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

$friday =
$data['total'] ?? 0;


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

$expense =
$data['total'] ?? 0;


/* REPORT */

$pdf->Cell(
100,
10,
'Monthly Collection'
);

$pdf->Cell(
50,
10,
'Rs. '.number_format($collection),
0,
1
);

$pdf->Cell(
100,
10,
'Friday Chanda'
);

$pdf->Cell(
50,
10,
'Rs. '.number_format($friday),
0,
1
);

$pdf->Cell(
100,
10,
'Donations'
);

$pdf->Cell(
50,
10,
'Rs. '.number_format($donation),
0,
1
);

$pdf->Cell(
100,
10,
'Expenses'
);

$pdf->Cell(
50,
10,
'Rs. '.number_format($expense),
0,
1
);

$pdf->Output();