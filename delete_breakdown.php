<?php
include('includes/conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']); // Sanitize input

    // Start transaction
    $conn->begin_transaction();

    try {
        // Retrieve all consignor records linked to the eapip_bd_id
        $stmt = $conn->prepare("SELECT consignor_id, cr FROM consignor WHERE eapip_bd_id = ?");
        if (!$stmt) {
            throw new Exception("Statement preparation failed: " . $conn->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Store values to update balances
        $updates = [];
        while ($row = $result->fetch_assoc()) {
            $updates[] = $row;
        }
        $stmt->close();

        // Delete related records from consignor
        $stmt = $conn->prepare("DELETE FROM consignor WHERE eapip_bd_id = ?");
        if (!$stmt) {
            throw new Exception("Statement preparation failed: " . $conn->error);
        }
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete from consignor: " . $stmt->error);
        }
        $stmt->close();

        // Delete from eapip_breakdown
        $stmt = $conn->prepare("DELETE FROM eapip_breakdown WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Statement preparation failed: " . $conn->error);
        }
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete from eapip_breakdown: " . $stmt->error);
        }
        $stmt->close();

        // Update consignor_liststb balance by subtracting the deleted cr values
        foreach ($updates as $update) {
            $stmt = $conn->prepare("UPDATE consignor_liststb SET balance = balance - ? WHERE id = ?");
            if (!$stmt) {
                throw new Exception("Statement preparation failed: " . $conn->error);
            }
            $stmt->bind_param("di", $update['cr'], $update['consignor_id']);
            if (!$stmt->execute()) {
                throw new Exception("Failed to update balance in consignor_liststb: " . $stmt->error);
            }
            $stmt->close();
        }

        // Commit transaction
        $conn->commit();
        echo json_encode(["success" => true]);
    } catch (Exception $e) {
        $conn->rollback(); // Rollback transaction if an error occurs
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }

    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>
