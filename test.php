<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = "My Profile";
    include_once 'include/metaData.php';
    ?>
</head>

<body>
    <?php
    include_once 'include/navigationBar.php';

    // Database Connection
    require 'include/connection.php';

    $sql = "SELECT firstName, lastName, email, gender, college, picture, birthDate FROM attendee Where attendeeID = 1";

    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $gender = $row["gender"] == 'M' ? 'Male' : 'Female';
            $pictureData = base64_encode($row["picture"]);
            $birthDate = new DateTime($row["birthDate"]);
            $today = new DateTime('today');
            $age = $birthDate->diff($today)->y;
            ?>

            <body>
                <style>
                    .gradient-custom {
                        /* fallback for old browsers */
                        background: #f6d365;

                        /* Chrome 10-25, Safari 5.1-6 */
                        background: -webkit-linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1));

                        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
                        background: linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1))
                    }
                </style>
                <section class="vh-100">
                    <div class="container py-5 h-100">
                        <div class="row d-flex justify-content-center align-items-center h-100">
                            <div class="col col-lg-6 mb-4 mb-lg-0">
                                <div class="card mb-3" style="border-radius: .5rem;">
                                    <div class="row g-0">
                                        <div class="col-md-4 gradient-custom text-center text-white"
                                            style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                                            <img src="data:image/jpeg;base64,<?php echo $pictureData; ?>" alt="User Picture"
                                                class="img-fluid my-5" style="width: 200px;" />
                                            <h5>
                                                <?php echo $row["firstName"] . " " . $row["lastName"]; ?>
                                            </h5>
                                            <br>
                                            <i class="far fa-edit mb-5"></i>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body p-4">
                                                <h6>Information</h6>
                                                <hr class="mt-0 mb-4">
                                                <div class="row pt-1">
                                                    <div class="col-6 mb-3">
                                                        <h6>Email</h6>
                                                        <p class="text-muted">
                                                            <?php echo $row["email"]; ?>
                                                        </p>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <h6>Age</h6>
                                                        <p class="text-muted">
                                                            <?php echo $age; ?>
                                                        </p>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <h6>Gender</h6>
                                                        <p class="text-muted">
                                                            <?php echo $gender; ?>
                                                        </p>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <h6>Collage</h6>
                                                        <p class="text-muted">
                                                            <?php echo $row["college"]; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    </div>
                </section>

                <?php

        }
    } else {
        ?>
            <p>No results found.</p>
            <?php
    }
    $conn->close();

    include_once 'include/footer.php';
    ?>
    </body>


</html>