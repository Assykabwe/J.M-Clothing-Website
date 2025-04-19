<?php
include_once '../Components/Connection.php';

// Redirect to login page if Admin_ID is not in the cookie
if (!isset($_COOKIE['Admin_ID'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_COOKIE['Admin_ID'];

if (!function_exists('unique_id')) {
    function unique_id() {
        return uniqid('prod_', true);
    }
}

function add_product($user_id, $title, $name, $price, $description, $stock, $status, $image, $size, $color, $category) {
    global $conn;

    $id = unique_id();
    $image_folder = '../upload_files/' . $image;

    $select_image = $conn->prepare("SELECT * FROM products WHERE image = ? AND Admin_ID = ?");
    $select_image->bind_param("ss", $image, $user_id);
    $select_image->execute();
    $select_image->store_result();

    if ($select_image->num_rows > 0) {
        return 'Image name is repeated. Please rename your image.';
    } elseif ($_FILES['image']['size'] > 2000000) {
        return 'Image size is too large. Maximum allowed is 2MB.';
    } else {
        move_uploaded_file($_FILES['image']['tmp_name'], $image_folder);

        if ($status != 'active' && $status != 'deactive') {
            $status = 'pending';
        }

        $insert_product = $conn->prepare("INSERT INTO products 
            (id, Admin_ID, Title, name, price, image, stock, product_detail, status, size, color, category)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert_product->bind_param("ssssdsdsssss", $id, $user_id, $title, $name, $price, $image, $stock, $description, $status, $size, $color, $category);
        $insert_product->execute();

        return 'Product added successfully! The status is set to pending until approved.';
    }

    $select_image->close();
}

if (isset($_POST['publish']) || isset($_POST['draft'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $stock = filter_var($_POST['stock'], FILTER_SANITIZE_NUMBER_INT);
    $size = filter_var($_POST['size'], FILTER_SANITIZE_STRING);
    $color = filter_var($_POST['color'], FILTER_SANITIZE_STRING);
    $category = filter_var($_POST['category'], FILTER_SANITIZE_STRING);

    $status = isset($_POST['publish']) ? 'active' : (isset($_POST['draft']) ? 'deactive' : 'pending');

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);

    if ($title && $name && $price && $description && $stock && $image && $size && $color && $category) {
        $msg = add_product($user_id, $title, $name, $price, $description, $stock, $status, $image, $size, $color, $category);
        if (strpos($msg, 'successfully') !== false) {
            $success_msg[] = $msg;
        } else {
            $error_msg[] = $msg;
        }
    } else {
        $warning_msg[] = 'Please fill in all required fields.';
    }
}

include '../Components/alert.php';
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
    <title>Add Product - Admin</title>
</head>
<body>
    <div class="main-container">
        <?php include '../Components/admin_header.php'; ?>
        <section class="post_editor">
            <div class="heading">
                <h1>Add Product</h1>
                <img src="../Images/separator.avif" width="250" height="80">
            </div>

            <div class="form-container">
                <form action="" method="post" enctype="multipart/form-data" class="register">
                    <div class="input-field">
                        <p>Product Title <span>*</span></p>
                        <input type="text" name="title" maxlength="100" placeholder="Enter product title" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Product Name <span>*</span></p>
                        <input type="text" name="name" maxlength="100" placeholder="Enter product name" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Product Price <span>*</span></p>
                        <input type="number" name="price" step="0.01" min="0" placeholder="Enter product price" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Product Detail <span>*</span></p>
                        <textarea name="description" maxlength="1000" placeholder="Enter product details" required class="box"></textarea>
                    </div>
                    <div class="input-field">
                        <p>Stock Quantity <span>*</span></p>
                        <input type="number" name="stock" min="1" placeholder="Enter stock quantity" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Category <span>*</span></p>
                        <select name="category" id="category" required class="box" onchange="adjustSizePlaceholder()">
                            <option value="">Select Category</option>
                            <option value="Clothes">Clothes</option>
                            <option value="Shoes">Shoes</option>
                            <option value="Kids">Kids</option>
                            <option value="Jewelry and Accessories">Jewelry and Accessories</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <p>Available Sizes <span>*</span></p>
                        <input type="text" name="size" id="size" placeholder="Select category first" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Available Colours <span>*</span></p>
                        <input type="text" name="color" placeholder="e.g. Red, Blue, Black" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Product Image <span>*</span></p>
                        <input type="file" name="image" accept="image/*" required class="box">
                    </div>
                    <div class="flex-btn">
                        <input type="submit" name="publish" value="Add Product" class="btn">
                        <input type="submit" name="draft" value="Save as Draft" class="btn">
                    </div>
                </form>
            </div>
        </section>
    </div>
    <script>
        function adjustSizePlaceholder() {
            const category = document.getElementById('category').value;
            const sizeInput = document.getElementById('size');

            switch (category) {
                case "Clothes":
                    sizeInput.placeholder = "e.g. S, M, L, XL";
                    break;
                case "Shoes":
                    sizeInput.placeholder = "e.g. 6, 7, 8, 9";
                    break;
                case "Kids":
                    sizeInput.placeholder = "e.g. S, M, L or 2, 3, 4";
                    break;
                case "Jewelry and Accessories":
                    sizeInput.placeholder = "e.g. One Size, Adjustable, M";
                    break;
                default:
                    sizeInput.placeholder = "Select category first";
            }
        }
    </script>
</body>
<?php include '../Components/alert.php'; ?>
</html>
