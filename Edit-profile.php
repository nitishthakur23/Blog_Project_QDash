<?php
include 'partials/header.php';
//fetch current user from database
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $current_user_id = $_SESSION['user-id'];
    $profile_user_id = $id;
    $query = "SELECT avatar,firstname,lastname,about_user,word_desc FROM users WHERE id=$current_user_id";
    $result = mysqli_query($connection, $query);
    $profile_info = mysqli_fetch_assoc($result);
}
else {
    header('location:' . ROOT_URL . 'index.php');
    die();
  }
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
            <h2>Edit Profile</h2>
            <?php if (isset($_SESSION['editprofile'])) : ?> 
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['editprofile'];
                        unset($_SESSION['editprofile']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>Edit-profile-logic.php?id=<?=$profile_user_id?>" enctype="multipart/form-data" method="post">
                <!-- entype because of file upload -->
                <input type="text" name="firstname" value="<?=$profile_info['firstname']?>" placeholder="First Name">
                <input type="text" name="lastname" value="<?=$profile_info['lastname']?>" placeholder="Last Name">
                <textarea name="about_user"><?=$profile_info['about_user']?></textarea>
                <input type="text" name="word_desc" value="<?=$profile_info['word_desc']?>" placeholder="A word that describes your personality.">
                <div class="form__control">
                    <label for="avatar">User avatar</label>
                    <input name="avatar" type="file" id="avatar">
                </div>
                <button type="submit" name="submit" class="btn">Edit Profile</button>
            </form>
        </div>
    </section>
</body>
</html>
