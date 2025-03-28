<?php
include('includes/conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']); // Sanitize input
    $consignor_id = isset($_POST['consignor_id']) ? intval($_POST['consignor_id']) : null;

    // Retrieve consignor_id if not provided
    if (!$consignor_id) {
        $query = "SELECT consignor_id FROM consignor WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $consignor_id = $row['consignor_id'];
        } else {
            echo json_encode(["success" => false, "message" => "No consignor_id found for the given ID."]);
            exit;
        }
        $stmt->close();
    }

    // Step 1: Get the `cr` and `dr` values of the row to be deleted, ensuring it belongs to the specified consignor
    $query = "SELECT cr, dr, eapip_bd_id FROM consignor WHERE id = ? AND consignor_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id, $consignor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if (!$row) {
        echo json_encode(["success" => false, "message" => "Record not found or does not belong to the specified consignor."]);
        exit;
    }

    $deleted_cr = $row['cr'];
    $deleted_dr = $row['dr'];
    $eapip_bd_id = $row['eapip_bd_id'];
    $stmt->close();

    // Step 2: Adjust `balance` in `consignor_liststb`
    $updateListQuery = "UPDATE consignor_liststb SET balance = balance - ? + ? WHERE id = ?";
    $stmt = $conn->prepare($updateListQuery);
    $stmt->bind_param("ddi", $deleted_cr, $deleted_dr, $consignor_id);
    $stmt->execute();
    $stmt->close();

    // Step 3: Get the consignor name dynamically
    $query = "SELECT conName FROM consignor_liststb WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $consignor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        echo json_encode(["success" => false, "message" => "Consignor name not found."]);
        exit;
    }

    $consignor_name = strtolower(str_replace(' ', '_', $row['conName'])); // Convert to column format
    $stmt->close();

    // Step 4: Dynamically update `eapip_breakdown` only if eapip_bd_id is not NULL
    if (!is_null($eapip_bd_id)) {
        $query = "UPDATE eapip_breakdown SET $consignor_name = 0 WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $eapip_bd_id);
        if (!$stmt->execute()) {
            echo json_encode(["success" => false, "message" => "Failed to update eapip_breakdown."]);
            exit;
        }
        $stmt->close();
    }

    // Step 5: Get the `new_balance` of the row before the deleted one within the same consignor
    $query = "SELECT new_balance FROM consignor WHERE id < ? AND consignor_id = ? ORDER BY id DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id, $consignor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $previous_new_balance = $row ? $row['new_balance'] : 0;
    $stmt->close();

    // Step 6: Delete the selected record
    $stmt = $conn->prepare("DELETE FROM consignor WHERE id = ? AND consignor_id = ?");
    $stmt->bind_param("ii", $id, $consignor_id);
    if (!$stmt->execute()) {
        echo json_encode(["success" => false, "message" => "Failed to delete record."]);
        exit;
    }
    $stmt->close();

    // Step 7: Find affected rows (where id > deleted_id) within the same consignor
    $query = "SELECT id, dr, cr FROM consignor WHERE id > ? AND consignor_id = ? ORDER BY id ASC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id, $consignor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Step 8: Loop through affected rows and update balances
    while ($row = $result->fetch_assoc()) {
        $record_id = $row['id'];
        $dr = $row['dr'];
        $cr = $row['cr'];

        $old_balance = $previous_new_balance;
        $new_balance = $old_balance + $cr - $dr;

        // Update affected row
        $updateSQL = "UPDATE consignor SET old_balance=?, new_balance=? WHERE id=?";
        $updateStmt = $conn->prepare($updateSQL);
        $updateStmt->bind_param("ddi", $old_balance, $new_balance, $record_id);
        $updateStmt->execute();
        $updateStmt->close();

        $previous_new_balance = $new_balance;
    }

    $stmt->close();
    $conn->close();

    echo json_encode(["success" => true, "message" => "Record deleted, balance updated, and affected rows adjusted."]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>
