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

        // Prepare and execute query to fetch notifications specific to this attendee
        $attendeeID = intval($_SESSION['attendeeID'][0]);
        $sql = "SELECT n.notificationID, n.notificationType, n.message, n.date
                FROM notification n
                INNER JOIN attendeeNotifications an ON n.notificationID = an.notificationID
                WHERE an.attendeeID = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Prepare Statement Error: " . $conn->error);
        }

        $stmt->bind_param("i", $attendeeID);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check for query errors
        if ($result === false) {
            die("Query Error: " . $conn->error);
        }
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

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .dismiss-btn {
            color: red;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php include_once 'include/navigationBar.php'; ?>

    <h1>Notifications</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Dismiss</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['notificationType']); ?></td>
                        <td><?= htmlspecialchars($row['message']); ?></td>
                        <td><?= htmlspecialchars($row['date']); ?></td>
                        <td>
                            <form action="functions/dismissNotification.php" method="POST">
                                <input type="hidden" name="notificationID" value="<?= $row['notificationID']; ?>">
                                <button type="submit" class="dismiss-btn" title="Dismiss">&times;</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <br>
    <?php else: ?>
        <p>No notifications found.</p>
    <?php endif; ?>

    <?php include_once 'include/footer.php'; ?>
</body>

</html>