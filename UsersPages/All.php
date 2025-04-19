<?php
    include_once '../Components/Connection.php';

    if(isset($_COOKIE['User_ID'])){
        $user_id = $_COOKIE['User_ID'];
    }else{
        $user_id = '';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Styles/user_style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="../JS_Script/user_script.js" defer></script>
    <title>Janette Bombo - All Products page</title>
</head>
<body>
    <?php include '../Components/user_header.php'; ?>
    <!---- slider 1 section start ---->
    <section class="container">
    <div class="wrapper">
        <div class="slide">
            <img src="../Images/BackgroundWomen.webp">
            <div class="slide-text">
                <h2>Elegance Redefined</h2>
                <p>Discover the latest trends in women’s fashion.</p>
                <a href="category.php" class="btn">Shop Now</a>
            </div>
        </div>
        <div class="slide">
            <img src="../Images/backgroundMen.webp">
            <div class="slide-text">
                <h2>Style for Every Occasion</h2>
                <p>Elevate your wardrobe with our men's collection.</p>
                <a href="category.php" class="btn">Explore</a>
            </div>
        </div>
        <div class="slide">
            <img src="../Images/bachgroundAccessories.webp">
            <div class="slide-text">
                <h2>Complete Your Look</h2>
                <p>From jewelry to bags, find the perfect accessory.</p>
                <a href="category.php" class="btn">See More</a>
            </div>
        </div>
        <div class="slide">
            <img src="../Images/backgroundKids.webp">
            <div class="slide-text">
                <h2>Fashion for the Little Ones</h2>
                <p>Adorable styles for your kids.</p>
                <a href="category.php" class="btn">Shop Kids</a>
            </div>
        </div>
    </div>
    <!-- Navigation Dots -->
    <div class="slider-nav">
        <div class="dot active"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>
</section>
    <!-----slider section end------->
    <section class="service">
        <div class="box-container">
            <!---service item box--------->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="../Images/delivrery.jpg" class="img1">
                    </div>
                </div>
                <div class="detail">
                    <h4>free delivery</h4>
                    <span>on orders over R500.00</span>
                </div>
            </div>
            <!---service item box--------->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="../Images/payements.png" class="img1">
                    </div>
                </div>
                <div class="detail">
                    <h4>payment</h4>
                    <span>100% secure</span>
                </div>
            </div>
            <!---service item box--------->
            <!---service item box--------->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="../Images/money.png" class="img1">
                    </div>
                </div>
                <div class="detail">
                    <h4>support</h4>
                    <span>24*7 hours</span>
                </div>
            </div>
            <!---service item box--------->
            <!---service item box--------->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="../Images/gift.webp" class="img1">
                    </div>
                </div>
                <div class="detail">
                    <h4>gift service</h4>
                    <span>support gift service</span>
                </div>
            </div>
            <!---service item box--------->
            <!---service item box--------->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="../Images/return.webp" class="img1">
                    </div>
                </div>
                <div class="detail">
                    <h4>returns</h4>
                    <span>24*7 free return</span>
                </div>
            </div>
            <!---service item box--------->
            <!---service item box--------->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="../Images/delivrery.jpg" class="img1">
                    </div>
                </div>
                <div class="detail">
                    <h4>delivery</h4>
                    <span>100% secure</span>
                </div>
            </div>
        </div>
    </section>
    <!-----service section end------>
    <section class="categories">
        <div class="cat-container">
            <div class="cat-box">
                <img src="../Images/womenDresses.jpg">
                <div class="detail">
                    <a href="women.php">Women →</a>
                </div>
            </div>
            <div class="cat-box">
                <img src="../Images/manclothes.jpeg">
                <div class="detail">
                    <a href="men.php">Men →</a>
                </div>
            </div>
            <div class="cat-box">
                <img src="../Images/kidsClothes.jpg">
                <div class="detail">
                    <a href="kids.php">Kids →</a>
                </div> 
            </div>
            <div class="cat-box">
                <img src="../Images/shoes.jpg">
                <div class="detail">
                    <a href="shoes.php">Shoes →</a>
                </div>
            </div>
            <div class="cat-box">
                <img src="../Images/bagsWomen.jpg">
                <div class="detail">
                    <a href="bags.php">Bags →</a>
                </div>
            </div>
            <div class="cat-box">
                <img src="../Images/Accessories.webp">
                <div class="detail">
                    <a href="jewerlyAccessories.php">Jewelry & Accessories →</a>
                </div>
            </div>
        </div>
    </section>
    <!-----categories section end------>
    <!-----weekly deals---------------->
    <section class="weeklyDeals">
        <div class="heading">
            <h1>BOOM BOOM! Your Weekly Deals Are Here!</h1>
            <img src="../Images/separator.avif" width="250" height="80">
            <p>Don't blink or you'll miss out! These deals are dropping like fire. Grab them before they disappear!</p>
        </div>
        <div class="weekly">
            <div class="box">
            <h2>Limited-Time Discounts!</h2>
            <p>Score amazing products at jaw-dropping prices. Because you deserve it!</p>
            <div class="deal-container">
                <div class="deal-item">
                    <img src="../Images/WeeklyDealsWomen.jpg" alt="Women Dress">
                    <h3>Elegant Women Dress</h3>
                    <p class="price"><span class="old-price">R450</span> <span class="new-price">R350</span></p>
                    <p class="discount">30% OFF!</p>
                    <button class="btn">Shop Now</button>
                </div>
                <div class="deal-item">
                    <img src="../Images/WeeklyDealsMen.webp" alt="Men Outfit">
                    <h3>Stylish Men Outfit</h3>
                    <p class="price"><span class="old-price">R760</span> <span class="new-price">R600</span></p>
                    <p class="discount">25% OFF!</p>
                    <button class="btn">Shop Now</button>
                </div>
                <div class="deal-item">
                    <img src="../Images/WeeklyDealShoes.jpg" alt="Trendy Shoes">
                    <h3>Trendy Shoes</h3>
                    <p class="price"><span class="old-price">R380</span> <span class="new-price">R540</span></p>
                    <p class="discount">30% OFF!</p>
                    <button class="btn">Shop Now</button>
                </div>
                <div class="deal-item">
                    <img src="../Images/bagsMen.jpg" alt="Luxury Bag">
                    <h3>Luxury Leather Bag</h3>
                    <p class="price"><span class="old-price">R150</span> <span class="new-price">R240</span></p>
                    <p class="discount">25% OFF!</p>
                    <button class="btn">Shop Now</button>
                </div>
            </div>
            <div class="countdown">
                <p>Hurry! These deals vanish in:</p>
                <span id="timer">00d 00h 00m 00s</span>
            </div>
        </div>
    </section>
    <!-----weekly deals end---------------->
    <!-----------footer-------------------->
    <?php include '../Components/footer.php'; ?>
</body>
<?php include '../Components/alert.php'; ?>
</html>