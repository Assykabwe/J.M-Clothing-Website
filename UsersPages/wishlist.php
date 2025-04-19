<?php
include_once '../Components/Connection.php';
session_start();

if (!isset($_SESSION['wishlist'])) {
    $_SESSION['wishlist'] = [];
}

// Remove item
if (isset($_GET['remove'])) {
    $remove_index = $_GET['remove'];
    if (isset($_SESSION['wishlist'][$remove_index])) {
        unset($_SESSION['wishlist'][$remove_index]);
        $_SESSION['wishlist'] = array_values($_SESSION['wishlist']); // Re-index
    }
    header("Location: wishlist.php");
    exit;
}

// Add item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    if (!in_array($product_id, $_SESSION['wishlist'])) {
        $_SESSION['wishlist'][] = $product_id;
    }
    header("Location: wishlist.php");
    exit;
}

// total number of all the wish lists
$wishlist_items = [];

if (isset($_SESSION['wishlist']) && !empty($_SESSION['wishlist'])) {
    $placeholders = implode(',', array_fill(0, count($_SESSION['wishlist']), '?'));
    $types = str_repeat('s', count($_SESSION['wishlist']));

    $stmt = $conn->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->bind_param($types, ...$_SESSION['wishlist']);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $wishlist_items[] = $row;
    }

    $stmt->close();
}

$wishlist_count = count($wishlist_items);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your Wishlist</title>
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
    <section class="wishlist-container">
        <h1>Your Wishlist (<?= $wishlist_count ?>)</h1>
        <?php if (empty($wishlist_items)): ?>
            <p>Your wishlist is empty.</p>
        <?php else: ?>
            <div class="wishlist-grid">
            <?php foreach ($wishlist_items as $index => $item): ?>
                <div class="wishlist-item">
                    <img src="../upload_files/<?= htmlspecialchars($item['image']); ?>" alt="Wishlist Image">
                    <div class="wishlist-details">
                        <h3><?= htmlspecialchars($item['Name']); ?></h3>
                        <p><?= htmlspecialchars($item['product_detail']); ?></p>
                        <p class="wishlist-price">R<?= number_format($item['price'], 2); ?></p>
                        <div class="wishlist-actions">
                            <form method="post" action="cart.php" style="display:inline;">
                                <input type="hidden" name="product_id" value="<?= $item['id']; ?>">
                                <button type="submit" class="btn">Add to Cart</button>
                            </form>
                            <a href="wishlist.php?remove=<?= $index; ?>" class="delete-btn"><i class="fa-solid fa-trash"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
    <div class="allproduct">
        <h1>you may also like</h1>
    </div>
    <?php include '../UsersPages/See_All_Products.php'; ?>
    <?php include '../Components/footer.php'; ?>
</body>
</html>
