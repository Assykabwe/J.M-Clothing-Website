<?php
    include '../Components/Connection.php';

    if (isset($_POST['submit'])) {
        $id = unique_id();
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
        $password = $_POST['pass'];
        $confirm_password = $_POST['cpass'];
    
        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $rename = unique_id() . '.' . $ext;
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../upload_files/' . $rename;
    
        $select_user = $conn->prepare("SELECT * FROM users WHERE EmailAddress = ?");
        $select_user->bind_param("s", $email);
        $select_user->execute();
        $result = $select_user->get_result();
    
        if ($result->num_rows > 0) {
            $warning_msg[] = 'Email already exists!';
        } else {
            if ($password !== $confirm_password) {
                $warning_msg[] = 'Confirm password does not match!';
            } else {
                // Hash the password AFTER validation
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
                $insert_user = $conn->prepare("INSERT INTO users (User_ID, Name, EmailAddress, Password, image) VALUES (?, ?, ?, ?, ?)");
                $insert_user->bind_param("sssss", $id, $name, $email, $hashed_password, $rename);
    
                if ($insert_user->execute()) {
                    move_uploaded_file($image_tmp_name, $image_folder);
                    $success_msg[] = 'New customer registered! Please log in now.';
                } else {
                    $error_msg[] = 'Registration failed, please try again!';
                }
    
                $insert_user->close();
            }
        }
    
        $select_user->close();
        $conn->close();
    }
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Janette Bombom - registration page</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
</head>
<body>
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="register">
            <h3>regidter now</h3>
              <div class="flex">
                <div class="col">
                    <div class="input-field">
                        <p>your full name <span>*</span></p>
                        <input type="text" name="name" placeholder="enter your name" maxlength="50" required class="box">
                    </div>
                    <div class="input-field">
                        <p>your email address <span>*</span></p>
                        <input type="email" name="email" placeholder="enter your email" maxlength="50" required class="box">
                    </div>
                </div>
                <div class="col">
                    <div class="input-field">
                        <p>your password <span>*</span></p>
                        <input type="password" name="pass" placeholder="enter your password" maxlength="50" required class="box">
                    </div>
                    <div class="input-field">
                        <p>confirm password <span>*</span></p>
                        <input type="password" name="cpass" placeholder="confirm your password" maxlength="50" required class="box">
                    </div>
                </div>
            </div>
            <div class="input-field">
                <p>your profile <span>*</span></p>
                <input type="file" name="image" accept="image/*" required class="box">
            </div>
            <p class="link">alrealdy have an account? <a href="login.php">login now</a></p>
            <input type="submit" name="submit" value="register now" class="btn">
        </form>
    </div>
    <script src="script.js"></script>
</body>
<?php include '../Components/alert.php'; ?>
</html>