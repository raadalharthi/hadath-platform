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
            // No header content
        }

        // Page footer
        function Footer()
        {
            // No footer content
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
        $eventSql = "SELECT title, date, time, organizerID FROM events WHERE eventID = ?";
        $eventStmt = mysqli_prepare($conn, $eventSql);
        mysqli_stmt_bind_param($eventStmt, 'i', $eventID);
        mysqli_stmt_execute($eventStmt);
        mysqli_stmt_bind_result($eventStmt, $eventTitle, $eventDate, $eventTime, $organizerID);
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

        // Instantiate the PDF class and add a page in landscape mode
        $pdf = new PDF('L'); // Pass 'L' for landscape orientation
        $pdf->AliasNbPages();
        $pdf->AddPage();

        // Load the certificate template image
        $templateImage = 'fpdf/certificateTemplate.png'; // Adjust the path if needed
        $pdf->Image($templateImage, 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight());

        // Set the title and attendee name
        $pdf->SetFont('Courier', 'B', 15);
        $pdf->SetXY(0, 142.5); // Adjust the X and Y coordinates as needed
        $pdf->Cell(0, 10, htmlspecialchars($eventTitle), 0, 1, 'C');

        // Set the title and attendee name
        $pdf->SetFont('Courier', 'B', 30);
        $pdf->SetXY(0, 115); // Adjust the X and Y coordinates as needed
        $pdf->Cell(0, 10, htmlspecialchars($firstName) . " " . htmlspecialchars($lastName), 0, 1, 'C');

        // Set additional event details
        $pdf->SetFont('Courier', 'B', 25);
        $pdf->SetXY(-100, 175); // Adjust the X and Y coordinates as needed
        $pdf->Cell(-280, 10, htmlspecialchars($organizerName), 0, 0, 'C');
        $pdf->SetXY(-90, 175); // Adjust the X and Y coordinates as needed
        $pdf->Cell(0, 10, htmlspecialchars($eventDate), 0, 1, 'C');

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