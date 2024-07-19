<?php
include 'partials/header.php';

// fetch current user's posts from database
$current_user_id = $_SESSION['user-id'];
$search = isset($_GET['search']) ? filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
$query_save="SELECT * FROM saved_posts WHERE user_id=$current_user_id ORDER BY saved_at DESC";
$saved_post=mysqli_query($connection, $query_save);
$save_post_id_array = [];
while ($row = mysqli_fetch_assoc($saved_post)) {
    $save_post_id_array[] = $row['post_id'];
}
$query_Post = "SELECT id, title, category_id FROM posts WHERE id IN (" . implode(',', $save_post_id_array) . ")";
if (!empty($search)) {
    $query = "SELECT id, title, category_id  FROM posts WHERE title LIKE '$search%' and id IN (" . implode(',', $save_post_id_array) . ")";
}
$posts = mysqli_query($connection, $query_Post);
?>

<section class="dashboard">
        <?php if (isset($_SESSION['delete-saved-post-success'])) : // show if category is added successfully
    ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['delete-saved-post-success'];
                unset($_SESSION['delete-saved-post-success']);
                ?>
            </p>
        </div>
    <?php endif ?>
    <div class="container dashboard__container">
        <button id="show__sidebar-btn" class="sidebar__toggle"><i class="uil uil-arrow-circle-left"></i></button>
        <button id="hide__sidebar-btn" class="sidebar__toggle"><i class="uil uil-arrow-circle-right"></i></button>
        <aside>
            <ul>
                <li>
                    <a href="add-post.php"><i class="uil uil-postcard"></i>
                        <h5>Add Post</h5>
                    </a>
                </li>
                <li>
                    <a href="index.php" ><i class="uil uil-edit"></i>
                        <h5>Manage Post</h5>
                    </a>
                </li>
                <li>
                    <a href="saved_posts.php"class="active"><i class="uil uil-file-bookmark-alt"></i>
                        <h5>Saved Post</h5>
                    </a>
                </li>
                <?php if (isset($_SESSION['user_is_admin'])) : ?>

                    <li>
                        <a href="add-user.php"><i class="uil uil-user-plus"></i>
                            <h5>Add User</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-user.php"><i class="uil uil-users-alt"></i>
                            <h5>Manage User</h5>
                        </a>
                    </li>
                    <li>
                        <a href="add-category.php"><i class="uil uil-list-ul"></i>
                            <h5>Add Category</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-categories.php"><i class="uil uil-edit"></i>
                            <h5>Manage Category</h5>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </aside>
        <main>
            <h2> Saved Posts</h2>
            <form class="search__bar-container" action="index.php" method="get">
                <div>
                    <i class="uil uil-search"></i>
                    <input type="search" name="search" placeholder="Search">
                </div>
                <button type="submit" name="submit" class="btn">Go</button>
            </form>
            <?php if (mysqli_num_rows($posts) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Saved On</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
                            <!-- get category title of each post from categories table -->
                            <?php
                            $category_id = $post['category_id'];
                            $category_query = "SELECT title FROM categories WHERE id=$category_id";
                            $category_result = mysqli_query($connection, $category_query);
                            $category = mysqli_fetch_assoc($category_result);
                            $current_post_id=$post['id'];
                            $query_save="SELECT * FROM saved_posts WHERE user_id=$current_user_id and post_id=$current_post_id";
                            $saved_post_query=mysqli_query($connection, $query_save);
                            $save_post = mysqli_fetch_assoc($saved_post_query);
                            ?>
                            <tr>
                                <td><?= $post['title'] ?></td>
                                <td><?= $category['title'] ?></td>
                                <td><small>
                <?= date("M d, Y", strtotime($save_post['saved_at'])) ?>
              </small></td>
                                <td><a href="<?= ROOT_URL ?>admin/delete-saved-post.php?id=<?= $post['id']?>" class="btn sm danger">Delete</a></td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="alert__message error"><?= "No post found." ?></div>
            <?php endif ?>
        </main>
    </div>
</section>
<script src="<?= ROOT_URL?>/js/side_bar.js"></script>

<?php
include '../partials/footer.php';
?>