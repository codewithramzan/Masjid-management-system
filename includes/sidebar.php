<?php
// include('../../config/session.php');
// include('../../config/permission.php');
$role = $_SESSION['role'] ?? '';

?>
<div class="sidebar">

  <!-- Search Input (moved INSIDE sidebar) -->
  <input type="text"
		 id="searchInput"
		 class="form-control mb-3"
		 placeholder="Search Member">

  <ul class="nav flex-column">  <!-- ✅ Added missing <ul> wrapper -->

	<!-- Dashboard (fixed: now wrapped in <li>) -->
	<li class="nav-item">
	  <a href="<?php echo BASE_URL; ?>dashboard.php" class="nav-link">
		📊 Dashboard
	  </a>
	</li>


	<!-- Members Menu -->
	<?php

if(
$role=='Super Admin'
||
$role=='Admin'
||
$role=='Accountant'
||
$role=='Imam'
||
$role=='Viewer'
)
{

?>

<li class="nav-item">

<a class="nav-link d-flex justify-content-between align-items-center"
data-bs-toggle="collapse"
href="#membersMenu">

<span>👥 Members</span>

<i class="bi bi-chevron-down"></i>

</a>

<div class="collapse" id="membersMenu">

<ul class="nav flex-column ms-4">

<?php

if(
$role=='Super Admin'
||
$role=='Admin'
)
{

?>

<li>

<a href="<?php echo BASE_URL; ?>modules/members/add-member.php"
class="nav-link">

Add Member

</a>

</li>

<?php } ?>

<li>

<a href="<?php echo BASE_URL; ?>modules/members/manage-members.php"
class="nav-link">

Manage Members

</a>

</li>

</ul>

</div>

</li>

<?php } ?>

	<!-- Monthly Collection Menu -->
	 <?php

if(
$role=='Super Admin'
||
$role=='Admin'
||
$role=='Accountant'
)
{

?>

	<li class="nav-item">
	  <a class="nav-link d-flex justify-content-between align-items-center"
		 data-bs-toggle="collapse"
		 href="#collectionMenu"
		 role="button"
		 aria-expanded="false">
		<span><i class="bi bi-cash-coin me-2"></i>💰 Monthly Collection</span>
		<i class="bi bi-chevron-down"></i>
	  </a>
	  <div class="collapse" id="collectionMenu">
		<ul class="nav flex-column ms-4">
		  <li class="nav-item">
			<a href="<?php echo BASE_URL; ?>modules/monthly-payments/add-payment.php" class="nav-link text-secondary">Add Payment</a>
		  </li>
		  <li class="nav-item">
			<a href="<?php echo BASE_URL; ?>modules/monthly-payments/manage-payments.php" class="nav-link text-secondary">Manage Payments</a>
		  </li>
			<li class="nav-item">
				<a href="<?php echo BASE_URL; ?>modules/monthly-payments/generate-bills.php"
				class="nav-link text-secondary">

				Generate Bills

				</a>
				</li>
				<li class="nav-item">
				<a href="<?php echo BASE_URL; ?>modules/monthly-payments/collect-payment.php"
				class="nav-link text-secondary">

				Collect Payments

				</a>
				</li>
				<li class="nav-item">
				<a href="<?php echo BASE_URL; ?>modules/monthly-payments/member-ledger.php"
				class="nav-link text-secondary">

				Member Ledger

				</a>
				</li>
		  <li class="nav-item">
			<a href="<?php echo BASE_URL; ?>modules/monthly-payments/unpaid-members.php" class="nav-link text-secondary">
			  <i class="bi bi-person-x me-1"></i>  <!-- ✅ Fixed empty icon -->
			  Unpaid Members
			</a>
		  </li>
		</ul>
	  </div>
	</li>
  <?php } ?>
	<!-- Friday Chanda Menu -->
	 <?php

if(
$role=='Super Admin'
||
$role=='Admin'
||
$role=='Accountant'
)
{

?>
	<li class="nav-item">
	  <a class="nav-link d-flex justify-content-between align-items-center"
		 data-bs-toggle="collapse"
		 href="#fridayChandaMenu"
		 role="button"
		 aria-expanded="false">
		<span><i class="bi bi-building me-2"></i>🕌 Friday Chanda</span>
		<i class="bi bi-chevron-down"></i>
	  </a>
	  <div class="collapse" id="fridayChandaMenu">
		<ul class="nav flex-column ms-4">
		  <li class="nav-item">
			<a href="<?php echo BASE_URL; ?>modules/friday_chanda/add-chanda.php" class="nav-link text-secondary">Add Chanda</a>
		  </li>
		  <li class="nav-item">
			<a href="<?php echo BASE_URL; ?>modules/friday_chanda/manage-chanda.php" class="nav-link text-secondary">Manage Chanda</a>
		  </li>
		</ul>
	  </div>
	</li>
	 <?php } ?>
	
	<!-- Donation chanda Menu -->
	 <?php

		if(
		$role=='Super Admin'
		||
		$role=='Admin'
		||
		$role=='Accountant'
		)
		{

		?>
	<li class="nav-item">
	  <a class="nav-link d-flex justify-content-between align-items-center"
		 data-bs-toggle="collapse"
		 href="#donationMenu"
		 role="button"
		 aria-expanded="false">
		<span><i class="bi bi-building me-2"></i>🎁 Donations</span>
		<i class="bi bi-chevron-down"></i>
	  </a>
	  <div class="collapse" id="donationMenu">
		<ul class="nav flex-column ms-4">
		  <li class="nav-item">
			<a href="<?php echo BASE_URL; ?>modules/donations/add-donation.php" class="nav-link text-secondary">Add Donation</a>
		  </li>
		  <li class="nav-item">
			<a href="<?php echo BASE_URL; ?>modules/donations/manage-donations.php" class="nav-link text-secondary">Manage Donation</a>
		  </li>
		</ul>
	  </div>
	</li>
	<?php } ?>
	<!-- User Management Menu -->
	 <?php

	if($role=='Super Admin')
	{

	?>

	<li class="nav-item">
	  <a class="nav-link d-flex justify-content-between align-items-center"
		 data-bs-toggle="collapse"
		 href="#userManagementMenu"
		 role="button"
		 aria-expanded="false">
		<span><i class="bi bi-building me-2"></i>👥User Management</span>
		<i class="bi bi-chevron-down"></i>
	  </a>
	  <div class="collapse" id="userManagementMenu">
		<ul class="nav flex-column ms-4">
		  <li class="nav-item">
			<a href="<?php echo BASE_URL; ?>modules/users/add-user.php" class="nav-link text-secondary">Add User</a>
		  </li>
		  <li class="nav-item">
			<a href="<?php echo BASE_URL; ?>modules/users/manage-users.php" class="nav-link text-secondary">Manage Users</a>
		  </li>
		</ul>
	  </div>
	</li>
  <?php } ?>
	<!-- Imam salary Menu -->
	 <?php

		if(
		$role=='Super Admin'
		||
		$role=='Admin'
		||
		$role=='accountant'
		)
		{

		?>

	<li class="nav-item">
	  <a class="nav-link d-flex justify-content-between align-items-center"
		 data-bs-toggle="collapse"
		 href="#salaryMenu"
		 role="button"
		 aria-expanded="false">
		<span><i class="bi bi-building me-2"></i>👳 Imam Salary</span>
		<i class="bi bi-chevron-down"></i>
	  </a>
	  <div class="collapse" id="salaryMenu">
		<ul class="nav flex-column ms-4">
		  <li class="nav-item">
			<a href="<?php echo BASE_URL; ?>modules/imam-salary/add-salary.php" class="nav-link text-secondary">Add Salary</a>
		  </li>
			<li>

			<a
			href="<?php echo BASE_URL; ?>modules/imam-salary/manage-salary.php"
			class="nav-link text-secondary">
			Manage Salary
			</a>
			
			</li>

			<li class="nav-item">

			<a href="<?php echo BASE_URL; ?>modules/imam-salary/salary-history.php"
			class="nav-link text-secondary">
			Salary History

			</a>

			</li>
		</ul>
	  </div>
	</li>
	<?php } ?>
	<!-- Expenses Menu -->
	 <?php

		if(
		$role=='Super Admin'
		||
		$role=='Admin'
		||
		$role=='Accountant'
		)
		{

		?>

<li class="nav-item">

<a class="nav-link d-flex justify-content-between align-items-center"
data-bs-toggle="collapse"
href="#expenseMenu">

<span>
💸 Expenses

</span>

</a>

<div class="collapse" id="expenseMenu">

<ul class="nav flex-column ms-4">

<li>
<a href="<?php echo BASE_URL; ?>modules/expenses/add-expense.php"
class="nav-link text-secondary">

Add Expense

</a>
</li>

<li>
<a href="<?php echo BASE_URL; ?>modules/expenses/manage-expenses.php"
class="nav-link text-secondary">

Manage Expenses
 
</a>
</li>

<li>
<a href="<?php echo BASE_URL; ?>modules/expenses/expense-report.php"
class="nav-link text-secondary">

Expense Report

</a>
</li>

</ul>

</div>

</li>
	<?php } ?>
<li class="nav-item">

<a class="nav-link d-flex justify-content-between align-items-center"
data-bs-toggle="collapse"
href="#fundMenu">

<span>
📒 Fund Ledger
</span>

</a>

<div class="collapse" id="fundMenu">

<ul class="nav flex-column ms-4">

<li>
<a href="<?php echo BASE_URL; ?>modules/fund-transactions/manage-transactions.php"
class="nav-link text-secondary">

All Transactions

</a>
</li>

<li>
<a href="<?php echo BASE_URL; ?>modules/fund-transactions/fund-ledger-report.php"
class="nav-link text-secondary">

Ledger Report

</a>
</li>

</ul>

</div>

</li>
<?php
if(
$role=='Super Admin'
||
$role=='Admin'
||
$role=='Accountant'
||
$role=='Imam'
||
$role=='Viewer'
)
{

?>
<li class="nav-item">

<a class="nav-link d-flex justify-content-between align-items-center"
data-bs-toggle="collapse"
href="#reportsMenu">

<span>
📑 Reports Center
</span>

</a>

<div class="collapse" id="reportsMenu">

<ul class="nav flex-column ms-4">

<li>
<a href="<?php echo BASE_URL; ?>modules/reports/monthly-report.php"
class="nav-link">
Monthly Report
</a>
</li>

<li>
<a href="<?php echo BASE_URL; ?>modules/reports/yearly-report.php"
class="nav-link">
Yearly Report
</a>
</li>

<li>
<a href="<?php echo BASE_URL; ?>modules/reports/member-report.php"
class="nav-link">
Member Collection Report
</a>
</li>

<li>
<a href="<?php echo BASE_URL; ?>modules/reports/donation-report.php"
class="nav-link">
Donation Report
</a>
</li>

<li>
<a href="<?php echo BASE_URL; ?>modules/reports/friday-report.php"
class="nav-link">
Friday Chanda Report
</a>
</li>

<li>
<a href="<?php echo BASE_URL; ?>modules/reports/financial-summary.php"
class="nav-link">
Financial Summary
</a>
</li>

</ul>

</div>

</li>
<?php } ?>

<li class="nav-item">

<a class="nav-link d-flex justify-content-between align-items-center"
data-bs-toggle="collapse"
href="#accountMenu">

<span>👤 My Account</span>

<i class="bi bi-chevron-down"></i>

</a>

<div class="collapse" id="accountMenu">

<ul class="nav flex-column ms-4">

<li>

<a href="<?php echo BASE_URL; ?>modules/users/my-profile.php"
class="nav-link">

👤 My Profile

</a>

</li>

<li>

<a href="<?php echo BASE_URL; ?>modules/users/change-password.php"
class="nav-link">

Change Password

</a>

</li>

</ul>

</div>

</li>
  </ul>  <!-- end nav -->

</div>  <!-- end sidebar -->

<!-- ✅ Script moved to BOTTOM, after all HTML is rendered -->
<script>
const searchInput =
document.getElementById("searchInput");

if(searchInput){

searchInput.addEventListener("keyup", function () {

    let value =
    this.value.toLowerCase();

    let rows =
    document.querySelectorAll("tbody tr");

    rows.forEach(function (row) {

        row.style.display =
        row.innerText.toLowerCase()
        .includes(value)
        ? ""
        : "none";

    });

});

}
</script>