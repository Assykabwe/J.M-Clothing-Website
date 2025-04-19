<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once '../Components/Connection.php';

// Cart count
$cart_count = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cart_count += $item['quantity'];
    }
}

// Wishlist count
$wishlist_count = 0;
if ($user_id) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM whishlist WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($wishlist_count);
    $stmt->fetch();
    $stmt->close();
} elseif (!empty($_SESSION['wishlist'])) {
    $wishlist_count = count($_SESSION['wishlist']);
}
?>

<header class="header">
    <section class="flex">
        <a href="All.php" class="logo"><img src="../Images/BackgroundLogo.jpg" width="100"></a>
        <?php $current_page = basename($_SERVER['PHP_SELF']); ?>
        <nav class="navbar">
            <a href="All.php" class="<?= ($current_page === 'All.php') ? 'active' : '' ?>">all</a>
            <a href="women.php" class="<?= ($current_page === 'women.php') ? 'active' : '' ?>">women</a>
            <a href="men.php" class="<?= ($current_page === 'men.php') ? 'active' : '' ?>">men</a>
            <a href="kids.php" class="<?= ($current_page === 'kids.php') ? 'active' : '' ?>">kids</a>
            <a href="bags.php" class="<?= ($current_page === 'bags.php') ? 'active' : '' ?>">bags</a>
            <a href="shoes.php" class="<?= ($current_page === 'shoes.php') ? 'active' : '' ?>">shoes</a>
            <a href="JewerlyAccessories.php" class="<?= ($current_page === 'JewerlyAccessories.php') ? 'active' : '' ?>">jewerly & Accessories</a>
        </nav>

        <form action="" method="post" class="search-form">
            <input type="text" name="search_product" placeholder="search product..." required maxlength="100">
            <button type="submit" class="bx bx-search-alt-2" id="search_product_btn"></button>
        </form>

        <div class="icons">
            <div class="bx bx-list-plus" id="menu-btn"></div>
            <div class="bx bx-search-alt-2" id="search-btn"></div>
            <!-- Wishlist with Count -->
            <a href="wishlist.php" class="icon-link">
                <i class="bx bx-heart"></i>
                <?php if ($wishlist_count > 0): ?>
                    <sup><?= $wishlist_count; ?></sup>
                <?php endif; ?>
            </a>

            <!-- Cart with Count -->
            <a href="cart.php" class="icon-link">
                <i class="bx bx-cart"></i>
                <?php if ($cart_count > 0): ?>
                    <sup><?= $cart_count; ?></sup>
                <?php endif; ?>
            </a>
            <div class="bx bxs-user" id="user-btn"></div>
        </div>

        <div class="profile-detail">
            <?php
                if (!empty($user_id)) {
                    $select_profile = $conn->prepare("SELECT * FROM users WHERE User_ID = ?");
                    $select_profile->bind_param("s", $user_id);
                    $select_profile->execute();
                    $result = $select_profile->get_result();

                    if ($result->num_rows > 0) {
                        $fetch_profile = $result->fetch_assoc();
            ?>
                <img src="../upload_files/<?= htmlspecialchars($fetch_profile['image']); ?>">
                <h3 style="margin-bottom: 1rem;"><?= htmlspecialchars($fetch_profile['Name']); ?></h3>
                <div class="flex-btn">
                    <a href="../Images/profile.php" class="btn">view profile</a>
                    <a href="../Components/user_logout.php" onclick="return confirm('logout from this website');" class="btn">logout</a>
                </div>
            <?php 
                    } else {
            ?>
                <h3 style="margin-bottom: 1rem;">please login or register</h3>
                <div class="flex-btn">
                    <a href="../Images/login.php" class="btn">login</a>
                    <a href="../Images/register.php" class="btn">register</a>
                </div>
            <?php 
                    }

                    // Free result and close statement
                    $result->free_result();
                    $select_profile->close();
                } else {
            ?>
                <h3 style="margin-bottom: 1rem;">please login or register</h3>
                <div class="flex-btn">
                    <a href="../Images/login.php" class="btn">login</a>
                    <a href="../Images/register.php" class="btn">register</a>
                </div>
            <?php 
                }
            ?>
        </div>
    </section>
</header>
