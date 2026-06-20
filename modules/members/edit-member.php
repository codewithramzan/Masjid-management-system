<?php

include('../../config/session.php');
include('../../config/database.php');
include('../../includes/header.php');



$id = $_GET['id'];

$getData = "
SELECT *
FROM members
WHERE member_id='$id'
";

$dataResult = mysqli_query($conn, $getData);

$member = mysqli_fetch_assoc($dataResult);

if(isset($_POST['update_member']))
{
    $member_name = $_POST['member_name'];

    $phone = $_POST['phone'];

    $address = $_POST['address'];

    $monthly_amount = $_POST['monthly_amount'];

    $updateQuery = "
    UPDATE members

    SET

    member_name='$member_name',
    phone='$phone',
    address='$address',
    monthly_amount='$monthly_amount'

    WHERE member_id='$id'
    ";

    mysqli_query($conn, $updateQuery);

    header("Location: manage-members.php");
}

?>


<div class="container mt-4">

    <div class="card shadow border-0">

        <div class="card-header bg-white py-3">
            <h3 class="mb-0">
                <i class="fas fa-user-edit text-primary me-2"></i>
                Update Member
            </h3>
        </div>

        <div class="card-body p-4">

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Member Name
                    </label>

                    <input type="text"
                           name="member_name"
                           value="<?php echo $member['member_name']; ?>"
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Phone Number
                    </label>

                    <input type="text"
                           name="phone"
                           value="<?php echo $member['phone']; ?>"
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Address
                    </label>

                    <textarea name="address"
                              rows="4"
                              class="form-control"><?php echo $member['address']; ?></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">
                        Monthly Amount (PKR)
                    </label>

                    <input type="number"
                           name="monthly_amount"
                            value="<?php echo $member['monthly_amount']; ?>"
                           step="0.01"
                           class="form-control">
                </div>

                <button type="submit"
                        name="update_member"
                        class="btn btn-success px-4">

                    <i class="fas fa-save me-2"></i>
                    Update Member

                </button>

            </form>

        </div>

    </div>

</div>