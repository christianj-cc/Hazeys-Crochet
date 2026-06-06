<?php
require 'includes/db_fetchProdDetails.php';

// Fetch all products from the database
$productData = getAllProducts($conn);

// Debugging output
if (!$productData) {
  die("Error: No products found.");
}

if (isset($_SESSION['alert_message'])) {
  echo "<script>alert('" . $_SESSION['alert_message'] . "');</script>";
  unset($_SESSION['alert_message']); // Clear after displaying
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
  <link rel="icon" type="image/x-icon" href="assets/icon/favicon.ico">
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Calistoga&family=Caprasimo&family=Dancing+Script:wght@400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <title>Hazey's Crochet</title>
</head>

<body>
  <header class="nav-bar">
    <div class="logo-area">
      <a href="index.php" class="logo"><img src="assets/logo-small.png" alt="" /></a>
    </div>
    <nav class="link-area">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li class="active"><a href="shop.php">Shop</a></li>
        <li><a href="reviews.php">Reviews</a></li>
        <li><a href="request.php">Request</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
    </nav>
    <div class="link-area user-area">
      <a href="#" class="fa fa-shopping-cart">
        <span id="cartCountBadge" class="cart-badge">
          <?= $_SESSION['totalCartItems']; ?>
        </span>
      </a>
      <a href="#" class="fa fa-user"></a>
    </div>
  </header>
  <div class="wrapper">
    <section class="section title">
      <div class="panel center-panel">
        <div class="heading-area">
          <h2>Browse Ready-Made Products</h2>
        </div>
        <h4>to your heart's content!</h4>
      </div>
    </section>
    <section class="section shop">
      <div class="filter-area">
        <span>Filter:&nbsp;</span>
        <button onclick="filterProducts('all')">All</button>
        <button onclick="filterProducts('keychain')">Keychain</button>
        <button onclick="filterProducts('clothing')">Clothing</button>
        <button onclick="filterProducts('animal')">Animal</button>
        <button onclick="filterProducts('nature')">Nature</button>
        <button onclick="filterProducts('food')">Food</button>
        <button onclick="filterProducts('cartoon')">Cartoon</button>
        <button onclick="filterProducts('misc')">Miscellaneous</button>
      </div>
      <div class="card-grid">
        <?php foreach ($productData as $product): ?>
          <div class="card" data-category="<?= htmlspecialchars($product['ProductCategory']) ?>" id="<?= htmlspecialchars($product['ProductName']) ?>">
            <div class="card-img">
              <img src="assets/products/<?= htmlspecialchars($product['ProductImg']) ?>" alt="<?= htmlspecialchars($product['ProductName']) ?>" class="clickable-img">
            </div>
            <div class="card-info">
              <h5><?= htmlspecialchars($product['ProductName']) ?></h5>
              <h6>₱<?= number_format($product['ProductPrice'], 2) ?></h6>
              <p>In Stock: <?= htmlspecialchars($product['InStock']) ?></p>
            </div>
            <div class="card-button-area">
              <?php if ($product['InStock'] == 0): ?>
                <form action="actions/db_addToCart.php" method="POST">
                  <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['ProductId']) ?>">
                  <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['ProductName']) ?>">
                  <button type="button" name="add_to_cart" class="button-default button-addToCart" disabled>
                    <i class="fa fa-shopping-cart"></i> Out of Stock
                  </button>
                </form>
              <?php else: ?>
                <form action="actions/db_addToCart.php" method="POST">
                  <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['ProductId']) ?>">
                  <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['ProductName']) ?>">
                  <button type="button" name="add_to_cart" class="button-default button-addToCart">
                    <i class="fa fa-shopping-cart"></i> Add to Cart
                  </button>
                </form>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  </div>
  <footer class="footer-bar">
    <div class="footer-content">
      <a href="index.php"><img src="assets/logo-big.png" alt="" /></a>
      <div class="social-area">
        <a href="https://www.facebook.com/profile.php?id=61557911686578" target="_blank" class="fa fa-facebook"></a>
        <a href="https://www.instagram.com/hazey.crochet/" target="_blank" class="fa fa-instagram"></a>
      </div>
      <p>© All Rights Reserved.</p>
    </div>
  </footer>

  <?php include 'includes/modals.php'; ?>

  <span id="isLoggedInData" style="display:none;"><?php echo json_encode($isLoggedIn); ?></span>
  <span id="isAdminData" style="display:none;"><?php echo json_encode($isAdmin); ?></span>

  <script src="scripts.js"></script>
</body>

</html>