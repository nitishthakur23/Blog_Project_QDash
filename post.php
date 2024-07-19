<?php
include 'partials/header.php';
include 'partials/functions.php';

// fetch post from database if id is set
if (isset($_GET['id'])) {
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $post_id = $id;
  $query = "SELECT * FROM posts WHERE id=$id";
  $result = mysqli_query($connection, $query);
  $post = mysqli_fetch_assoc($result);
  //increment view count
  $sql = "UPDATE posts SET views = views + 1 WHERE id = $id";
  $result = mysqli_query($connection, $sql);
} else {
  header('location:' . ROOT_URL . 'blog.php');
  die();
}
?>

<!-- ============Single Post============= -->
<section class="singlepost">
  <div class="container singlepost__container">
    <h2><?= $post['title'] ?></h2>
    <div class="post__author">
      <?php
      // fetch author from users table using author_id
      $author_id = $post['author_id'];
      $author_query = "SELECT * FROM users WHERE id=$author_id";
      $author_result = mysqli_query($connection, $author_query);
      $author = mysqli_fetch_assoc($author_result);
      ?>
      <div class="post__author-avatar">
        <img src="./images/<?= $author['avatar'] ?>">
      </div>
      <div class="post__author-info">
        <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
        <small>
          <?= date("M d, Y", strtotime($post['date_time'])) ?>
        </small>
      </div>
    </div>
    <?php
    // fetch category from categories table using category_id of post
    $category_id = $post['category_id'];
    $category_query = "SELECT * FROM categories WHERE id=$category_id";
    $category_result = mysqli_query($connection, $category_query);
    $category = mysqli_fetch_assoc($category_result);
    $like_count = Fetch_likes($connection, $post_id);
    //fetch likes from likes table

    $view_count = Fetch_views($connection, $post_id);
    //fetch views
    ?>
    <div class="d-flex justify-content-between align-items-center mb-2">
      <div>
        <button class="view">
          <i class="uil uil-eye"><?= $view_count ?></i>
        </button>
      </div>
      <div>
        <?php if (isset($_SESSION['user-id'])) : ?>
          <?php $current_user_id = $_SESSION['user-id']; ?>
          <?php
          $user_has_liked_post = LikeCount($connection, $post_id, $current_user_id);
          ?>
          <!-- // Like button  -->
          <?php if ($user_has_liked_post) : ?>
            <button class="like-btn" data-container="body" data-toggle="popover" data-trigger="hover focus" data-placement="top" data-content="Liked" data-post-id="<?= $post_id ?>"><i class="uil uil-thumbs-up"></i></button>
          <?php else : ?>
            <button class="unlike-btn" data-container="body" data-toggle="popover" data-trigger="hover focus" data-placement="top" data-content="Like" data-post-id="<?= $post_id ?>"><i class="uil uil-thumbs-up"></i></button>
          <?php endif ?>
        <?php endif ?>
        <!-- Display like count -->
        <span class="like-count" data-post-id="<?= $post_id ?>"><?= $like_count ?></span> Likes
      </div>
      <div>
        <?php if (isset($_SESSION['user-id'])) : ?>
          <?php $user_has_saved_posts = Saved_post($connection, $post_id, $current_user_id) ?>
          <!-- // Save button  -->
          <?php if ($user_has_saved_posts) : ?>
            <button class="save-btn" data-container="body" data-toggle="popover" data-trigger="hover focus" data-placement="top" data-content="Saved" data-post-id="<?= $post_id ?>"><i class="uil uil-bookmark"></i></button>
          <?php else : ?>
            <button class="unsave-btn" data-container="body" data-toggle="popover" data-trigger="hover focus" data-placement="top" data-content="Save" data-post-id="<?= $post_id ?>"><i class="uil uil-bookmark"></i></button>
          <?php endif ?>
        <?php endif ?>
      </div>
      <div>
      <?php if (isset($_SESSION['user-id'])) : ?>

        <a href="#comments-section">
          <button id="commentButton" class="unsave-btn" data-container="body" data-toggle="popover" data-trigger="hover focus" data-placement="top" data-content="Comment"><i class="uil uil-comments"></i></button>
          <?php endif ?>
        </a>
      </div>
    </div>
    <a href="<?= ROOT_URL ?>category-post.php?id=<?= $post['category_id'] ?>" class="category__button"><?= $category['title'] ?></a>

    <div class="singlepost__thumbnail">
      <img src="images/<?= $post['thumbnail'] ?>">
    </div>


    <p id="post-content"><?= $post['body'] ?></p>
    <!-- Comments section -->
    <div id="comments-section">
      <h3 style="margin-top: 6rem;">Comments</h3>
      <div class="comments_width">
        <div id="comments-list">
        </div>
      </div>
      <!-- Comment form -->
      <h3 style="margin-top: 1rem;">Add a Comment</h3>
      <form id="comment-form" class="comment_form">
        <input type="hidden" id="post-id" name="post_id" value="<?= $id ?>">
        <label for="comment">Comment:</label>
        <textarea id="comment" name="comment" required></textarea>
        <button type="submit" class="btn">Submit</button>
      </form>
    </div>
  </div>
</section>




<!-- ===============THE END OF SINGLE POST============== -->

<?php
include 'partials/footer.php';
?>
<script>
  $(document).ready(function() {
    $('[data-toggle="popover"]').popover()
  });
</script>
<script src="js/post_info.js"></script>