<?php
include './utils/db_connection.php';
if (isset($_GET['message'])) {
    if ($_GET['message'] == 'added_to_cart') {
        $message = 'Product added to cart...';
    } else {
        $message = 'Product quantity updated...';
    }
} else
    $message = '';
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    // Fetch the product details from the database
    $sql = "SELECT * FROM tbl_product WHERE p_id = $product_id";
    $result = $conn->query($sql);

    // Check if the product exists
    if ($result->rowCount() > 0) {
        $product = $result->fetch();
    } else {
        header("Location: 404.php");
        exit();
    }
} else {
    header("Location: 404.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'head.php'; ?>

</head>

<body class="pdt">
    <?php include 'navbar.php'; ?>
    <h2 class="dtl_h2">Details</h2>
    <main>
        <section class="dtl_container">
            <div class="product-details">
                <div class="dtl_left">
                    <h2><?php echo $product['p_name']; ?></h2>

                    <p><strong>Description:</strong> <?php echo $product['p_desc']; ?></p>
                    <p><strong>Price:</strong> $<?php echo $product['p_price']; ?></p>
                    <p><strong>Rating:</strong> <?php echo $product['p_rating']; ?></p>
                    <a href="./utils/u_addToCart.php?id=<?php echo $product['p_id']; ?>"><button type="button" class="button1">Add to Cart</button></a>
                    <div id="message"><?php echo $message ?></div>
                </div>
                <div class="dtl_right">
                    <img src="./images/<?php echo $product['p_image']; ?>" alt="<?php echo $product['p_name']; ?>">

                </div>

            </div>

        </section>

    </main>
    <?php include 'footer.php'; ?>
</body>

</html>