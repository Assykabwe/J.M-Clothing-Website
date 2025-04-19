<?php
include_once '../Components/Connection.php';

if (isset($_COOKIE['Admin_ID'])) {
    $user_id = $_COOKIE['Admin_ID'];
} else {
    $user_id = '';
    header('location:login.php');
    exit();
}

$get_id = $_GET['post_id'];

if (isset($_POST['delete'])) {
    $p_id = $_POST['product_id'];
    $p_id = filter_var($p_id, FILTER_SANITIZE_STRING);

    $delete_image_query = "SELECT image FROM products WHERE id = '$p_id' AND Admin_ID = '$user_id'";
    $result = mysqli_query($conn, $delete_image_query);

    if ($result && mysqli_num_rows($result) > 0) {
        $fetch_delete_image = mysqli_fetch_assoc($result);
        if (!empty($fetch_delete_image['image'])) {
            unlink('../upload_files/' . $fetch_delete_image['image']);
        }

        $delete_product_query = "DELETE FROM products WHERE id = '$p_id' AND Admin_ID = '$user_id'";
        mysqli_query($conn, $delete_product_query);
    }
    header("location:view_product.php");
    exit();
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
    <title>Janette Bombo - Product Details</title>
</head>
<body>
    <div class="main-container">
        <?php include '../Components/admin_header.php'; ?>
        <section class="read-post">
            <div class="heading">
                <h1>Product Detail</h1>
                <img src="../Images/separator.avif" width="250" height="80">
            </div>
            <div class="box-container">
                <?php
                $select_product_query = "SELECT * FROM products WHERE id = '$get_id' AND Admin_ID = '$user_id'";
                $result = mysqli_query($conn, $select_product_query);

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($fetch_product = mysqli_fetch_assoc($result)) {
                ?>
                        <form method="post" class="box">
                            <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">
                            <div class="status" style="color: <?= ($fetch_product['status'] == 'active') ? 'limegreen' : 'coral'; ?>;">
                                <?= $fetch_product['status']; ?>
                            </div>
                            <?php if (!empty($fetch_product['image'])) { ?>
                                <img src="../upload_files/<?= $fetch_product['image']; ?>">
                            <?php } ?>
                            <div class="price">R<?= $fetch_product['price']; ?></div>
                            <div class="title"><?= $fetch_product['Name']; ?></div>
                            <div class="content"><?= $fetch_product['product_detail']; ?></div>

                            <!-- Size and Color -->
                            <div class="extra-info">
                                <p><strong>Size:</strong> <?= $fetch_product['size']; ?></p>
                                <p><strong>Color:</strong> <?= $fetch_product['color']; ?></p>
                            </div>

                            <div class="flex-btn">
                                <a href="edit_product.php?id=<?= $fetch_product['id']; ?>" class="btn">Edit</a>
                                <button type="submit" name="delete" class="btn" onclick="return confirm('Delete this product?');">Delete</button>
                                <a href="view_product.php?post_id=<?= $fetch_product['id']; ?>" class="btn">Go Back</a>
                            </div>
                        </form>
                <?php
                    }
                } else {
                    echo '<div class="empty"><p>No products added yet! <a href="add_products.php" class="btn">Add Products</a></p></div>';
                }
                ?>
            </div>
        </section>
    </div>
</body>
<?php include '../Components/alert.php'; ?>
</html>
