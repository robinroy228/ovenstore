<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'head.php'; ?>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <header>
        <div style="height: max-content;background-color: white;">
            <h1>BAKE.<span> GRILL </span>.TOAST</h1>
            <h3>FIND THE BEST OVENS <span>!</span></h3>
        </div>
    </header>
    <div class="login-container mx-auto">
        <h2>Login</h2>

        <form action="./utils/u_login.php" method="post">
            <div class="form-group m-2">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group m-2">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary m-2">Login</button>
        </form>
        <?php
        // Check if there's a login error message
        if (isset($_SESSION["login_error"])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION["login_error"] . '</div>';
            unset($_SESSION["login_error"]); // Clear the error message after displaying
        }
        if (isset($_SESSION["registration_success"])) {
            echo '<div class="alert alert-danger" role="alert">' .  $_SESSION["registration_success"]  . '</div>';
            unset($_SESSION["registration_success"]); // Clear the error message after displaying
        }
        if (isset($_SESSION["registration_error"])) {
            echo '<div class="alert alert-danger" role="alert">' .  $_SESSION["registration_error"]  . '</div>';
            unset($_SESSION["registration_error"]); // Clear the error message after displaying
        }
        ?>
        <p>Don't have an account? <a href="signup.php">Sign up</a></p>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>