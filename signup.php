<?php
require 'config/constants.php';
// get back form data if there was a registration error
$firstname = $_SESSION['signup-data'] ['firstname']?? null;
$lastname = $_SESSION['signup-data']['lastname']?? null;
$username = $_SESSION['signup-data'] ['username']?? null;
$email = $_SESSION['signup-data'] ['email']?? null;
$about_user = $_SESSION['signup-data'] ['about_user']?? null;
$word_desc = $_SESSION['signup-data'] ['word_desc']?? null;
$createpassword = $_SESSION['signup-data'] ['createpassword']?? null;
$confirmpassword = $_SESSION['signup-data']['confirmpassword']?? null;

//delete signup data session
unset($_SESSION['sign-data']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Multipage Bloge website</title>

    <!--COSTON STYLESHEET-->

    <link rel="stylesheet" href="<?= ROOT_URL ?>css/wakhra.css">

    <!--ICON_SCOUT CDN-->

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/solid.css">
    <!-- Font family -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
<section class="section_wave">

    <section class="form__section " style="padding-bottom:8rem;">
        <div class="container form__section-container">
            <h2>Sign Up & Profile Setup</h2>
            <?php if (isset($_SESSION['signup'])) : ?> 
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['signup'];
                        unset($_SESSION['signup']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>signup-logic.php" enctype="multipart/form-data" method="post">
                <!-- entype because of file upload -->
                <input type="text" name="firstname" value="<?=$firstname?>" placeholder="First Name">
                <input type="text" name="lastname" value="<?=$lastname?>" placeholder="Last Name">
                <input type="text" name="username" value="<?=$username?>" placeholder="Username">
                <input type="email" name="email" value="<?=$email?>" placeholder="Email">
                <textarea name="about_user" placeholder="Bio."><?=$about_user?></textarea>
                <input type="text" name="word_desc" value="<?=$word_desc?>" placeholder="A word that describes your personality.">
                <input type="password" name="createpassword" value="<?=$createpassword?>" placeholder="Create Password">
                <input type="password" name="confirmpassword" value="<?=$confirmpassword?>" placeholder="Confirm Password">
                <div class="form__control">
                    <label for="avatar">User avatar</label>
                    <input name="avatar" type="file" id="avatar">
                </div>
                <button type="submit" name="submit" class="btn">Sign Up</button>
                <small>Already have an account?<a href="signin.php">Sign In</a></small>
            </form>
        </div>
    </section>
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
