<?php
require 'db_auth.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
  <link rel="icon" type="image/x-icon" href="assets/icon/favicon.ico">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
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
        <li class="active"><a href="index.php">Home</a></li>
        <li><a href="shop.php">Shop</a></li>
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
    <section class="section showcase">
      <div class=" panel left-panel">
        <div class="heading-area">
          <h1>Crochet Creations</h1>
        </div>
        <h4>handmade just for you!</h4>
        <p>
          Discover the warmth and charm of handcrafted crochet
          creations! From keychain amigurumis to headbands,
          buckethats, and bandanas. Each piece is made with care and
          creativity. Whether you're looking for a special gift or a
          unique addition to your collection, we have something just
          for you.
        </p>
        <div class="button-area">
          <a href="shop.php" class="button-default">Shop Catalogue</a>
          <a href="request.php" class="button-alt">Request Custom</a>
        </div>
      </div>
      <div class="panel right-panel">
        <div class="right-content">
          <div class="img-cont">
            <img src="assets/yarn.png" alt="" />
          </div>
        </div>
      </div>
    </section>
    <section class="section strip">
      <div class="panel center-panel">
        <div class="box-container">
          <div class="box">
            <img src="assets/home-handmade.png" alt="hands knitting" />
            <h5>Handmade Creations</h5>
            <p>
              Unique, one-of-a-kind crochet items crafted with care.
            </p>
          </div>
          <div class="box">
            <img src="assets/home-gift.png" alt="gift box" />
            <h5>Gift-Ready Options</h5>
            <p>
              Thoughtful, handmade gifts perfect for special occasions.
            </p>
          </div>
          <div class="box">
            <img src="assets/home-local.png" alt="store front" />
            <h5>Support Small Business</h5>
            <p>
              Purchase handmade crafts from a passionate artisan.
            </p>
          </div>
        </div>
      </div>
    </section>
    <section class="section feature">
      <h3>FEATURED PRODUCTS</h3>
      <div class="feature-grid-container">
        <button class="nav-btn left-btn">&#10094;</button>
        <div class="feature-grid">
          <div class="grid-grp">
            <div class="card-img">
              <img src="assets/products/pouch-rose.png" alt="" class="clickable-img">
            </div>
            <div class="card-img">
              <img src="assets/products/key-chick.jpg" alt="" class="clickable-img">
            </div>
            <div class="card-img">
              <img src="assets/products/key-egg.jpg" alt="" class="clickable-img">
            </div>
          </div>
          <div class="grid-grp">
            <div class="card-img">
              <img src="assets/products/key-frog.jpg" alt="" class="clickable-img">
            </div>
            <div class="card-img">
              <img src="assets/products/key-octopus.jpg" alt="" class="clickable-img">
            </div>
            <div class="card-img">
              <img src="assets/products/key-dog.jpg" alt="" class="clickable-img">
            </div>
          </div>
        </div>
        <button class="nav-btn right-btn">&#10095;</button>
      </div>
      <div class="button-area">
        <a href="shop.php" class="button-default">Go to Shop</a>
      </div>
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

  <!-- FEATURE SLIDER BUTTON -->
  <script>
    let currentIndex = 0;
    const featureGrid = document.querySelector('.feature-grid');
    const gridGroups = document.querySelectorAll('.grid-grp');

    document.querySelector('.left-btn').addEventListener('click', () => {
      if (currentIndex > 0) {
        currentIndex--;
        featureGrid.style.transform = `translateX(-${currentIndex * 100}%)`;
      }
    });

    document.querySelector('.right-btn').addEventListener('click', () => {
      if (currentIndex < gridGroups.length - 1) {
        currentIndex++;
        featureGrid.style.transform = `translateX(-${currentIndex * 100}%)`;
      }
    });
  </script>

  <span id="isLoggedInData" style="display:none;"><?php echo json_encode($isLoggedIn); ?></span>
  <span id="isAdminData" style="display:none;"><?php echo json_encode($isAdmin); ?></span>

  <script src="scripts.js"></script>
</body>

</html>