<?php
// Start session if needed
session_start();
require('includes/conn.php');

// Check if form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $date = $_POST['date'] ?? '';
    $name = $_POST['name'] ?? '';
    $particulars = $_POST['particulars'] ?? '';
    $dr = $_POST['dr'] ?? null;
    $cr = $_POST['cr'] ?? null;
    $remarks = $_POST['remarks'] ?? '';
    $consignor_id = $_POST['consignor_id'] ?? 21;  // Getting consignor_id from the form, defaulting to 8

    // Validate required fields
    if (empty($date) || empty($name) || empty($particulars)) {
        die("Error: Required fields are missing.");
    }

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO consignor (consignor_id, date, name, particulars, dr, cr, remarks) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issdsss", $consignor_id, $date, $name, $particulars, $dr, $cr, $remarks);

    // Execute and check if successful
if ($stmt->execute()) {
    echo "<script>
        alert('Balance updated successfully.');
        window.location.href = 'russan.php';
    </script>";
} else {
    echo "Error: " . $stmt->error;
}


    // Close resources
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
