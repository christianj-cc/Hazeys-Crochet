<?php
require 'includes/db_fetchAllReviews.php';

if (!isset($_GET['product_name'])) {
  die("No product selected.");
}

$productName = urldecode($_GET['product_name']); // Decode product name
$query = "SELECT r.*, p.ProductImg, u.Username 
        FROM reviews r
        JOIN products p ON r.ProductId = p.ProductId
        JOIN users u ON r.UserId = u.UserId
        WHERE p.ProductName = ? 
        ORDER BY r.CreatedAt DESC";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $productName);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$reviews = [];
$productImg = "";

while ($row = mysqli_fetch_assoc($result)) {
  $productImg = $row['ProductImg'];
  $reviews[] = [
    'Username' => $row['Username'],
    'Rating' => $row['Rating'],
    'ReviewText' => $row['ReviewText'],
    'CreatedAt' => $row['CreatedAt']
  ];
}

mysqli_stmt_close($stmt);
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
      <div class="product-review-container">
        <h2><?= htmlspecialchars($productName) ?> - Reviews</h2>
        <img src="assets/products/<?= htmlspecialchars($productImg) ?>" alt="<?= htmlspecialchars($productName) ?>" width="200">

        <div class="reviews">
          <?php if (empty($reviews)): ?>
            <p>No reviews yet for this product.</p>
          <?php else: ?>
            <?php foreach ($reviews as $review): ?>
              <div class="review-box">
                <span><strong><?= htmlspecialchars($review['Username']) ?></strong>: <?= str_repeat('⭐', $review['Rating']) ?></span>
                <p><?= htmlspecialchars($review['ReviewText']) ?></p>
                <small><?= htmlspecialchars($review['CreatedAt']) ?></small>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <a href="index.php">← Back to Products</a>
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