<?php
include 'partials/header.php';
// fetch categories from database
$search = isset($_GET['search']) ? filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
$query = "SELECT * FROM categories ORDER BY title";
if (!empty($search)) {
    $query = "SELECT * FROM categories WHERE title LIKE '$search%'";
}
$categories = mysqli_query($connection, $query);
?>
<section class="dashboard">
    <?php if (isset($_SESSION['edit-category-success'])) : // show if category is added is successfully
    ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['edit-category-success'];
                unset($_SESSION['edit-category-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-category'])) : // show if category info is changed successfully
    ?>
        <div class="alert__message error container">
            <p>
                <?= $_SESSION['edit-category'];
                unset($_SESSION['edit-category']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['add-category'])) : // show if category is added successfully
    ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['add-category'];
                unset($_SESSION['add-category']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['add-category-success'])) : // show if user info is changed successfully
    ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['add-category-success'];
                unset($_SESSION['add-category-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['delete-category-success'])) : // show if category is deleted successfully
    ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['delete-category-success'];
                unset($_SESSION['delete-category-success']);
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
                    <a href="index.php"><i class="uil uil-edit"></i>
                        <h5>Manage Post</h5>
                    </a>
                </li>
                <li>
                    <a href="saved_posts.php"><i class="uil uil-file-bookmark-alt"></i>
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
                        <a href="manage-categories.php" class="active"><i class="uil uil-edit"></i>
                            <h5>Manage Category</h5>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </aside>
        <main>
            <h2> Manage Categories</h2>
            <form class="search__bar-container" action="manage-categories.php" method="get">
                <div>
                    <i class="uil uil-search"></i>
                    <input type="search" name="search" placeholder="Search">
                </div>
                <button type="submit" name="submit" class="btn">Go</button>
            </form>
                <?php if (mysqli_num_rows($categories) > 0) : ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
                                <tr>
                                    <td><?= $category['title'] ?></td>
                                    <td><a href="<?= ROOT_URL ?>admin/edit-category.php?id=<?= $category['id'] ?>" class="btn sm">Edit</a></td>
                                    <td><a href="<?= ROOT_URL ?>admin/delete-category.php?id=<?= $category['id'] ?>" class="btn sm danger">Delete</a></td>
                                </tr>
                            <?php endwhile ?>
                    </table>
                <?php else : ?>
                    <div class="alert__message error "><?= "No category found" ?></div>
                <?php endif ?>
        </main>
    </div>
</section>

<script src="<?= ROOT_URL?>/js/side_bar.js"></script>

<?php
include '../partials/footer.php'
?>