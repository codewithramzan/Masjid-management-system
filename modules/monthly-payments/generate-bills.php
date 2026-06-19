<?php

include('../../config/session.php');
include('../../config/database.php');

include('../../includes/header.php');
include('../../includes/sidebar.php');

$message = "";

if(isset($_POST['generate_bills']))
{
    $payment_month =
    mysqli_real_escape_string(
    $conn,
    $_POST['payment_month']
    );

    $payment_year =
    mysqli_real_escape_string(
    $conn,
    $_POST['payment_year']
    );

    $memberQuery = "

    SELECT *

    FROM members

    WHERE status='Active'

    ";

    $memberResult =
    mysqli_query(
    $conn,
    $memberQuery
    );

    $generated = 0;
    $skipped = 0;

    while(
    $member =
    mysqli_fetch_assoc(
    $memberResult
    ))
    {

        $member_id =
        $member['member_id'];

        $amount =
        $member['monthly_amount'];

        $checkQuery = "

        SELECT payment_id

        FROM monthly_payments

        WHERE member_id='$member_id'

        AND payment_month='$payment_month'

        AND payment_year='$payment_year'

        ";

        $checkResult =
        mysqli_query(
        $conn,
        $checkQuery
        );

        if(
        mysqli_num_rows(
        $checkResult
        ) > 0
        )
        {
            $skipped++;
            continue;
        }

        $insertQuery = "

        INSERT INTO monthly_payments
        (
        member_id,
        amount,
        payment_month,
        payment_year,
        payment_status,
        created_at
        )

        VALUES
        (
        '$member_id',
        '$amount',
        '$payment_month',
        '$payment_year',
        'Unpaid',
        NOW()
        )

        ";

        if(
        mysqli_query(
        $conn,
        $insertQuery
        ))
        {
            $generated++;
        }

    }

    $message =

    "Bills Generated Successfully.

    Generated: $generated

    | Skipped: $skipped";

}

?>

<div class="main-content">

<div class="container-fluid">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h4>

📅 Generate Monthly Bills

</h4>

</div>

<div class="card-body">

<?php if($message!="") { ?>

<div class="alert alert-success">

<?php echo $message; ?>

</div>

<?php } ?>

<form method="POST">

<div class="row">

<div class="col-md-4">

<label>

Month

</label>

<select
name="payment_month"
class="form-control"
required>

<option value="January">January</option>
<option value="February">February</option>
<option value="March">March</option>
<option value="April">April</option>
<option value="May">May</option>
<option value="June">June</option>
<option value="July">July</option>
<option value="August">August</option>
<option value="September">September</option>
<option value="October">October</option>
<option value="November">November</option>
<option value="December">December</option>

</select>

</div>

<div class="col-md-4">

<label>

Year

</label>

<select
name="payment_year"
class="form-control"
required>

<?php

for(
$year=date('Y')-2;
$year<=date('Y')+5;
$year++
)
{

?>

<option
value="<?php echo $year; ?>">

<?php echo $year; ?>

</option>

<?php

}

?>

</select>

</div>

<div class="col-md-4">

<label>

&nbsp;

</label>

<button
type="submit"
name="generate_bills"
class="btn btn-success w-100">

Generate Bills

</button>

</div>

</div>

</form>

</div>

</div>

</div>

</div>

<?php

include('../../includes/footer.php');

?>