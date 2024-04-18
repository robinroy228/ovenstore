<?php
session_start();
require_once "./utils/db_connection.php";

// Check if user is logged in
if (!isset($_SESSION["u_id"])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Fetch orders made by the user from the database
$stmt = $conn->prepare("SELECT order_id,order_group_id, order_date FROM tbl_orders WHERE u_id = :u_id GROUP BY order_group_id");
$stmt->bindParam(":u_id", $_SESSION["u_id"]);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    header("Location: account.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'head.php'; ?>

</head>

<body>
    <?php include 'navbar.php'; ?>
    <main>
        <div class="account-container mx-auto m-4">
            <h3>User Profile Details</h3>
            <form method="post">
                <div class="form-group">
                    <label for="customer_name">Customer Name:</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?php echo $userDetails['customer_name']; ?>">
                </div>
                <div class="form-group">
                    <label for="customer_email">Email:</label>
                    <input type="email" class="form-control" id="customer_email" name="customer_email" value="<?php echo $userDetails['customer_email']; ?>">
                </div>
                <div class="form-group">
                    <label for="mobile_number">Phone Number:</label>
                    <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?php echo $userDetails['mobile_number']; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
        <div class="account-container mx-auto m-4">
            <h3>Order Details</h3>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order) : ?>
                            <tr>
                                <td><?php echo $order['order_id']; ?></td>
                                <td><?php echo $order['order_date']; ?></td>
                                <td><a href="./utils/invoice_generate.php?order_id=<?php echo $order['order_group_id']; ?>" class="btn btn-primary">View Invoice</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>

</html>