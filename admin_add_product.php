<?php
session_start();
include './utils/db_connection.php';
include "./utils/Product.php";

// Fetch brand data from tbl_brand
$sql = "SELECT * FROM tbl_brand";
$brand_result = $conn->query($sql);
$brands = $brand_result->fetchAll(PDO::FETCH_ASSOC);

// Check if the form is submitted for inserting a new product
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $rating = $_POST['rating'];
    $image = $_POST['image'];
    $brand_id = $_POST['brand_id'];

    // Create a new Product object
    $product = new Product($conn);

    // Insert new product into the database
    $result = $product->insertProduct($brand_id, $name, $price, $description, $rating, $image);

    if ($result) {
        $message = 'Product inserted successfully!';
    } else {
        $message = 'Failed to insert product.';
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
    <h2 class="dtl_h2">Insert New Product</h2>
    <main>
        <div class="login-container mx-auto">
            <form method="post">
                <div class="form-group">
                    <label for="name">Product Name:</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="text" class="form-control" id="price" name="price">
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
                <div class="form-group">
                    <label for="rating">Rating:</label>
                    <input type="text" class="form-control" id="rating" name="rating">
                </div>
                <div class="form-group">
                    <label for="brand_id">Brand:</label>
                    <select class="form-control" id="brand_id" name="brand_id">
                        <?php foreach ($brands as $brand) : ?>
                            <option value="<?php echo $brand['b_id']; ?>"><?php echo $brand['b_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="image">Image:</label>
                    <input type="text" class="form-control" id="image" name="image">
                </div>
                <button type="submit" class="btn btn-primary">Insert Product</button>
                <?php if (isset($message)) : ?>
                    <div class="alert alert-success mt-3" role="alert"><?php echo $message; ?></div>
                <?php endif; ?>
            </form>
        </div>

    </main>
    <?php include 'footer.php'; ?>
</body>

</html>