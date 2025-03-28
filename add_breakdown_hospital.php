<?php
// Include the database connection
include('includes/conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $date = $_POST['date'];
    $orNumber = $_POST['orNumber'];  // Keep as string for safety
    $particulars = $_POST['particulars'];
    $totalAmount = str_replace(",", "", $_POST['tlAmount']); // Remove commas
    $breakdown = str_replace(",", "", $_POST['brkdown']);
    $hospital_fees = str_replace(",", "", $_POST['hospital_fees']);

    // Consignor values
    $consignors = [
        13 => str_replace(",", "", $_POST['Clearveu']),   // CLEARVEU
        15 => str_replace(",", "", $_POST['Fresenius']),  // FRESENIUS
        16 => str_replace(",", "", $_POST['Infimax']),    // INFIMAX
        17 => str_replace(",", "", $_POST['Ivaxx']),      // IVAXX
        18 => str_replace(",", "", $_POST['Macrik']),     // MACRIK
        19 => str_replace(",", "", $_POST['Mahintana']),  // MAHINTANA
        20 => str_replace(",", "", $_POST['RedCross']),   // RED CROSS
        21 => str_replace(",", "", $_POST['Russan']),     // RUSSAN
        22 => str_replace(",", "", $_POST['Sannovex']),   // SANNOVEX
        23 => str_replace(",", "", $_POST['Twincirca']),  // TWINCIRCA
        24 => str_replace(",", "", $_POST['Zion']),       // ZION
        27 => str_replace(",", "", $_POST['pool']),       // POOL
        28 => str_replace(",", "", $_POST['PoPayblsPF'])  // OTR-PAYBLS-PF
    ];

    try {
        // Begin transaction
        $conn->begin_transaction();

        // Insert into eapip_breakdown table
        $query = "INSERT INTO hospital_breakdown (
                    date, or_number, particulars, total_amount, breakdown,
                    clearveu, fresenius, infimax, ivaxx, 
                    macrik, mahintana, red_cross, russan, sannovex, 
                    twincirca, zion, otr_paybls_pf, pf_pooling, hospital_fees
                  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Error preparing breakdown query: " . $conn->error);
        }

        // Bind parameters
        $stmt->bind_param(
            "sssssssssssssssssss",
            $date, $orNumber, $particulars, $totalAmount, $breakdown,
            $consignors[13], $consignors[15], $consignors[16], $consignors[17], 
            $consignors[18], $consignors[19], $consignors[20], $consignors[21], $consignors[22], 
            $consignors[23], $consignors[24], $consignors[27], $consignors[28], $hospital_fees
        );

        if (!$stmt->execute()) {
            throw new Exception("Error inserting breakdown: " . $stmt->error);
        }

        echo "Breakdown successfully added.<br>";
        $stmt->close();

        // Insert data into consignor table with date
$consignor_query = "INSERT INTO consignor (consignor_id, or_number, cr, date) VALUES (?, ?, ?, ?)";
$consignor_stmt = $conn->prepare($consignor_query);
if (!$consignor_stmt) {
    throw new Exception("Error preparing consignor query: " . $conn->error);
}

// Convert OR number to string before binding
$orNumberStr = strval($orNumber);

foreach ($consignors as $consignor_id => $amount) {
    if ($amount > 0) {
        $consignor_id_int = intval($consignor_id);  // Ensure it's an integer
        $amount_float = floatval($amount);  // Ensure it's a float
        
        $consignor_stmt->bind_param("isss", $consignor_id_int, $orNumberStr, $amount_float, $date);
        
        if (!$consignor_stmt->execute()) {
            throw new Exception("Error inserting consignor $consignor_id: " . $consignor_stmt->error);
        }
        
        echo "Consignor $consignor_id successfully added with amount in 'cr'.<br>";
    }
}

        // Commit the transaction
        $conn->commit();

    } catch (Exception $e) {
        // Rollback on error
        $conn->rollback();
        echo "Transaction failed: " . $e->getMessage();
    }

    // Close statements
    $consignor_stmt->close();
    $conn->close();
}
?>
