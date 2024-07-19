<?php
include 'partials/header.php';
include 'partials/functions.php';
$search = isset($_GET['search']) ? filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
$categories_query = "SELECT * FROM categories ORDER BY id DESC limit 3";
if (!empty($search)) {
    $categories_query = "SELECT * FROM categories WHERE title LIKE '$search%'";
    $search=null;
}
$categories = mysqli_query($connection, $categories_query);
?>

<section class="search__bar">
  <form class="container search__bar-container" action="<?= ROOT_URL ?>all_categories.php" method="GET">
    <div>
      <i class="uil uil-search"></i>
      <input type="search" name="search" placeholder="Search" required>
    </div>
    <button type="submit" name="submit" class="btn">Go</button>
     </form>
</section>


<section class="section_wave">
<section class="category__buttons">
  <h1>
    CATEGORY</h1>
  <div class="container category__buttons-container" id="categorybuttons">
    <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
      <a href="<?= ROOT_URL ?>category-post.php?id=<?= $category['id'] ?>" class="category__button"><?= $category['title'] ?></a>
    <?php endwhile ?>
  </div>
  <?php 
if ($search !== null) {
    echo '<button id="showMoreBtn_category" class="btn" style="display: block; margin: 0 auto;">Show More</button>';
}
echo $search; // This will display the value of $search

?>
</section>
  
<!-- ===========END OF CATEGORY BUTTON============= -->



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

  // Load more for category
  let offset_category = 3; // Start from the second post
  const limit_category = 3; // Number of posts to load at a time

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


</script>