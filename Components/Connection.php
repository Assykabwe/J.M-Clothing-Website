<?php

$servername = "localhost";
$dbname ="admin";
$db_user = "Assy";
$db_password = "AssyKabwe@16";

$conn = new mysqli($servername, $db_user, $db_password, $dbname);

// Prevent duplicate function declaration
if (!function_exists('unique_id')) {
    function unique_id() {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charLength = strlen($chars);
        $randomString = '';
        for ($i = 0; $i < 20; $i++) {
            $randomString .= $chars[mt_rand(0, $charLength - 1)];
        }
        return $randomString;
    }
}

?>