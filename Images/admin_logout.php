<?php
    
    include 'Connection.php';

    setcookie('Admin_ID', '', time() -1, '/');
    header('location: ../Images/login.php');
    exit();
?>