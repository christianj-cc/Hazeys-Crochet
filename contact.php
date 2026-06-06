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
        <li><a href="reviews.php">Reviews</a></li>
        <li><a href="request.php">Request</a></li>
        <li class="active"><a href="contact.php">Contact</a></li>
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
  <div class="wrapper contact">
    <!--<section class="section title">
      <div class="panel center-panel">
        <div class="heading-area">
          <h2>All About Me</h2>
        </div>
        <h4>and this passion!</h4>
      </div>
    </section>
    <section class="section strip">
      <div class="panel center-panel">
        <div class="box-container">
          <div class="box">
            <h5><a href="https://www.facebook.com/profile.php?id=61557911686578" target="_blank" class="fa fa-facebook"></a>
            </h5>
            <p>Facebook</p>
          </div>
          <div class="box">
            <h5><a href="https://www.instagram.com/hazey.crochet/" target="_blank" class="fa fa-instagram"></a></h5>
            <p>Instagram</p>
          </div>
          <div class="box">
            <h5><a href="#" target="_blank" class="fa fa-envelope-o"></a></h5>
            <p>Email</p>
          </div>
        </div>
      </div>
    </section>-->
    <section class="section info">
      <div class="panel right-panel">
        <div class="img-cont">
          <img src="assets/portrait.jpg" alt="" />
        </div>
      </div>
      <div class="panel left-panel">
        <div class="heading-area">
          <h2>All About Me</h2>
        </div>
        <h4>and this passion!</h4>
        <p>
          The business started as a small crochet venture on March 2023 while balancing college studies.
          Initially, it focused on keychain amigurumis but later expanded to include accessories like headbands,
          bucket hats, and bandanas. Orders are primarily managed through Facebook, where customers can choose
          from ready-made products or request custom orders. The business has grown due to a strong passion for
          crochet and appreciation from satisfied customers.
        </p>
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