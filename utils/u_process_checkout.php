<?php
session_start();
include 'db_connection.php';

// Function to validate card number (16 digits)
function validateCardNumber($cardNumber)
{
    return preg_match('/^\d{16}$/', $cardNumber);
}

// Function to validate expiry date (MMYY format)
function validateExpiryDate($expiryDate)
{
    return preg_match('/^(0[1-9]|1[0-2])(2[1-9]|3[0-9])$/', $expiryDate);
}

// Function to validate CVV (3 digits)
function validateCVV($cvv)
{
    return preg_match('/^\d{3}$/', $cvv);
}

// Function to generate a unique order group ID
function generateUniqueOrderGroupId()
{
    $timestamp = time();
    $randomNumber = mt_rand(10000, 99999);
    $orderGroupId = $timestamp . $randomNumber;
    return $orderGroupId;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form inputs
    $fullName = $_POST["fullName"];
    $email = $_POST["email"];
    $phoneNumber = $_POST["phoneNumber"];
    $cardName = $_POST["cardName"];
    $cardNumber = $_POST["cardNumber"];
    $expiryDate = $_POST["expiryDate"];
    $cvv = $_POST["cvv"];

    // Store form values in session to retain them in case of validation errors
    $_SESSION['fullName'] = $fullName;
    $_SESSION['email'] = $email;
    $_SESSION['phoneNumber'] = $phoneNumber;
    $_SESSION['cardName'] = $cardName;
    $_SESSION['cardNumber'] = $cardNumber;
    $_SESSION['expiryDate'] = $expiryDate;
    $_SESSION['cvv'] = $cvv;

    // Add your validation logic here for each field
    $errors = [];

    if (empty($fullName)) {
        $errors[] = "Full name is required.";
    }

    if (!validateCardNumber($cardNumber)) {
        $errors[] = "Invalid card number.";
    }

    if (!validateExpiryDate($expiryDate)) {
        $errors[] = "Invalid expiry date. Please enter MMYY format.";
    }

    if (!validateCVV($cvv)) {
        $errors[] = "Invalid CVV. Please enter a 3-digit number.";
    }

    if (empty($errors)) {
        // Generate a unique order group ID
        $orderGroupId = generateUniqueOrderGroupId();

        // Insert order details into tbl_orders
        $sql = "INSERT INTO tbl_orders (order_group_id, u_id, p_id, quantity) VALUES ";
        $userId = 2;
        // $userId = $_SESSION['u_id']; // Assuming you have stored user id in the session
        foreach ($_SESSION['cart'] as $product_id => $product) {
            $productId = $product_id;
            $quantity = $product['quantity'];
            $sql .= "($orderGroupId, $userId, $productId, $quantity),";
        }
        $sql = rtrim($sql, ','); // Remove the last comma

        // Execute the query
        if ($conn->query($sql)) {
            // Redirect to thank you page or confirmation page
            $_SESSION['order_id'] = $orderGroupId;
            header("Location: ../order_confirmation.php");
            exit;
        } else {
            $errorInfo = $conn->errorInfo(); // Fetch error info
            echo "Error: " . $errorInfo[2]; // Display error message
        }
    } else {
        // Redirect back to the checkout page with error messages
        $_SESSION["checkout_errors"] = $errors;
        header("Location: ../checkout.php");
        exit;
    }
}
