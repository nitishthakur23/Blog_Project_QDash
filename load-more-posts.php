<?php
// Include necessary files and establish database connection
include 'config/database.php';
include 'partials/functions.php';
// Define your query to fetch more posts, adjust as needed
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 4; // Offset for pagination
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 3; // Limit for each query, defaults to 2
$query = "SELECT * FROM posts ORDER BY id DESC LIMIT $offset, $limit";
$result = mysqli_query($connection, $query);

// Check if there are more posts to load
if (mysqli_num_rows($result) > 0) {
    // Loop through each post and display HTML markup
    while ($post = mysqli_fetch_assoc($result)) {
        // Output HTML markup for each post
        ?>
       <article class="post">
        <div class="post__thumbnail">
          <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>">
            <img src="./images/<?= $post['thumbnail'] ?>">
          </a>
        </div>
        <div class="post__info">
          <?php
          // fetch category from categories table using category_id of post
          $post_id = $post['id'];
          $category_id = $post['category_id'];
          $category_query = "SELECT * FROM categories WHERE id=$category_id";
          $category_result = mysqli_query($connection, $category_query);
          $category = mysqli_fetch_assoc($category_result);
          $like_count = Fetch_likes($connection, $post_id);
          //fetch likes from likes table

          $view_count = Fetch_views($connection, $post_id);
          //fetch views
          ?>
          <a href="<?= ROOT_URL ?>category-post.php?id=<?= $post['category_id'] ?>" class="category__button"><?= $category['title'] ?></a>
          <button class="view">
            <i class="uil uil-eye"><?= $view_count ?></i>
          </button>
          <h3 class="post__title">
            <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
          </h3>
          <?php if (isset($_SESSION['user-id'])) : ?>
            <?php $current_user_id = $_SESSION['user-id']; ?>
            <?php
            $user_has_liked_post = LikeCount($connection, $post_id, $current_user_id);
            ?>
            <!-- // Like button  -->
            <?php if ($user_has_liked_post) : ?>
              <button class="unlike-btn" data-container="body" data-toggle="popover" data-trigger="hover focus" data-placement="top" data-content="Liked" data-post-id="<?= $post_id ?>"><i class="uil uil-thumbs-up"></i></button>
            <?php else : ?>
              <button class="like-btn" data-container="body" data-toggle="popover" data-trigger="hover focus" data-placement="top" data-content="Like" data-post-id="<?= $post_id ?>"><i class="uil uil-thumbs-up"></i></button>
            <?php endif ?>
          <?php endif ?>
          <!-- Display like count -->
          <span class="like-count" data-post-id="<?= $post_id ?>"><?= $like_count ?></span> Likes
          <?php if (isset($_SESSION['user-id'])) : ?>
            <?php $user_has_saved_posts = Saved_post($connection, $post_id, $current_user_id) ?>
            <!-- // Save button  -->
            <?php if ($user_has_saved_posts) : ?>
              <button class="unsave-btn" data-container="body" data-toggle="popover" data-trigger="hover focus" data-placement="top" data-content="Saved" data-post-id="<?= $post_id ?>"><i class="uil uil-bookmark"></i></button>
            <?php else : ?>
              <button class="save-btn" data-container="body" data-toggle="popover" data-trigger="hover focus" data-placement="top" data-content="Save" data-post-id="<?= $post_id ?>"><i class="uil uil-bookmark"></i></button>
            <?php endif ?>
          <?php endif ?>
          <p class="post__body">
            <?= substr($post['body'], 0, 300) ?>...
          </p>
          <div class="post__author">
            <?php
            // fetch author from users table using author_id
            $author_id = $post['author_id'];
            $author_query = "SELECT * FROM users WHERE id=$author_id";
            $author_result = mysqli_query($connection, $author_query);
            $author = mysqli_fetch_assoc($author_result);

            ?>
            <div class="post__author-avatar">
              <a href="<?php echo ROOT_URL ?>User_profile.php?id=<?= $post['author_id'] ?>">
                <img src="./images/<?= $author['avatar'] ?>">
              </a>
            </div>
            <div class="post__author-info">
              <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
              <small>
                <?= date("M d, Y", strtotime($post['date_time'])) ?>
              </small>
            </div>
          </div>
        </div>
      </article>
        <?php
    }
} else {
    // No more posts to load
}
?>
