<?php
include 'partials/header.php';

// fetch posts if id is set
if (isset($_GET['id'])) {
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $query = "SELECT * FROM posts WHERE category_id=$id ORDER BY date_time DESC";
  $posts = mysqli_query($connection, $query);
} else {
  header('location:' . ROOT_URL . 'blog.php');
  die();
}
?>

<header class="category__title">
  <h2>
  <?php
  // fetch author from users table using author_id
  $category_id = $id;
  $author_query = "SELECT * FROM categories WHERE id=$category_id";
  $author_result = mysqli_query($connection, $author_query);
  $author = mysqli_fetch_assoc($author_result);
  echo $author['title'];
  ?>
  </h2>
</header>


<?php if(mysqli_num_rows($posts)>0):?>
<!-- Post section  -->
<section class="posts">
  <div class="container post__container">
    <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
      <article class="post">
        <div class="post__thumbnail">
          <a href="<?= ROOT_URL ?>post.php?=<?= $post['id'] ?>">
            <img src="./images/<?= $post['thumbnail'] ?>">
          </a>
        </div>
        <div class="post__info">
          <h3 class="post__title">
            <a href="<?= ROOT_URL ?>post.php?=<?= $post['id'] ?>"><?= $post['title'] ?></a>
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
              <img src="./images/<?= $author['avatar'] ?>">
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
</section>
<?php else:?>
  <div class="alert__message error lg">
    <p>No posts found for this category</p>
  </div>
  <?php endif?>
<!-- ===============THE END OF POST SECTION============== -->

<section class="category__buttons">
<h1 data-text="Trending Post">
Popular  category</h1>
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
<!-- ===========END OF CATEGORY BUTTON============= -->

<?php
include 'partials/footer.php';
?>