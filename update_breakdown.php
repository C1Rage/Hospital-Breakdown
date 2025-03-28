<?php
include 'includes/conn.php'; // Ensure correct DB connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        die("Invalid ID provided.");
    }

    $id = intval($_POST['id']);
    $date = $_POST['date'];
    $or_number = $_POST['orNumber'];
    $particulars = $_POST['particulars'];
    $total_amount = floatval($_POST['tlAmount']);
    $breakdown = $_POST['brkdown'];
    $hospital_fees = floatval($_POST['hospital_fees']);
    $clearveu = floatval($_POST['Clearveu']);
    $fas = floatval($_POST['Fas']);
    $fresenius = floatval($_POST['Fresenius']);
    $infimax = floatval($_POST['Infimax']);
    $ivaxx = floatval($_POST['Ivaxx']);
    $macrik = floatval($_POST['Macrik']);
    $mahintana = floatval($_POST['Mahintana']);
    $red_cross = floatval($_POST['RedCross']);
    $russan = floatval($_POST['Russan']);
    $sannovex = floatval($_POST['Sannovex']);
    $twincirca = floatval($_POST['Twincirca']);
    $zion = floatval($_POST['Zion']);
    $otr_paybls_pf = floatval($_POST['P-OTR-PAYBLS-PF']);

    // Start transaction
    $conn->begin_transaction();

    try {
        // Update eapip_breakdown
        $sql = "UPDATE eapip_breakdown SET 
            date=?, or_number=?, particulars=?, total_amount=?, breakdown=?, hospital_fees=?, 
            clearveu=?, fas=?, fresenius=?, infimax=?, ivaxx=?, macrik=?, mahintana=?, red_cross=?, russan=?, 
            sannovex=?, twincirca=?, zion=?, otr_paybls_pf=? 
            WHERE id=?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssdsdddddddddddddi", 
            $date, $or_number, $particulars, $total_amount, $breakdown, $hospital_fees, 
            $clearveu, $fas, $fresenius, $infimax, $ivaxx, $macrik, $mahintana, $red_cross, $russan, 
            $sannovex, $twincirca, $zion, $otr_paybls_pf, $id);
        $stmt->execute();
        $stmt->close();

        // Define mapping between consignor_id and eapip_breakdown fields
        $consignor_mapping = [
            13 => $clearveu,
            14 => $fas,
            15 => $fresenius,
            16 => $infimax,
            17 => $ivaxx,
            18 => $macrik,
            19 => $mahintana,
            20 => $red_cross,
            21 => $russan,
            22 => $sannovex,
            23 => $twincirca,
            24 => $zion,
            28 => $otr_paybls_pf
        ];

        // Loop through each consignor and update balances
        foreach ($consignor_mapping as $consignor_id => $new_amount) {
            // Fetch old values before updating
            $sql = "SELECT id, cr, old_balance, new_balance FROM consignor WHERE eapip_bd_id=? AND consignor_id=? ORDER BY id ASC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $id, $consignor_id);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $record_id = $row['id'];
                $old_cr = $row['cr'];
                $old_balance = $row['old_balance'];
                $previous_new_balance = $row['new_balance'];

                // Corrected balance calculation
                $new_old_balance = $old_balance; // Retain old balance
                $new_new_balance = $old_balance - $old_cr + $new_amount;

                // Update consignor record
                $updateSQL = "UPDATE consignor SET cr=?, old_balance=?, new_balance=? WHERE id=?";
                $updateStmt = $conn->prepare($updateSQL);
                $updateStmt->bind_param("dddi", $new_amount, $new_old_balance, $new_new_balance, $record_id);
                $updateStmt->execute();
                $updateStmt->close();
            }
            $stmt->close();

            // Update balance in consignor_liststb
            $sql = "SELECT balance FROM consignor_liststb WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $consignor_id);
            $stmt->execute();
            $stmt->bind_result($current_balance);
            $stmt->fetch();
            $stmt->close();

            // Correct the balance in consignor_liststb
            $new_list_balance = $current_balance - $old_cr + $new_amount;

            // Update the balance in consignor_liststb
            $sql = "UPDATE consignor_liststb SET balance = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("di", $new_list_balance, $consignor_id);
            $stmt->execute();
            $stmt->close();
        }

        // Commit transaction
        $conn->commit();
        echo "Record updated successfully!";
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    $conn->close();
}
?>
