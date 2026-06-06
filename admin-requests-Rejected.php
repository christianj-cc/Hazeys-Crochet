<?php
include 'includes/db_fetchAllRequests.php';

$requests = fetchRequests('Rejected');

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
        <a href="admin-orders.php" class="fa fa-shopping-basket"><span>&nbsp Manage Orders</span></a>
        <a href="admin-requests.php" class="fa fa-file-text active"><span>&nbsp Manage Requests</span></a>
        <a href="admin-users.php" class="fa fa-users"><span>&nbsp Manage Users</span></a>
        <form id="logoutForm" action="actions/db_signout.php" method="post">
          <button id="logoutButton" class="log-out" type="button">
            <i class="fa fa-sign-out"></i><span>Log Out</span>
          </button>
        </form>
      </div>
      <div class="user-info-main">
        <div class="user-main-area heading">
          <h3><i class="fa fa-bars">&nbsp</i>Manage Requests</h3>
        </div>
        <div class="user-main-area">
          <div class="StatusTabs">
            <a href="admin-requests.php"><button class="button-alt">Pending</button></a> <!--Requests placed-->
            <a href="admin-requests-toBePaid.php"><button class="button-alt">To Be Paid</button></a>
            <a href="admin-requests-inProgress.php"><button class="button-alt">In Progress</button></a>
            <a href="admin-requests-toPackage.php"><button class="button-alt">To Package</button></a>
            <a href="admin-requests-forMeetup.php"><button class="button-alt">For Meetup</button></a>
            <a href="admin-requests-Delivered.php"><button class="button-alt">Delivered</button></a>
            <a href="admin-requests-Completed.php"><button class="button-alt">Completed</button></a>
            <a href="admin-requests-Cancelled.php"><button class="button-alt">Cancelled</button></a>
            <a href="admin-requests-Rejected.php"><button class="button-alt active">Rejected</button></a>
          </div>
        </div>
        <div class="user-main-area">
          <div class="table-list user-list">
            <table>
              <?php if (!empty($requests)): ?>
                <tr class="table-header">
                  <th>ID</th>
                  <th>USER</th>
                  <th>REQUEST DATE</th>
                  <th>NAME(QTY)</th>
                  <th>REFERENCE</th>
                  <th>DEADLINE</th>
                  <th>MEETUP</th>
                  <th>UPDATED AT</th>
                </tr>
                <?php foreach ($requests as $request): ?>
                  <tr>
                    <td><?= number_format($request['RequestId']) ?></td>
                    <td><?= htmlspecialchars($request['Username']) ?></td>
                    <td><?= htmlspecialchars($request['RequestedAt']) ?></td>
                    <td><?= htmlspecialchars($request['RequestName']) ?> (<?= number_format($request['Quantity']) ?>x)</td>
                    <td>
                      <?php if (!empty($request['ReferenceImage'])): ?>
                        <a href="<?= htmlspecialchars($request['ReferenceImage']) ?>" target="_blank">
                          <button class="table-button">
                            <i class="fa fa-image"></i>&nbspView
                          </button>
                        </a>
                      <?php else: ?>
                        No Image
                      <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($request['Deadline']) ?></td>
                    <td><?= htmlspecialchars($request['PlaceName']) ?></td>
                    <td><?= htmlspecialchars($request['StatusUpdatedAt']) ?></td>
                    <td>
                      <i class="fa fa-chevron-down toggle-down" data-request-id="<?= $request['RequestId'] ?>"></i>
                    </td>
                  </tr>

                  <tr class="request-details" data-request-id="<?= $request['RequestId'] ?>" style="display: none;">
                    <td colspan="12" style="padding: 0;">
                      <div class="dropdown-items">
                        <table>
                          <tr class="dropdown-items-header">
                            <th style="width: 40%;">INSTRUCTIONS</th>
                            <th style="width: 40%;">REPLY</th>
                          </tr>
                          <tr class="dropdown-items-data">
                            <td style="width: 40%;"><?= htmlspecialchars($request['Instructions']) ?></td>
                            <td style="width: 40%;"><?= htmlspecialchars($request['AdminMessage']) ?></td>
                          </tr>
                        </table>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <p style="text-align: center; font-weight:600; font-size:20px;">No requests found.</p>
              <?php endif; ?>
            </table>
            <br>
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