<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = "My Profile";
    include_once 'include/metaData.php';

    if (empty($_SESSION['organizerID']) && empty($_SESSION['attendeeID'])) {
        require_once 'include\accessDenied.php';
    } else { ?>
    </head>

    <body>
        <?php
        include_once 'include/navigationBar.php';

        // Database Connection
        require 'include/connection.php';

        $id = $_SESSION['attendeeID'][0];

        $sql = "SELECT firstName, lastName, email, gender, college, attendeeImage, birthDate FROM attendee Where attendeeID = '$id'";

        $result = mysqli_query($conn, $sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $gender = $row["gender"] == 'M' ? 'Male' : 'Female';
                $birthDate = new DateTime($row["birthDate"]);
                $today = new DateTime('today');
                $age = $birthDate->diff($today)->y;
                ?>

                <body>
                    <style>
                        .gradient-custom {
                            background: linear-gradient(270deg, #5DE0E6, #004AAD);
                            background-size: 400% 400%;
                            animation: gradient 15s ease infinite;
                            border-top-left-radius: .5rem;
                            border-bottom-left-radius: .5rem;
                            text-align: center;
                            color: white;
                        }

                        @keyframes gradient {
                            0% {
                                background-position: 0% 50%;
                            }

                            50% {
                                background-position: 100% 50%;
                            }

                            100% {
                                background-position: 0% 50%;
                            }
                        }
                    </style>
                    <section class="vh-100" style="height: 100vh;">
                        <div class="container h-100">
                            <div class="row d-flex justify-content-center align-items-center h-100">
                                <div class="col-lg-8">
                                    <div class="card" style="width: 100%;">
                                        <div class="row g-0">
                                            <div class="col-md-4 gradient-custom">
                                                <img src="<?php echo $row["attendeeImage"]; ?>" alt="User Picture"
                                                    class="img-fluid my-5"
                                                    style="width: 300px; height: 300px; object-fit: cover;" />
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
    }
    ?>
    </body>


</html>