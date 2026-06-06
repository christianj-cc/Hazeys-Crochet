<?php
include 'includes/db_fetchRequestReceipt.php';
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
      <a href="#" class="fa fa-user"></a>
    </div>
  </header>
  <div class="wrapper">
    <section class="section title success">
      <div class="panel center-panel">
        <div class="heading-area">
          <h2>Request Submitted</h2>
        </div>
        <h4>Thank you for requesting!</h4>
        <div class="receipt">
          <?php if ($result_request->num_rows > 0) : ?>
            <h5>Request Receipt</h5>
            <p><strong>Request Deadline:</strong> <?= date('F d, Y h:i A', strtotime($request['Deadline'])); ?></p>
            <p><strong>Meetup Place:</strong> <?= htmlspecialchars($request['MeetupPlace']); ?></p>
            <hr>
            <table class="receipt-table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Instructions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><?= htmlspecialchars($request['RequestName']); ?></td>
                  <td><?= htmlspecialchars($request['Instructions']); ?></td>
                </tr>
              </tbody>
            </table>
            <hr>
            <p><strong>Request Date:</strong> <?= date('F d, Y h:i A', strtotime($request['RequestedAt'])); ?></p>
            <p><strong>Total Price:</strong> ₱<?= number_format($request['RequestPrice'], 2); ?></p>
            <p><strong>Payment Method:</strong> <?= htmlspecialchars($request['PaymentMethod']); ?></p>
            <?php if (!empty($request['PaymentRefNo'])) : ?>
              <p><strong>Payment Reference No.:</strong> <?= htmlspecialchars($request['PaymentRefNo']); ?></p>
            <?php endif; ?>
            <!--<?php if (!empty($request['ReceiptImage'])) : ?>
              <p><strong>Receipt:</strong><br>
                <img src="<?= htmlspecialchars($request['ReceiptImage']); ?>" alt="Receipt Image" class="receipt-img clickable-img">
              </p>
            <?php endif; ?>-->
          <?php else : ?>
            <p class="error">No request details found.</p>
          <?php endif; ?>
        </div>
        <div class="button-area">
          <?php if (!$isAdmin) : ?>
            <a href="user-requests.php"><button class="button-alt">Back to Requests</button></a>
          <?php else : ?>
            <a href="admin-requests.php"><button class="button-alt">Back to Requests</button></a>
          <?php endif; ?>
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