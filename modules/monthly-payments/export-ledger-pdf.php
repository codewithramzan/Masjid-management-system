<?php

require '../../vendor/autoload.php';


use Dompdf\Dompdf;


include('../../config/database.php');


$member_id=$_GET['member_id'];



$memberQ=mysqli_query(
$conn,
"
SELECT *
FROM members
WHERE member_id='$member_id'
"
);


$member=mysqli_fetch_assoc($memberQ);



$html="

<h2 align='center'>
Masjid Monthly Ledger
</h2>

<h3>
Member:
{$member['member_name']}
</h3>


<table border='1'
width='100%'
cellpadding='8'>


<tr>

<th>Month</th>
<th>Year</th>
<th>Amount</th>
<th>Status</th>

</tr>

";



$data=mysqli_query(
$conn,
"
SELECT *
FROM monthly_payments
WHERE member_id='$member_id'
"
);



while($r=mysqli_fetch_assoc($data))
{


$html.="

<tr>

<td>{$r['payment_month']}</td>

<td>{$r['payment_year']}</td>

<td>
Rs {$r['amount']}
</td>


<td>
{$r['payment_status']}
</td>


</tr>

";


}



$html.="</table>";



$pdf=new Dompdf();


$pdf->loadHtml($html);


$pdf->setPaper('A4','portrait');


$pdf->render();


$pdf->stream(
"member-ledger.pdf",
[
"Attachment"=>true
]
);

?>