<?php
include 'includes/db_fetchUserCart.php';

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
      <a href="#" class="fa fa-shopping-cart active">
        <span id="cartCountBadge" class="cart-badge">
          <?= $_SESSION['totalCartItems']; ?>
        </span>
      </a>
      <a href="#" class="fa fa-user"></a>
    </div>
  </header>
  <div class="wrapper">
    <section class="section cart">
      <div class="panel left-panel" id="cart">
        <h3>Shopping Cart</h3>
        <div class="table-list">
          <?php if (count($cartItems) > 0): ?>
            <table>
              <tr class="table-header">
                <th>NAME</th>
                <th>PRICE</th>
                <th>QUANTITY</th>
                <th>TOTAL</th>
                <th>ACTIONS</th>
              </tr>
              <?php
              $grandTotal = 0;
              foreach ($cartItems as $item):
                $total = $item['ProductPrice'] * $item['Quantity'];
                $grandTotal += $total;
              ?>
                <tr class="table-row">
                  <td class="td-left"><?= htmlspecialchars($item['ProductName']) ?></td>
                  <td><?= number_format($item['ProductPrice'], 2) ?></td>
                  <td>
                    <form action="actions/db_updateCart.php" method="POST">
                      <button type="button" class="table-button minus-btn"><i class="fa fa-minus"></i></button>
                      <input type="hidden" name="product_id" value="<?= htmlspecialchars($item['ProductId']) ?>">
                      <input class="table-input qty-input" type="number" name="quantity" value="<?= $item['Quantity'] ?>" min="1" max="<?= $item['InStock'] ?>" style="width: 50px;">
                      <button type="button" class="table-button plus-btn"><i class="fa fa-plus"></i></button>
                    </form>
                  </td>
                  <td><?= number_format($total, 2) ?></td>
                  <td>
                    <form id="removeCartItemForm" action="actions/db_removeFromCart.php" method="POST">
                      <input type="hidden" name="product_id" value="<?= htmlspecialchars($item['ProductId']) ?>">
                      <div class="button-area">
                        <button type="button" class="table-button btn-remove confirmTrigger" data-message="Are you sure you want to remove this item from your cart?">
                          <i class="fa fa-trash"></i> Remove
                        </button>
                      </div>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
              <tr class="cart-total-row">
                <td colspan="3" class="td-left"><strong>Grand Total:</strong></td>
                <td><strong>₱<?= number_format($grandTotal, 2) ?></strong></td>
                <td></td>
              </tr>
            </table>
            <br>
            <a href="#"><button class="button-checkout button-default">Proceed to Checkout</button></a>
          <?php else: ?>
            <p class="empty-cart">Your cart is empty. <a href="shop.php">Go shopping!</a></p>
          <?php endif; ?>
        </div>
      </div>

      <div class="panel right-panel" id="checkout" style="display: none;">
        <h3>Checkout</h3>
        <div class="checkout-section">
          <div class="checkout-area">
            <h6>Order Summary</h6>
            <div class="table-list order-summary">
              <?php if (count($cartItems) > 0): ?>
                <table>
                  <tr class="table-header">
                    <th class="td-left">NAME</th>
                    <th>QUANTITY</th>
                    <th>SUBTOTAL</th>
                  </tr>
                  <?php
                  $grandTotal = 0;
                  foreach ($cartItems as $item):
                    $total = $item['ProductPrice'] * $item['Quantity'];
                    $grandTotal += $total;
                  ?>
                    <tr class="table-row">
                      <td class="td-left"><?= htmlspecialchars($item['ProductName']) ?></td>
                      <td><?= htmlspecialchars($item['Quantity']) ?></td>
                      <td><?= number_format($total, 2) ?></td>
                    </tr>
                  <?php endforeach; ?>
                  <tr class="cart-total-row">
                    <td colspan="2" class="td-left"><strong>Grand Total:</strong></td>
                    <td><strong>₱<?= number_format($grandTotal, 2) ?></strong></td>
                  </tr>
                </table>
                <br>
              <?php endif; ?>
            </div>
          </div>
          <div class="checkout-area">
            <h6>Select mode of payment:</h6>
            <select name="payment">
              <option value="GCash">GCash</option>
              <option value="Cash on Meetup">Cash on Meetup</option>
            </select>
            <div class="payment-option-container">
              <div class="payment-option gcash" style="display: block;">
                <h6>GCash - Proof of Payment</h6>
                <form action="actions/db_payForOrder.php" id="gcash_details" method="POST" class="form-area form-alt" enctype="multipart/form-data">
                  <?php foreach ($cartItems as $item): ?>
                    <input type="hidden" name="product_ids[]" value="<?= htmlspecialchars($item['ProductId']) ?>">
                    <input type="hidden" name="quantities[]" value="<?= htmlspecialchars($item['Quantity']) ?>">
                    <input type="hidden" name="prices[]" value="<?= htmlspecialchars($item['ProductPrice']) ?>">
                  <?php endforeach; ?>

                  <input type="hidden" name="total_price" value="<?= $grandTotal ?>">
                  <input type="hidden" name="payment_method" value="GCash">

                  <div class="img-cont">
                    <img src="assets/gcash-qr.png" alt="gcash-qr" class="clickable-img">
                  </div>

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
                <form action="actions/db_payForOrder.php" id="gcash_details" method="POST" class="form-area" enctype="multipart/form-data">
                  <?php foreach ($cartItems as $item): ?>
                    <input type="hidden" name="product_ids[]" value="<?= htmlspecialchars($item['ProductId']) ?>">
                    <input type="hidden" name="quantities[]" value="<?= htmlspecialchars($item['Quantity']) ?>">
                    <input type="hidden" name="prices[]" value="<?= htmlspecialchars($item['ProductPrice']) ?>">
                  <?php endforeach; ?>

                  <input type="hidden" name="total_price" value="<?= $grandTotal ?>">
                  <input type="hidden" name="payment_method" value="Cash on Meetup">

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