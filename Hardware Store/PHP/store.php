<!--By Fadel Diab and Mohammad Daoud-->

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
    <title>Home Improvement Store</title>
    <link rel="stylesheet" href="/CSS/style_store.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

    
        <a href="/PHP/profile.php" class="profile-icon" style="margin-left: 1380px;">
            <i class="fas fa-user"></i>
        </a>
        <a href="/PHP/logout.php" class="logout-icon">
            <i class="fas fa-sign-out-alt"></i>
        </a>
    
    

    <a href="/PHP/home.php" class="back-button">← Back to Home</a>
    
    <section id="products">
        <h2>Our Products</h2>
        <div class="search-filter">

            

            <div class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-count" id="cart-count">0</span>
            </div>
            <input type="text" placeholder="Search products..." id="search-input">
            <button id="search-button">Search</button>
            <button id="filter-button">Filter by Price</button>
        </div>
        
        <div class="product-list">
            <div class="product">
                <img src="/Images/Circular Saw.jpg" alt="Circular Saw">
                <h3>Circular Saw</h3>
                <p>$100.99</p>
                <button>Add to Cart</button>
            </div>
            <div class="product">
                <img src="/Images/Cordless Drill Set.jpg" alt="Cordless Drill">
                <h3>Cordless Drill</h3>
                <p>$45.99</p>
                <button>Add to Cart</button>
            </div>
            <div class="product">
                <img src="/Images/hammer.jpg" alt="hammer">
                <h3>Hammer</h3>
                <p>$15.49</p>
                <button>Add to Cart</button>
            </div>
            <div class="product">
                <img src="/Images/Paint Roller Kit.jpg" alt="Paint Roller Kit">
                <h3>Paint Roller Kit</h3>
                <p>$20.99</p>
                <button>Add to Cart</button>
            </div>
            <div class="product">
                <img src="/Images/Safety Goggles.jpg" alt="Safety Goggles">
                <h3>Safety Goggles</h3>
                <p>$2.49</p>
                <button>Add to Cart</button>
            </div>
            <div class="product">
                <img src="/Images/Sandpaper Assortment.jpg" alt="Sandpaper">
                <h3>Sandpaper</h3>
                <p>$0.99</p>
                <button>Add to Cart</button>
            </div>
            <div class="product">
                <img src="/Images/screwdriver.jpg" alt="screwdriver">
                <h3>Screwdriver</h3>
                <p>$4.49</p>
                <button>Add to Cart</button>
            </div>
            <div class="product">
                <img src="/Images/Tape Measure.jpg" alt="Tape Measure">
                <h3>Tape Measure</h3>
                <p>$1.99</p>
                <button>Add to Cart</button>
            </div>
            <div class="product">
                <img src="/Images/Toolbox.jpg" alt="Toolbox">
                <h3>Toolbox</h3>
                <p>$25.99</p>
                <button>Add to Cart</button>
            </div>
            <div class="product">
                <img src="/Images/adjustable wrench.jpg" alt="adjustable wrench">
                <h3>Adjustable Wrench</h3>
                <p>$2.99</p>
                <button>Add to Cart</button>
            </div>
        </div>
    </section>

    <div id="custom-alert" class="custom-alert">
        <p id="alert-message">Item added to cart successfully!</p>
    </div>

    <section class="image-slider">
        <h2>50% Off on Selected Items</h2>
        <div class="slider-container">
            <div class="slide">
                <img src="/Images/Circular Saw.jpg Saw.jpg" alt="Circular Saw">
                <div class="slide-caption">
                    <h3>Circular Saw</h3>
                    <p>Now only $50.49!</p>
                </div>
            </div>
            <div class="slide">
                <img src="/Images/Cordless Drill Set.jpg" alt="Cordless Drill">
                <div class="slide-caption">
                    <h3>Cordless Drill</h3>
                    <p>Now only $22.99!</p>
                </div>
            </div>
            <div class="slide">
                <img src="/Images/hammer.jpg" alt="Hammer">
                <div class="slide-caption">
                    <h3>Hammer</h3>
                    <p>Now only $7.75!</p>
                </div>
            </div>
        </div>
        <button class="prev" onclick="prevSlide()">❮</button>
        <button class="next" onclick="nextSlide()">❯</button>
    </section>

    <script src="/JS/onClick.js"></script>
</body>
</html>
