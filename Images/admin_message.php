<?php
// Ensure this file is included only once
include_once '../Components/Connection.php';

if (isset($_COOKIE['Admin_ID'])) {
    $user_id = $_COOKIE['Admin_ID'];
} else {
    header('location:login.php');
    exit(); // Stop execution after redirect
}

// Delete message from database
if (isset($_POST['delete_msg'])) {
    $delete_id = $_POST['delete_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    // Verify message exists
    $verify_delete = $conn->prepare("SELECT * FROM message WHERE Message_ID = ?");
    $verify_delete->bind_param("i", $delete_id);
    $verify_delete->execute();
    $result_verify = $verify_delete->get_result();

    if ($result_verify->num_rows > 0) {
        $delete_msg = $conn->prepare("DELETE FROM message WHERE Message_ID = ?");
        $delete_msg->bind_param("i", $delete_id);
        $delete_msg->execute();
        $success_msg[] = 'Message deleted successfully!';
    } else {
        $warning_msg[] = 'Message already deleted!';
    }
}
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
    <title>Janette Bombo - Admin Dashboard</title>
</head>
<body>

    <div class="main-container">
        <?php include '../Components/admin_header.php'; ?>
        <section class="message-container">
            <div class="heading">
                <h1>Unread Messages</h1>
                <img src="../Images/separator.avif" width="250" height="80">
            </div>
            <div class="box-container">
                <?php
                    $select_message = "SELECT * FROM message";
                    $result_message = $conn->query($select_message);

                    if ($result_message->num_rows > 0) {
                        while ($fetch_message = $result_message->fetch_assoc()) {
                ?>
                <div class="box">
                    <h3 class="name"><?= htmlspecialchars($fetch_message['Name']); ?></h3>
                    <h4><?= htmlspecialchars($fetch_message['Subject']); ?></h4>
                    <p><?= htmlspecialchars($fetch_message['Message']); ?></p>
                    <form action="" method="post">
                        <input type="hidden" name="delete_id" value="<?= htmlspecialchars($fetch_message['Message_ID']); ?>">
                        <input type="submit" name="delete_msg" value="Delete Message" class="btn"  
                        onclick="return confirm('Are you sure you want to delete this message?');">
                    </form>
                </div>
                <?php            
                        }
                    } else {
                        echo '<div class="empty">
                                <p>No unread messages yet!</p>
                              </div>';
                    } 
                ?>
            </div>
        </section>
    </div>
</body>
<?php include '../Components/alert.php'; ?>
</html>
