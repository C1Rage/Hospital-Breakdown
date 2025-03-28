<?php
include('includes/conn.php'); // Ensure database connection

header('Content-Type: application/json'); // Set JSON header
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Validate and get consignor_id
if (isset($_GET['consignor_id']) && is_numeric($_GET['consignor_id'])) {
    $consignor_id = (int) $_GET['consignor_id'];
} else {
    echo json_encode(['error' => 'Invalid consignor_id']);
    exit;
}

// Prepare the query to fetch the balance
$query = "SELECT balance FROM consignor_liststb WHERE id = ?";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("i", $consignor_id); // Ensure correct data type
    $stmt->execute();
    $stmt->bind_result($balance);

    if ($stmt->fetch()) {
        echo json_encode(['balance' => floatval($balance)]);
    } else {
        echo json_encode(['balance' => 0]); // Default if no record found
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Query preparation failed', 'details' => $conn->error]);
}

$conn->close();
?>
