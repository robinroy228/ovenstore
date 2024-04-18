<?php session_start();
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'head.php' ?>

<body>
    <?php
    // Check if the user is logged in and the user type is admin
    if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
        include 'admin_navbar.php';
    } else {
        include 'navbar.php';
    }
    ?>
    <main>
        <div class="common-container">
            <h3>404 error. Page not found</h3>
        </div>
    </main>
    <?php include 'footer.php' ?>
</body>

</html>