<?php
require 'config/database.php';
//fetch current user from database
if (isset($_SESSION['user-id'])) {
  $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
  $query = "SELECT avatar FROM users WHERE id=$id";
  $result = mysqli_query($connection, $query);
  $avatar = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PHP & MySQL</title>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="<?= ROOT_URL ?>css_bootstrap/bootstrap.css">
  <!--COSTON STYLESHEET-->
  <link rel="stylesheet" type="text/css" href="<?= ROOT_URL ?>css/user_page.css">
  <link rel="stylesheet" type="text/css" href="<?= ROOT_URL ?>css/wakhra.css">
  <link rel="stylesheet" type="text/css" href="<?= ROOT_URL ?>css/text_css.css">
  <link rel="stylesheet" type="text/css" href="<?= ROOT_URL ?>css/toggle_css.css">

  <!--ICON_SCOUT CDN-->

  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/solid.css">
  <!-- Font family -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<!-- Include jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.responsivevoice.org/responsivevoice.js?key=YOUR_UNIQUE_KEY"></script>

<body>
<div class="loader"></div>
<nav>
    <div class="container nav__container">
      <a href="<?= ROOT_URL ?>" class="nav__logo">
        <h2 class="picture_heading">QDash</h2>
      </a>
      <ul class="nav__items">
        <li>
          <div class="toggleWrapper">
            <input type="checkbox" class="dn" id="dn" />
            <label for="dn" class="toggle">
              <span class="toggle__handler">
                <span class="crater crater--1"></span>
                <span class="crater crater--2"></span>
                <span class="crater crater--3"></span>
              </span>
              <span class="star star--1"></span>
              <span class="star star--2"></span>
              <span class="star star--3"></span>
              <span class="star star--4"></span>
              <span class="star star--5"></span>
              <span class="star star--6"></span>
            </label>
          </div>
        </li>
        <li><a href="<?php echo ROOT_URL ?>">Home</a></li>
        <li><a href="<?php echo ROOT_URL ?>blog.php">Blog</a></li>
        <li><a href="<?php echo ROOT_URL ?>all_categories.php">Category</a></li>
        <!-- to locate the file through ROOT_URL -->
        <li><a href="<?php echo ROOT_URL ?>services.php">Services</a></li>
        <?php if (isset($_SESSION['user-id'])) : ?>
          <li class="nav__profile">
            <a href="<?php echo ROOT_URL ?>User_profile.php?id=<?= $_SESSION['user-id'] ?>">
              <div class="avatar">
                <img src="<?= ROOT_URL . 'images/' . $avatar['avatar'] ?>">
              </div>
            </a>
            <ul>
              <li><a href="<?= ROOT_URL ?>Edit-profile.php?id=<?= $_SESSION['user-id'] ?>">
                  Edit Profile</a></li>
                  <?php if(isset($_SESSION['user_is_admin'])) : ?>
                    <li><a href="<?= ROOT_URL ?>admin/subscriptions.php">Subscribers</a></li>
                    <?php endif?>
                  </li>
              <li><a href="<?php echo ROOT_URL ?>admin/index.php">Dashboard</a></li>
              <li><a href="<?php echo ROOT_URL ?>logout.php">Log Out</a></li>
            </ul>
          </li>
        <?php else : ?>
          <li><a href="<?php echo ROOT_URL ?>signin.php">Sign In</a></li>
        <?php endif ?>
      </ul>
      <button id="open__nav-btn"><i class="uis uis-bars"></i></button>
      <button id="close__nav-btn"><i class="uis uis-multiply"></i></button>
    </div>
  </nav>
  <!--==================THE END OF THIS NAV========================-->
  <script>
    window.addEventListener("load", () => {
      const loader = document.querySelector(".loader");

      loader.classList.add("loader--hidden");

      loader.addEventListener("transitionend", () => {
        document.body.removeChild(loader);
      });
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="js_bootstrap/bootstrap.js"></script>
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
<script>
  // Get the video element
  var video = document.getElementById("myVideo");

  // Define the target playback rate
  var targetPlaybackRate = 0.8; // Half speed

  // Set an initial playback rate
  video.playbackRate = targetPlaybackRate;

  // Smoothly adjust the playback rate over time
  var interval = setInterval(function() {
    // Calculate the difference between current and target playback rates
    var delta = targetPlaybackRate - video.playbackRate;

    // If the difference is small, stop adjusting
    if (Math.abs(delta) < 0.01) {
      clearInterval(interval);
    } else {
      // Interpolate the playback rate towards the target
      video.playbackRate += delta * 0.05; // Adjust the smoothness (0.05 is a factor)
    }
  }, 100);
</script>
