<?php
$title = "Edit Profile";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include_once 'include/metaData.php';

    // Ensure that the user is either an attendee or organizer
    if (empty($_SESSION['organizerID']) && empty($_SESSION['attendeeID'])) {
        require_once 'include/accessDenied.php';
    } else {
        include_once 'include/navigationBar.php';

        // Database Connection
        require 'include/connection.php';

        // Initialize variables
        $first_name = $last_name = $email = $gender = $college = $birthDate = $profile_image = '';
        $college_options = ['CCSIT', 'CBA', 'COE', 'ARCH', 'MED'];
        $gender_options = ['M' => 'Male', 'F' => 'Female'];

        // Fetch existing data based on session
        if (!empty($_SESSION['organizerID'])) {
            $organizerID = $_SESSION['organizerID'][0];
            $sql = "SELECT organizerName, email, college, organizerImage FROM organizer WHERE organizerID = '$organizerID'";
            $result = mysqli_query($conn, $sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $first_name = $row["organizerName"];
                $email = $row["email"];
                $college = $row["college"];
                $profile_image = $row["organizerImage"];
            }
        } elseif (!empty($_SESSION['attendeeID'])) {
            $attendeeID = $_SESSION['attendeeID'][0];
            $sql = "SELECT firstName, lastName, email, gender, college, attendeeImage, birthDate FROM attendee WHERE attendeeID = '$attendeeID'";
            $result = mysqli_query($conn, $sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $first_name = $row["firstName"];
                $last_name = $row["lastName"];
                $email = $row["email"];
                $gender = $row["gender"];
                $college = $row["college"];
                $birthDate = $row["birthDate"];
                $profile_image = $row["attendeeImage"];
            }
        }

        // Handle profile update form submission
        // ... (rest of the code remains the same)
    }
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

            <form name="editProfile" action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                <input type="hidden" name="oldImage" value="<?php echo $profile_image; ?>">

                <!-- Image Upload Section -->
                <div class="form-floating mb-3">
                    <input type="file" class="form-control" id="profileImage" name="profileImage" accept="image/*">
                    <label for="profileImage">Upload Profile Image</label>
                </div>

                <?php if (!empty($_SESSION['organizerID'])) { ?>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="organizerName" name="organizerName" placeholder="Organizer Name" value="<?php echo $first_name; ?>" required>
                        <label for="organizerName">Organizer Name<span style="color: red;"> *</span></label>
                        <p id="errorOrganizerName" class="error-message"></p>
                    </div>
                <?php } else { ?>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" value="<?php echo $first_name; ?>" required>
                        <label for="firstName">First Name<span style="color: red;"> *</span></label>
                        <p id="errorFirstName" class="error-message"></p>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" value="<?php echo $last_name; ?>" required>
                        <label for="lastName">Last Name<span style="color: red;"> *</span></label>
                        <p id="errorLastName" class="error-message"></p>
                    </div>
                <?php } ?>

                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required>
                    <label for="email">Email<span style="color: red;"> *</span></label>
                    <p id="errorEmail" class="error-message"></p>
                </div>

                <?php if (!empty($_SESSION['attendeeID'])) { ?>
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
                <?php } ?>

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

                <?php if (!empty($_SESSION['attendeeID'])) { ?>
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="birthDate" name="birthDate" value="<?php echo $birthDate; ?>" required>
                        <label for="birthDate">Birth Date<span style="color: red;"> *</span></label>
                        <p id="errorBirthDate" class="error-message"></p>
                    </div>
                <?php } ?>

                <div class="d-grid">
                    <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit" id="btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <?php include_once 'include/footer.php'; ?>
    <script>
        function validateForm() {
            var firstName = document.getElementById("firstName") ? document.getElementById("firstName").value.trim() : "";
            var lastName = document.getElementById("lastName") ? document.getElementById("lastName").value.trim() : "";
            var organizerName = document.getElementById("organizerName") ? document.getElementById("organizerName").value.trim() : "";
            var email = document.getElementById("email").value.trim();
            var gender = document.getElementById("gender") ? document.getElementById("gender").value : "";
            var college = document.getElementById("college").value;
            var birthDate = document.getElementById("birthDate") ? document.getElementById("birthDate").value : "";
            var error = false;

            // Clear previous error messages
            if (document.getElementById("errorFirstName")) document.getElementById("errorFirstName").innerText = "";
            if (document.getElementById("errorLastName")) document.getElementById("errorLastName").innerText = "";
            if (document.getElementById("errorOrganizerName")) document.getElementById("errorOrganizerName").innerText = "";
            document.getElementById("errorEmail").innerText = "";
            if (document.getElementById("errorGender")) document.getElementById("errorGender").innerText = "";
            document.getElementById("errorCollege").innerText = "";
            if (document.getElementById("errorBirthDate")) document.getElementById("errorBirthDate").innerText = "";

            if (firstName === "" && lastName === "" && organizerName === "") {
                if (document.getElementById("errorFirstName")) document.getElementById("errorFirstName").innerText = "First Name is required.";
                if (document.getElementById("errorLastName")) document.getElementById("errorLastName").innerText = "Last Name is required.";
                if (document.getElementById("errorOrganizerName")) document.getElementById("errorOrganizerName").innerText = "Organizer Name is required.";
                error = true;
            } else if (firstName === "" && lastName === "") {
                if (document.getElementById("errorFirstName")) document.getElementById("errorFirstName").innerText = "First Name is required.";
                if (document.getElementById("errorLastName")) document.getElementById("errorLastName").innerText = "Last Name is required.";
                error = true;
            } else if (organizerName === "") {
                if (document.getElementById("errorOrganizerName")) document.getElementById("errorOrganizerName").innerText = "Organizer Name is required.";
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
                if (document.getElementById("errorGender")) document.getElementById("errorGender").innerText = "Gender is required.";
                error = true;
            }

            if (college === "") {
                document.getElementById("errorCollege").innerText = "College is required.";
                error = true;
            }

            if (birthDate === "") {
                if (document.getElementById("errorBirthDate")) document.getElementById("errorBirthDate").innerText = "Birth Date is required.";
                error = true;
            }

            return !error; // Only submit if no errors
        }
    </script>
</body>

</html>
