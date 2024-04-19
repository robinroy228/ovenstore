<?php
include './utils/db_connection.php';
$sql = "SELECT * 
FROM tbl_product
ORDER BY p_rating DESC
LIMIT 4";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'head.php' ?>

<body>
    <!-- Navbar -->
    <?php include 'navbar.php' ?>
    <header>
        <div style="height: max-content;background-color: white;">
            <h1>BAKE.<span> GRILL </span>.TOAST</h1>
            <h3>FIND THE BEST OVENS <span>!</span></h3>
        </div>
    </header>

    <main>

        <div class="container mx-auto">
            <div class="text-center mx-auto" style="width: fit-content;">
                <p>Thank you for shopping with us. Please download the invoice.</p>
                <a href="./utils/invoice_generate.php"> <button class="btn btn-primary">Download Invoice</button> </a>
            </div>
        </div>
    </main>


    <?php include 'footer.php' ?>
</body>

</html>