<?php
include 'includes/db_fetchUserRequestsDetails.php';
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
  <div class="wrapper admin">
    <section class="section user-info">
      <div class="user-info-nav">
        <a href="admin.php" class="fa fa-address-book-o"><span>&nbsp Overview</span></a>
        <a href="admin-products.php" class="fa fa-archive"><span>&nbsp Manage Products</span></a>
        <a href="admin-orders.php" class="fa fa-shopping-basket"><span>&nbsp Manage Orders</span></a>
        <a href="admin-requests.php" class="fa fa-file-text active"><span>&nbsp Manage Requests</span></a>
        <a href="admin-users.php" class="fa fa-users"><span>&nbsp Manage Users</span></a>
        <form id="logoutForm" action="actions/db_signout.php" method="post">
          <button id="logoutButton" class="log-out" type="button">
            <i class="fa fa-sign-out"></i><span>Log Out</span>
          </button>
        </form>
      </div>
      <div class="user-info-main requests">
        <div class="user-main-area heading">
          <h3><i class="fa fa-bars">&nbsp</i>Set <?= htmlspecialchars($requestDetails['RequestName']) ?> Request Details</h3>
        </div>
        <div class="user-main-area">
          <div class="user-main-area review">
            <a href="admin-requests.php"><button class="button-alt"><i class="fa fa-back"></i>Go Back</button></a>
            <form action="actions/db_updateRequestDetails.php" method="POST" class="form-area form-alt">
              <input type="hidden" name="request_id" value="<?= htmlspecialchars($requestDetails['RequestId']) ?>">
              <input type="hidden" name="request_status" value="<?= htmlspecialchars($request['RequestStatus']) ?>">
              <input type="hidden" name="return_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">

              <label>Price</label>
              <input type="number" name="request_price" required>

              <label>Message</label>
              <textarea name="admin_message" required></textarea>

              <div class="button-area">
                <button type="submit" name="action" value="accept" class="button-alt">
                  <i class="fa fa-check"></i> Finalize Details
                </button>
              </div>
            </form>
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