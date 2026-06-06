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
        <li class="active"><a href="request.php">Request</a></li>
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
    <section class="section title">
      <div class="panel center-panel">
        <div class="heading-area">
          <h2>Request Custom Order</h2>
        </div>
        <h4>and bring your ideas to life!</h4>
      </div>
    </section>
    <section class="section form">
      <div class="panel center-panel">
        <!--<div class="heading-area">
          <h2>Make a Request</h2>
        </div>-->
        <form action="actions/db_submitRequest.php" method="post" enctype="multipart/form-data" class="form-area">
          <label>Request Name (or Product Name)</label>
          <input type="text" name="request_name" placeholder="Request Name" required />

          <label>Deadline</label>
          <input type="date" name="deadline" required />

          <label>Instructions (Product description, specifications, color...)</label>
          <textarea name="instructions" cols="30" rows="5" placeholder="Instructions" required></textarea>

          <label>Quantity</label>
          <input type="number" name="quantity" placeholder="Quantity" min="1" value="1" required />

          <label>Reference Image (.jpg, .jpeg, .png)</label>
          <input type="file" name="reference_image" required />

          <label>Meetup Place</label>
          <select name="meetup_place" required>
            <option value="UM Matina">UM Matina</option>
            <option value="UM Bolton">UM Bolton</option>
          </select>

          <input type="hidden" name="request_status" value="Pending" />

          <div class="input-box">
            <button type="button" name="submit_request" class="button-default button-submitRequest"><i class="fa fa-envelope-open"></i> Submit Request</button>
          </div>
        </form>

      </div>
    </section>
    <!--<section class="section strip">
      <div class="panel center-panel">
        <div class="box-container">
          <div class="box">
            <img src="assets/home-handmade.png" alt="" />
            <h5>Fill in the Details Below</h5>
            <p>
              Unique, one-of-a-kind crochet items crafted with care.
            </p>
          </div>
          <div class="box">
            <img src="assets/home-gift.png" alt="" />
            <h5>Wait for a Reply</h5>
            <p>
              Thoughtful, handmade gifts perfect for special occasions.
            </p>
          </div>
          <div class="box">
            <img src="assets/home-local.png" alt="" />
            <h5>Support Small Business</h5>
            <p>
              Purchase handmade crafts from a passionate artisan.
            </p>
          </div>
        </div>
      </div>
    </section>-->
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