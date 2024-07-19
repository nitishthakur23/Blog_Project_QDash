<?php
session_start();
require 'config/database.php';

if (isset($_POST['submit'])) {
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Data validation
    if (empty($title)) {
        $_SESSION['add-category'] = "Enter title";
    } elseif (empty($description)) {
        $_SESSION['add-category'] = "Enter description";
    } else {
        // Insert category into database
        $query = "INSERT INTO categories (title, description) VALUES ('$title', '$description')";
        $result = mysqli_query($connection, $query);

        if (!$result) {
            $_SESSION['add-category'] = "Couldn't add category: " . mysqli_error($connection);
        } else {
            $_SESSION['add-category-success'] = "Category '$title' added successfully";
            header('location:' . ROOT_URL . 'admin/manage-categories.php');
            die();
        }
    }

    // Redirect back to add category page with form data if there was invalid input
    $_SESSION['add-category-data'] = $_POST;
    header('location:' . ROOT_URL . 'admin/add-category.php');
    die();
}
