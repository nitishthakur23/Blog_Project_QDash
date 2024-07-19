<?php
include 'partials/header.php';
//fetch id of the profile and the current from database
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $current_user_id = $_SESSION['user-id'];
    $profile_user_id = $id;
    $query = "SELECT users.*
    FROM users
    INNER JOIN followers ON users.id = followers.follower_id
    WHERE followers.user_id = $profile_user_id;
    ";
    $result = mysqli_query($connection, $query);
} else {
    header('location:' . ROOT_URL . 'index.php');
    die();
}
?>
<div class="featured">
    <h1>
        FOLLOWERS</h1>
    <div class="follower container">
        <?php while ($profile_info = mysqli_fetch_assoc($result)) : ?>
            <?php $profile_id = $profile_info['id'] ?>
            <div class="post__author">
                <div class="post__author-avatar">
                    <a href="<?php echo ROOT_URL ?>User_profile.php?id=<?= $profile_info['id'] ?>">
                        <img src="./images/<?= $profile_info['avatar'] ?>">
                    </a>
                </div>
                <div class="post__author-info">
                    <h5>By: <?= "{$profile_info['firstname']} {$profile_info['lastname']}" ?></h5>
                    <small>
                        <?= $profile_info['username'] ?>
                    </small>
                </div>
            </div>
        <?php endwhile ?>
    </div>
</div>
<?php
include 'partials/footer.php';
?>
<!-- <script>
$(document).ready(function() {
    $('#followForm').submit(function(e) {
        e.preventDefault(); // Prevent form submission

        var url = $(this).attr('action'); // Get the URL of the PHP script
        var type = 'POST';
        var formData = $(this).serialize(); // Serialize form data
        var dataType = 'json'; // Expect JSON response

        // Send AJAX request
        $.ajax({
            url: url,
            type: type,
            data: formData,
            dataType: dataType,
            success: function(response) {
                // Handle JSON response
                if (response.hasOwnProperty('follow-success')) {
                    displayMessage(response['follow-success'], 'success');
                } else if (response.hasOwnProperty('follow')) {
                    displayMessage(response['follow'], 'error');
                } else if (response.hasOwnProperty('unfollow-success')) {
                    displayMessage(response['unfollow-success'], 'success');
                } else if (response.hasOwnProperty('unfollow')) {
                    displayMessage(response['unfollow'], 'error');
                } else {
                    displayMessage('Unknown error occurred', 'error');
                }
            },
            error: function(xhr, status, error) {
                location.reload();
                console.error(xhr.responseText); // Log any errors to console
                displayMessage('An error occurred while processing your request', 'error');
            }
        });
    });

    // Function to display message in the alert container
    function displayMessage(message, type) {
        var alertClass = (type === 'success') ? 'success' : 'error';
        $('#alertContainer').html('<p>' + message + '</p>').addClass(alertClass).fadeIn();

        // Hide the message after some time (e.g., 5 seconds)
        setTimeout(function() {
            $('#alertContainer').fadeOut();
        }, 5000); // 5000 milliseconds = 5 seconds
    }
});
</script> -->
