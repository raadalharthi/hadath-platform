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
        <h1 class="my-4">Page Heading
            <small>Secondary Text</small>
        </h1>

        <?php
        require_once 'include/connection.php';

        $sql = "SELECT * FROM events";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                // Assuming eventImage is stored as a BLOB in the database
                $imageData = $row['eventImage'];
                $base64Image = base64_encode($imageData); // Encode the binary data as base64
                ?>
                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <a href="#"><img class="card-img-top" src="data:image/jpeg;base64,<?php echo $base64Image; ?>"
                                alt="Event Image" style="width:700px;height:400px;"></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="#">
                                    <?php echo $row["title"]; ?>
                                </a>
                            </h4>
                            <p class="card-text">
                                <?php echo $row["description"]; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php
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