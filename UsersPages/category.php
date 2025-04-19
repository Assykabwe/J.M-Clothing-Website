<?php
    include_once '../Components/Connection.php';

    if(isset($_COOKIE['Admin_ID'])){
        $user_id = $_COOKIE['Admin_ID'];
    }else{
        $user_id = '';
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Styles/user_style.css?v=1.0">
    <link rel="stylesheet" type="text/css" href="../Styles/All_Products.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="../JS_Script/user_script.js" defer></script>
    <title>Janette Bombo - Category page</title>
</head>
<body>
    <?php include"../Components/user_header.php";?>
    <!----------Category-------------->
    <section class="shop">
        <div class="shop_header">
            <h2>shop by category</h2>
        </div>
        <div class="shop_category">
            <div class="box">
                <h3>women clothing</h3>
                <div class="box-content">
                    <a href="women.php" class="image-btn">
                        <i class="fa-solid fa-list"></i>
                        <p>view all</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CNewIn.avif" alt="Women Clothes">
                        <p>New In</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CDress.jpg" alt="Women Clothes">
                        <p>Dresses</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CTops.webp" alt="Women Clothes">
                        <p>Tops</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CDenin.jpg" alt="Women Clothes">
                        <p>Denin</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CPants.jpg" alt="Women Clothes">
                        <p>Pants</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CSkirts.jpg" alt="Women Clothes">
                        <p>Skirts</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CCoOrds.jpg" alt="Women Clothes">
                        <p>Co-ords</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CSuits.jpg" alt="Women Clothes">
                        <p>Suits</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CJumpsuits.webp" alt="Women Clothes">
                        <p>Jumpsuits & Bodysuits</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CJacket.avif" alt="Women Clothes">
                        <p>Jackets & Coats</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CShoes.jpg" alt="Women Clothes">
                        <p>Shoes</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CJewerlyAccessories.jpg" alt="Women Clothes">
                        <p>Jewelry & Accessories</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CBags.jpg" alt="Women Clothes">
                        <p>Bags</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CShorts.webp" alt="Women Clothes">
                        <p>Shorts</p>
                    </a>
                </div>
            </div>
            <div class="box">
                <h3>men clothing</h3>
                <div class="box-content">
                    <a href="men.php" class="image-btn">
                        <i class="fa-solid fa-list"></i>
                        <p>view all</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CMNewIn.jpg" alt="men Clothes">
                        <p>New In</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CMTops.webp" alt="men Clothes">
                        <p>Tops</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CMDenin.jpg" alt="men Clothes">
                        <p>Denin</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CMPants.webp" alt="men Clothes">
                        <p>Pants</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CMHoddies.png" alt="men Clothes">
                        <p>Hoddies</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CMCo-Ords.jpg" alt="men Clothes">
                        <p>Co-ords</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CMSuits.jpg" alt="men Clothes">
                        <p>Suits & Separates</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CMJumpsuits.jpg" alt="men Clothes">
                        <p>Jumpsuits & Overalls</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CMJacket.jpeg" alt="men Clothes">
                        <p>Jackets & Coats</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CMShoes.jpg" alt="men Clothes">
                        <p>Shoes</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CMJewerly&Accessories.jpg" alt="men Clothes">
                        <p>Jewelry & Accessories</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CMBags.jpg" alt="men Clothes">
                        <p>Bags</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CMShort.webp" alt="men Clothes">
                        <p>Shorts</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CMShirts.webp" alt="men Clothes">
                        <p>Shirts</p>
                    </a>
                </div>
            </div>
            <div class="box">
                <h3>kids clothing</h3>
                <div class="box-content">
                    <a href="kids.php" class="image-btn">
                        <i class="fa-solid fa-list"></i>
                        <p>view all</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CKNewIn.avif" alt="kids Clothes">
                        <p>New In</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CMTG1316.webp" alt="kids Clothes">
                        <p>Teen Girls (13-16 Yrs)</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CTWG812.jpg" alt="kids Clothes">
                        <p>Tween Girls (8-12 Yrs)</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CMYG37.jpg" alt="kids Clothes">
                        <p>Young Girls (3-7 Yrs)</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CBT1316.jpg" alt="kids Clothes">
                        <p>Teen Boys (13-16 Yrs)</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CTWG812.jpg" alt="kids Clothes">
                        <p>Tween Boys (8-12 Yrs)</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CKY37.webp" alt="kids Clothes">
                        <p>Young Boys (3-7 Yrs)</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CKShoes.avif" alt="kids Clothes">
                        <p>Shoes</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CKJewerly$Accessories.jpg" alt="kids Clothes">
                        <p>Kids Jewelry & Accessories</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CKBags.jpg" alt="kids Clothes">
                        <p>Bags</p>
                    </a>
                    <a href="All.php" class="image-btn">
                        <img src="../ImportImages/CKJacket.jpg" alt="kids Clothes">
                        <p>Jackets & Coats</p>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- All Products Section -->
    <section class="main-container">
        <div class="shop-post">
            <div class="box-container">
                <?php
                $select_products = $conn->prepare("SELECT * FROM products WHERE Admin_ID = ? AND status = 'active'");
                $select_products->bind_param("s", $user_id);
                $select_products->execute();
                $result = $select_products->get_result();

                if ($result->num_rows > 0) {
                    while ($fetch_products = $result->fetch_assoc()) {
                        ?>
                        <form action="" method="post" class="box">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_products['id']); ?>">

                            <?php if (!empty($fetch_products['image'])) : ?>
                                <!-- Make the image clickable to redirect to the product details page -->
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
                                    <a href="../UsersPages/See_All_Products.php"><i class="fa-solid fa-cart-plus"></i></a>
                                </div>
                            </div>
                        </form>
                        <?php
                    }
                } else {
                    echo '<div class="empty">
                            <p>No active products available! <br><a href="add_products.php" class="btn" style="margin-top: 1.5rem;">Add Products</a></p>
                        </div>';
                }

                $result->free_result();
                $select_products->close();
                ?>
            </div>
        </div>
    </section>
    <!-----------footer-------------------->
    <?php include '../Components/footer.php'; ?>
</body>
</html>