<?php
$title = "Edit Profile";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    session_start();
    include_once 'include/metaData.php';

    // Ensure that the user is either an attendee or organizer
    if (empty($_SESSION['organizerID']) && empty($_SESSION['attendeeID'])) {
        require_once 'include/accessDenied.php';
    } else {
        include_once 'include/navigationBar.php';

        // Database Connection
        require 'include/connection.php';

        // Initialize variables
        $organizerID = $_SESSION['organizerID'][0];
        $type = $_GET['type'] ?? '';
        $first_name = $last_name = $email = $gender = $college = $birthDate = $profile_image = '';
        $college_options = ['CCSIT', 'CBA', 'COE', 'ARCH', 'MED'];
        $gender_options = ['M' => 'Male', 'F' => 'Female'];

        // Fetch existing data
        if ($type === 'attendee') {
            $sql = "SELECT firstName, lastName, email, gender, college, attendeeImage, birthDate FROM attendee WHERE attendeeID = '$id'";
        } elseif ($type === 'organizer') {
            $sql = "SELECT firstName, lastName, email, gender, college, organizerImage, birthDate FROM organizer WHERE organizerID = '$organizerID'";
        }

        $result = mysqli_query($conn, $sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $first_name = $row["firstName"];
            $last_name = $row["lastName"];
            $email = $row["email"];
            $gender = $row["gender"];
            $college = $row["college"];
            $birthDate = $row["birthDate"];
            $profile_image = $type === 'attendee' ? $row["attendeeImage"] : $row["organizerImage"];
        }

        // Handle profile update form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $first_name = $_POST['firstName'] ?? '';
            $last_name = $_POST['lastName'] ?? '';
            $email = $_POST['email'] ?? '';
            $gender = $_POST['gender'] ?? '';
            $college = $_POST['college'] ?? '';
            $birthDate = $_POST['birthDate'] ?? '';
            $old_image = $_POST['oldImage'] ?? '';
            $new_image = '';

            // Handle image upload if provided
            if (!empty($_FILES['profileImage']['name'])) {
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["profileImage"]["name"]);
                $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $valid_extensions = ["jpg", "jpeg", "png", "gif"];

                if (in_array($image_file_type, $valid_extensions)) {
                    if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $target_file)) {
                        $new_image = $target_file;
                    }
                }
            } else {
                $new_image = $old_image;
            }

            if ($type === 'attendee') {
                $sql = "UPDATE attendee SET firstName = '$first_name', lastName = '$last_name', email = '$email', gender = '$gender', college = '$college', attendeeImage = '$new_image', birthDate = '$birthDate' WHERE attendeeID = '$id'";
            } elseif ($type === 'organizer') {
                $sql = "UPDATE organizer SET firstName = '$first_name', lastName = '$last_name', email = '$email', gender = '$gender', college = '$college', organizerImage = '$new_image', birthDate = '$birthDate' WHERE organizerID = '$id'";
            }

            if (mysqli_query($conn, $sql)) {
                header("Location: profile.php");
                exit;
            } else {
                echo "Error updating record: " . mysqli_error($conn);
            }
        }

        mysqli_close($conn);
        ?>
        <title><?php echo $title; ?></title>
        <style>
            .form-container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }

            .form-content {
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                padding: 40px;
                max-width: 500px;
                width: 100%;
            }

            .error-message {
                color: red;
                font-size: 14px;
                margin-top: -10px;
                margin-bottom: 10px;
            }
        </style>
    </head>

    <body>
        <div class="container-fluid ps-md-0 form-container">
            <div class="form-content">
                <h3 class="login-heading mb-4 text-center">Edit Profile</h3>

                <form name="editProfile" action="" method="POST" enctype="multipart/form-data"
                    onsubmit="return validateForm()">
                    <input type="hidden" name="oldImage" value="<?php echo $profile_image; ?>">

                    <!-- Image Upload Section -->
                    <div class="form-floating mb-3">
                        <input type="file" class="form-control" id="profileImage" name="profileImage" accept="image/*">
                        <label for="profileImage">Upload Profile Image</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name"
                            value="<?php echo $first_name; ?>" required>
                        <label for="firstName">First Name<span style="color: red;"> *</span></label>
                        <p id="errorFirstName" class="error-message"></p>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name"
                            value="<?php echo $last_name; ?>" required>
                        <label for="lastName">Last Name<span style="color: red;"> *</span></label>
                        <p id="errorLastName" class="error-message"></p>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                            value="<?php echo $email; ?>" required>
                        <label for="email">Email<span style="color: red;"> *</span></label>
                        <p id="errorEmail" class="error-message"></p>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" id="gender" name="gender" required>
                            <?php
                            foreach ($gender_options as $key => $value) {
                                echo "<option value='$key'" . ($gender === $key ? " selected" : "") . ">$value</option>";
                            }
                            ?>
                        </select>
                        <label for="gender">Gender<span style="color: red;"> *</span></label>
                        <p id="errorGender" class="error-message"></p>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" id="college" name="college" required>
                            <?php
                            foreach ($college_options as $option) {
                                echo "<option value='$option'" . ($college === $option ? " selected" : "") . ">$option</option>";
                            }
                            ?>
                        </select>
                        <label for="college">College<span style="color: red;"> *</span></label>
                        <p id="errorCollege" class="error-message"></p>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="birthDate" name="birthDate"
                            value="<?php echo $birthDate; ?>" required>
                        <label for="birthDate">Birth Date<span style="color: red;"> *</span></label>
                        <p id="errorBirthDate" class="error-message"></p>
                    </div>

                    <div class="d-grid">
                        <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit"
                            id="btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <?php include_once 'include/footer.php';

    } ?>
    <script>
        function validateForm() {
            var firstName = document.getElementById("firstName").value.trim();
            var lastName = document.getElementById("lastName").value.trim();
            var email = document.getElementById("email").value.trim();
            var gender = document.getElementById("gender").value;
            var college = document.getElementById("college").value;
            var birthDate = document.getElementById("birthDate").value;
            var error = false;

            // Clear previous error messages
            document.getElementById("errorFirstName").innerText = "";
            document.getElementById("errorLastName").innerText = "";
            document.getElementById("errorEmail").innerText = "";
            document.getElementById("errorGender").innerText = "";
            document.getElementById("errorCollege").innerText = "";
            document.getElementById("errorBirthDate").innerText = "";

            if (firstName === "") {
                document.getElementById("errorFirstName").innerText = "First Name is required.";
                error = true;
            }

            if (lastName === "") {
                document.getElementById("errorLastName").innerText = "Last Name is required.";
                error = true;
            }

            if (email === "") {
                document.getElementById("errorEmail").innerText = "Email is required.";
                error = true;
            } else {
                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    document.getElementById("errorEmail").innerText = "Invalid email format.";
                    error = true;
                }
            }

            if (gender === "") {
                document.getElementById("errorGender").innerText = "Gender is required.";
                error = true;
            }

            if (college === "") {
                document.getElementById("errorCollege").innerText = "College is required.";
                error = true;
            }

            if (birthDate === "") {
                document.getElementById("errorBirthDate").innerText = "Birth Date is required.";
                error = true;
            }

            return !error; // Only submit if no errors
        }
    </script>
</body>

</html>