<?php
include 'includes/db_fetchAllOrders.php';

$orders = fetchOrders('Pending');

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
        <a href="admin-orders.php" class="fa fa-shopping-basket active"><span>&nbsp Manage Orders</span></a>
        <a href="admin-requests.php" class="fa fa-file-text"><span>&nbsp Manage Requests</span></a>
        <a href="admin-users.php" class="fa fa-users"><span>&nbsp Manage Users</span></a>
        <form id="logoutForm" action="actions/db_signout.php" method="post">
          <button id="logoutButton" class="log-out" type="button">
            <i class="fa fa-sign-out"></i><span>Log Out</span>
          </button>
        </form>
      </div>
      <div class="user-info-main">
        <div class="user-main-area heading">
          <h3><i class="fa fa-bars">&nbsp</i>Manage Orders</h3>
        </div>
        <div class="user-main-area">
          <div class="StatusTabs">
            <a href="admin-orders.php"><button class="button-alt active">Pending</button></a> <!--Orders placed-->
            <a href="admin-orders-toPackage.php"><button class="button-alt">To Package</button></a>
            <a href="admin-orders-forMeetup.php"><button class="button-alt">For Meetup</button></a>
            <a href="admin-orders-Delivered.php"><button class="button-alt">Delivered</button></a>
            <a href="admin-orders-Completed.php"><button class="button-alt">Completed</button></a>
            <a href="admin-orders-Cancelled.php"><button class="button-alt">Cancelled</button></a>
          </div>
        </div>
        <div class="user-main-area">
          <div class="table-list user-list">
            <table>
              <?php if (!empty($orders)): ?>
                <tr class="table-header">
                  <th>ID</th>
                  <th>USER</th>
                  <th>ORDER DATE</th>
                  <th>PRODUCTS</th>
                  <th>TOTAL</th>
                  <th>PAYMENT</th>
                  <th>MEETUP</th>
                  <th>ACTIONS</th>
                </tr>
                <?php foreach ($orders as $order): ?>
                  <tr class="table-row">
                    <td><?= number_format($order['OrderId']) ?></td>
                    <td><?= htmlspecialchars($order['Username']) ?></td>
                    <td><?= htmlspecialchars($order['CreatedAt']) ?></td>
                    <td>
                      <?php foreach ($order['Products'] as $product): ?>
                        <?= htmlspecialchars($product['ProductName']) ?>
                        (<?= number_format($product['Quantity']) ?>x)<br>
                      <?php endforeach; ?>
                    </td>
                    <td>₱<?= number_format($order['TotalPrice'], 2) ?></td>
                    <td>
                      <?= htmlspecialchars($order['PaymentMethod']) ?>
                      <?php if (!empty($order['ReceiptImage'])): ?>
                        <a href="<?= htmlspecialchars($order['ReceiptImage']) ?>" target="_blank">
                          <button class="table-button">
                            <i class="fa fa-image"></i>&nbspView
                          </button>
                        </a>
                      <?php else: ?>

                      <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($order['PlaceName']) ?></td>
                    <td>
                      <div class="button-area">
                        <form action="actions/db_OrderStockOut.php" method="POST">
                          <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['OrderId']) ?>">
                          <input type="hidden" name="order_status" value="<?= htmlspecialchars($order['OrderStatus']) ?>">
                          <input type="hidden" name="return_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                          <button type="button" class="table-button btn-stockout confirmTrigger" data-message="Are you sure you want to stock out the contents of this order?">
                            <i class="fa fa-minus-square"></i> Stock Out
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <p style=" text-align: center; font-weight:600; font-size:20px;">No pending orders found.</p>
              <?php endif; ?>
            </table>
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