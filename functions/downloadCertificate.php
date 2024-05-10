<?php
session_start();

// Ensure there's no preceding output; everything should start with <?php and not have any whitespace or lines before it

if (isset($_POST['eventID']) && isset($_SESSION['attendeeID']) && !is_array($_SESSION['attendeeID'][0])) {
    $eventID = $_POST['eventID'];
    $attendeeID = $_SESSION['attendeeID'][0];

    require_once 'fpdf/fpdf.php'; // Make sure you have the correct path to the fpdf.php file.
    require_once '../include/connection.php'; // This should be the path to your database connection file.

    class PDF extends FPDF
    {
        // Page header
        function Header()
        {
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, 'Certificate of Participation', 0, 1, 'C');
        }

        // Page footer
        function Footer()
        {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        }
    }

    function generateCertificate($attendeeID, $eventID, $conn)
    {
        // Fetch attendee information
        $attendeeSql = "SELECT firstName, lastName FROM attendee WHERE attendeeID = ?";
        $attendeeStmt = mysqli_prepare($conn, $attendeeSql);
        mysqli_stmt_bind_param($attendeeStmt, 'i', $attendeeID);
        mysqli_stmt_execute($attendeeStmt);
        mysqli_stmt_bind_result($attendeeStmt, $firstName, $lastName);
        mysqli_stmt_fetch($attendeeStmt);
        mysqli_stmt_close($attendeeStmt);

        // Fetch event information
        $eventSql = "SELECT title, date, time, location, organizerID FROM events WHERE eventID = ?";
        $eventStmt = mysqli_prepare($conn, $eventSql);
        mysqli_stmt_bind_param($eventStmt, 'i', $eventID);
        mysqli_stmt_execute($eventStmt);
        mysqli_stmt_bind_result($eventStmt, $eventTitle, $eventDate, $eventTime, $location, $organizerID);
        mysqli_stmt_fetch($eventStmt);
        mysqli_stmt_close($eventStmt);

        // Fetch organizer information
        $organizerSql = "SELECT organizerName FROM organizer WHERE organizerID = ?";
        $organizerStmt = mysqli_prepare($conn, $organizerSql);
        mysqli_stmt_bind_param($organizerStmt, 'i', $organizerID);
        mysqli_stmt_execute($organizerStmt);
        mysqli_stmt_bind_result($organizerStmt, $organizerName);
        mysqli_stmt_fetch($organizerStmt);
        mysqli_stmt_close($organizerStmt);

        // Instantiate the PDF class and add a page
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();

        // Set the title and attendee name
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(0, 10, "Event: " . htmlspecialchars($eventTitle), 0, 1, 'C');
        $pdf->Cell(0, 10, "Attendee: " . htmlspecialchars($firstName) . " " . htmlspecialchars($lastName), 0, 1, 'C');

        // Set additional event details
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(0, 10, "Organized by: " . htmlspecialchars($organizerName), 0, 1, 'C');
        $pdf->Cell(0, 10, "On: " . htmlspecialchars($eventDate) . " at " . htmlspecialchars($eventTime), 0, 1, 'C');
        $pdf->Cell(0, 10, "At: " . htmlspecialchars($location), 0, 1, 'C');

        // Output the PDF to the browser for download
        $pdf->Output('D', 'Certificate_' . $attendeeID . '_' . $eventID . '.pdf');
    }

    // Assuming you have an established database connection in $conn
    generateCertificate($attendeeID, $eventID, $conn);
} else {
    if (is_array($_SESSION['attendeeID'])) {
        // Handle the error appropriately if attendeeID is an array
        die("Error: attendeeID session variable is an array.");
    } else {
        // Handle other errors, such as missing eventID or attendeeID
        die("Error: Missing eventID or attendeeID.");
    }
}
?>
