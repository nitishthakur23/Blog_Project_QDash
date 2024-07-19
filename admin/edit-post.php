<?php
include 'partials/header.php';
// fetch categories from database
$category_query = "SELECT * FROM categories";
$category = mysqli_query($connection, $category_query);


// fetch post data from database if id is set
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $post = mysqli_fetch_assoc($result);
}else{
    header('location:'.ROOT_URL.'admin/');
    die();
}
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit Post</h2>
        <form action="<?=ROOT_URL?>admin/edit-post-logic.php" enctype="multipart/form-data" method="post">
        <input type="hidden" value="<?=$post['id']?>" name="id">
        <input type="hidden" value="<?=$post['thumbnail']?>" name="previous_thumbnail_name">
            <input type="text" name="title" value="<?= $post['title']?>"placeholder="Title">
            <select name="category">
                <?php while ($categories = mysqli_fetch_assoc($category)) : ?>
                    <option value="<?= $categories['id'] ?>"><?= $categories['title'] ?></option>
                <?php endwhile ?>
            </select>
            <textarea rows="10" name="body" placeholder="Body"><?=$post['body']?></textarea>
            <?php if(isset($_SESSION['user_is_admin'])):?>
                <div class="form__control inline">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" checked>
                    <label for="is_featured" checked>Featured</label>
                </div>
                <?php endif?>
            <div class="form__control">
                <label for="thumbnail">Update Thumbnail</label>
                <input type="file" id="thumbnail" name="thumbnail">
            </div>
            <button type="submit" name="submit" class="btn">Update Post</button>
        </form>
    </div>
</section>

<?php
include '../partials/footer.php'
?>