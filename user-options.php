<?php
include 'includes/db_fetchUserInfo.php';
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
        <li><a href="contact.php">Contact</a></li>
      </ul>
    </nav>
    <div class="link-area user-area">
      <a href="#" class="fa fa-shopping-cart">
        <span id="cartCountBadge" class="cart-badge">
          <?= $_SESSION['totalCartItems']; ?>
        </span>
      </a>
      <a href="#" class="fa fa-user active"></a>
    </div>
  </header>
  <div class="wrapper user">
    <section class="section user-info">
      <div class="user-info-nav">
        <a href="user.php" class="fa fa-address-book-o"><span>&nbsp Personal Information</span></a>
        <a href="user-orders.php" class="fa fa-shopping-basket"><span>&nbsp Orders History</span></a>
        <a href="user-requests.php" class="fa fa-file-text"><span>&nbsp Requests History</span></a>
        <form id="logoutForm" action="actions/db_signout.php" method="post">
          <button id="logoutButton" class="log-out" type="button">
            <i class="fa fa-sign-out"></i><span>Log Out</span>
          </button>
        </form>
      </div>
      <div class="user-info-main">
        <div class="user-main-area heading">
          <h3>Payment Options</h3>
        </div>
        <div class="user-main-area">
          <div class="part-container">
            <div class="part">
              <h6>First Name</h6>
              <p><?php echo isset($user['FirstName']) ? htmlspecialchars($user['FirstName']) : 'N/A'; ?></p>
              <h6>Last Name</h6>
              <p><?php echo isset($user['LastName']) ? htmlspecialchars($user['LastName']) : 'N/A'; ?></p>
              <h6>Username</h6>
              <p><?php echo isset($user['Username']) ? htmlspecialchars($user['Username']) : 'N/A'; ?></p>
            </div>
            <div class="part">
              <h6>Contact Number (11-digit)</h6>
              <p><?php echo isset($user['ContactNumber']) ? htmlspecialchars($user['ContactNumber']) : 'N/A'; ?></p>
              <h6>Email</h6>
              <p><?php echo isset($user['Email']) ? htmlspecialchars($user['Email']) : 'N/A'; ?></p>
              <h6>Password</h6>
              <p><?php echo isset($user['Password']) ? str_repeat('*', strlen($user['Password'])) : 'N/A'; ?></p>
            </div>
          </div>
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

  <span id="isLoggedInData" style="display:none;"><?php echo json_encode($isLoggedIn); ?></span>
  <span id="isAdminData" style="display:none;"><?php echo json_encode($isAdmin); ?></span>

  <script src="scripts.js"></script>
</body>

</html>