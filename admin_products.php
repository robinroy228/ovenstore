<?php
session_start();
include './utils/db_connection.php';
$sql_brand = "SELECT * FROM tbl_brand";
$brand_response = $conn->query($sql_brand);

$filter_condition = "";

if (isset($_GET['brand']) && $_GET['brand'] != 'all') {
    $selected_brand = $_GET['brand']; // Corrected typo 'barnd' to 'brand'
    $filter_condition = "WHERE brand_id = $selected_brand";
}

$sql = "SELECT * FROM tbl_product $filter_condition";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'head.php'; ?>
</head>

<body class="pdt">
    <?php include 'admin_navbar.php'; ?>
    <main>
        <h2 class="pdt_h2">Ovens</h2>
        <form method="GET" action="" class="pdt_form">
            <label for="brand">Filter by Brand:</label>
            <select name="brand" id="brand" style="color:black;">
                <option value="all">All</option>
                <?php
                if ($brand_response->rowCount() > 0) { // Corrected variable name from $genre_response to $brand_response
                    while ($brand_row = $brand_response->fetch()) {
                        $selected = ($_GET['brand'] == $brand_row["b_id"]) ? 'selected' : '';
                        echo '<option value="' . $brand_row["b_id"] . '" ' . $selected . '>' . $brand_row["b_name"] . '</option>';
                    }
                }
                ?>
            </select>
            <button type="submit">Filter</button>
        </form>

        <section class="pdt_sec">
            <div class="gridview">
                <?php
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch()) {
                        echo '<div class="items">';
                        echo '<a href="admin_update_product.php?id=' . $row["p_id"] . '"><img src="./images/' . $row["p_image"] . '" alt="' . $row["p_name"] . '"></a>';

                        echo '<h4><strong>' . $row["p_name"] . '</strong></h4>';
                        echo '<p>';
                        echo $row["p_rating"] . '<br>';

                        echo 'Price: $' . $row["p_price"] . '<br>';


                        echo '</div>';
                    }
                } else {
                    echo "No ovens available.";
                }
                ?>
            </div>
        </section>

    </main>
    <?php include 'footer.php'; ?>

</body>

</html>