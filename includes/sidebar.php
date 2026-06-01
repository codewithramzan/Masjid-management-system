
<input type="text"
       id="searchInput"
       class="form-control mb-3"
       placeholder="Search Member">
       <div class="sidebar">
       <a href="<?php echo BASE_URL; ?>dashboard.php">

   📊 Dashboard

</a>


<!-- Members Menu -->
<li class="nav-item">
    <a class="nav-link d-flex justify-content-between align-items-center"
       data-bs-toggle="collapse"
       href="#membersMenu"
       role="button"
       aria-expanded="false">

        <span>
            <i class="bi bi-people-fill me-2"></i>
           👥 Members
        </span>

        <i class="bi bi-chevron-down"></i>
    </a>

    <div class="collapse show" id="membersMenu">
        <ul class="nav flex-column ms-4">

            <li class="nav-item">
                <a href="<?php echo BASE_URL; ?>modules/members/add-member.php" class="nav-link text-secondary">
                    Add Member
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo BASE_URL; ?>modules/members/manage-members.php" class="nav-link text-secondary">
                    Manage Members
                </a>
            </li>

        </ul>
    </div>
</li>


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

<!-- Monthly Collection Menu -->
<li class="nav-item">
    <a class="nav-link d-flex justify-content-between align-items-center"
       data-bs-toggle="collapse"
       href="#collectionMenu"
       role="button"
       aria-expanded="false">

        <span>
            <i class="bi bi-cash-coin me-2"></i>
            💰Monthly Collection
        </span>

        <i class="bi bi-chevron-down"></i>
    </a>

    <div class="collapse show" id="collectionMenu">
        <ul class="nav flex-column ms-4">

            <li class="nav-item">
                <a href="<?php echo BASE_URL; ?>modules/monthly-payments/add-payment.php" class="nav-link text-secondary">
                    Add Payment
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo BASE_URL; ?>modules/monthly-payments/manage-payments.php" class="nav-link text-secondary">
                    Manage Payments
                </a>
            </li>

           <li class="nav-item">
                <a href="<?php echo BASE_URL; ?>modules/monthly-payments/unpaid-members.php" class="nav-link text-secondary">

                    <i class="fa"></i>

                    Unpaid Members

                </a>
            </li>

        </ul>
    </div>
</li>


<!-- Friday Chanda Menu -->
<li class="nav-item">
    <a class="nav-link d-flex justify-content-between align-items-center"
       data-bs-toggle="collapse"
       href="#fridayChandaMenu"
       role="button"
       aria-expanded="false">

        <span>
            <i class="bi bi-building me-2"></i>
           🕌Friday Chanda
        </span>

        <i class="bi bi-chevron-down"></i>
    </a>

    <div class="collapse show" id="fridayChandaMenu">
        <ul class="nav flex-column ms-4">

            <li class="nav-item">
                <a href="<?php echo BASE_URL; ?>modules/friday_chanda/add-chanda.php" class="nav-link text-secondary">
                    Add Chanda
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo BASE_URL; ?>modules/friday_chanda/manage-chanda.php" class="nav-link text-secondary">
                    Manage Chanda
                </a>
            </li>

        </ul>
    </div>
</li>



<a href="<?php echo BASE_URL; ?>auth/logout.php">

    <i class="fa fa-sign-out-alt"></i>

    Logout

</a>
</div>