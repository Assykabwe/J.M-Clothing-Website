<?php
include_once '../Components/Connection.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Add this to check connection
} else {
    echo "Connected successfully!"; // If connected properly
}
if (isset($_COOKIE['Admin_ID'])) {
    $user_id = $_COOKIE['Admin_ID'];
} else {
    $user_id = '';
    echo "User ID not found in the cookie!<br>";
}

// Delete product
if (isset($_POST['delete'])) {
    $p_id = filter_var($_POST['product_id'], FILTER_SANITIZE_STRING);

    $delete_product = $conn->prepare("DELETE FROM products WHERE id = ?");
    $delete_product->bind_param("s", $p_id);
    $delete_product->execute();

    $success_msg[] = 'Product deleted successfully!';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Images/style.css">
    <link rel="stylesheet" href='https://unpkg.com/boxicons@2.1.2/css/boxicons.css'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="../Images/script.js" defer></script>
    <title>Show Products</title>
</head>
<body>

    <div class="main-container">
        <?php include '../Components/admin_header.php'; ?>

        <section class="shop-post">
            <div class="heading">
                <h1>Your Products</h1>
                <img src="../Images/separator.avif" width="250" height="80">
            </div>

            <div class="box-container">
                <?php
                // Fetch Products from the Database
                $select_products = $conn->prepare("SELECT * FROM products WHERE Admin_ID = ?");
                $select_products->bind_param("s", $user_id);
                $select_products->execute();
                $result = $select_products->get_result();
                if ($result->num_rows > 0) {
                    while ($fetch_products = $result->fetch_assoc()) {
                        ?>
                        <form action="" method="post" class="box">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_products['id']); ?>">

                            <?php if (!empty($fetch_products['image'])) { ?>
                                <img src="../upload_files/<?= htmlspecialchars($fetch_products['image']); ?>" class="image" alt="Product Image">
                            <?php } ?>

                            <div class="status" style="color: <?= $fetch_products['status'] == 'active' ? 'limegreen' : 'coral'; ?>">
                                <?= ucfirst($fetch_products['status']); ?>
                            </div>
                            <div class="price">R<?= number_format($fetch_products['price'], 2); ?></div>
                            <div class="content">
                                <div class="title"><?= htmlspecialchars($fetch_products['Name']); ?></div>
                                <div class="flex-btn">
                                    <a href="edit_product.php?id=<?= htmlspecialchars($fetch_products['id']); ?>" class="btn">Edit</a>
                                    <button type="submit" name="delete" class="btn" onclick="return confirm('Are you sure you want to delete this product?');">Delete</button>
                                    <a href="read_product.php?post_id=<?= htmlspecialchars($fetch_products['id']); ?>" class="btn">Read</a>
                                </div>
                            </div>
                        </form>
                        <?php
                    }
                } else {
                    echo '<div class="empty">
                            <p>No products added yet! <br><a href="add_products.php" class="btn" style="margin-top: 1.5rem;">Add Products</a></p>
                          </div>';
                }
                ?>
            </div>
        </section>
    </div>
</body>
<?php include '../Components/alert.php'; ?>
</html>
