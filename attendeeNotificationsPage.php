<!DOCTYPE html>
<html lang="en">

<head>
    <title>Notifications</title>
    <?php
    include_once 'include/metaData.php';

    if (empty($_SESSION['attendeeID'])) {
        require_once 'include/accessDenied.php';
    } else {
        // Database connection
        require_once 'include/connection.php';

        // Prepare and execute query to fetch notifications
        $sql = "SELECT notificationType, message, date FROM notification";
        $result = mysqli_query($conn, $sql);
    }
    ?>
    <style>
        body {
            text-align: center;
        }
        table {
            margin: auto;
            width: 80%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <?php include_once 'include/navigationBar.php'; ?>

    <h1>Notifications</h1>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <caption>Notifications</caption>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['notificationType']); ?></td>
                        <td><?= htmlspecialchars($row['message']); ?></td>
                        <td><?= htmlspecialchars($row['date']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No notifications found.</p>
    <?php endif; ?>

    <?php include_once 'include/footer.php'; ?>
</body>

</html>
