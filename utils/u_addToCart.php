<?php
session_start();
include 'db_connection.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $sql = "SELECT * FROM tbl_product WHERE p_id = $product_id";
    $result = $conn->query($sql);
    if ($result->rowCount() > 0) {
        $product = $result->fetch();
    } else {
        header("Location: 404.php");
        exit();
    }
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (array_key_exists($product_id, $_SESSION['cart'])) {
        $_SESSION['cart'][$product_id]['quantity'] += 1;
        header("Location: ../product_details.php?id=$product_id&message=quantity_incremented");
        exit();
    } else {
        $_SESSION['cart'][$product_id] = $product;
        $_SESSION['cart'][$product_id]['quantity'] = 1;
        header("Location: ../product_details.php?id=$product_id&message=added_to_cart");
        exit();
    }
} else {
    header("Location: 404.php");
    exit();
}
