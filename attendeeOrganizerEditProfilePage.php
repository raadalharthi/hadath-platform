<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include_once 'include/metaData.php';
    ?>

<?php
$title = "Edit Profile";


// Database Connection
require 'include/connection.php';

// Ensure that the user is either an attendee or organizer
if (empty($_SESSION['organizerID']) && empty($_SESSION['attendeeID'])) {
    require_once 'include/accessDenied.php';
    exit;
} else {
    include_once 'include/navigationBar.php';

    // Initialize variables
    $first_name = $last_name = $email = $gender = $college = $birthDate = $profile_image = '';
    $college_options = ['CCSIT', 'CBA', 'COE', 'ARCH', 'MED'];
    $gender_options = ['M' => 'Male', 'F' => 'Female'];
    $error_messages = [];

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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate form data
        $error_messages = validateForm($_POST, $gender_options, $college_options);

        if (empty($error_messages)) {
            // No errors, process the form data
            $firstName = $_POST['firstName'] ?? '';
            $lastName = $_POST['lastName'] ?? '';
            $organizerName = $_POST['organizerName'] ?? '';
            $email = $_POST['email'];
            $gender = $_POST['gender'] ?? '';
            $college = $_POST['college'];
            $birthDate = $_POST['birthDate'] ?? '';

            // Handle file upload
            $profile_image = handleFileUpload($_FILES['profileImage'], $profile_image);

            // Update the database with the new profile information
            if (!empty($_SESSION['organizerID'])) {
                $updateSQL = "UPDATE organizer SET organizerName = ?, email = ?, college = ?, organizerImage = ? WHERE organizerID = ?";
                $stmt = mysqli_prepare($conn, $updateSQL);
                mysqli_stmt_bind_param($stmt, "ssssi", $organizerName, $email, $college, $profile_image, $organizerID);
                if (mysqli_stmt_execute($stmt)) {
                    echo "Profile updated successfully.";
                } else {
                    echo "Error updating profile: " . mysqli_stmt_error($stmt);
                }
                mysqli_stmt_close($stmt);
            } elseif (!empty($_SESSION['attendeeID'])) {
                $updateSQL = "UPDATE attendee SET firstName = ?, lastName = ?, email = ?, gender = ?, college = ?, birthDate = ?, attendeeImage = ? WHERE attendeeID = ?";
                $stmt = mysqli_prepare($conn, $updateSQL);
                mysqli_stmt_bind_param($stmt, "sssssssi", $firstName, $lastName, $email, $gender, $college, $birthDate, $profile_image, $attendeeID);
                if (mysqli_stmt_execute($stmt)) {
                    echo "Profile updated successfully.";
                } else {
                    echo "Error updating profile: " . mysqli_stmt_error($stmt);
                }
                mysqli_stmt_close($stmt);
            }
        }
    }
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

            <form name="editProfile" action="functions/attendeeOrganizerEditProfileValidation.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
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
                        <?php if (isset($error_messages['organizerName'])) { ?>
                            <p class="error-message"><?php echo $error_messages['organizerName']; ?></p>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" value="<?php echo $first_name; ?>" required>
                        <label for="firstName">First Name<span style="color: red;"> *</span></label>
                        <?php if (isset($error_messages['firstName'])) { ?>
                            <p class="error-message"><?php echo $error_messages['firstName']; ?></p>
                        <?php } ?>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" value="<?php echo $last_name; ?>" required>
                        <label for="lastName">Last Name<span style="color: red;"> *</span></label>
                        <?php if (isset($error_messages['lastName'])) { ?>
                            <p class="error-message"><?php echo $error_messages['lastName']; ?></p>
                        <?php } ?>
                    </div>
                <?php } ?>

                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required>
                    <label for="email">Email<span style="color: red;"> *</span></label>
                    <?php if (isset($error_messages['email'])) { ?>
                        <p class="error-message"><?php echo $error_messages['email']; ?></p>
                    <?php } ?>
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
                        <?php if (isset($error_messages['gender'])) { ?>
                            <p class="error-message"><?php echo $error_messages['gender']; ?></p>
                        <?php } ?>
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
                    <?php if (isset($error_messages['college'])) { ?>
                        <p class="error-message"><?php echo $error_messages['college']; ?></p>
                    <?php } ?>
                </div>

                <?php if (!empty($_SESSION['attendeeID'])) { ?>
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="birthDate" name="birthDate" value="<?php echo $birthDate; ?>" required>
                        <label for="birthDate">Birth Date<span style="color: red;"> *</span></label>
                        <?php if (isset($error_messages['birthDate'])) { ?>
                            <p class="error-message"><?php echo $error_messages['birthDate']; ?></p>
                        <?php } ?>
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
            var firstName = document.forms["editProfile"]["firstName"].value.trim();
            var lastName = document.forms["editProfile"]["lastName"].value.trim();
            var organizerName = document.forms["editProfile"]["organizerName"].value.trim();
            var email = document.forms["editProfile"]["email"].value.trim();
            var gender = document.forms["editProfile"]["gender"].value;
            var college = document.forms["editProfile"]["college"].value;
            var birthDate = document.forms["editProfile"]["birthDate"].value;

            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            var namePattern = /^[A-Za-z\s]+$/;

            if (<?php echo empty($_SESSION['organizerID']) ? 'true' : 'false'; ?>) {
                if (firstName === "") {
                    alert("First Name is required.");
                    return false;
                } else if (!namePattern.test(firstName)) {
                    alert("First Name can only contain letters and spaces.");
                    return false;
                }

                if (lastName === "") {
                    alert("Last Name is required.");
                    return false;
                } else if (!namePattern.test(lastName)) {
                    alert("Last Name can only contain letters and spaces.");
                    return false;
                }
            } else {
                if (organizerName === "") {
                    alert("Organizer Name is required.");
                    return false;
                } else if (!namePattern.test(organizerName)) {
                    alert("Organizer Name can only contain letters and spaces.");
                    return false;
                }
            }

            if (email === "") {
                alert("Email is required.");
                return false;
            } else if (!emailPattern.test(email)) {
                alert("Invalid email format. Email should be in the format something@something.something");
                return false;
            }

            <?php if (!empty($_SESSION['attendeeID'])) { ?>
            if (gender === "") {
                alert("Gender is required.");
                return false;
            }
            <?php } ?>

            if (college === "") {
                alert("College is required.");
                return false;
            }

            <?php if (!empty($_SESSION['attendeeID'])) { ?>
            if (birthDate === "") {
                alert("Birth Date is required.");
                return false;
            }
            <?php } ?>

            return true;
        }
    </script>
</body>
</html>

<?php
function validateForm($formData, $genderOptions, $collegeOptions)
{
    $error_messages = [];

    // Validate first name, last name, and organizer name
    if (empty($formData['firstName']) && empty($formData['lastName']) && empty($formData['organizerName'])) {
        $error_messages['firstName'] = "First Name is required.";
        $error_messages['lastName'] = "Last Name is required.";
        $error_messages['organizerName'] = "Organizer Name is required.";
    } elseif (empty($formData['firstName']) && empty($formData['lastName'])) {
        $error_messages['firstName'] = "First Name is required.";
        $error_messages['lastName'] = "Last Name is required.";
    } elseif (empty($formData['organizerName'])) {
        $error_messages['organizerName'] = "Organizer Name is required.";
    }

    // Validate email
    if (empty($formData['email'])) {
        $error_messages['email'] = "Email is required.";
    } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $error_messages['email'] = "Invalid email format.";
    }

    // Validate gender
    if (!empty($_SESSION['attendeeID']) && !isset($genderOptions[$formData['gender']])) {
        $error_messages['gender'] = "Gender is required.";
    }

    // Validate college
    if (!in_array($formData['college'], $collegeOptions)) {
        $error_messages['college'] = "College is required.";
    }

    // Validate birth date
    if (!empty($_SESSION['attendeeID']) && empty($formData['birthDate'])) {
        $error_messages['birthDate'] = "Birth Date is required.";
    }

    return $error_messages;
}

function handleFileUpload($file, $currentImage)
{
    $uploadDir = 'uploads/'; // Specify the upload directory
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = uniqid() . '.' . $fileExtension;
            $uploadPath = $uploadDir . $newFileName;

            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                // Remove the old image file if it exists
                if (!empty($currentImage) && file_exists($currentImage)) {
                    unlink($currentImage);
                }

                return $uploadPath;
            }
        }
    }

    // If no new file was uploaded or the upload failed, return the current image path
    return $currentImage;
}

?>