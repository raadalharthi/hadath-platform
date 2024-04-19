<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Rate the Event</title>
<!-- Include jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<style>
    /* Add your CSS for the star rating here */
    .star-rating {
        /* Your star rating CSS */
    }
    /* Ensure the star images are referenced correctly */
    .star-rating label {
        background: url('star-off.png') no-repeat;
    }
    .star-rating label:before {
        background: url('star-on.png') no-repeat;
    }
    /* More CSS */
</style>
</head>
<body>

<!-- Rating form -->
<div id="ratingForm" class="star-rating">
    <!-- Add your star inputs and labels here, similar to the previous example -->
    <!-- For instance: -->
    <input type="radio" id="star10" name="rating" value="10" /><label for="star10"></label>
    <!-- Repeat this for each star -->
</div>

<script>
// jQuery to handle the rating submission
$(document).ready(function(){
    $('.star-rating input').change(function(){
        var ratingValue = $(this).val();
        var attendeeID = <?php echo json_encode($attendeeID); ?>;
        var eventID = <?php echo json_encode($eventID); ?>;
        
        // Make an AJAX call to your PHP script
        $.ajax({
            url: 'submitRating.php', // The PHP file that processes the rating submission
            type: 'POST',
            data: {
                'rating': ratingValue,
                'attendeeID': attendeeID,
                'eventID': eventID
            },
            success: function(response) {
                alert('Rating submitted successfully!'); // Handle the response from the server
            },
            error: function() {
                alert('Error submitting rating.'); // Handle errors
            }
        });
    });
});
</script>

</body>
</html>
