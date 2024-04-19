<nav class="navbar navbar-expand-lg navbar-light ">
    <a class="navbar-brand" href="admin_dashboard.php">
        <img src="./images/logo.jpeg" alt="Oven Store Icon" class="logo-img mr-2"> Oven Store
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="admin_dashboard.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin_add_product.php">Add Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin_update_product.php">Update Products</a>
            </li>
            <?php if (isset($_SESSION['u_id'])) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="./utils/u_logout.php">Logout</a>
                </li>
            <?php else : ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>