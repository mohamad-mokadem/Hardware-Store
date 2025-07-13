<?php
// Include the auth.php to manage session and login check
include('auth.php');
include('config.php'); // Include your database connection

// Check if the user is logged in (if not, they will be redirected to the login page)
checkLogin();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Home Improvement Store</title>
    <link rel="stylesheet" href="/CSS/style_cart.css">
</head>
<body>
    <a href="/PHP/home.php" class="back-button anim">← Back to Home</a>
    <div class="wrapper anim">
        <h1>Your Cart</h1>
        
        <!-- Cart Item List -->
        <div id="cart-items">
            <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                <div class="product-list">
                    <?php foreach ($_SESSION['cart'] as $item): ?>
                        <div class="product">
                            <img src="images/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                            <h3><?php echo $item['name']; ?></h3>
                            <p>$<?php echo number_format($item['price'], 2); ?></p>
                            <a href="/PHP/cart.php echo $item['id']; ?>" class="remove-button">Remove</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Your cart is empty. <a href="/PHP/store.php">Start shopping!</a></p>
            <?php endif; ?>
        </div>

        <!-- Total Price -->
        <div class="total-price">
            <h2>Total: $<?php echo number_format($totalPrice, 2); ?></h2>
            <a href="checkout.php" class="checkout-button">Proceed to Checkout</a>
        </div>
    </div>
</body>
</html>
