<?php
include '../Components/Connection.php';

if (isset($_POST['submit'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['pass'];

    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Check admin table first
    $admin_stmt = $conn->prepare("SELECT Admin_ID, Password FROM admin WHERE Email_Address = ?");
    $admin_stmt->bind_param("s", $email);
    $admin_stmt->execute();
    $admin_result = $admin_stmt->get_result();

    if ($admin_result->num_rows > 0) {
        $admin = $admin_result->fetch_assoc();
        if (password_verify($password, $admin['Password'])) {
            setcookie('Admin_ID', $admin['Admin_ID'], time() + (60 * 60 * 24 * 30), '/');
            header("Location: ../Images/dashboard.php");
            exit();
        } else {
            $warning_msg = "Incorrect email or password.";
        }
    } else {
        // Check user table if not admin
        $user_stmt = $conn->prepare("SELECT User_ID, Password FROM users WHERE EmailAddress = ?");
        $user_stmt->bind_param("s", $email);
        $user_stmt->execute();
        $user_result = $user_stmt->get_result();

        if ($user_result->num_rows > 0) {
            $user = $user_result->fetch_assoc();
            if (password_verify($password, $user['Password'])) {
                setcookie('User_ID', $user['User_ID'], time() + (60 * 60 * 24 * 30), '/');
                header("Location: ../UsersPages/All.php");
                exit();
            } else {
                $warning_msg = "Incorrect email or password.";
            }
        } else {
            $warning_msg = "Email not found.";
        }
        $user_stmt->close();
    }
    $admin_stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Janette Bombom - Login Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
</head>
<body>
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="login">
            <h3>Login Now</h3>
            <?php if (isset($warning_msg)) { ?>
                <p style="color:red;"><?= $warning_msg; ?></p>
            <?php } ?>
            <div class="input-field">
                <p>Your Email Address <span>*</span></p>
                <input type="email" name="email" placeholder="Enter your email" maxlength="50" required class="box">
            </div>
            <div class="input-field">
                <p>Your Password <span>*</span></p>
                <input type="password" name="pass" placeholder="Enter your password" maxlength="50" required class="box">
            </div>
            <p class="link">Don't have an account? <a href="register.php">Register now</a></p>
            <input type="submit" name="submit" value="Login Now" class="btn">
        </form>
    </div>
    <script src="script.js"></script>
</body>
<?php include '../Components/alert.php'; ?>
</html>
