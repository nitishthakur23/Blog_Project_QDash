<?php
include 'partials/header.php';
include 'partials/functions.php';
// fetch featured post from database
$featured_query = "SELECT * FROM posts WHERE is_featured=1";
$featured_result = mysqli_query($connection, $featured_query);

// fetch 9 post only
$query = "Select * From posts ORDER BY date_time desc limit 6";
$posts = mysqli_query($connection, $query);

//trending posts
$query_trend = "Select * From posts order by views and date_time desc limit 6";
$posts_trending = mysqli_query($connection, $query_trend);
?>


<!-- show featured if present -->
<?php if (mysqli_num_rows($featured_result)) : ?>
  <section class="featured">
    <!-- Video element -->
    <video autoplay muted loop>
      <source src="images/vecteezy_cartoon-animated-clouds-in-the-sky_1790830.mp4" type="video/mp4">
    </video>
    <!-- <div class="gradient-overlay"></div> -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        <?php
        $count = 0; // Initialize count variable outside the loop
        while ($featured = mysqli_fetch_assoc($featured_result)) :
        ?>
          <div class="carousel-item <?= $count == 0 ? 'active' : '' ?>"> <!-- Check if count is 0 -->
            <div class="container featured__container">
              <div class="post__thumbnail">
                <img src="./images/<?= $featured['thumbnail'] ?>">
              </div>
              <div class="post__info">
                <?php
                // fetch category from categories table using category_id of post
                $category_id = $featured['category_id'];
                $category_query = "SELECT * FROM categories WHERE id=$category_id";
                $category_result = mysqli_query($connection, $category_query);
                $category = mysqli_fetch_assoc($category_result);
                ?>
                <a href="<?= ROOT_URL ?>category-post.php?id=<?= $category['id'] ?>" class="category__button"><?= $category['title'] ?></a>
                <h2 class="post__title"><a href="<?= ROOT_URL ?>post.php?id=<?= $featured['id'] ?>">
                    <?= $featured['title'] ?></a></h2>
                <p class="post__body">
                  <?= substr($featured['body'], 0, 150) ?>...
                </p>
                <div class="post__author">
                  <?php
                  // fetch author from users table using author_id
                  $author_id = $featured['author_id'];
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
                      <?= date("M d, Y", strtotime($featured['date_time'])) ?>
                    </small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php
          $count++; // Increment count after each iteration
        endwhile;
        ?>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </section>
<?php endif ?>
<!-- =========================THE End OF FEATURES ==================== -->



<section class="posts <?= $featured_result ? '' : '.section__extra-margin ' ?>">
  <div class="trend_head container">
    Trending Posts <i class="uil uil-arrow-growth"></i>
  </div>
  <div class="container post__container">
    <?php while ($post = mysqli_fetch_assoc($posts_trending)) : ?>
      <article class="post trend_post">
        <span class="counter"></span>
        <div class="post__info">
          <div class="post__author">
            <?php
            // fetch author from users table using author_id
            $post_id = $post['id'];
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
          <a href="<?= ROOT_URL ?>category-post.php?id=<?= $post['category_id'] ?>" class="category__button"><?= $category['title'] ?></a>
          
          <button class="view">
            <i class="uil uil-eye"><?= $view_count ?></i>
          </button>
          <h3 class="post__title">
            <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
          </h3>
          <div class="d-flex justify-content-between mb-2">
            <div>
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
            </div>
            <div>
          <?php if (isset($_SESSION['user-id'])) : ?>
            <?php $user_has_saved_posts = Saved_post($connection, $post_id, $current_user_id) ?>
            <!-- // Save button  -->
            <?php if ($user_has_saved_posts) : ?>
              <button class="unsave-btn" data-container="body" data-toggle="popover" data-trigger="hover focus" data-placement="top" data-content="Saved" data-post-id="<?= $post_id ?>"><i class="uil uil-bookmark"></i></button>
            <?php else : ?>
              <button class="save-btn" data-container="body" data-toggle="popover" data-trigger="hover focus" data-placement="top" data-content="Save" data-post-id="<?= $post_id ?>"><i class="uil uil-bookmark"></i></button>
            <?php endif ?>
            </div>
          </div>
          <?php endif ?>
        </div>
      </article>
    <?php endwhile ?>
  </div>
</section>
<!-- ===============THE END OF TRENDING SECTION============== -->

<section class="posts">
  <section class="section_wave">
    <h1>
      Posts For You</h1>
    <div class="container post__container">
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
<!-- ===============THE END OF POST SECTION============== -->


<section class="category__buttons">
  <section class="section_wave">
    <h1>
      Popular category</h1>
    <div class="container category__buttons-container">
      <?php
      $all_categories_query = "SELECT * FROM categories limit 6";
      $all_categories = mysqli_query($connection, $all_categories_query);
      ?>
      <?php while ($category = mysqli_fetch_assoc($all_categories)) : ?>
        <a href="<?= ROOT_URL ?>category-post.php?id=<?= $category['id'] ?>" class="category__button"><?= $category['title'] ?></a>
      <?php endwhile ?>
    </div>
  </section>
</section>

<!-- ===========END OF CATEGORY BUTTON============= -->

<div class="container_email">
  <h2 style="text-align:center;">Subscribe to Our Newsletter</h2>
  <div class="dots">
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
  </div>
  <div class="email_content">
    <img class="email_img" src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/256492/cXsiNryL.png" alt="Car">
    <form action="subcri_email.php" method="post" class="email_form" id="emailForm">
      <input type="text" name="name" id="nameInput" placeholder="Enter your name" required>
      <input type="email" name="email" id="emailInput" placeholder="Enter your email" required>
      <button type="submit" name="Submit">Subscribe</button>
    </form>
  </div>
</div>
<div class="modal fade" id="exampleModalCenter_yes" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Email Subscription</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Congratulations! You've successfully subscribed to our email updates.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="exampleModalCenter_no" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Email Subscription</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>You are already subscribed to our email updates.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<?php
include 'partials/footer.php';
?>

</body>
<script>
  $(document).ready(function() {
    $('[data-toggle="popover"]').popover()
  });
</script>
<script src="js/post_info.js"></script>

<script>
  const trend_posts = document.querySelectorAll('.trend_post');
  let counter = 1;

  trend_posts.forEach((trend_post) => {
    const counterElement = trend_post.querySelector('.counter');
    counterElement.textContent = `0${counter}`;
    counter++;
  });
  $('#myModal').on('shown.bs.modal', function() {
    $('#myInput').trigger('focus')
  })
</script>
<script>
  $(document).ready(function() {
    $('input[type="email"]').on('input', function() {
      if ($(this).val() !== '') {
        $('button[name="Submit"]').addClass('active');
      } else {
        $('button[name="Submit"]').removeClass('active');
      }
    });
  });
</script>

<script>
  $(document).ready(function() {
    // Submit the form via AJAX when it's submitted
    $('#emailForm').submit(function(e) {
      e.preventDefault(); // Prevent the default form submission

      $.ajax({
        type: 'POST',
        url: 'subcri_email.php', // URL of the PHP script
        data: $(this).serialize(), // Serialize the form data
        success: function(response) {
          var trimmedResponse = response.trim(); // Trim the response
          console.log('Response from server:', response);
          if (trimmedResponse === '') {
            // Handle empty response
            console.error('Empty response from server');
            // Check the response from the server
          } else if (trimmedResponse === 'already_subscribed') {
             // Clear input values
             $('#nameInput').val('');
            $('#emailInput').val('');
        // This code will execute when the DOM content is fully loaded
        $('#exampleModalCenter_no').modal('show');
    
          } else if (trimmedResponse === 'success') {
            // Clear input values
            $('#nameInput').val('');
            $('#emailInput').val('');
            // If successful subscription, display modal
            $('#exampleModalCenter_yes').modal('show');
          } else {
            // Handle unexpected response
            console.error('Unexpected response from server:', response);
          }
        },
        error: function(xhr, status, error) {
          // Handle errors
          console.error('AJAX error:', error);
        }
      });
    });
  });
</script>

</html>
<!-- nitishthakur2004@gmail.com -->