<?php
require 'config/database.php';
//get editprofile form data if editprofile button is clicked

if (isset($_POST['submit']) && isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $about_user = filter_var($_POST['about_user'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $word_desc = filter_var($_POST['word_desc'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    // $avatar = $_FILES['avatar'];
    //validate input values
    if (!$firstname) {
        $_SESSION['editprofile'] = "Please enter your First Name.";
    } elseif (!$lastname) {
        $_SESSION['editprofile'] = "Please enter your Last Name.";
    } elseif (!$about_user) {
        $_SESSION['editprofile'] = "Please enter your Bio.";
    } elseif (!$word_desc) {
        $_SESSION['editprofile'] = "Please enter a word that describes you.";
    } else {
        if(isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            // fetch user from database
            $query = "SELECT * FROM users WHERE id=$id";
            $result = mysqli_query($connection, $query);
            $user = mysqli_fetch_assoc($result);

            // make sure we got back only one user
            if (mysqli_num_rows($result) == 1) {
                $avatar_name = $user['avatar'];
                $avatar_path = '../images/' . $avatar_name;
                // delete image if available 
                if ($avatar_path) {
                    unlink($avatar_path);
                }
            }
            // Work on Avatar rename avatar
            $time = time(); // Make each image unique
            $avatar_name = $time . $_FILES['avatar']['name'];
            $avatar_tmp_name = $_FILES['avatar']['tmp_name'];
            $avatar_size = $_FILES['avatar']['size'];
            $avatar_destination_path = 'images/' . $avatar_name;

            // Make sure file is an image
            $allowed_files = ['png', 'jpg', 'jpeg'];
            $extention = strtolower(pathinfo($avatar_name, PATHINFO_EXTENSION));
            if (in_array($extention, $allowed_files)) {
                // Make sure image is not too large (1mb+)
                if ($avatar_size < 4000000) { // 4MB
                    // Upload avatar
                    if (move_uploaded_file($avatar_tmp_name, $avatar_destination_path)) {
                        // File uploaded successfully, continue processing
                        $insert_user_query = "UPDATE  users SET avatar='$avatar_name' where id=$id";
                        $insert_user_query = mysqli_query($connection, $insert_user_query);
                        if (mysqli_errno($connection)) {
                            //if button was not clicked, bounce back to the admin page
                            header("Location: " . ROOT_URL . "Edit-profile.php?id=$id");
                            die();
                        }
                    } else {
                        $_SESSION['editprofile'] = "Error uploading avatar. Please try again.";
                    }
                } else {
                    $_SESSION['editprofile'] = "File size too big. Should be less than 1mb";
                }
            } else {
                $_SESSION['editprofile'] = "File should be png, jpg, or jpeg";
            }
        }
    }

    // redirect back to sign up page if there is any error
    if (isset($_SESSION['editprofile'])) {
        header("Location: " . ROOT_URL . "Edit-profile.php?id=$id");
        die();
    } else {
        // insert new user into users table
        $insert_user_query = "UPDATE users
        SET firstname = '$firstname', 
            lastname = '$lastname', 
            about_user = '$about_user',
            word_desc = '$word_desc'
        WHERE id = $id;
        ";
        $insert_user_query = mysqli_query($connection, $insert_user_query);
        if (!mysqli_errno($connection)) {
            //redirect to login page with success message
            $_SESSION['editprofile-success'] = "Edit Profile is successful.";
            header("Location: " . ROOT_URL . "User_profile.php?id=$id");
            die();
        }
    }
} else {
    //if button was not clicked, bounce back to the Edit page
    header("Location: " . ROOT_URL . "Edit-profile.php?id=$id");
    die();
}
