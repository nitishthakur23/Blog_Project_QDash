<?php
require 'config/constants.php';


$username_email = $_SESSION['signin-data']['username_email'] ?? null;
$password = $_SEESION['signin-data']['password'] ?? null;

unset ($_SESSION['signin-data']);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP & MySQL Blog Application with Admin Panel</title>
    <!-- CUSTOM STYLESHEET -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/wakhra.css">
    <!-- ICONSCOUT CDN -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line. css">
    <!-- GOOGLE FONT (MONTSERRAT) -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:wght@300; 400;500; 600;700; 800; 900&display=swap" rel="stylesheet">
</head>

<body>

<section class="section_wave">

    <section class="form__section" style="padding-bottom:10rem;">

        <div class="container form__section-container">
            <h2>Sign In</h2>
            <?php if (isset($_SESSION['signup-success'])) : ?>
                <div class="alert__message success">
                    <p>
                        <?= $_SESSION['signup-success'];
                        unset($_SESSION['signup-success']);
                        ?>
                    </p>

                </div>
                <?php elseif (isset($_SESSION['signin'])) : ?>
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['signin'];
                        unset($_SESSION['signin']);
                        ?>
                    </p>

                </div>
                <?php endif ?> 
            <form action="<?= ROOT_URL ?>signin-logic.php" method="POST">
                <input type="text" name="username_email" value= "<?= $username_email ?>" placeholder ="Username or Email"> 
                <input type="password" name="password" value="<?= $password ?>" placeholder = "password" >

                <button type="submit" name="submit" class="btn">Sign In</button> <small>Don't have account? <a href="signup.php">Sign Up</a></small>
            </form>
        </div>
        <div class='air air1'></div>
    <div class='air air2'></div>
    <div class='air air3'></div>
    <div class='air air4'></div>
  </section>
</body>

</html>
<script>
  // Function to set toggle state in localStorage
  function setToggleState(state) {
    localStorage.setItem('darkMode', state);
  }

  // Function to apply toggle state from localStorage
  function applyToggleState() {
    const darkMode = localStorage.getItem('darkMode');
    if (darkMode === 'true') {
      document.documentElement.classList.add('dark-mode');
      document.getElementById('dn').checked = true;
      addGradientOverlay(); // Add the gradient overlay when in dark mode
    } else {
      document.documentElement.classList.remove('dark-mode');
      document.getElementById('dn').checked = false;
      removeGradientOverlay(); // Remove the gradient overlay when in light mode
    }
  }

  // Function to add gradient overlay
  function addGradientOverlay() {
    const gradientOverlay = document.createElement('div');
    gradientOverlay.className = 'gradient-overlay';
    document.body.appendChild(gradientOverlay);
  }

  // Function to remove gradient overlay
  function removeGradientOverlay() {
    const gradientOverlay = document.querySelector('.gradient-overlay');
    if (gradientOverlay) {
      gradientOverlay.remove();
    }
  }

  // Apply the toggle state on page load
  document.addEventListener('DOMContentLoaded', function() {
    applyToggleState();

    // Toggle between light and dark mode on switch change
    document.getElementById('dn').addEventListener('change', function() {
      document.documentElement.classList.toggle('dark-mode', this.checked);
      setToggleState(this.checked);
      if (this.checked) {
        addGradientOverlay(); // Add the gradient overlay when switching to dark mode
      } else {
        removeGradientOverlay(); // Remove the gradient overlay when switching to light mode
      }
    });
  });
</script>