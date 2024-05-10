<?php

$title = "My Profile";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include_once 'include/metaData.php';

    // Initialize variables
    $conn = null;
    $result = null;
    $id = null;
    $is_attendee = false;
    $first_name = $last_name = $email = $gender = $college = $image = '';
    $birthDate = null;
    $age = '';
    $organizerName = '';

    // Database Connection
    require 'include/connection.php';

    // Check if the user is an attendee or organizer
    if (empty($_SESSION['organizerID']) && empty($_SESSION['attendeeID'])) {
        require_once 'include/accessDenied.php';
    } else {
        include_once 'include/navigationBar.php';

        if (!empty($_SESSION['attendeeID'])) {
            // Attendee details
            $id = $_SESSION['attendeeID'][0];
            $is_attendee = true;
            $sql = "SELECT firstName, lastName, email, gender, college, attendeeImage, birthDate FROM attendee WHERE attendeeID = '$id'";

            $result = mysqli_query($conn, $sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $first_name = $row["firstName"];
                    $last_name = $row["lastName"];
                    $email = $row["email"];
                    $gender = $row["gender"] == 'M' ? 'Male' : 'Female';
                    $college = $row["college"];
                    $image = $row["attendeeImage"];
                    $birthDate = new DateTime($row["birthDate"]);
                    $today = new DateTime('today');
                    $age = $birthDate->diff($today)->y;
                }
            } else {
                echo "<p>No results found for the attendee.</p>";
            }

        } elseif (!empty($_SESSION['organizerID'])) {
            // Organizer details
            $id = $_SESSION['organizerID'][0];
            $is_attendee = false;
            $sql = "SELECT organizerName, email, college, organizerImage FROM organizer WHERE organizerID = '$id'";

            $result = mysqli_query($conn, $sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $organizerName = $row["organizerName"];
                    $email = $row["email"];
                    $college = $row["college"];
                    $image = $row["organizerImage"];
                }
            } else {
                echo "<p>No results found for the organizer.</p>";
            }
        }

        $conn->close();
    }
    ?>
</head>
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
                                <img src="<?php echo $image; ?>" alt="User Picture" class="img-fluid my-5"
                                    style="width: 300px; height: 300px; object-fit: cover;" />
                                <h5>
                                    <?php
                                    if (!empty($_SESSION['attendeeID'])) {
                                        echo $first_name . " " . $last_name;
                                    }

                                    if (!empty($_SESSION['organizerID'])) {
                                        echo $organizerName;
                                    }
                                    ?>
                                </h5>
                                <br>
                                <a
                                    href="attendeeOrganizerEditProfilePage.php?id=<?php echo $id; ?>&type=<?php echo $is_attendee ? 'attendee' : 'organizer'; ?>">
                                    <i class="far fa-edit mb-5" style="cursor: pointer;"></i>
                                </a>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body p-4">
                                    <h6>Information</h6>
                                    <hr class="mt-0 mb-4">
                                    <div class="row pt-1">
                                        <div class="col-6 mb-3">
                                            <h6>Email</h6>
                                            <p class="text-muted"><?php echo $email; ?></p>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <h6>College</h6>
                                            <p class="text-muted"><?php echo $college; ?></p>
                                        </div>
                                        <?php if (!empty($_SESSION['attendeeID'])) { ?>
                                            <div class="col-6 mb-3">
                                                <h6>Age</h6>
                                                <p class="text-muted"><?php echo $age; ?></p>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <h6>Gender</h6>
                                                <p class="text-muted"><?php echo $gender; ?></p>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include_once 'include/footer.php'; ?>
</body>
</html>
