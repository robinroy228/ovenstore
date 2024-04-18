<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    require_once "db_connection.php";
    // Getting username and password from form
    $username = $_POST["username"];
    $password = $_POST["password"];
    // Prepare statement for preventing SQL injection
    $stmt = $conn->prepare("SELECT u_id, u_name, customer_name, u_password, user_type FROM tbl_userdetails WHERE u_name=:username");
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        // Verify password
        if (password_verify($password, $result["u_password"])) {
            $_SESSION["u_id"] = $result["u_id"];
            $_SESSION["u_name"] = $result["u_name"];
            $_SESSION["user_type"] = $result["user_type"];
            setcookie("u_id", $result["u_id"], time() + (86400 * 1), "/");
            setcookie("u_name", $result["u_name"], time() + (86400 * 1), "/");
            setcookie("customer_name", $result["customer_name"], time() + (86400 * 1), "/");
            setcookie("user_type", $result["user_type"], time() + (86400 * 1), "/");
            if ($result["user_type"] === "admin") {
                header("Location: ../admin_dashboard.php");
            } else {
                header("Location: ../index.php");
            }
            exit();
        } else {
            // Login failed
            $_SESSION["login_error"] = "Invalid username or password.";
            header("Location: ../login.php");
            exit();
        }
    } else {
        // Login failed
        $_SESSION["login_error"] = "Invalid username or password.";
        header("Location: ../login.php");
        exit();
    }
} else {
    // Redirect to login page
    $_SESSION["login_error"] = "Invalid username or password.";
    header("Location: ../login.php");
    exit();
}
