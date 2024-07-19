<?php
// Include necessary files and establish database connection
include 'config/database.php';
include 'partials/functions.php';
// Define your query to fetch more posts, adjust as needed
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 4; // Offset for pagination
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 3; // Limit for each query, defaults to 2
$query = "SELECT * FROM categories ORDER BY id DESC LIMIT $offset, $limit";
$result = mysqli_query($connection, $query);

// Check if there are more posts to load
if (mysqli_num_rows($result) > 0) {
    // Loop through each post and display HTML markup
   while ($category = mysqli_fetch_assoc($result)) {?>
        <a href="<?= ROOT_URL ?>category-post.php?id=<?= $category['id'] ?>" class="category__button"><?= $category['title'] ?></a>    
        <?php
    }
} else {
    // No more posts to load
}
?>
