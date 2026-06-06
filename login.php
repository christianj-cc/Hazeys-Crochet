<?php
require "db_auth.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="login_style.css" />
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
  <div class="container" id="container">
    <div class="form-container sign-up">
      <form action="actions/db_signup.php" method="POST">
        <img src="assets/logo.png" alt="" />
        <span>Create an account</span>
        <input type="text" name="first_name" placeholder="First Name" required />
        <input type="text" name="last_name" placeholder="Last Name" required />
        <input type="text" name="username" placeholder="Username" required />
        <input type="text" name="contact_number" placeholder="Contact Number" value="09" maxlength="11" pattern="09[0-9]{9}" required>
        <input type="email" name="email" placeholder="Email" required />
        <div class="password-container">
          <input type="password" name="password" id="signup-password" placeholder="Password" required />
          <i class="fa fa-eye" id="toggleSignupPassword"></i>
        </div>
        <button class="button" type="submit">Sign Up</button>
      </form>

    </div>
    <div class="form-container sign-in">
      <form action="actions/db_signin.php" method="POST">
        <img src="assets/logo.png" alt="" />
        <span>Log In</span>
        <input type="email" name="email" placeholder="Email" required />
        <div class="password-container">
          <input type="password" name="password" id="signin-password" placeholder="Password" required />
          <i class="fa fa-eye" id="toggleSigninPassword"></i>
        </div>
        <button class="button" type="submit">Sign In</button>
      </form>

    </div>
    <div class="toggle-container">
      <div class="toggle">
        <div class="toggle-panel toggle-left">
          <h1>Already have an account?</h1>
          <p>Login to use all of the site features.</p>
          <button class="hidden" id="login">Sign In</button>
        </div>
        <div class="toggle-panel toggle-right">
          <h1>Don't have an account?</h1>
          <p>Register a new account to use all of the site features.</p>
          <button class="hidden" id="register">Sign Up</button>
        </div>
      </div>
    </div>
  </div>

  <div id="messageModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <p id="modalMessage"></p>
    </div>
  </div>

  <!-- ANIMATIONS -->
  <script>
    const container = document.getElementById('container');
    const registerBtn = document.getElementById('register');
    const loginBtn = document.getElementById('login');

    registerBtn.addEventListener('click', () => {
      container.classList.add("active");
    })

    loginBtn.addEventListener('click', () => {
      container.classList.remove("active");
    })
  </script>

  <!-- PASSWORD PEEK -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const toggleIcon = document.getElementById(iconId);

        toggleIcon.addEventListener("click", function() {
          if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
          } else {
            passwordInput.type = "password";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
          }
        });
      }

      togglePassword("signup-password", "toggleSignupPassword");
      togglePassword("signin-password", "toggleSigninPassword");
    });
  </script>
</body>

</html>