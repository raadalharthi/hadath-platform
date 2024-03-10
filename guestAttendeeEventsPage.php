<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = "Events Page";
    include_once 'include/metaData.php';

    if (!empty($_SESSION['organizerID'])) {
        require_once 'include\accessDenied.php';
    }
    ?>
</head>

<body>
    <?php
    include_once 'include/navigationBar.php';
    ?>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <h1 class="my-4">Events
        </h1>

        <?php
        require_once 'include/connection.php';

        $sql = "SELECT * FROM events";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<div class="row">';

            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                // Assuming eventImage is stored as a BLOB in the database
                $imageData = $row['eventImage'];
                $base64Image = base64_encode($imageData); // Encode the binary data as base64
                ?>

                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <!-- Replace '#' with the actual link -->
                        <a href="your-link-here">
                            <?php if (isset($base64Image)): ?>
                                <img class="card-img-top"
                                    src="data:image/jpeg;base64,<?php echo htmlspecialchars($base64Image, ENT_QUOTES, 'UTF-8'); ?>"
                                    alt="<?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'); ?>">
                            <?php endif; ?>
                        </a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <!-- Replace '#' with the actual link -->
                                <a href="your-link-here">
                                    <?php echo htmlspecialchars($row["title"], ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </h4>
                            <p class="card-text">
                                <?php echo htmlspecialchars($row["description"], ENT_QUOTES, 'UTF-8'); ?>
                            </p>
                        </div>
                    </div>
                </div>

                <?php
                if ($result->num_rows % 2 == 0) {
                    echo '</div><div class="row">';
                }
            }

            // End of the row div
            echo '</div>';

        } else {
            echo "0 results";
        }
        ?>

        <!-- /.row -->

        <!-- Pagination -->
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>

    </div>
    <!-- /.container -->

    <?php
    include_once 'include/footer.php';
    ?>

</body>

<?php
$conn->close();
?>


</html>