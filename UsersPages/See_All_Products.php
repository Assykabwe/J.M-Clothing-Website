<?php
    include_once '../Components/Connection.php';

    // Get the product ID from the URL
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $product_id = $_GET['id'];

        // Prepare and execute the query to fetch product details
        $select_product = $conn->prepare("SELECT * FROM products WHERE id = ? AND status = 'active'");
        $select_product->bind_param("s", $product_id);
        $select_product->execute();

        $result = $select_product->get_result();
        $product = $result->fetch_assoc();

        // If no product found
        if (!$product) {
            echo '<p>Product not found or inactive.</p>';
            exit;
        }
    } else {
        echo '<p>Invalid product ID.</p>';
        exit;
    }

    // Close the prepared statement and result
    $result->free_result();
    $select_product->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Styles/user_style.css?v=1.0">
    <link rel="stylesheet" type="text/css" href="../Styles/All_Products.css?v=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="../JS_Script/user_script.js" defer></script>
</head>
<body>
    <?php include "../Components/user_header.php"; ?>

    <!-- Product Details Section -->
    <section class="product-detail">
        <div class="product-container">
            <div class="product-image">
                <?php if (!empty($product['image'])) : ?>
                    <img src="../upload_files/<?= htmlspecialchars($product['image']); ?>" alt="Product Image">
                <?php endif; ?>
            </div>
            <div class="product-info">
                <h1 class="product-title"><?= htmlspecialchars($product['Name']); ?></h1>
                <p class="product-description"><?= htmlspecialchars($product['product_detail']); ?></p>
                <div class="product-price">R<?= number_format($product['price'], 2); ?></div>
                <!-- Add to Cart Form -->
                <form method="post" action="../UsersPages/cart.php" class="product-options-form">
                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']); ?>">

                    <!-- Size Selection -->
                    <div class="product-size">
                        <strong>Select Size:</strong><br>
                        <?php 
                        $sizes = explode(',', $product['size']);
                        foreach ($sizes as $size) {
                            $size_trimmed = trim($size);
                            echo '<label class="option-label">
                                    <input type="radio" name="selected_size" value="' . htmlspecialchars($size_trimmed) . '" required>
                                    <span>' . htmlspecialchars($size_trimmed) . '</span>
                                </label>';
                        }
                        ?>
                    </div>

                    <!-- Color Selection -->
                    <div class="product-color">
                        <strong>Select Color:</strong><br>
                        <?php 
                        $colors = explode(',', $product['color']);
                        foreach ($colors as $color) {
                            $color_trimmed = trim($color);
                            echo '<label class="option-label">
                                    <input type="radio" name="selected_color" value="' . htmlspecialchars($color_trimmed) . '" required>
                                    <span>' . htmlspecialchars($color_trimmed) . '</span>
                                </label>';
                        }
                        ?>
                    </div>

                    <div class="add-to-cart">
                        <button type="submit" class="btn">Add to Cart</button>
                    </div>
                </form>
                <!-- Add to Whishlist Form -->
                <form method="post" action="../UsersPages/wishlist.php" style="display: inline;">
                    <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                    <button type="submit"><i class="fa-regular fa-heart"></i></button>
                </form>
            </div>
        </div>
    </section>
    
    <!-----------footer-------------------->
    <?php include '../Components/footer.php'; ?>
</body>
</html>

