<?php
session_start();
include './utils/db_connection.php';
include './utils/Product.php'; // Include the Product class file

// Create an instance of the Product class
$product = new Product($conn);

// Check if the product ID is set in the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch the product details using getProductById method
    $product_details = $product->getProductById($product_id);

    // Check if the product exists
    if ($product_details) {
        // Get product details
        $product_id = $product_details->p_id;
        $brand_id = $product_details->brand_id;
        $name = $product_details->p_name;
        $price = $product_details->p_price;
        $description = $product_details->p_desc;
        $rating = $product_details->p_rating;
        $image = $product_details->p_image;
    } else {
        header("Location: 404.php");
        exit();
    }
} else {
    // Redirect to the product page to show all products
    header("Location: admin_products.php");
    exit();
}

// Check if the form is submitted for updating the product details
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $rating = $_POST['rating'];
    $image = $_POST['image'];

    // Update product details using the updateProduct method
    if ($product->updateProduct($product_id, $brand_id, $name, $price, $description, $rating, $image)) {
        // Fetch the updated product details
        $product_details = $product->getProductById($product_id);

        // Check if the product exists
        if ($product_details) {
            // Get updated product details
            $product_id = $product_details->p_id;
            $brand_id = $product_details->brand_id;
            $name = $product_details->p_name;
            $price = $product_details->p_price;
            $description = $product_details->p_desc;
            $rating = $product_details->p_rating;
            $image = $product_details->p_image;
        }

        $message = 'Product details updated successfully!';
    } else {
        $message = 'Failed to update product details.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'head.php'; ?>
</head>

<body class="pdt">
    <?php include 'admin_navbar.php'; ?>
    <h2 class="dtl_h2">Update Product Details</h2>
    <main>

        <div class="login-container mx-auto">
            <form method="post">
                <div class="form-group">
                    <label for="name">Product Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>">
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="text" class="form-control" id="price" name="price" value="<?php echo $price; ?>">
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" id="description" name="description"><?php echo $description; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="rating">Rating:</label>
                    <input type="text" class="form-control" id="rating" name="rating" value="<?php echo $rating; ?>">
                </div>
                <div class="form-group">
                    <label for="image">Image:</label>
                    <input type="text" class="form-control" id="image" name="image" value="<?php echo $image; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Update Product</button>
                <?php if (isset($message)) : ?>
                    <div class="alert alert-success mt-3" role="alert"><?php echo $message; ?></div>
                <?php endif; ?>
            </form>
        </div>

    </main>
    <?php include 'footer.php'; ?>
</body>

</html>