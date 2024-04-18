<?php
session_start();
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Database connection
        require_once "db_connection.php";
        // Getting form data
        $username = $_POST["username"];
        $password = $_POST["password"];
        $customer_name = $_POST["customer_name"];
        $customer_email = $_POST["customer_email"];
        $mobile_number = $_POST["mobile_number"];
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // Prepare and execute statement
        $stmt = $conn->prepare("INSERT INTO tbl_userdetails (u_name, u_password, customer_name, customer_email, mobile_number) VALUES (:username, :password, :customer_name, :customer_email, :mobile_number)");
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":customer_name", $customer_name);
        $stmt->bindParam(":customer_email", $customer_email);
        $stmt->bindParam(":mobile_number", $mobile_number);
        if ($stmt->execute()) {
            // Registration successful, redirect to login page with success message
            $_SESSION["registration_success"] = "Registration successful! You can now log in.";
            header("Location: ../login.php");
            exit();
        } else {
            // Registration failed, redirect back to signup page with error message
            $_SESSION["registration_error"] = "Failed to register. Please try again.";
            header("Location: ../signup.php");
            exit();
        }
    } else {
        // Redirect to signup page if accessed directly
        header("Location: ../signup.php");
        exit();
    }
} catch (PDOException $e) {
    // Handle PDO exceptions
    $_SESSION["registration_error"] = "Database error: " . $e->getMessage();
    header("Location: ../signup.php");
    exit();
}
