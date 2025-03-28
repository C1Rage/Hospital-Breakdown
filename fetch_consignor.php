<?php
header('Content-Type: application/json');
include 'includes/conn.php'; // Ensure this file contains DB connection logic

if (!isset($_POST['id'])) {
    echo json_encode(["status" => "error", "message" => "ID is required"]);
    exit;
}

$id = $_POST['id'];
$sql = "SELECT * FROM consignor WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "Query preparation failed"]);
    exit;
}

$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(["status" => "success", "data" => $row]);
} else {
    echo json_encode(["status" => "error", "message" => "Record not found"]);
}

exit;
?>
