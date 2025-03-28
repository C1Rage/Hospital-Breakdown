<?php
include('includes/conn.php');


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        /* The container for the balance text */
        .animation-balance {
            font-size: 3rem;
            font-weight: bold;
            color: #28a745;
            /* Green color for the balance */
            display: inline-block;
            animation: flip 3s ease-out infinite;
            /* Infinite animation */
        }


        @keyframes flip {
            0% {
                transform: rotateX(0deg);
                opacity: 0;
            }

            25% {
                transform: rotateX(90deg);
                opacity: 0.5;
            }

            50% {
                transform: rotateX(180deg);
                opacity: 1;
            }

            75% {
                transform: rotateX(270deg);
                opacity: 0.5;
            }

            100% {
                transform: rotateX(360deg);
                opacity: 1;
            }
        }
    </style>
</head>


<body class="sb-nav-fixed">
    <?php include('includes/navbar.php'); ?>

    <div id="layoutSidenav">
        <?php include('includes/sidebar.php'); ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="row align-items-center">
                        <!-- Left side: Consignor header and buttons -->
                        <div class="col-md-8">
                        <h1 class="mt-4"><?php echo $consignor_name ?? 'Unknown'; ?></h1>


                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item active">Consignor</li>
                            </ol>
                            <?php if ($consignor_id && $consignor_name): ?>
    <button type="button" class="btn btn-primary" 
        data-bs-toggle="modal" 
        data-bs-target="#addBalanceModal"
        data-consignor-id="<?php echo htmlspecialchars($consignor_id, ENT_QUOTES, 'UTF-8'); ?>" 
        data-consignor-name="<?php echo htmlspecialchars($consignor_name, ENT_QUOTES, 'UTF-8'); ?>">
        <i class="fas fa-plus"></i> Add Balance
    </button>
<?php endif; ?>



                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addConsignorModal">Add Consignor</button>
                        </div>

                        <!-- Right side: Balance box -->
                        <div class="col-md-4 text-end">
                            <!-- Balance Box -->
                            <div class="card text-center shadow-sm rounded-3" style="width: 18rem; display: inline-block;">
                                <div class="card-body">
                                    <span class="text-muted opacity-50">Balance</span>

                                    <p id="balanceDisplay" class="display-6 text-success fw-bold">₱0.00</p>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End of row align-items-center -->
                    <br>
                </div> <!-- End of container-fluid -->

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Consignor</th>
                                    <th>OR Number</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Particulars</th>
                                    <th>DR</th>
                                    <th>CR</th>
                                    <th>Remarks</th>
                                    <th>Old Balance</th>
                                    <th>New Balance</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Consignor</th>
                                    <th>OR Number</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Particulars</th>
                                    <th>DR</th>
                                    <th>CR</th>
                                    <th>Remarks</th>
                                    <th>Old Balance</th>
                                    <th>New Balance</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
    <?php
    // Ensure consignor_name is set
    if ($consignor_name) {
        // Fetch all records dynamically based on the active consignor
        $sql = "SELECT consignor.id, consignor_liststb.conName, consignor.or_number, consignor.date, consignor.name, consignor.particulars, consignor.dr,
                consignor.cr, consignor.remarks, consignor.old_balance, consignor.new_balance 
                FROM consignor
                JOIN consignor_liststb ON consignor.consignor_id = consignor_liststb.id
                WHERE consignor_liststb.conName = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $consignor_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['conName']) . "</td>";
                echo "<td>" . htmlspecialchars($row['or_number']) . "</td>";
                echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['particulars']) . "</td>";
                echo "<td>" . htmlspecialchars($row['dr']) . "</td>";
                echo "<td>" . htmlspecialchars($row['cr']) . "</td>";
                echo "<td>" . htmlspecialchars($row['remarks']) . "</td>";
                echo "<td>" . htmlspecialchars($row['old_balance']) . "</td>";
                echo "<td>" . htmlspecialchars($row['new_balance']) . "</td>";
                echo "<td>
                        <div class='btnAction'>
                            <button class='btn btn-primary' onclick='fetchData(" . $row['id'] . ")' 
                                    data-bs-toggle='modal' data-bs-target='#editBreakdownModal'>
                                <i class='fas fa-edit'></i>
                            </button>
                            <a href='javascript:void(0);' class='btn btn-danger shadow btn-xs sharp' 
                               onclick='deleteRecord(" . $row['id'] . ")'>
                                <i class='fas fa-trash'></i>
                            </a>
                        </div>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='11' class='text-center'>No records found</td></tr>";
        }

        $stmt->close();
    } else {
        echo "<tr><td colspan='11' class='text-center'>Invalid consignor</td></tr>";
    }
    ?>
</tbody>

                        </table>
                    </div>
                </div> <!-- End of card mb-4 -->

            </main>
            <?php include('includes/footer.php'); ?>
        </div> <!-- End of layoutSidenav_content -->
    </div> <!-- End of layoutSidenav -->

    <!-- Edit Modal Structure -->
<div class="modal fade" id="editBreakdownModal" tabindex="-1" aria-labelledby="editBreakdownModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBreakdownModalLabel">Edit Breakdown</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBreakdownForm">
                    <!-- Hidden input for ID -->
                    <input type="hidden" id="editId">
                    <!-- Hidden input for Consignor ID -->
                    <input type="hidden" id="editConsignorId">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="editDate" required>
                        </div>
                        <div class="mb-3">
                        <label for="editOr_number" class="form-label">OR Number</label>
                        <input type="text" class="form-control" id="editOr_number" name="editOr_number" required>
                    </div>
                        <div class="col-md-6 mb-3">
                            <label for="editName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="editName" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editParticulars" class="form-label">Particulars</label>
                            <input type="text" class="form-control" id="editParticulars" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editDR" class="form-label">DR</label>
                            <input type="number" class="form-control" id="editDR">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editCR" class="form-label">CR</label>
                            <input type="number" class="form-control" id="editCR">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editRemarks" class="form-label">Remarks</label>
                            <input type="text" class="form-control" id="editRemarks">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveChanges">Save Changes</button>
            </div>
        </div>
    </div>
</div>



<!-- Add Balance Modal -->
<div class="modal fade" id="addBalanceModal" tabindex="-1" aria-labelledby="addBalanceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBalanceModalLabel">Add Balance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="add_consignor_balance.php" method="POST">
                    <div class="mb-3">
                        <label for="particulars" class="form-label">Particulars</label>
                        <input type="text" class="form-control" id="particulars" name="particulars" required>
                    </div>
                    <div class="mb-3">
                        <label for="or_number" class="form-label">OR Number</label>
                        <input type="text" class="form-control" id="or_number" name="or_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="balance" class="form-label">Balance</label>
                        <input type="number" class="form-control" id="balance" name="balance" required step="0.01">
                    </div>

                    <!-- Display Consignor Info -->
                    <p><strong>Consignor ID:</strong> <span id="modalConsignorIdDisplay"></span></p>
                    <p><strong>Consignor Name:</strong> <span id="modalConsignorNameDisplay"></span></p>

                    <!-- Hidden Fields to Send Data -->
                    <input type="hidden" id="modalConsignorId" name="consignor_id">
                    <input type="hidden" id="modalConsignorName" name="consignor_name">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

   <!-- Add Consignor Modal -->
<div class="modal fade" id="addConsignorModal" tabindex="-1" aria-labelledby="addConsignorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addConsignorModalLabel">Add Consignor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addConsignorForm">
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="or_number" class="form-label">OR Number</label>
                        <input type="text" class="form-control" id="or_number" name="or_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="particulars" class="form-label">Particulars</label>
                        <input type="text" class="form-control" id="particulars" name="particulars" required>
                    </div>
                    <div class="mb-3">
                        <label for="addDR" class="form-label">DR</label>
                        <input type="number" class="form-control" id="addDR" name="dr">
                    </div>
                    <div class="mb-3">
                        <label for="addCR" class="form-label">CR</label>
                        <input type="number" class="form-control" id="addCR" name="cr">
                    </div>
                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <input type="text" class="form-control" id="remarks" name="remarks">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="submitConsignor">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
        const addBalanceModal = document.getElementById("addBalanceModal");

        if (addBalanceModal) {
            addBalanceModal.addEventListener("show.bs.modal", function (event) {
                // Get button that triggered the modal
                const button = event.relatedTarget;

                // Get data attributes from button
                const consignorId = button.getAttribute("data-consignor-id");
                const consignorName = button.getAttribute("data-consignor-name");

                // Set values inside modal
                document.getElementById("modalConsignorIdDisplay").textContent = consignorId;
                document.getElementById("modalConsignorNameDisplay").textContent = consignorName;

                // Set hidden input values for form submission
                document.getElementById("modalConsignorId").value = consignorId;
                document.getElementById("modalConsignorName").value = consignorName;
            });
        }
    });

        function formatDate(dateString) {
            // Convert date format if needed (e.g., from 'MM/DD/YYYY' to 'YYYY-MM-DD' for input[type=date])
            let date = new Date(dateString);
            if (!isNaN(date.getTime())) {
                return date.toISOString().split("T")[0];
            }
            return "";
        }

        document.getElementById('submitConsignor').addEventListener('click', function() {
    let formData = new FormData(document.getElementById('addConsignorForm'));

    // Append consignor_id = 26
    formData.append('consignor_id', '26');

    fetch('add_consignor.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Show response message
        location.reload(); // Reload page to update records
    })
    .catch(error => console.error('Error:', error));
});


    document.addEventListener("DOMContentLoaded", function () {
        let consignorId = "<?php echo $consignor_id ?? ''; ?>"; // Ensure ID is available

        if (!consignorId) {
            console.error("No consignor_id available.");
            return;
        }

        fetch(`get_balance.php?consignor_id=${consignorId}`)
            .then(response => response.json())
            .then(data => {
                let finalBalance = parseFloat(data.balance) || 0;
                animateBalance(0, finalBalance, 5000);
            })
            .catch(error => console.error("Error fetching balance:", error));

        function animateBalance(start, end, duration) {
            let balanceDisplay = document.getElementById("balanceDisplay");
            if (!balanceDisplay) return;

            let startTime = null;

            function updateBalance(timestamp) {
                if (!startTime) startTime = timestamp;
                let progress = timestamp - startTime;
                let fraction = Math.min(progress / duration, 1);

                // Preserve decimal places
                let current = (start + (end - start) * fraction).toFixed(2);

                balanceDisplay.textContent = `₱${parseFloat(current).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

                if (fraction < 1) {
                    requestAnimationFrame(updateBalance);
                }
            }

            requestAnimationFrame(updateBalance);
        }
    });



        function fetchData(id) {
    console.log("Fetching ID:", id); // Debugging output
    $.ajax({
    url: "fetch_consignor.php",
    type: "POST",
    data: { id: id },
    dataType: "json",
    success: function(response) {
        console.log("Response:", response); // Debugging output
        if (response.status === "success") {
            $("#editId").val(response.data.id);
            $("#editConsignorId").val(response.data.consignor_id); // ✅ Populate consignor_id
            $("#editDate").val(response.data.date);
            $("#editOr_number").val(response.data.or_number);
            $("#editName").val(response.data.name);
            $("#editParticulars").val(response.data.particulars);
            $("#editDR").val(response.data.dr);
            $("#editCR").val(response.data.cr);
            $("#editRemarks").val(response.data.remarks);
            $("#editBreakdownModal").modal("show");
        } else {
            alert("Error fetching data: " + response.message);
        }
    },
    error: function(xhr, status, error) {
        console.error("AJAX Error:", status, error);
        alert("Failed to retrieve data.");
    }
});

}

$(document).ready(function () {
    $("#saveChanges").click(function () {
        var id = $("#editId").val();
        var date = $("#editDate").val();
        var or_number = $("#editOr_number").val();
        var name = $("#editName").val();
        var particulars = $("#editParticulars").val();
        var dr = $("#editDR").val();
        var cr = $("#editCR").val();
        var remarks = $("#editRemarks").val();

        $.ajax({
            url: "update_consignor_balance.php",
            type: "POST",
            data: {
                id: id,
                date: date,
                or_number: or_number,
                name: name,
                particulars: particulars,
                dr: dr,
                cr: cr,
                remarks: remarks
            },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    alert("Record updated successfully!");
                    location.reload(); // Refresh page to reflect changes
                } else {
                    alert("Error updating record: " + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
                alert("Failed to update record.");
            }
        });
    });
});

function deleteRecord(id) {
    if (confirm("Are you sure you want to delete this record?")) {
        fetch('delete_consignor.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Record deleted successfully!");
                location.reload(); // Refresh the page to update the table
            } else {
                alert("Error deleting record: " + data.message);
            }
        })
        .catch(error => console.error("Error:", error));
    }
}
    </script>
    </body>

</html>