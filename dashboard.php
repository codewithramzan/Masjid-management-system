<?php

include('config/session.php');

include('includes/header.php');

include('includes/sidebar.php');

?>

<div class="main-content">

    <h2>
        Dashboard
    </h2>

    <p>
        Welcome,
        <?php echo $_SESSION['full_name']; ?>
    </p>

</div>

<?php

include('includes/footer.php');

?>