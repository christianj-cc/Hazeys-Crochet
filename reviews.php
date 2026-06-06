<?php
require 'includes/db_fetchAllReviews.php';
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
        <li><a href="shop.php">Shop</a></li>
        <li class="active"><a href="reviews.php">Reviews</a></li>
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
          <h2>Product Reviews</h2>
        </div>
        <h4>and Customer Feedback</h4>
      </div>
    </section>
    <section class="section reviews">
      <div class="filter-area">
        <span>Filter:&nbsp;</span>
        <button onclick="filterProductReviews('all')">All</button>
        <?php foreach ($reviews as $productId => $product): ?>
          <button onclick="filterProductReviews('<?= htmlspecialchars($productId) ?>')"
            data-product-id="<?= htmlspecialchars($productId) ?>">
            <?= htmlspecialchars($product['ProductName']) ?>
          </button>
        <?php endforeach; ?>
      </div>
      <div class="card-grid">
        <?php if (!empty($reviews)): ?>
          <?php foreach ($reviews as $productId => $product): ?>
            <div class="card" data-product-id="<?= htmlspecialchars($productId) ?>">
              <div class="card-img">
                <img src="assets/products/<?= htmlspecialchars($product['ProductImg']) ?>"
                  alt="<?= htmlspecialchars($product['ProductName']) ?>" class="clickable-img">
              </div>
              <div class="card-info">
                <div class="heading-area">
                  <h5><?= htmlspecialchars($product['ProductName']) ?></h5>
                  <span>
                    <?= str_repeat('⭐', $product['AvgRating']) ?>&nbsp<?= htmlspecialchars($product['AvgRating']) ?>/5
                  </span>
                </div>
                <div class="review-section">
                  <?php $reviewCount = 0; ?>
                  <?php foreach ($product['Reviews'] as $review): ?>
                    <?php if ($reviewCount >= 3) break; ?> <!-- LIMIT REVIEWS SHOWN TO 3-->
                    <div class="review-box">
                      <span><?= htmlspecialchars($review['Username']) ?>: <?= str_repeat('⭐', $review['Rating']) ?></span>
                      <p><?= htmlspecialchars($review['ReviewText']) ?></p>
                      <small><?= htmlspecialchars($review['CreatedAt']) ?></small>
                    </div>
                    <?php $reviewCount++; ?>
                  <?php endforeach; ?>
                </div>
              </div>
              <div class="card-button-area">
                <button type="button" class="button-default button-seeMore" onclick="filterProductReviews('<?= htmlspecialchars($productId) ?>')">
                  <i class="fa fa-eye"></i> See More
                </button>
                <button type="button" class="button-default button-back hidden" onclick="filterProductReviews('all')">
                  <i class="fa fa-arrow-left"></i> Back to Reviews
                </button>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p style="text-align: center; font-weight:600; font-size:20px;">No reviews yet.</p>
        <?php endif; ?>
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