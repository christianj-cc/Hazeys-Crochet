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
  <div class="wrapper user">
    <section class="section user-info">
      <div class="user-info-nav">
        <a href="user.php" class="fa fa-address-book-o"><span>&nbsp Personal Details</span></a>
        <a href="user-orders.php" class="fa fa-shopping-basket"><span>&nbsp Orders History</span></a>
        <a href="user-requests.php" class="fa fa-file-text active"><span>&nbsp Requests History</span></a>
        <form id="logoutForm" action="actions/db_signout.php" method="post">
          <button id="logoutButton" class="log-out" type="button">
            <i class="fa fa-sign-out"></i><span>Log Out</span>
          </button>
        </form>
      </div>
      <div class="user-info-main user-payment">
        <div class="user-main-area heading">
          <h3>Payment for <?= htmlspecialchars($requestDetails['RequestName']) ?> Request</h3>
        </div>
        <div class="user-main-area">
          <a href="user-requests.php"><button class="button-alt"><i class="fa fa-back"></i>Go Back</button></a>
          <div class="checkout-section">
            <div class="checkout-area">
              <h6>Select mode of payment:</h6>
              <select name="payment">
                <option value="GCash">GCash</option>
                <option value="Cash on Meetup">Cash on Meetup</option>
              </select>
              <div class="payment-option-container">
                <div class="payment-option gcash" style="display: block;">
                  <h6>GCash - Proof of Payment</h6>
                  <form action="actions/db_payForRequest.php" id="gcash_details" method="POST" class="form-area form-alt" enctype="multipart/form-data">
                    <div class="img-cont">
                      <img src="assets/gcash-qr.png" alt="gcash-qr" class="clickable-img">
                    </div>

                    <input type="hidden" name="request_id" value="<?= htmlspecialchars($requestDetails['RequestId']) ?>">

                    <input type="hidden" name="payment_method" value="GCash">

                    <label>Receipt Image</label>
                    <input type="file" name="receipt_image" accept="image/*" required>

                    <label>Reference No.</label>
                    <input type="text" name="payment_ref_no" required>

                    <label>Meetup Place</label>
                    <select name="meetup_place" required>
                      <option value="UM Matina">UM Matina</option>
                      <option value="UM Bolton">UM Bolton</option>
                    </select>

                    <div class="button-area">
                      <button type="submit" name="order_now" class="button-default button-orderNow">
                        <i class="fa fa-shopping-cart"></i> Order Now
                      </button>
                    </div>
                  </form>
                </div>
                <div class="payment-option meetup" style="display: none;">
                  <h6>Cash on Meetup</h6>
                  <form action="actions/db_payForRequest.php" method="POST" class="form-area" enctype="multipart/form-data">
                    <input type="hidden" name="payment_method" value="Cash on Meetup">

                    <input type="hidden" name="request_id" value="<?= htmlspecialchars($requestDetails['RequestId']) ?>">

                    <label>Meetup Place</label>
                    <select name="meetup_place" required>
                      <option value="UM Matina">UM Matina</option>
                      <option value="UM Bolton">UM Bolton</option>
                    </select>

                    <div class="button-area">
                      <button type="submit" name="order_now" class="button-default button-orderNow">
                        <i class="fa fa-shopping-cart"></i> Pay Now
                      </button>
                    </div>
                  </form>
                </div>
              </div>
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