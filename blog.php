<?php
include 'partials/header.php';
include 'partials/functions.php';

// fetch all post only
$query = "Select * From posts ORDER BY id desc limit 3";
$posts = mysqli_query($connection, $query);

?>

<section class="search__bar">
  <form class="container search__bar-container" action="<?= ROOT_URL ?>search.php" method="GET">
    <div>
      <i class="uil uil-search"></i>
      <input type="search" name="search" placeholder="Search" required>
    </div>
    <button type="submit" name="submit" class="btn">Go</button>
    <select name="sort" id="sort" class=" btn">
      <option value="title" selected>Search by: Title</option>
      <option value="name">Name</option>
      <option value="category">Category</option>
      <option value="date_time">Time updated</option>
    </select>

    <i class="uil uil-direction"></i>
  </form>
</section>
<!-- <script>
  document.getElementById('sort').addEventListener('change', function() {
    this.form.submit();
  });
</script> -->
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
            <div class="d-flex justify-content-between mb-2" >
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
  <button id="showMoreBtn_post" class="btn" style="display: block;
    margin: 0 auto;">Show More</button>
<?php else : ?>
  <div class="alert__message error lg section__extra-margin">
    <p>No posts found</p>
  </div>
<?php endif ?>
<!-- ===============THE END OF POST SECTION============== -->






<?php
include 'partials/footer.php';
?>
<script>
  $(document).ready(function() {
    $('[data-toggle="popover"]').popover()
  });

</script>
<script src="js/post_info.js"></script>
<script>
  const ROOT_URL = "<?= ROOT_URL ?>"; // Assuming ROOT_URL is defined somewhere

  // Load more for posts
  let offset_post= 3; // Start from the second post
  const limit_post = 3; // Number of posts to load at a time
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