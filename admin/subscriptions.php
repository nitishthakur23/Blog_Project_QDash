<?php
include 'partials/header.php';

// fetch current user's posts from database
$search = isset($_GET['search']) ? filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
$query = "SELECT * FROM subscribers ORDER BY id DESC";
if (!empty($search)) {
    $query = "SELECT * FROM subscribers WHERE subscriber_mail LIKE '$search%' or name LIKE '$search%' ORDER BY id DESC";
}
$subscribers = mysqli_query($connection, $query);
?>

<section class="dashboard">
    <?php if (isset($_SESSION['add-post-success'])) : // shows if add post was successful
    ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['add-post-success'];
                unset($_SESSION['add-post-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-post'])) : // show if category is added successfully
    ?>
        <div class="alert__message error container">
            <p>
                <?= $_SESSION['edit-post'];
                unset($_SESSION['edit-post']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-post-success'])) : // show if category is added successfully
    ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['edit-post-success'];
                unset($_SESSION['edit-post-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['delete-post-success'])) : // show if category is added successfully
    ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['delete-post-success'];
                unset($_SESSION['delete-post-success']);
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
                    <a href="subscriptions.php" class="active">
                        <h5>Subscribers</h5><i class="uil uil-envelope-upload"></i>
                    </a>
                </li>
                <li>
                    <a href="email_history.php" >
                        <h5>Email History</h5><i class="uil uil-envelope-search"></i>
                    </a>
                </li>
            </ul>
        </aside>
        <main>
            <h2> NewsLetter subscribers</h2>
            <form class="search__bar-container" action="subscriptions.php" method="get">
                <div>
                    <i class="uil uil-search"></i>
                    <input type="search" name="search" placeholder="Search">
                </div>
                <button type="submit" name="submit" class="btn">Go</button>
            </form>

            <?php if (mysqli_num_rows($subscribers) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($subscriber = mysqli_fetch_assoc($subscribers)) : ?>
                            <tr>
                                <td><?= $subscriber['name'] ?></td>
                                <td><?= $subscriber['subscriber_mail'] ?></td>
                                <td><button onclick="sendEmail(<?= $subscriber['id'] ?>)" class="btn sm">Send</button></td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="alert__message error"><?= "No Subscriber found." ?></div>
            <?php endif ?>
        </main>
    </div>
</section>
<script src="<?= ROOT_URL ?>/js/side_bar.js"></script>
<?php
include '../partials/footer.php';
?>
<script>
function sendEmail(subscriberId) {
    // Show loading indicator
    showLoadingIndicator();

    // Make an AJAX request to send the email
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "email_update.php?id=" + subscriberId, true);
    xhr.onload = function () {
        // Hide loading indicator
        hideLoadingIndicator();

        if (xhr.status >= 200 && xhr.status < 300) {
            alert("Email sent successfully!");
        } else {
            alert("Failed to send email!");
        }
    };
    xhr.onerror = function () {
        // Hide loading indicator
        hideLoadingIndicator();

        alert("Failed to send email!");
    };
    xhr.send();
}

function showLoadingIndicator() {
    // Code to display a loading indicator
    // You can show a spinner or a message indicating that the request is being processed
}

function hideLoadingIndicator() {
    // Code to hide the loading indicator
}
</script>

