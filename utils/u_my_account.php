<?php
session_start();
require_once "./utils/db_connection.php";

// Check if user is logged in
if (!isset($_SESSION["u_id"])) {
    // Redirect to login page if not logged in
    header("Location: ../login.php");
    exit();
}

// Fetch user details from database
$stmt = $conn->prepare("SELECT customer_name, customer_email, mobile_number FROM tbl_userdetails WHERE u_id = :u_id");
$stmt->bindParam(":u_id", $_SESSION["u_id"]);
$stmt->execute();
$userDetails = $stmt->fetch(PDO::FETCH_ASSOC);

// Process form submission for updating user details
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate and sanitize input data
    $customer_name = $_POST["customer_name"];
    $customer_email = $_POST["customer_email"];
    $mobile_number = $_POST["mobile_number"];

    // Update user details in the database
    $updateStmt = $conn->prepare("UPDATE tbl_userdetails SET customer_name = :customer_name, customer_email = :customer_email, mobile_number = :mobile_number WHERE u_id = :u_id");
    $updateStmt->bindParam(":customer_name", $customer_name);
    $updateStmt->bindParam(":customer_email", $customer_email);
    $updateStmt->bindParam(":mobile_number", $mobile_number);
    $updateStmt->bindParam(":u_id", $_SESSION["u_id"]);
    $updateStmt->execute();

    // Redirect to "My Account" page to reflect changes
    header("Location: ../account.php");
    exit();
}
