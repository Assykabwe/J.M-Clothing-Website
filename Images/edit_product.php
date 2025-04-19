
<?php
include_once '../Components/Connection.php';

if (isset($_COOKIE['Admin_ID'])) {
    $user_id = $_COOKIE['Admin_ID'];
} else {
    $user_id = '';
    header('location:login.php');
    exit();
}

// Update product
if (isset($_POST['update'])) {
    $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_STRING);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING); // Title field
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $stock = filter_var($_POST['stock'], FILTER_SANITIZE_NUMBER_INT);
    $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
    $size = filter_var($_POST['size'], FILTER_SANITIZE_STRING);
    $color = filter_var($_POST['color'], FILTER_SANITIZE_STRING);

    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("s", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $fetch_product = $result->fetch_assoc();

    $existing_title = $fetch_product['Title'];
    $existing_name = $fetch_product['Name'];
    $existing_price = $fetch_product['price'];
    $existing_stock = $fetch_product['stock'];
    $existing_description = $fetch_product['product_detail'];
    $existing_status = $fetch_product['status'];
    $existing_size = $fetch_product['size'];
    $existing_color = $fetch_product['color'];

    // Update status if changed
    if ($status !== $existing_status) {
        $stmt = $conn->prepare("UPDATE products SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $product_id);
        $stmt->execute();
        $success_msg[] = 'Product status updated successfully';
    }

    // Handle image upload
    $old_image = $_POST['old_image'];
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../upload_files/' . $image;

    if (!empty($image)) {
        if ($image_size > 2000000) {
            $warning_msg[] = 'Image size is too large';
        } else {
            $stmt = $conn->prepare("SELECT * FROM products WHERE image = ? AND Admin_ID = ?");
            $stmt->bind_param("ss", $image, $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $warning_msg[] = 'Please rename your image';
            } else {
                $stmt = $conn->prepare("UPDATE products SET image = ? WHERE id = ?");
                $stmt->bind_param("si", $image, $product_id);
                if ($stmt->execute()) {
                    move_uploaded_file($image_tmp_name, $image_folder);
                    if ($old_image != $image && $old_image != '') {
                        unlink('../upload_files/' . $old_image);
                    }
                    $success_msg[] = 'Image updated successfully';
                } else {
                    $error_msg[] = 'Error updating image: ' . $stmt->error;
                }
                $stmt->close();
            }
        }
    }

    // Update other fields if changed
    $update_query = "UPDATE products SET ";
    $params = [];
    $types = "";

    // Title update logic
    if ($title !== $existing_title) {
        $update_query .= "Title = ?, ";
        $params[] = $title;
        $types .= "s";
    }

    if ($name !== $existing_name) {
        $update_query .= "Name = ?, ";
        $params[] = $name;
        $types .= "s";
    }

    if ($price !== $existing_price) {
        $update_query .= "price = ?, ";
        $params[] = $price;
        $types .= "d";
    }

    if ($stock !== $existing_stock) {
        $update_query .= "stock = ?, ";
        $params[] = $stock;
        $types .= "i";
    }

    if ($description !== $existing_description) {
        $update_query .= "product_detail = ?, ";
        $params[] = $description;
        $types .= "s";
    }

    if ($size !== $existing_size) {
        $update_query .= "size = ?, ";
        $params[] = $size;
        $types .= "s";
    }

    if ($color !== $existing_color) {
        $update_query .= "color = ?, ";
        $params[] = $color;
        $types .= "s";
    }

    if (count($params) > 0) {
        $update_query = rtrim($update_query, ", ");
        $update_query .= " WHERE id = ?";
        $params[] = $product_id;
        $types .= "i";

        $stmt = $conn->prepare($update_query);
        $stmt->bind_param($types, ...$params);
        if ($stmt->execute()) {
            $success_msg[] = 'Product updated successfully';
        } else {
            $error_msg[] = 'Error updating product: ' . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../Images/style.css">
    <link rel="stylesheet" href='https://unpkg.com/boxicons@2.1.2/css/boxicons.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../Images/script.js" defer></script>
    <title>Janette Bombo - Edit Products</title>
</head>
<body>

<div class="main-container">
    <?php include '../Components/admin_header.php'; ?>
    <section class="edit_post">
        <div class="heading">
            <h1>edit product</h1>
            <img src="../Images/separator.avif" width="250" height="80">
        </div>
        <div class="box-container">
            <?php
            $product_id = $_GET['id'];
            $select_product = $conn->prepare("SELECT * FROM products WHERE id = ? AND Admin_ID = ?");
            $select_product->bind_param('ii', $product_id, $user_id);
            $select_product->execute();
            $result = $select_product->get_result();
            if ($result->num_rows > 0) {
                $fetch_product = $result->fetch_assoc();
            ?>
                <div class="form-container">
                    <form action="" method="post" enctype="multipart/form-data" class="register">
                            <input type="hidden" name="old_image" value="<?= $fetch_product['image']; ?>">
                            <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">

                            <!-- Title Input Field -->
                            <div class="input-field">
                                <p>product title <span>*</span></p>
                                <input type="text" name="title" value="<?= $fetch_product['Title']; ?>" class="box">
                            </div>

                            <div class="input-field">
                                <p>product status <span>*</span></p>
                                <select name="status" class="box">
                                    <option value="<?= $fetch_product['status']; ?>" selected><?= $fetch_product['status']; ?></option>
                                    <option value="active">active</option>
                                    <option value="deactived">deactived</option>
                                </select>
                            </div>

                            <div class="input-field">
                                <p>product name <span>*</span></p>
                                <input type="text" name="name" value="<?= $fetch_product['Name']; ?>" class="box">
                            </div>

                            <div class="input-field">
                                <p>product price <span>*</span></p>
                                <input type="number" name="price" value="<?= $fetch_product['price']; ?>" class="box">
                            </div>

                            <div class="input-field">
                                <p>product stock <span>*</span></p>
                                <input type="number" name="stock" value="<?= $fetch_product['stock']; ?>" class="box">
                            </div>

                            <div class="input-field">
                                <p>product size <span>*</span></p>
                                <input type="text" name="size" value="<?= $fetch_product['size']; ?>" class="box">
                            </div>

                            <div class="input-field">
                                <p>product color <span>*</span></p>
                                <input type="text" name="color" value="<?= $fetch_product['color']; ?>" class="box">
                            </div>

                            <div class="input-field">
                                <p>product description <span>*</span></p>
                                <textarea name="description" class="box"><?= $fetch_product['product_detail']; ?></textarea>
                            </div>

                            <div class="input-field">
                                <p>product image</p>
                                <input type="file" name="image" accept="image/*" class="box">
                                <?php if ($fetch_product['image'] != '') { ?>
                                    <img src="../upload_files/<?= $fetch_product['image']; ?>" class="image">
                                    <div class="flex-btn">
                                        <input type="submit" name="delete_image" class="btn" value="delete image">
                                        <a href="view_product.php" class="btn">go back</a>
                                    </div>
                                <?php } ?>
                            </div>

                            <br><br>
                            <div class="flex-btn">
                                <input type="submit" name="update" value="update product" class="btn">
                                <input type="submit" name="delete_product" value="delete product" class="btn">
                            </div>
                        </form>
                </div>
            <?php
            } else {
                echo '<div class="empty"><p>No product found!</p></div>';
            ?>
                <div class="flex-btn">
                    <a href="view_product.php" class="btn">view product</a>
                    <a href="add_products.php" class="btn">add product</a>
                </div>
            <?php } ?>
        </div>
    </section>
</div>

</body>
<?php include '../Components/alert.php'; ?>
</html>
