<?php
include 'includes/db_fetchAllProducts.php';

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
        <a href="admin-products.php" class="fa fa-archive active"><span>&nbsp Manage Products</span></a>
        <a href="admin-orders.php" class="fa fa-shopping-basket"><span>&nbsp Manage Orders</span></a>
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
          <h3><i class="fa fa-bars">&nbsp</i>Product Listing</h3>
        </div>
        <div class="user-main-area">
          <div class="table-list user-list">
            <table>
              <?php if (!empty($productList)): ?>
                <tr class="table-header">
                  <th>ID</th>
                  <th>NAME</th>
                  <th>CATEGORY</th>
                  <th>IMAGE PATH</th>
                  <th>PRICE</th>
                  <th>IN STOCK</th>
                  <th>STATUS</th>
                  <th>ACTIONS</th>
                </tr>
                <?php foreach ($productList as $item): ?>
                  <tr class="table-row">
                    <form action="actions/db_updateProduct.php" method="POST">
                      <td class="first-cell"><?= number_format($item['ProductId']) ?>
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($item['ProductId']) ?>">
                      </td>
                      <td>
                        <input class="table-input" type="text" name="product_name" value="<?= htmlspecialchars($item['ProductName']) ?>" style="width: 150px;">
                      </td>
                      <td>
                        <?= htmlspecialchars($item['ProductCategory']) ?>
                      </td>
                      <td>
                        <?= htmlspecialchars($item['ProductImg']) ?>
                      </td>
                      <td>
                        <input class="table-input" type="number" name="product_price" value="<?= $item['ProductPrice'] ?>" min="1" style="width: 65px;">
                      </td>
                      <td>
                        <input class="table-input" type="number" name="in_stock" value="<?= $item['InStock'] ?>" min="0" style="width: 60px;">
                      </td>
                      <td>
                        <button type="button" class="table-button toggle-status" data-id="<?= $item['ProductId'] ?>">
                          <?= $item['IsActive'] ? 'Active' : 'Inactive' ?>
                        </button>
                        <input type="hidden" name="is_active" id="is_active_<?= $item['ProductId'] ?>" value="<?= $item['IsActive'] ?>">
                      </td>
                      <td>
                        <button type="submit" class="table-button btn-update" data-message="Are you sure you want to update the details of this product?">
                          <i class="fa fa-edit"></i> Update
                        </button>
                      </td>
                    </form>
                  </tr>
                <?php endforeach; ?>
            </table>
          <?php else: ?>
            <p>No products found.</p>
          <?php endif; ?>
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