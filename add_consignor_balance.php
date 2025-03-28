<?php
// Include the database connection
include('includes/conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize form input
    $particulars = trim($_POST['particulars']);
    $or_number = trim($_POST['or_number']);
    $balance = str_replace(",", "", $_POST['balance']); // Remove commas
    $consignor_id = trim($_POST['consignor_id']); // Get dynamic consignor_id
    $consignor_name = trim($_POST['consignor_name']); // Get dynamic consignor_name

    // Validate inputs
    if (!is_numeric($balance) || empty($consignor_id) || empty($consignor_name)) {
        die("Invalid input: Please provide a valid consignor ID, name, and balance.");
    }

    // Get the current date (YYYY-MM-DD format)
    $current_date = date("Y-m-d");

    // Default values for required fields
    $default_dr = 0.00;  // Debit remains 0 (since it's a credit entry)
    $default_remarks = "Balance Added";

    // Start a transaction
    $conn->begin_transaction();

    try {
        // ✅ Step 1: Insert into consignor table (trigger will handle balances)
        $query = "INSERT INTO consignor (consignor_id, date, or_number, name, particulars, dr, cr, remarks) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssdds", $consignor_id, $current_date, $or_number, $consignor_name, $particulars, $default_dr, $balance, $default_remarks);
        $stmt->execute();
        $stmt->close();

        // ✅ Step 2: Commit transaction
        $conn->commit();
        echo "Balance successfully added and recorded.";
    } catch (Exception $e) {
        $conn->rollback(); // Revert changes on error
        echo "Error: " . $e->getMessage();
    }

    $conn->close();
}
?>
