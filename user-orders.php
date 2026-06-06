<?php
include 'includes/db_fetchUserOrders.php';
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
        <a href="user-orders.php" class="fa fa-shopping-basket active"><span>&nbsp Orders History</span></a>
        <a href="user-requests.php" class="fa fa-file-text"><span>&nbsp Requests History</span></a>
        <form id="logoutForm" action="actions/db_signout.php" method="post">
          <button id="logoutButton" class="log-out" type="button">
            <i class="fa fa-sign-out"></i><span>Log Out</span>
          </button>
        </form>
      </div>
      <div class="user-info-main">
        <div class="user-main-area heading">
          <h3>Order History</h3>
        </div>
        <div class="user-main-area">
          <div class="table-list user-list">
            <table>
              <?php if (!empty($orders)): ?>
                <tr class="table-header">
                  <th>ORDERED ON</th>
                  <th>PRODUCT/S</th>
                  <th>TOTAL</th>
                  <th>PAYMENT</th>
                  <th>RECEIPT</th>
                  <th>STATUS</th>
                  <th>UPDATED AT</th>
                  <th>ACTIONS</th>
                </tr>
                <?php foreach ($orders as $order): ?>
                  <tr class="table-row">
                    <td><?= htmlspecialchars($order['CreatedAt']) ?></td>
                    <td>
                      <?php foreach ($order['Products'] as $product): ?>
                        <?= htmlspecialchars($product['ProductName']) ?>
                        (<?= number_format($product['Quantity']) ?>x)<br>
                      <?php endforeach; ?>
                    </td>
                    <td>₱<?= number_format($order['TotalPrice'], 2) ?></td>
                    <td><?= htmlspecialchars($order['PaymentMethod']) ?></td>
                    <td>
                      <?php if (!empty($order['ReceiptImage'])): ?>
                        <a href="<?= htmlspecialchars($order['ReceiptImage']) ?>" target="_blank">
                          <button class="table-button">
                            <i class="fa fa-image"></i>&nbspView
                          </button>
                        </a>
                      <?php else: ?>
                        No Image
                      <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($order['OrderStatus']) ?></td>
                    <td><?= htmlspecialchars($order['StatusUpdatedAt']) ?></td>
                    <td>
                      <?php if ($order['OrderStatus'] == "Completed"): ?>
                        <?php if ($order['HasReview'] == 0): ?>
                          <div class="button-area">
                            <a href="user-writeReview.php?order_id=<?= $order['OrderId'] ?>">
                              <button class="table-button btn-write">
                                <i class="fa fa-pencil"></i> Write Review
                              </button>
                            </a>
                          </div>
                        <?php else: ?>
                          <div class="button-area">
                            <a href="reviews.php">
                              <button class="table-button btn-view">
                                <i class="fa fa-eye"></i> View Review
                              </button>
                            </a>
                          </div>
                        <?php endif; ?>
                      <?php elseif ($order['OrderStatus'] == "Delivered"): ?>
                        <div class="button-area">
                          <form action="actions/db_updateOrderStatus.php" method="POST">
                            <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['OrderId']) ?>">
                            <input type="hidden" name="order_status" value="<?= htmlspecialchars($order['OrderStatus']) ?>">
                            <input type="hidden" name="return_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                            <button type="submit" class="table-button btn-update confirmTrigger" data-message="Are you sure you want to confirm you received the order?">
                              <i class="fa fa-check"></i> Confirm Delivery
                            </button>
                          </form>
                        </div>
                      <?php else: ?>
                        N/A
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <p style="text-align: center; font-weight:600; font-size:20px;">No orders found.</p>
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