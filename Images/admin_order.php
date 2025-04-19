<?php
// Ensure this file is included only once
include_once '../Components/Connection.php';
if (isset($_COOKIE['Admin_ID'])) {
    $user_id = $_COOKIE['Admin_ID'];
} else {
    $user_id = '';
    header('location:login.php');
}

//update order from database
if(isset($_POST['update_order'])){
    $order_id = $_POST['order_id'];
    $order_id = filter_id($order_id, FILTER_SANITIZE_STRING);

    $update_payement = $_POST['update_payment'];
    $update_payement = filter_var($update_payement, FILTER_SANITIZE_STRING);

    $update_pay = $conn->prepare("UPDATE orders SET Status = ? WHERE Oder_ID = ?");
    $update_pay->execute([$update_payement, $order_id]);
    $success_msg[] = 'order payment status updated';
}

//delete order
if(isset($_POST['delete_order'])){
    $delete_id = $_POST['order_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
     $verify_delete = $conn->prepare("SELECT * FROM orders WHERE Order_ID = ?");
     $verify_delete->execute([$delete_id]);
     
     if($verify_delete->num_rows() > 0){
        $delete_order = $conn->prepare("DELETE FROM orders WHERE Order_ID = ?");
        $delete_order->execute([$delete_id]);
        $success_msg[] = 'order deleted';
     }else{
        $warning_msg [] = 'order already deleted';
     }
     
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="with=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Images/style.css">
    <link rel="stylesheet" href='https://unpkg.com/boxicons@2.1.2/css/boxicons.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../Images/script.js" defer></script>
    <title>Janette Bombo - Admin Dashboard page</title>
</head>

<body>

    <div class="main-container">
        <?php include '../Components/admin_header.php'; ?>
        <section class="order-container">
            <div class="heading">
                <h1>total orders placed</h1>
                <img src="../Images/separator.avif" width="250" height="80">
            </div>
            <div class="box-container">
                <?php
                     $select_order = $conn->prepare("SELECT * FROM orders WHERE Admin_ID = ?");
                     $select_order->execute([$user_id]);

                     if($select_order->num_rows() > 0){
                        while($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)){
                ?>
                <div class="box">
                    <div class="status" style="color: <?php if($fetch_order['Status']=='in progress')
                    {echo "limegreen";}else{echo "red";} ?>"<?= $fetch_order['Status']; ?>>
                    </div>
                    <div class="details">
                        <p>user name: <span><?= $fetch_order['Name']; ?></span></p>
                        <p>user id: <span><?= $fetch_order['User_ID']; ?></span></p>
                        <p>placed on : <span><?= $fetch_order['Date']; ?></span></p>
                        <p>user number: <span><?= $fetch_order['Number']; ?></span></p>
                        <p>user email : <span><?= $fetch_order['EmailAddress']; ?></span></p>
                        <p>total price : <span><?= $fetch_order['Price']; ?></span></p>
                        <p>payment method : <span><?= $fetch_order['Methods']; ?></span></p>
                        <p>user address: <span><?= $fetch_order['Address']; ?></span></p>
                    </div>
                    <form action="" method="post">
                        <input type="hidden" name="order_id" value="<?= $fetch_order['Order_ID']; ?>">
                        <select name="update_payment" class="box" style="width: 90%;">
                            <option disabled selected><?= $fetch_order['Status']; ?></option>
                            <option value="pending">pending</option>
                            <option value="order delived">order delived</option>
                        </select>
                        <div class="flex-btn">
                            <input type="submit" name="update_order" value="update payment" class="btn">
                            <input type="submit" name="delete_order" value="delete order" class="btn" onclick="return confirm('delete this order');">
                        </div>
                    </form>
                </div>
                <?php            
                        }
                     }else{
                        echo '<div class="empty">
                            <p>No order placed yet!</p>
                          </div>';
                     }
                ?>
            </div>
        </section>
    </div>
</body>
<?php include '../Components/alert.php'; ?>

</html>