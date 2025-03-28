<?php
include('includes/conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve consignor_id dynamically (default to null if not provided)
    $consignor_id = isset($_POST['consignor_id']) ? $_POST['consignor_id'] : null;

    // If consignor_id is still null, try to determine it from the consignor_liststb table
    if (!$consignor_id) {
        $query = "SELECT id FROM consignor_liststb ORDER BY id LIMIT 1"; // Adjust this query based on logic
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $consignor_id = $row['id'];
        } else {
            echo json_encode(["success" => false, "message" => "No consignor_id found."]);
            exit;
        }
        $stmt->close();
    }

    // Ensure date is provided; otherwise, use today's date
    $date = !empty($_POST['date']) ? $_POST['date'] : date("Y-m-d");
    $or_number = !empty($_POST['or_number']) ? $_POST['or_number'] : "Consignor";
    $name = !empty($_POST['name']) ? $_POST['name'] : "Consignor";
    $particulars = !empty($_POST['particulars']) ? $_POST['particulars'] : "";
    $dr = isset($_POST['dr']) && $_POST['dr'] !== '' ? floatval($_POST['dr']) : NULL;
    $cr = isset($_POST['cr']) && $_POST['cr'] !== '' ? floatval($_POST['cr']) : NULL;
    $remarks = !empty($_POST['remarks']) ? $_POST['remarks'] : "";

    // Start transaction
    $conn->begin_transaction();

    try {
        $query = "INSERT INTO consignor (consignor_id, date, or_number, name, particulars, dr, cr, remarks) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("issssdds", $consignor_id, $date, $or_number, $name, $particulars, $dr, $cr, $remarks);
            
            if ($stmt->execute()) {
                // Commit transaction
                $conn->commit();
                echo json_encode(["success" => true, "message" => "Consignor added successfully!"]);
            } else {
                throw new Exception("Execution error: " . $stmt->error);
            }

            $stmt->close();
        } else {
            throw new Exception("Prepare error: " . $conn->error);
        }
    } catch (Exception $e) {
        // Rollback transaction if any error occurs
        $conn->rollback();
        echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
    }

    $conn->close();
}
?>
