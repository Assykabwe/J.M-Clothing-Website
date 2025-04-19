<?php
// Ensure this file is included only once
include_once '../Components/Connection.php';

if (isset($_COOKIE['Admin_ID'])) {
    $user_id = $_COOKIE['Admin_ID'];
} else {
    header('location:login.php');
    exit();
}

// Fetch user profile
$select_profile = $conn->prepare("SELECT * FROM admin WHERE Admin_ID = ?");
$select_profile->bind_param("s", $user_id);
$select_profile->execute();
$result_profile = $select_profile->get_result();
$fetch_profile = $result_profile->fetch_assoc();

// Get total products
$select_products = $conn->prepare("SELECT COUNT(*) AS total FROM products WHERE Admin_ID = ?");
$select_products->bind_param("s", $user_id);
$select_products->execute();
$result_products = $select_products->get_result();
$row_products = $result_products->fetch_assoc();
$total_products = $row_products['total'];

// Get total orders
$select_orders = $conn->prepare("SELECT COUNT(*) AS total FROM orders WHERE Admin_ID = ?");
$select_orders->bind_param("s", $user_id);
$select_orders->execute();
$result_orders = $select_orders->get_result();
$row_orders = $result_orders->fetch_assoc();
$total_orders = $row_orders['total'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../Images/style.css">
    <link rel="stylesheet" href='https://unpkg.com/boxicons@2.1.2/css/boxicons.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../Images/script.js" defer></script>
    <title>Janette Bombo - User Profile Page</title>
</head>
<body>

    <div class="main-container">
        <?php include '../Components/admin_header.php'; ?>
        <section class="user-profile">
            <div class="heading">
                <h1>Profile Details</h1>
                <img src="../Images/separator.avif" width="250" height="80">
            </div>
            <div class="details">
                <div class="user">
                    <img src="../upload_files/<?= htmlspecialchars($fetch_profile['Image']); ?>" alt="User Image">
                    <h3 class="name"><?= htmlspecialchars($fetch_profile['Name']); ?></h3>
                    <span>User</span>
                    <a href="update.php" class="btn">Update Profile</a>
                </div>
                <div class="flex">
                    <div class="box">
                        <span><?= $total_products; ?></span>
                        <p>Total Products</p>
                        <a href="view_product.php" class="btn">View Products</a>
                    </div>
                    <div class="box">
                        <span><?= $total_orders; ?></span>
                        <p>Total Orders Placed</p>
                        <a href="admin_order.php" class="btn">View Orders</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
<?php include '../Components/alert.php'; ?>
</html>
