<?php
    include '../Components/Connection.php'; 
    session_start();

    // Check if user is logged in
    if (isset($_SESSION['Admin_ID'])) {
        $user_id = $_SESSION['Admin_ID'];
    } elseif (isset($_COOKIE['Admin_ID'])) {
        $user_id = $_COOKIE['Admin_ID'];
    } else {
        $user_id = null;
    }

    $fetch_profile = null;
    if ($user_id) {
        $select_profile = $conn->prepare("SELECT * FROM admin WHERE Admin_ID = ?");
        $select_profile->bind_param("s", $user_id);
        $select_profile->execute();
        $result = $select_profile->get_result();

        if ($result->num_rows > 0) {
            $fetch_profile = $result->fetch_assoc();
        }

        $select_profile->close();
    }
?>
<header>
    <div class="logo">
        <img src="../Images/BackgroundLogo.jpg" width="100">
    </div>
    <div class="right">
        <div><i class="fa-solid fa-user" id="user-btn"></i></div>
        <div><i class="fa-solid fa-bars"></i></div>
    </div>
    <div class="profile-detail">
        <?php if ($fetch_profile): ?>
        <div class="profile">
        <img src="../upload_files/<?= htmlspecialchars($fetch_profile['Image']); ?>" class="logo-img" width="80" height="80" onerror="this.onerror=null; this.src='../Images/default-profile.png';">
            <p><?= htmlspecialchars($fetch_profile['Name']); ?></p>
            <div class="flex-btn">
                <a href="profile.php" class="btn">Profile</a>
                <a href="../Images/admin_logout.php" onclick="return confirm('Logout from this website?');" class="btn">Logout</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</header>
<div class="sidebar-container">
    <div class="sidebar">
        <?php
        if ($user_id) {
            $select_profile = $conn->prepare("SELECT * FROM admin WHERE Admin_ID = ?");
            $select_profile->bind_param("s", $user_id);
            $select_profile->execute();
            $result = $select_profile->get_result();

            if ($result->num_rows > 0) {
                $fetch_profile = $result->fetch_assoc();
        ?>
                <div class="profile">
                    <img src="../upload_files/<?= htmlspecialchars($fetch_profile['Image']); ?>" class="logo-img" width="80">
                    <p><?= htmlspecialchars($fetch_profile['Name']); ?></p>
                </div>
        <?php
            }
            $select_profile->close();
        }
        ?>
        <h5>Menu</h5>
        <div class="navbar">
            <ul>
                <li><a href="dashboard.php"><i class="bx bxs-home-smile"></i> Dashboard</a></li>
                <li><a href="add_products.php"><i class="bx bxs-shopping-bags"></i> Add Products</a></li>
                <li><a href="view_product.php"><i class="bx bxs-food-menu"></i> View Products</a></li>
                <li><a href="user_accounts.php"><i class="bx bxs-user-detail"></i> Accounts</a></li>
                <li><a href="../Images/admin_logout.php" onclick="return confirm('Logout from this website?');">
                <i class="bx bx-log-out"></i>Logout</a></li>
            </ul>
        </div>
        <h5>Find Us</h5>
        <div class="social-links">
            <i class="bx bxl-facebook"></i>
            <i class="bx bxl-instagram-alt"></i>
            <i class="bx bxl-twitter"></i>
            <i class="bx bxl-whatsapp"></i>
        </div>
    </div>
</div>
