<?php
include('conn.php');

// Fetch all records from consignor table
$sql = "SELECT * FROM consignor WHERE consignor_id ='21'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
echo "<td>" . htmlspecialchars($row['id']) . "</td>";
echo "<td>" . htmlspecialchars($row['date']) . "</td>";
echo "<td>" . htmlspecialchars($row['name']) . "</td>";
echo "<td>" . htmlspecialchars($row['particulars']) . "</td>";
echo "<td>" . htmlspecialchars($row['dr']) . "</td>";
echo "<td>" . htmlspecialchars($row['cr']) . "</td>";
echo "<td>" . htmlspecialchars($row['new_balance']) . "</td>";
echo "<td>" . htmlspecialchars($row['remarks']) . "</td>";
echo "<td>
        <div class='btnAction'>
            <button class='btn btn-success shadow btn-xs sharp' onclick='editRecord(" . $row['id'] . ")' data-bs-toggle='modal' data-bs-target='#editBreakdownModal'>
    <i class='fas fa-edit'></i>
</button>
            <a href='javascript:void(0);' class='btn btn-danger shadow btn-xs sharp' onclick='deleteRecord(" . $row['id'] . ")'>
                <i class='fas fa-trash'></i>
            </a>
        </div>
      </td>";
echo "</tr>";

    }
} else {
}

?>