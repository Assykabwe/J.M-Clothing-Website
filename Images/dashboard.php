<?php
// Ensure this file is included only once
include_once '../Components/Connection.php';
if(isset($_COOKIE['Admin_ID'])){
    $user_id = $_COOKIE['Admin_ID'];
}else{
    $user_id = '';
    header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="with=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Images/style.css">
    <link rel="stylesheet" href='https://unpkg.com/boxicons@2.1.2/css/boxicons.css'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="../Images/script.js" defer></script>
    <title>Janette Bombo - Admin Dashboard page</title>
</head>
<body>
    <div class="main-container">
        <?php include '../Components/admin_header.php'; ?>
        <section class="dashboard">
            <div class="heading">
                <h1>dashboard</h1>
                <img src="../Images/separator.avif" width="250" height="80">
            </div>
            <div class="box-container">
                <div class="box">
                    <h3>Welcome!</h3>
                    <p><?= isset($fetch_profile['Name']) ? htmlspecialchars($fetch_profile['Name']) : 'Guest'; ?></p>
                    <a href="update.php" class="btn">Update Profile</a>
                </div>
                <div class="box">
                    <?php
                         $select_message = $conn->prepare("SELECT * FROM message");
                         $select_message->execute();
                         $result = $select_message->get_result(); // Fetch the result set
                         $number_of_msg = $result->num_rows;
                         // Close the prepared statement
                         $select_message->close();
                         ?>
                    <h3><?= $number_of_msg; ?></h3>
                    <p>Unread Message</p>
                    <a href="admin_message.php" class="btn">see message</a>
                </div>
                <div class="box">
                    <?php
                         $select_products = $conn->prepare("SELECT * FROM products WHERE Admin_ID = ?");
                         $select_products->bind_param("s", $user_id);
                         $select_products->execute();
                         $result_products = $select_products->get_result();
                         $number_of_products = $result_products->num_rows;
                         // Close the prepared statement
                         $select_products->close();
                         ?>
                    <h3><?= $number_of_products; ?></h3>
                    <p>Products Added</p>
                    <a href="add_products.php" class="btn">add product</a>
                </div>
                <div class="box">
                    <?php
                        // Prepare the statement
                        $select_active_products = $conn->prepare("SELECT * FROM products WHERE Admin_ID = ? AND status = ?");
                        $status = 'active';  // Define status variable

                        // Bind parameters
                        $select_active_products->bind_param("ss", $user_id, $status);
                        $select_active_products->execute();

                        // Get result
                        $result_active_products = $select_active_products->get_result();
                        $number_of_active_products = $result_active_products->num_rows;

                        // Free result and close statement
                        $result_active_products->free();
                        $select_active_products->close();
                    ?>
                    <h3><?= $number_of_active_products; ?></h3>
                    <p>Total Active Products</p>
                    <a href="view_product.php?status=active" class="btn">Active Products</a>
                </div>
                <div class="box">
                    <?php
                        $select_deactive_products = $conn->prepare("SELECT * FROM products WHERE Admin_ID = ? AND status = ?");
                        $status = 'deactived';
                        $select_deactive_products->bind_param("ss", $user_id, $status);  // Bind parameters
                        $select_deactive_products->execute();

                        $result_deactive = $select_deactive_products->get_result();  // Get result set
                        $number_of_deactive_products = $result_deactive->num_rows;

                        // Free result and close the statement
                        $result_deactive->free_result();
                        $select_deactive_products->close();
                        ?>
                        <h3><?= $number_of_deactive_products; ?></h3>
                        <p>Total Deactivated Products</p>
                        <a href="view_product.php?status=deasactive" class="btn">Deactivated Products</a>
                    </div>
                    <div class="box">
                        <?php
                            $select_users = $conn->prepare("SELECT * FROM users");
                            $select_users->execute();
                            $result_user = $select_users->get_result(); 
                            $number_of_users = $result_user->num_rows; 

                            $result_user->free(); 
                            $select_users->close(); // Close the statement
                        ?>
                        <h3><?= $number_of_users; ?></h3>
                        <p>Users Account</p>
                        <a href="user_accounts.php" class="btn">see users</a>
                    </div>

                    <div class="box">
                        <?php
                            $select_seller = $conn->prepare("SELECT * FROM admin");
                            $select_seller->execute();
                            $result_seller = $select_seller->get_result();
        
                            $number_of_seller = $result_seller->num_rows;

                            $result_seller->free_result();
                            $select_seller->close();
                        ?>
                        <h3><?= $number_of_seller; ?></h3>
                        <p>Admin Account</p>
                        <a href="admin_accounts.php" class="btn">see admin</a>
                    </div>
                    <div class="box">
                         <?php
                            $select_orders = $conn->prepare("SELECT * FROM orders WHERE Admin_ID = ?");
                            $select_orders->bind_param("s", $user_id);
                            $select_orders->execute();
                            $result_orders = $select_orders->get_result();
                            $number_of_orders = $select_orders->num_rows;

                            $result_orders->free_result();
                            $select_orders->close();
                         ?>
                         <h3><?= $number_of_orders; ?></h3>
                         <p>Total Orders Placed</p>
                         <a href="admin_order.php" class="btn">total orders</a>
                    </div>
                    <div class="box">
                         <?php
                            $select_confirm_orders = $conn->prepare("SELECT * FROM orders WHERE Admin_ID = ? AND status = ?");
                            $select_confirm_orders->execute([$user_id, 'in progress']);
                            $number_of_confirm_orders = $select_confirm_orders->num_rows();
                            $select_confirm_orders->close();
                         ?>
                         <h3><?= $number_of_confirm_orders; ?></h3>
                         <p>Total Confirm Orders</p>
                         <a href="admin_message.php" class="btn">confirm orders</a>
                    </div>
                    <div class="box">
                        <?php
                           $status = 'in progress';
                           $select_canceled_orders = $conn->prepare("SELECT * FROM orders WHERE Admin_ID = ? AND status = ?");
                           $select_canceled_orders->bind_param("ss", $user_id, $status);
                           $select_canceled_orders->execute();

                           // Store result to count the rows
                           $select_canceled_orders->store_result();
                           $number_of_canceled_orders = $select_canceled_orders->num_rows;

                           $select_canceled_orders->close();
                        ?>
                        <h3><?= $number_of_canceled_orders; ?></h3>
                        <p>Total Canceled Orders</p>
                        <a href="admin_message.php" class="btn">canceled orders</a>
                    </div>
            </div>
    </section>
    </div>
</body>
<?php include '../Components/alert.php'; ?>

</html>