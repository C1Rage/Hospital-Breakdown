<?php
include('conn.php');

// Fetch the record's data by ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM consignor WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Record not found']);
    }
}
?>
