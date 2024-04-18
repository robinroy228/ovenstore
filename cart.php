<?php
session_start();
function updateQuantity($product_id, $quantity)
{
    $_SESSION['cart'][$product_id]['quantity'] = $quantity;
}
function deleteItem($product_id)
{
    unset($_SESSION['cart'][$product_id]);
}
if (isset($_POST['action']) && isset($_POST['id'])) {
    $action = $_POST['action'];
    $product_id = $_POST['id'];

    if ($action === 'update' && isset($_POST['quantity'])) {
        $quantity = $_POST['quantity'];
        updateQuantity($product_id, $quantity);
    } elseif ($action === 'delete') {
        deleteItem($product_id);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'head.php'; ?>
</head>

<body class="cart-page">
    <?php include 'navbar.php'; ?>
    <h2 class="cart-heading">Shopping Cart</h2>
    <main>
        <section class="cart-container">
            <?php if (!empty($_SESSION['cart'])) : ?>
                <?php foreach ($_SESSION['cart'] as $product_id => $product) : ?>
                    <div class="cart-item">
                        <img src="./images/<?php echo $product['p_image']; ?>" alt="<?php echo $product['p_name']; ?>">
                        <div class="cart-details">
                            <h3><?php echo $product['p_name']; ?></h3>
                            <p><strong>Price:</strong> $<?php echo $product['p_price']; ?></p>
                            <p><strong>Total Price:</strong> $<?php echo $product['p_price'] * $product['quantity']; ?></p>
                            <!-- Form for updating quantity -->
                            <div class="row">
                                <form method="post">
                                    <label for="quantity_<?php echo $product_id; ?>">Quantity:</label>
                                    <input type="hidden" name="id" value="<?php echo $product_id; ?>">
                                    <input type="hidden" name="action" value="update">
                                    <button type="button" class="btn btn-secondary" onclick="decrementQuantity(<?php echo $product_id; ?>)">-</button>
                                    <input type="number" id="quantity_<?php echo $product_id; ?>" name="quantity" value="<?php echo $product['quantity']; ?>" min="1" max="999" readonly>
                                    <button type="button" class="btn btn-secondary" onclick="incrementQuantity(<?php echo $product_id; ?>)">+</button>
                                    <button type="submit" class="btn btn-primary m-2">Update Quantity</button>
                                </form>

                                <form method="post">
                                    <input type="hidden" name="id" value="<?php echo $product_id; ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <button type="submit" class="btn btn-danger m-2">Delete Item</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="text-right mt-3">
                    <a href="checkout.php" class="btn btn-primary btn-lg mr-2 m-3">Checkout</a>
                </div>
            <?php else : ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>
        </section>
    </main>
    <?php include 'footer.php'; ?>
    <script>
        function incrementQuantity(productId) {
            var input = document.getElementById('quantity_' + productId);
            var currentValue = parseInt(input.value);
            if (!isNaN(currentValue)) {
                input.value = currentValue + 1;
            }
        }

        function decrementQuantity(productId) {
            var input = document.getElementById('quantity_' + productId);
            var currentValue = parseInt(input.value);
            if (!isNaN(currentValue) && currentValue > 1) {
                input.value = currentValue - 1;
            }
        }
    </script>
</body>

</html>