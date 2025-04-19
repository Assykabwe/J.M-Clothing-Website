<?php
include_once '../Components/Connection.php';

$name = "Assy";
$email = "assykayiba3@gmail.com";
$password = "Assy@2025"; 
$image = "../upload_files/suntrack10.jpeg";

// Hash the password before storing it
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Check if admin already exists
$stmt = $conn->prepare("SELECT * FROM admin WHERE Email_Address = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Admin account already exists.";
} else {
    $insert = $conn->prepare("INSERT INTO admin (Name, Email_Address, Password, Image) VALUES (?, ?, ?, ?)");
    $insert->bind_param("ssss", $name, $email, $hashedPassword, $image);

    if ($insert->execute()) {
        echo "Admin account created successfully!";
    } else {
        echo "Error creating admin account: " . $conn->error;
    }
}

$stmt->close();
$conn->close();
?>
