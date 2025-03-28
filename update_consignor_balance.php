<?php
header('Content-Type: application/json');
include 'includes/conn.php'; // Ensure correct database connection

// Check if all required fields are set
if (!isset($_POST['id'], $_POST['date'], $_POST['or_number'], $_POST['name'], $_POST['particulars'], $_POST['dr'], $_POST['cr'], $_POST['remarks'])) {
    echo json_encode(["status" => "error", "message" => "Missing required fields"]);
    exit;
}

$id = intval($_POST['id']);
$date = $_POST['date'];
$or_number = $_POST['or_number'];
$name = $_POST['name'];
$particulars = $_POST['particulars'];
$dr = floatval($_POST['dr']);
$cr = floatval($_POST['cr']);
$remarks = $_POST['remarks'];

// Step 1: Get consignor_id and eapip_bd_id using the given id
$query = "SELECT consignor_id, old_balance, eapip_bd_id FROM consignor WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    echo json_encode(["status" => "error", "message" => "Record with ID $id not found"]);
    exit;
}

$consignor_id = $row['consignor_id']; 
$old_balance = $row['old_balance'];  
$eapip_bd_id = $row['eapip_bd_id'];  // ✅ Get the associated `eapip_bd_id`
$stmt->close();

// Step 2: Compute new balance
$new_balance = $old_balance + $cr - $dr; 

// Step 3: Update the main record
$sql = "UPDATE consignor SET date=?, or_number=?, name=?, particulars=?, dr=?, cr=?, remarks=?, new_balance=? 
        WHERE id=? AND consignor_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssddsdii", $date, $or_number, $name, $particulars, $dr, $cr, $remarks, $new_balance, $id, $consignor_id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        // Update affected balances for the same consignor
        updateAffectedBalances($id, $consignor_id, $conn);

        // Update the corresponding column in `eapip_breakdown`
        updateEapipBreakdown($eapip_bd_id, $consignor_id, $cr, $conn);

        echo json_encode(["status" => "success", "message" => "Record updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "No changes made or record does not exist"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Database update failed"]);
}

$stmt->close();
$conn->close();
exit;

/**
 * Updates `old_balance` and `new_balance` for affected records within the same consignor.
 */
function updateAffectedBalances($id, $consignor_id, $conn) {
    $query = "SELECT new_balance FROM consignor WHERE id = ? AND consignor_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id, $consignor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $previous_new_balance = $row['new_balance']; 
    $stmt->close();

    $query = "SELECT id, dr, cr FROM consignor WHERE id > ? AND consignor_id = ? ORDER BY id ASC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id, $consignor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $record_id = $row['id'];
        $dr = $row['dr'];
        $cr = $row['cr'];

        $old_balance = $previous_new_balance;
        $new_balance = $old_balance + $cr - $dr;

        $updateSQL = "UPDATE consignor SET old_balance=?, new_balance=? WHERE id=? AND consignor_id=?";
        $updateStmt = $conn->prepare($updateSQL);
        $updateStmt->bind_param("ddii", $old_balance, $new_balance, $record_id, $consignor_id);
        $updateStmt->execute();
        $updateStmt->close();

        $previous_new_balance = $new_balance;
    }

    $stmt->close();
}

/**
 * Updates the correct column in `eapip_breakdown` based on `consignor_id`.
 */
function updateEapipBreakdown($eapip_bd_id, $consignor_id, $new_cr, $conn) {
    // Map consignor_id to the correct column name
    $consignor_map = [
        13 => 'clearveu',
        14 => 'fas',
        15 => 'fresenius',
        16 => 'infimax',
        17 => 'ivaxx',
        18 => 'macrik',
        19 => 'mahintana',
        20 => 'red_cross',
        21 => 'russan',
        22 => 'sannovex',
        23 => 'twincirca',
        24 => 'zion',
        28 => 'otr_paybls_pf'
    ];

    if (!isset($consignor_map[$consignor_id])) {
        error_log("Unknown consignor_id: " . $consignor_id);
        return;
    }

    $column_name = $consignor_map[$consignor_id];

    // Update the correct column in eapip_breakdown
    $query = "UPDATE eapip_breakdown SET $column_name = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("di", $new_cr, $eapip_bd_id);

    if (!$stmt->execute()) {
        error_log("Failed to update eapip_breakdown: " . $stmt->error);
    }
    $stmt->close();
}
?>
