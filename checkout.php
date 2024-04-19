<?php
session_start();
if (!isset($_SESSION["u_id"])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<?php include 'head.php' ?>

<body>
    <?php include 'navbar.php' ?>
    <main>
        <div class="checkout-container mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="mb-4">Checkout</h2>
                    <?php if (isset($_SESSION['checkout_errors']) && !empty($_SESSION['checkout_errors'])) : ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach ($_SESSION['checkout_errors'] as $error) : ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php unset($_SESSION['checkout_errors']); ?>
                    <?php endif; ?>
                    <form id="checkoutForm" action="./utils/u_process_checkout.php" method="POST">
                        <!-- Shipping Details -->
                        <h4>Shipping Details</h4>
                        <div class="form-group">
                            <label for="fullName">Full Name:</label>
                            <input type="text" class="form-control" id="fullName" name="fullName" value="<?php echo isset($_SESSION['fullName']) ? $_SESSION['fullName'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="phoneNumber">Phone Number:</label>
                            <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" value="<?php echo isset($_SESSION['phoneNumber']) ? $_SESSION['phoneNumber'] : ''; ?>" required>
                        </div>
                        <!-- Payment Details -->
                        <h4 class="mt-4">Payment Details</h4>
                        <div class="form-group">
                            <label for="cardName">Cardholder's Name:</label>
                            <input type="text" class="form-control" id="cardName" name="cardName" value="<?php echo isset($_SESSION['cardName']) ? $_SESSION['cardName'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="cardNumber">Card Number:</label>
                            <input type="text" class="form-control" id="cardNumber" name="cardNumber" value="<?php echo isset($_SESSION['cardNumber']) ? $_SESSION['cardNumber'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="expiryDate">Expiry Date (MMYY):</label>
                            <input type="text" class="form-control" id="expiryDate" name="expiryDate" placeholder="MMYY" value="<?php echo isset($_SESSION['expiryDate']) ? $_SESSION['expiryDate'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="cvv">CVV:</label>
                            <input type="text" class="form-control" id="cvv" name="cvv" value="<?php echo isset($_SESSION['cvv']) ? $_SESSION['cvv'] : ''; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-4">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php include 'footer.php' ?>
</body>

</html>