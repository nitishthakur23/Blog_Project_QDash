<?php
require 'config/database.php';
//get signup form data if signup button is clicked

if (isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $about_user = filter_var($_POST['about_user'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $word_desc = filter_var($_POST['word_desc'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    // $avatar = $_FILES['avatar'];
    //validate input values
    if (!$firstname) {
        $_SESSION['signup'] = "Please enter your First Name.";
    } elseif (!$lastname) {
        $_SESSION['signup'] = "Please enter your Last Name.";
    } elseif (!$username) {
        $_SESSION['signup'] = "Please enter your Username";
    } elseif (!$email || !strpos($email, '@')) {
        $_SESSION['signup'] = "Please enter valid email";
    } elseif (!$about_user) {
        $_SESSION['signup'] = "Please enter your Bio.";
    } elseif (!$word_desc) {
        $_SESSION['signup'] = "Please enter a word that describes you.";
    } elseif (strlen($createpassword) < 8) {
        $_SESSION['signup'] = "Password should be 8+ characters";
    } elseif ($_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['signup'] = "Error uploading avatar. Please try again.";
    } else {
        //check if password match
        if ($createpassword != $confirmpassword) {
            $_SESSION['signup'] = "Password do not match";
        } else {
            //hash password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            // check if username or email already exist in database
            $user_check_query = "Select * from users where username='$username' OR email='$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);
            if (mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['signup'] = "Username or Email already exist";
            } else {
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
                        } else {
                            $_SESSION['signup'] = "Error uploading avatar. Please try again.";
                        }
                    } else {
                        $_SESSION['signup'] = "File size too big. Should be less than 1mb";
                    }
                } else {
                    $_SESSION['signup'] = "File should be png, jpg, or jpeg";
                }
            }
        }
    }


    // redirect back to sign up page if there is any error
    if (isset($_SESSION['signup'])) {
        // pass form data back to sigup page
        $_SESSION['signup-data'] = $_POST;
        header('location:' . ROOT_URL . 'signup.php');
        die();
    } else {
        // insert new user into users table
        $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, about_user,word_desc, password, avatar, is_admin) VALUES ('$firstname', '$lastname', '$username', '$email','$about_user','$word_desc', '$hashed_password', '$avatar_name', 0)";
        $insert_user_query = mysqli_query($connection, $insert_user_query);
        if (!mysqli_errno($connection)) {
            //redirect to login page with success message
            $_SESSION['signup-success'] = "Registration successful. Please log in.";
            header('location:' . ROOT_URL . 'signin.php');
            die();
        }
    }
} else {
    //if button was not clicked, bounce back to the signup page
    header('location:' . ROOT_URL . 'signup.php');
    die();
}