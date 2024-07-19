
$(document).ready(function () {
    // When like button is clicked
    $(document).on('click', '.like-btn', function () {
        var postId = $(this).data('post-id');
        
        // AJAX request to like.php
        $.ajax({
            type: 'POST',
            url: 'unlike.php',
            data: {
                postId: postId
            },
            dataType: 'json',
            success: function (response) {
                if (response.error) {
                    console.error('Error: ' + response.error);
                    return;
                }
                // Update like count in the DOM
                $('.like-count[data-post-id="' + postId + '"]').text(response.likeCount);
                // Replace like button with liked button
                $('.like-btn[data-container="body"][data-toggle="popover"][data-trigger="hover focus"][data-placement="top"][data-content="Liked"][data-post-id="' + postId + '"]').popover('dispose');
            $('.like-btn[data-container="body"][data-toggle="popover"][data-trigger="hover focus"][data-placement="top"][data-content="Liked"][data-post-id="' + postId + '"]').replaceWith('<button class="unlike-btn" data-container="body" data-toggle="popover" data-trigger="hover focus" data-placement="top" data-content="Like" data-post-id="' + postId + '"><i class="uil uil-thumbs-up"></i></button>');
                $(document).ready(function() {
                    $('[data-toggle="popover"]').popover()
                });
            },
            error: function (xhr, status, error) {
                console.error('AJAX error: ' + status, error);
            }
        });
    });

    // When unlike button is clicked
    $(document).on('click', '.unlike-btn', function () {
        var postId = $(this).data('post-id');
        
        // AJAX request to unlike.php
        $.ajax({
            type: 'POST',
            url: 'like.php',
            data: {
                postId: postId
            },
            dataType: 'json',
            success: function (response) {
                if (response.error) {
                    console.error('Error: ' + response.error);
                    return;
                }
                // Update like count in the DOM
                $('.like-count[data-post-id="' + postId + '"]').text(response.likeCount);
                // Replace liked button with like button
                $('.unlike-btn[data-container="body"][data-toggle="popover"][data-trigger="hover focus"][data-placement="top"][data-content="Like"][data-post-id="' + postId + '"]').popover('dispose');
                $('.unlike-btn[data-container="body"][data-toggle="popover"][data-trigger="hover focus"][data-placement="top"][data-content="Like"][data-post-id="' + postId + '"]').replaceWith('<button class="like-btn" data-container="body" data-toggle="popover" data-trigger="hover focus" data-placement="top" data-content="Liked" data-post-id="' + postId + '"><i class="uil uil-thumbs-up"></i></button>');
                    $(document).ready(function() {
                        $('[data-toggle="popover"]').popover()
                    });            },
            error: function (xhr, status, error) {
                console.error('AJAX error: ' + status, error);
            }
        });
    });
});

$(document).ready(function () {
    // When save button is clicked
    $(document).on('click', '.save-btn', function () {
        var postId = $(this).data('post-id');

        // AJAX request to save.php
        $.ajax({
            type: 'POST',
            url: 'unsaved_post.php',
            data: {
                postId: postId
            },
            dataType: 'json',
            success: function (response) {
                if (response.error) {
                    console.error('Error: ' + response.error);
                    return;
                }
                // Replace save button with saved button
                
            $('.save-btn[data-container="body"][data-toggle="popover"][data-trigger="hover focus"][data-placement="top"][data-content="Saved"][data-post-id="' + postId + '"]').popover('dispose');
            $('.save-btn[data-container="body"][data-toggle="popover"][data-trigger="hover focus"][data-placement="top"][data-content="Saved"][data-post-id="' + postId + '"]').replaceWith('<button class="unsave-btn" data-container="body" data-toggle="popover" data-trigger="hover focus" data-placement="top" data-content="Save" data-post-id="' + postId + '"><i class="uil uil-bookmark"></i></button>');
                $(document).ready(function() {
                    $('[data-toggle="popover"]').popover()
                });
            },
            error: function (_xhr, status, error) {
                console.error('AJAX error: ' + status, error);
            }
        });
    });

    // When unsave button is clicked
    $(document).on('click', '.unsave-btn', function () {
        var postId = $(this).data('post-id');

        // AJAX request to unsave.php
        $.ajax({
            type: 'POST',
            url: 'saved_post.php',
            data: {
                postId: postId
            },
            dataType: 'json',
            success: function (response) {
                if (response.error) {
                    console.error('Error: ' + response.error);
                    return;
                }
                // Replace saved button with save button
                $('.unsave-btn[data-container="body"][data-toggle="popover"][data-trigger="hover focus"][data-placement="top"][data-content="Save"][data-post-id="' + postId + '"]').popover('dispose');
                $('.unsave-btn[data-container="body"][data-toggle="popover"][data-trigger="hover focus"][data-placement="top"][data-content="Save"][data-post-id="' + postId + '"]').replaceWith('<button class="save-btn" data-container="body" data-toggle="popover" data-trigger="hover focus" data-placement="top" data-content="Saved" data-post-id="' + postId + '"><i class="uil uil-bookmark"></i></button>');
                $(document).ready(function() {
                    $('[data-toggle="popover"]').popover()
                });
            },
            error: function (_xhr, status, error) {
                console.error('AJAX error: ' + status, error);
            }
        });
    });
});
$(document).ready(function () {
    // Function to toggle comments
    $('#commentButton').click(function () {
        $('#comments-section').toggle();
        if ($('#comments-section').is(':visible')) {
            loadComments();
        }
    });

    // Function to fetch and display comments
    function loadComments() {
        var postId = $('#post-id').val();
        $.ajax({
            type: 'GET',
            url: 'fetch_comments.php',
            data: {
                postId: postId
            },
            dataType: 'html',
            success: function (response) {
                $('#comments-list').html(response);
            }
        });
    }

    // Submit comment form via AJAX
    $('#comment-form').submit(function (event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: 'add_comment.php',
            data: formData,
            success: function (response) {
                // Parse the JSON response
                var data = JSON.parse(response);
                // Check if the server indicates success
                if (data.success) {
                    // Comment inserted successfully
                    loadComments(); // Call loadComments function
                    $('#comment-form')[0].reset();
                    // Optionally, display a success message or perform other actions
                } else {
                    // Handle the case where the server returns an error
                    console.error('Error:', data.error);
                    // Optionally, display an error message to the user
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
                // Optionally, display an error message to the user
            }
        });
    });
});