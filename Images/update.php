<?php
// Ensure this file is included only once
include_once '../Components/Connection.php';

if (isset($_COOKIE['Admin_ID'])) {
    $user_id = $_COOKIE['Admin_ID'];
} else {
    header('location:login.php');
    exit();
}

if (isset($_POST['submit'])) {
    // Fetch user profile
    $select_seller = $conn->prepare("SELECT * FROM Admin WHERE Admin_ID = ? LIMIT 1");
    $select_seller->bind_param("s", $user_id);
    $select_seller->execute();
    $result_seller = $select_seller->get_result();
    $fetch_seller = $result_seller->fetch_assoc();

    $prev_pass = isset($fetch_seller['password']) ? $fetch_seller['password'] : '';
    $prev_image = isset($fetch_seller['image']) ? $fetch_seller['image'] : '';

    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);

    // Update Name
    if (!empty($name)) {
        $update_name = $conn->prepare("UPDATE admin SET Name = ? WHERE Admin_ID = ?");
        $update_name->bind_param("ss", $name, $user_id);
        $update_name->execute();
        $success_msg[] = 'Username updated successfully';
    }

    // Update Email
    if (!empty($email)) {
        $select_email = $conn->prepare("SELECT * FROM admin WHERE Admin_ID = ? AND Email_Address = ?");
        $select_email->bind_param("ss", $user_id, $email);
        $select_email->execute();
        $result_email = $select_email->get_result();

        if ($result_email->num_rows > 0) {
            $warning_msg[] = 'Email already exists';
        } else {
            $update_email = $conn->prepare("UPDATE admin SET Email_Address = ? WHERE Admin_ID = ?");
            $update_email->bind_param("ss", $email, $user_id);
            $update_email->execute();
            $success_msg[] = 'Email updated successfully';
        }
    }

    // Update Image
    if (!empty($_FILES['image']['name'])) {
        $image = filter_var($_FILES['image']['name'], FILTER_SANITIZE_STRING);
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $rename = uniqid() . '.' . $ext;
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../upload_files/' . $rename;

        if ($image_size > 20000000) {
            $warning_msg[] = 'Image is too large';
        } else {
            $update_image = $conn->prepare("UPDATE admin SET image = ? WHERE Admin_ID = ?");
            $update_image->bind_param("ss", $rename, $user_id);
            $update_image->execute();
            move_uploaded_file($image_tmp_name, $image_folder);

            if (!empty($prev_image) && $prev_image != $rename) {
                unlink('../upload_files/' . $prev_image);
            }
            $success_msg[] = 'Image updated successfully';
        }
    }

    // Update Password
    $empty_pass = sha1('');
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);

    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);

    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    if (!empty($_POST['old_pass'])) {
        if ($old_pass != $prev_pass) {
            $warning_msg[] = 'Old password not matched';
        } elseif ($new_pass != $cpass) {
            $warning_msg[] = 'Passwords do not match';
        } else {
            if ($new_pass != $empty_pass) {
                $update_pass = $conn->prepare("UPDATE admin SET Password = ? WHERE Admin_ID = ?");
                $update_pass->bind_param("ss", $cpass, $user_id);
                $update_pass->execute();
                $success_msg[] = 'Password updated successfully';
            } else {
                $warning_msg[] = 'Please enter a new password!';
            }
        }
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
    <title>Janette Bombo - Update Profile Page</title>
</head>
<body>
    <div class="main-container">
        <?php include '../Components/admin_header.php'; ?>
        <section class="update-container">
            <div class="heading">
                <h1> Update Profile Details</h1>
                <img src="../Images/separator.avif" width="250" height="80">
            </div>
            <div class="form-container">
                <form action="" method="post" enctype="multipart/form-data" class="register">
                    <div class="img-box">
                    <img src="../upload_files/<?= htmlspecialchars($fetch_profile['Image']); ?>" alt="Update Image">
                    </div>
                    <div class="flex">
                        <div class="col">
                            <div class="input-field">
                                <p>your name <span>*</span></p>
                                <input type="text" name="name" placeholder="<?= $fetch_profile['Name']; ?>" class="box">
                            </div>
                            <div class="input-field">
                                <p>your email <span>*</span></p>
                                <input type="text" name="email" placeholder="<?= $fetch_profile['Email_Address']; ?>" class="box">
                            </div>
                            <div class="input-field">
                                <p>select picture<span>*</span></p>
                                <input type="file" name="image" accept="image/*" class="box">
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-field">
                                <p>old password <span>*</span></p>
                                <input type="password" name="old_pass" placeholder="enter your old password" class="box">
                             </div>
                             <div class="input-field">
                                 <p>new password <span>*</span></p>
                                 <input type="password" name="new_pass" placeholder="enter your new password" class="box">
                             </div>
                             <div class="input-field">
                                 <p>confirm your password <span>*</span></p>
                                 <input type="password" name="c_pass" placeholder="confirm your password" class="box">
                             </div>
                        </div>
                    </div>
                    <input type="submit" name="submit" value="Update Profile" class="btn">
                </form>
            </div>
    </section>
    </div>
</body>
<?php include '../Components/alert.php'; ?>
</html>
