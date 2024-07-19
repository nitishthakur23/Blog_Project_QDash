<?php
include 'partials/header.php';
include 'partials/functions.php';

//fetch current user from database
if (isset($_GET['id'])) {
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $current_user_id = $_SESSION['user-id'];
  $profile_user_id = $id;
  $query = "SELECT avatar,firstname,lastname,about_user,word_desc FROM users WHERE id=$id";
  $result = mysqli_query($connection, $query);
  $profile_info = mysqli_fetch_assoc($result);


  $query_post = "SELECT * FROM posts WHERE author_id=$id";
  $posts = mysqli_query($connection, $query_post);

  $query_followers = "SELECT COUNT(*) as follower_count FROM followers WHERE user_id=$profile_user_id";
  $result_followers = mysqli_query($connection, $query_followers);
  $follower_count = mysqli_fetch_assoc($result_followers)['follower_count'];

  $query_followings = "SELECT COUNT(*) as following_count FROM followers WHERE follower_id=$profile_user_id";
  $result_followings = mysqli_query($connection, $query_followings);
  $following_count = mysqli_fetch_assoc($result_followings)['following_count'];
} else {
  header('location:' . ROOT_URL . 'index.php');
  die();
}
?>
<style>
  <?php include 'css\user_page.css' ?>
</style>
<div class="container container_profile">
  <?php if (isset($_SESSION['follow-success'])) : // shows if add post was successful
  ?>
    <div class="alert__message success container">
      <p>
        <?= $_SESSION['follow-success'];
        unset($_SESSION['follow-success']);
        ?>
      </p>
    </div>
  <?php elseif (isset($_SESSION['follow'])) : // show if category is added successfully
  ?>
    <div class="alert__message error container">
      <p>
        <?= $_SESSION['follow'];
        unset($_SESSION['follow']);
        ?>
      </p>
    </div>
  <?php elseif (isset($_SESSION['un-follow'])) : // show if category is added successfully
  ?>
    <div class="alert__message error container">
      <p>
        <?= $_SESSION['un-follow'];
        unset($_SESSION['un-follow']);
        ?>
      </p>
    </div>
  <?php elseif (isset($_SESSION['un-follow-success'])) : // show if category is added successfully
  ?>
    <div class="alert__message success container">
      <p>
        <?= $_SESSION['un-follow-success'];
        unset($_SESSION['un-follow-success']);
        ?>
      </p>
    </div>
  <?php elseif (isset($_SESSION['editprofile-success'])) : ?>
    <div class="alert__message success container">
      <p>
        <?= $_SESSION['editprofile-success'];
        unset($_SESSION['editprofile-success']);
        ?>
      </p>
    </div>
  <?php endif ?>
  <div class="left_profile">

    <div class="profile-pic">
      <img src="./images/<?= $profile_info['avatar'] ?>">
    </div>
    <div class="word_desc">
      <div style="background:var(--color-primary-light); padding:4px; border:2px solid var(--color-gray-200)"><?= $profile_info['word_desc'] ?></div>
    </div>
  </div>
  <div class="profile-info">
    <div class="name"><?= $profile_info['firstname'] ?> <?= $profile_info['lastname'] ?></div>
    <hr>
    <div class="bio"><?= $profile_info['about_user'] ?></div>
    <div class="follow-form">
      <?php if (isset($_SESSION['user-id']) && $_SESSION['user-id'] != $profile_user_id) {
        $query_follows = "SELECT * FROM followers WHERE user_id = $profile_user_id AND follower_id = $current_user_id";
        $follower_result = mysqli_query($connection, $query_follows);
        if (mysqli_num_rows($follower_result) > 0) {
          echo '<form action="unfollow.php" method="post">';
        } else {
          echo '<form action="follow.php" method="post">';
        }
      } else {
        echo '<form action="signin.php" method="post">';
      }
      ?>
      <?php if (isset($_SESSION['user-id'])) : ?>
        <?php if ($_SESSION['user-id'] != $profile_user_id) : ?>
          <input type="hidden" name="following_id" value="<?= $profile_user_id; ?>">
          <button type="submit" name="follow_btn btn"><?= (isset($_SESSION['user-id'])) ? (mysqli_num_rows($follower_result) > 0 ? 'Unfollow' : 'Follow') : 'Login to follow'; ?></button>
        <?php endif ?>
      <?php else : ?>
        <button type="submit" name="follow_btn btn">Login to follow</button>
      <?php endif ?>
      </form>
    </div>
    <div class="follower_info">
      <?php if (isset($_SESSION['user-id'])) : ?>
        <a href="<?= ROOT_URL ?>followers.php?id=<?= $profile_user_id ?>">
          <div class="followers">Followers: <?= $follower_count ?></div>
        </a>
        <a href="<?= ROOT_URL ?>following.php?id=<?= $profile_user_id ?>">
          <div class="followings">Followings: <?= $following_count ?></div>
        </a>
      <?php else : ?>
        <a href="<?= ROOT_URL ?>signin.php">
          <div class="followers">Followers: <?= $follower_count ?></div>
        </a>
        <a href="<?= ROOT_URL ?>signin.php">
          <div class="followings">Followings: <?= $following_count ?></div>
        </a>
      <?php endif ?>
    </div>
  </div>
</div>
<?php if (mysqli_num_rows($posts) > 0) : ?>
  <section class="posts">
    <section class="section_wave">
      <h1>
        BLOGS </h1>
      <div class="container post__container" id="postcontainer">
        <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
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
              <div class="d-flex justify-content-between mb-2">
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
              </div>

              <a href="<?= ROOT_URL ?>category-post.php?id=<?= $post['category_id'] ?>" class="category__button"><?= $category['title'] ?></a>
              <h3 class="post__title">
                <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
              </h3>
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
        <?php endwhile ?>
      </div>
      <div class='air air1'></div>
      <div class='air air2'></div>
      <div class='air air3'></div>
      <div class='air air4'></div>
    </section>
  </section>
<?php else : ?>
  <div class="alert__message error lg section__extra-margin">
    <p>No posts Uploaded</p>
  </div>
<?php endif ?>
</body>


</html>

</html>
<?php
include 'partials/footer.php'; ?>

<script>
  $(document).ready(function() {
    $('[data-toggle="popover"]').popover()
  });
</script>
<script src="js/post_info.js"></script>

<script>
  const ROOT_URL = "<?= ROOT_URL ?>"; // Assuming ROOT_URL is defined somewhere

  // Load more for category
  let offset_category = 1; // Start from the second post
  const limit_category = 2; // Number of posts to load at a time

  document.getElementById("showMoreBtn_category").addEventListener("click", function() {
    loadMoreCategory();
  });

  function loadMoreCategory() {
    // Make an AJAX request to fetch more posts with the current offset
    const xhr = new XMLHttpRequest();
    xhr.open("GET", ROOT_URL + "load-more-category.php?offset=" + offset_category + "&limit=" + limit_category, true); // Pass offset and limit to the server
    xhr.onreadystatechange = function() {
      if (xhr.readyState == 4 && xhr.status == 200) {
        // Append the response (new posts) to the container
        document.getElementById("categorybuttons").innerHTML += xhr.responseText;
        offset_category += limit_category; // Increment the offset for the next request
        // Check if the response is empty, indicating no more posts
        if (xhr.responseText.trim() === "") {
          // Hide the "Show More" button if no more posts are available
          document.getElementById("showMoreBtn_category").style.display = "none";
        }
      }
    };
    xhr.send();
  }

  // Load more for posts
  let offset_post = 1; // Start from the second post
  const limit_post = 2; // Number of posts to load at a time

  document.getElementById("showMoreBtn_post").addEventListener("click", function() {
    loadMorePosts();
  });

  function loadMorePosts() {
    // Make an AJAX request to fetch more posts with the current offset
    const xhr = new XMLHttpRequest();
    xhr.open("GET", ROOT_URL + "load-more-posts.php?offset=" + offset_post + "&limit=" + limit_post, true); // Pass offset and limit to the server
    xhr.onreadystatechange = function() {
      if (xhr.readyState == 4 && xhr.status == 200) {
        // Append the response (new posts) to the container
        document.getElementById("postcontainer").innerHTML += xhr.responseText;
        offset_post += limit_post; // Increment the offset for the next request
        // Check if the response is empty, indicating no more posts
        if (xhr.responseText.trim() === "") {
          // Hide the "Show More" button if no more posts are available
          document.getElementById("showMoreBtn_post").style.display = "none";
        }
      }
    };
    xhr.send();
  }
</script>
<!-- <script src="/js/main.js"></script> -->