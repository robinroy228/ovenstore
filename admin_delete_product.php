<?php
session_start();

include './utils/db_connection.php';
include "./utils/Product.php"; // Assuming you have defined the Product class in Product.php

// // Check if the user is logged in as admin
if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "admin") {
    // Redirect to login page if not logged in as admin
    header("Location: login.php");
    exit();
}

// Check if the product ID is set in the POST data
if (isset($_POST['p_id'])) {
    $product_id = $_POST['p_id'];

    // Create a new Product object
    $product = new Product($conn);

    // Delete the product
    $result = $product->deleteProduct($product_id);

    if ($result) {

        header("Location: admin_dashboard.php");
        exit();
    } else {

        echo "Failed to delete the product.";
    }
} else {
    // If product ID is not set, redirect to 404 page
    header("Location: 404.php");
    exit();
}
