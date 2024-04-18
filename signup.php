<?php session_start();
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
    <div class="signup-container mx-auto">
        <h2>Sign Up</h2>

        <form action="./utils/u_signup.php" method="post">
            <div class="form-group m-2">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group m-2">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group m-2">
                <label for="fullname">Full Name:</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
            </div>
            <div class="form-group m-2">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="customer_email" name="customer_email" required>
            </div>
            <div class="form-group m-2">
                <label for="mobile">Mobile Number:</label>
                <input type="tel" class="form-control" id="mobile_number" name="mobile_number" required>
            </div>
            <button type="submit" class="btn btn-primary m-2">Sign Up</button>
        </form>
        <?php
        // Check if there's a registration error message
        if (isset($_SESSION["registration_error"])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION["registration_error"] . '</div>';
            unset($_SESSION["registration_error"]); // Clear the error message after displaying
        }
        ?>
        <p>Already have an account? <a href="login.php">Log in</a></p>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>