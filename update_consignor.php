<?php
include('conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $date = $_POST['date'];
    $or_number = $_POST['or_number'];
    $name = $_POST['name'];
    $particulars = $_POST['particulars'];
    $dr = $_POST['dr'];
    $cr = $_POST['cr'];
    $remarks = $_POST['remarks'];

    $sql = "UPDATE consignor SET date=?, or_number=?, name=?, particulars=?, dr=?, cr=?, remarks=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $date, $or_number, $name, $particulars, $dr, $cr, $remarks, $id);

    if ($stmt->execute()) {
        echo "Record updated successfully!";
    } else {
        echo "Error updating record.";
    }
}
?>
