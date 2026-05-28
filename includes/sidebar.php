<input type="text"
       id="searchInput"
       class="form-control mb-3"
       placeholder="Search Member">
<a href="../../modules/members/add-member.php">

    <i class="fa fa-user-plus"></i>

    Add Member

</a>

<a href="../../modules/members/manage-members.php">

    <i class="fa fa-users"></i>

    Manage Members

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
<?php

include('includes/footer.php');

?>