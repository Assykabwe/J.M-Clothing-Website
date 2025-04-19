<?php
session_start();
include_once '../Components/Connection.php';

// Initialize cart session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle adding item to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $size = $_POST['selected_size'] ?? '';
    $color = $_POST['selected_color'] ?? '';

    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $product_id && $item['size'] == $size && $item['color'] == $color) {
            $item['quantity']++;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $product_id,
            'size' => $size,
            'color' => $color,
            'quantity' => 1
        ];
    }
    header('Location: cart.php');
    exit;
}

// Handle remove and update
if (isset($_GET['remove'])) {
    $index = $_GET['remove'];
    unset($_SESSION['cart'][$index]);
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    header('Location: cart.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_quantity'])) {
    $index = $_POST['index'];
    $new_qty = max(1, intval($_POST['quantity']));
    $_SESSION['cart'][$index]['quantity'] = $new_qty;
    header('Location: cart.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_options'])) {
    $index = $_POST['index'];
    $new_size = $_POST['selected_size'];
    $new_color = $_POST['selected_color'];

    if (isset($_SESSION['cart'][$index])) {
        // Check if an item with the same new options already exists
        $duplicate = false;
        foreach ($_SESSION['cart'] as $i => $item) {
            if ($i != $index && $item['id'] === $_SESSION['cart'][$index]['id'] &&
                $item['size'] === $new_size && $item['color'] === $new_color) {
                $_SESSION['cart'][$i]['quantity'] += $_SESSION['cart'][$index]['quantity'];
                unset($_SESSION['cart'][$index]);
                $_SESSION['cart'] = array_values($_SESSION['cart']);
                $duplicate = true;
                break;
            }
        }
        if (!$duplicate) {
            $_SESSION['cart'][$index]['size'] = $new_size;
            $_SESSION['cart'][$index]['color'] = $new_color;
        }
    }
    header('Location: cart.php');
    exit;
}

// Fetch cart items
$cart_items = [];
$total = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $index => $cart_item) {
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("s", $cart_item['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $row['selected_size'] = $cart_item['size'];
            $row['selected_color'] = $cart_item['color'];
            $row['quantity'] = $cart_item['quantity'];
            $row['index'] = $index;
            $row['subtotal'] = $row['price'] * $cart_item['quantity'];
            $total += $row['subtotal'];
            $cart_items[] = $row;
        }
        $stmt->close();
    }
}
// total number of all item
$total_quantity = 0;
foreach ($cart_items as $item) {
    $total_quantity += $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your Cart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Styles/user_style.css?v=1.0">
    <link rel="stylesheet" type="text/css" href="../Styles/All_Products.css?v=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="../JS_Script/user_script.js" defer></script>
</head>
<body>
    <?php include '../Components/user_header.php'; ?>
    <section class="cart-container">
        <div class="select">
            <div class="item">
                <input type="checkbox" class="item-select-all" id="select-all">
            </div>
            <div class="item">
                <h1>ALL ITEMS (<?= $total_quantity; ?>)</h1>
            </div>
        </div>
        <?php if (empty($cart_items)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <?php foreach ($cart_items as $item): ?>
                <div class="cart-item">
                    <input type="checkbox" class="item-select" data-price="<?= $item['subtotal']; ?>">
                    <img src="../upload_files/<?= htmlspecialchars($item['image']); ?>" alt="Product Image">
                    <div class="cart-item-details">
                        <h3><?= htmlspecialchars($item['product_detail']); ?></h3>
                        <p class="product-options">
                            <a href="see_all_products.php?id=<?= $item['id']; ?>">
                                <?= htmlspecialchars($item['selected_size']); ?> | <?= htmlspecialchars($item['selected_color']); ?>
                            </a>
                        </p>
                        <form method="post" class="update-options-form">
                            <input type="hidden" name="update_options" value="1">
                            <input type="hidden" name="index" value="<?= $item['index']; ?>">
                            <select name="selected_size" required>
                                <option value="">Size</option>
                                <option value="Small" <?= $item['selected_size'] === 'Small' ? 'selected' : '' ?>>Small</option>
                                <option value="Medium" <?= $item['selected_size'] === 'Medium' ? 'selected' : '' ?>>Medium</option>
                                <option value="Large" <?= $item['selected_size'] === 'Large' ? 'selected' : '' ?>>Large</option>
                            </select>
                            <select name="selected_color" required>
                                <option value="">Color</option>
                                <option value="Red" <?= $item['selected_color'] === 'Red' ? 'selected' : '' ?>>Red</option>
                                <option value="Blue" <?= $item['selected_color'] === 'Blue' ? 'selected' : '' ?>>Blue</option>
                                <option value="Black" <?= $item['selected_color'] === 'Black' ? 'selected' : '' ?>>Black</option>
                            </select>
                            <button type="submit">Change</button>
                        </form>
                        <div class="cart-item-bottom">
                            <div class="left-side">R<?= number_format($item['subtotal'], 2); ?></div>
                            <div class="right-side">
                                <form method="post" class="quantity-form">
                                    <input type="hidden" name="index" value="<?= $item['index']; ?>">
                                    <input type="hidden" name="update_quantity" value="1">
                                    <button type="submit" name="quantity" value="<?= $item['quantity'] - 1; ?>" class="qty-btn">-</button>
                                    <span class="quantity"><?= $item['quantity']; ?></span>
                                    <button type="submit" name="quantity" value="<?= $item['quantity'] + 1; ?>" class="qty-btn">+</button>
                                </form>
                                <form method="post" action="../UsersPages/wishlist.php" style="display: inline;">
                                    <input type="hidden" name="product_id" value="<?= $item['id']; ?>">
                                    <button type="submit">
                                        <i class="<?= $is_wishlisted ? 'fa-solid fa-heart' : 'fa-regular fa-heart'; ?>"></i>
                                    </button>
                                </form>
                                <a href="cart.php?remove=<?= $item['index']; ?>" class="delete-btn"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="cart-summary">
                <h2>Total: R<?= number_format($total, 2); ?></h2>
                <form action="checkout.php" method="post">
                    <button type="submit" class="checkout-btn">Checkout</button>
                </form>
            </div>
        <?php endif; ?>
        <h3>we accept</h3>
        <div class="all_cart">
            <div class="cart"></div>
            <div class="cart"></div>
            <div class="cart"></div>
            <div class="cart"></div>
            <div class="cart"></div>
            <div class="cart"></div>
            <div class="cart"></div>
            <div class="cart"></div>
        </div>
    </section>
    <?php include '../Components/footer.php'; ?>
    </body>
</html>
