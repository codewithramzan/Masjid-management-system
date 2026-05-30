
<input type="text"
       id="searchInput"
       class="form-control mb-3"
       placeholder="Search Member">
       <div class="sidebar">
       <a href="<?php echo BASE_URL; ?>dashboard.php">

    <i class="fa fa-dashboard"></i>

    Dashboard

</a>
<a href="<?php echo BASE_URL; ?>modules/members/add-member.php">

    <i class="fa fa-user-plus"></i>

    Add Member

</a>
<a href="<?php echo BASE_URL; ?>modules/members/manage-members.php">

    <i class="fa fa-users"></i>

    Manage Members

</a>
<a href="<?php echo BASE_URL; ?>modules/monthly-payments/unpaid-members.php">

    <i class="fa fa-exclamation-circle"></i>

    Unpaid Members

</a>

<script>

document.getElementById("searchInput")
.addEventListener("keyup", function() {

    let value =
    this.value.toLowerCase();

    let rows =
    document.querySelectorAll("tbody tr");

    rows.forEach(function(row) {

        row.style.display =
        row.innerText.toLowerCase()
        .includes(value)
        ? ""
        : "none";

    });

});

</script>
<a href="<?php echo BASE_URL; ?>modules/monthly-payments/add-payment.php">

    <i class="fa fa-money-bill"></i>

    Add Payment

</a>

<a href="<?php echo BASE_URL; ?>modules/monthly-payments/manage-payments.php">

    <i class="fa fa-list"></i>

    Manage Payments

</a>



<a href="<?php echo BASE_URL; ?>modules/friday_chanda/add-chanda.php">

    <i class="fa fa-mosque"></i>

    Add Friday Chanda

</a>

<a href="<?php echo BASE_URL; ?>modules/friday_chanda/manage-chanda.php">

    <i class="fa fa-list"></i>

    Manage Chanda

</a>
<a href="<?php echo BASE_URL; ?>auth/logout.php">

    <i class="fa fa-sign-out-alt"></i>

    Logout

</a>
</div>