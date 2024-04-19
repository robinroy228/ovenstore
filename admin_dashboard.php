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

// Create a new Product object
$product = new Product($conn);

// Fetch all products
$products = $product->getAllProducts();


?>

<!DOCTYPE html>
<html lang="en">

<?php include 'head.php' ?>

<body>

    <?php include 'admin_navbar.php' ?>
    <main>
        <div class="container mt-5 mx-auto">
            <h2 class="mb-4">All Products</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Rating</th>
                        <th>Image</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($products as $prod) : ?>
                        <tr>
                            <td><?php echo $prod->p_id; ?></td>
                            <td><?php echo $prod->p_name; ?></td>
                            <td><?php echo $prod->p_price; ?></td>
                            <td><?php echo $prod->p_desc; ?></td>
                            <td><?php echo $prod->p_rating; ?></td>
                            <td><?php echo $prod->p_image; ?></td>
                            <td>
                                <a href="admin_update_product.php?id=<?php echo $prod->p_id; ?>" class="btn btn-primary">Update</a>
                            </td>
                            <td>
                                <form method="post" action="admin_delete_product.php">
                                    <input type="hidden" name="p_id" value="<?php echo $prod->p_id; ?>">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <?php include 'footer.php' ?>
</body>

</html>