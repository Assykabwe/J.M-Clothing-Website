<?php
// Ensure this file is included only once
include_once '../Components/Connection.php';

if (isset($_COOKIE['User_ID'])) {
    $user_id = $_COOKIE['User_ID'];
} else {
    header('location:login.php');   
    exit(); // Stop further execution
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
    <title>Janette Bombo - Registered Users Page</title>
</head>
<body>

    <div class="main-container">
        <?php include '../Components/admin_header.php'; ?>
        <section class="user-container">
            <div class="heading">
                <h1>Registered Users</h1>
                <img src="../Images/separator.avif" width="250" height="80">
            </div>
            <div class="box-container">
                <?php
                    $select_users = "SELECT * FROM users";
                    $result_users = $conn->query($select_users);

                    if ($result_users->num_rows > 0) {
                        while ($fetch_users = $result_users->fetch_assoc()) {
                            $user_id = $fetch_users['User_ID'];
                ?>
                <div class="box">
                    <img src="../upload_files/<?= htmlspecialchars($fetch_users['image']); ?>" alt="User Image">
                    <p>User ID: <span><?= htmlspecialchars($user_id); ?></span></p>
                    <p>User Name: <span><?= htmlspecialchars($fetch_users['Name']); ?></span></p>
                    <p>User Email: <span><?= htmlspecialchars($fetch_users['EmailAddress']); ?></span></p>
                </div> 
                <?php           
                        }
                    } else {
                        echo '<div class="empty">
                                <p>No users yet!</p>
                              </div>';
                    }
                ?>
            </div>
        </section>
    </div>
</body>
<?php include '../Components/alert.php'; ?>

</html>
