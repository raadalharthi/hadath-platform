<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = "Access Denied";
    include_once 'include/metaData.php';
    header("Refresh:5; url=index.php"); // PHP redirection to 'index.php' after 5 seconds
    ?>

    <style>
        @keyframes gradient {
            0% {
                background-color: #5DE0E6;
                background-position: 0% 50%;
            }

            50% {
                background-color: #004AAD;
                background-position: 100% 50%;
            }

            100% {
                background-color: #5DE0E6;
                background-position: 0% 50%;
            }
        }

        body {
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(270deg, #5DE0E6, #004AAD);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
    </style>
</head>

<body>
    <div class="text-center" style="width: 100%;">
        <h1 class="display-3">Access Denied</h1>
        <hr class="border-white" style="margin:auto;width:50%">
        <h3>You don't have permission to view this site.</h3>
        <h6><strong>Error Code</strong>: 403 forbidden</h6>
        <br>
        <p id="redirectMessage">You will be redirected to the home page in <span id="countdown">5</span> seconds.</p>
    </div>

    <script>
        // JavaScript for countdown
        var timeLeft = 5;
        var countdownElement = document.getElementById('countdown');

        var timerId = setInterval(function () {
            timeLeft--;
            countdownElement.textContent = timeLeft;

            if (timeLeft <= 0) {
                clearInterval(timerId);
            }
        }, 1000);
    </script>
</body>

</html>