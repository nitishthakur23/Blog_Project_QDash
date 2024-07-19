<?php
require 'config/constants.php';
// get back form data if there was a registration error
$username = $_SESSION['signup-data'] ['username']?? null;
$email = $_SESSION['signup-data'] ['email']?? null;
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
    <section class="form__section">
        <div class="container form__section-container">
            <h2>Sign Up</h2>
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
                <input type="text" name="username" value="<?=$username?>" placeholder="Username">
                <input type="email" name="email" value="<?=$email?>" placeholder="Email">
                <input type="password" name="createpassword" value="<?=$createpassword?>" placeholder="Create Password">
                <input type="password" name="confirmpassword" value="<?=$confirmpassword?>" placeholder="Confirm Password">                <button type="submit" name="submit" class="btn">Send Email</button>
                <small>Already have an account?<a href="signin.php">Sign In</a></small>
            </form>
        </div>
    </section>
</body>
</html>
