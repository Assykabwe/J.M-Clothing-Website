<?php
    include_once '../Components/Connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Styles/user_style.css?v=1.0">
    <link rel="stylesheet" type="text/css" href="../Styles/All_Products.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="../JS_Script/user_script.js" defer></script>
</head>
<body>
    <?php include "../Components/user_header.php"; ?>

    <section class="main-container">
        <div class="shop-post">
            <div class="box-container">
                <?php
                $select_products = $conn->prepare("SELECT * FROM products WHERE status = 'active' AND Title = 'men'");
                $select_products->execute();
                $result = $select_products->get_result();

                if ($result->num_rows > 0) {
                    while ($fetch_products = $result->fetch_assoc()) {
                        ?>
                        <form action="" method="post" class="box">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_products['id']); ?>">

                            <?php if (!empty($fetch_products['image'])) : ?>
                                <a href="See_All_products.php?id=<?= htmlspecialchars($fetch_products['id']); ?>">
                                    <img src="../upload_files/<?= htmlspecialchars($fetch_products['image']); ?>" class="image" alt="Product Image">
                                </a>
                            <?php endif; ?>

                            <div class="info-row">
                                <span class="color">Color:
                                    <?php
                                    $colors = explode(',', $fetch_products['color']);
                                    foreach ($colors as $color) {
                                        $trimmed_color = trim($color);
                                        echo '<span class="color-swatch" title="' . htmlspecialchars($trimmed_color) . '" 
                                            style="background-color:' . htmlspecialchars($trimmed_color) . ';"></span>';
                                    }
                                    ?>
                                </span>
                            </div>

                            <div class="title">
                                <?= htmlspecialchars(strlen($fetch_products['product_detail']) > 30 
                                    ? substr($fetch_products['product_detail'], 0, 30) . '...'
                                    : $fetch_products['product_detail']); ?>
                            </div>

                            <div class="price-cart-row">
                                <div class="price">R<?= number_format($fetch_products['price'], 2); ?></div>
                                <div class="cartWhish">
                                    <i class="fa-solid fa-cart-plus"></i>
                                </div>
                            </div>
                        </form>
                        <?php
                    }
                } else {
                    echo '<div class="empty">
                            <p>No active women\'s products available! <br><a href="add_products.php" class="btn" style="margin-top: 1.5rem;">Add Products</a></p>
                        </div>';
                }

                $result->free_result();
                $select_products->close();
                ?>
            </div>
        </div>
    </section>

    <?php include '../Components/footer.php'; ?>
</body>
</html>
