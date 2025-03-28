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
</head>

<body class="sb-nav-fixed">
    <?php include('includes/navbar.php'); ?>
    <div id="layoutSidenav">
        <?php include('includes/sidebar.php'); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">EAPIP</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Breakdown</li>
                    </ol>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBreakdownModal">Add Breakdown</button>
                    <br><br>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>OR Number</th>
                                        <th>Particulars</th>
                                        <th>Total Amount (E-TRACS)</th>
                                        <th>Breakdown (E-TRACS)</th>
                                        <th>Amount</th>
                                        <th>Hospital Fees (PS)</th>
                                        <th>Total Amount Consignor</th>
                                        <th>Clearveu</th>
                                        <th>FAS</th>
                                        <th>Fresenius</th>
                                        <th>Infimax</th>
                                        <th>Ivaxx</th>
                                        <th>Macrik</th>
                                        <th>Mahintana</th>
                                        <th>Red Cross</th>
                                        <th>Russan</th>
                                        <th>Sannovex</th>
                                        <th>Twincirca</th>
                                        <th>Zion</th>
                                        <th>P-OTR Paybls-PF</th>
                                        <th>Total</th>
                                        <th>Diff</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>OR Number</th>
                                        <th>Particulars</th>
                                        <th>Total Amount (E-TRACS)</th>
                                        <th>Breakdown (E-TRACS)</th>
                                        <th>Amount</th>
                                        <th>Hospital Fees (PS)</th>
                                        <th>Total Amount Consignor</th>
                                        <th>Clearveu</th>
                                        <th>FAS</th>
                                        <th>Fresenius</th>
                                        <th>Infimax</th>
                                        <th>Ivaxx</th>
                                        <th>Macrik</th>
                                        <th>Mahintana</th>
                                        <th>Red Cross</th>
                                        <th>Russan</th>
                                        <th>Sannovex</th>
                                        <th>Twincirca</th>
                                        <th>Zion</th>
                                        <th>P-OTR Paybls-PF</th>
                                        <th>Total</th>
                                        <th>Diff</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    // Fetch all records from consignor table
                                    $sql = "SELECT * FROM eapip_breakdown";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['or_number']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['particulars']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['total_amount']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['breakdown']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['amount']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['hospital_fees']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['total_amount_consignor']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['clearveu']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['fas']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['fresenius']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['infimax']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['ivaxx']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['macrik']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['mahintana']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['red_cross']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['russan']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['sannovex']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['twincirca']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['zion']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['otr_paybls_pf']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['total']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['diff']) . "</td>";
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
                                        echo "<tr><td colspan='26' class='text-center'>No records found</td></tr>";
                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>
     <!-- Edit Modal -->
<div class="modal fade" id="editBreakdownModal" tabindex="-1" aria-labelledby="editBreakdownModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div  class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBreakdownModalLabel" >Edit Breakdown</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBreakdownForm" action="update_breakdown.php" method="POST" onsubmit="cleanCurrencyInputs()">
                    <div class="row">
                        <div class="form-group">
                            <label class="sr-only" for="id">ID</label>
                            <input type="hidden" class="form-control" name="id" id="id" placeholder="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="editDate" name="date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editOrNumber" class="form-label">OR Number</label>
                            <input type="text" class="form-control" id="editOrNumber" name="orNumber" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editParticulars" class="form-label">Particulars</label>
                            <input type="text" class="form-control" id="editParticulars" name="particulars" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editTlAmount" class="form-label">Total Amount (E-TRACS) ₱</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control" id="editTlAmount" name="tlAmount" required oninput="formatCurrency(this)">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editBrkdown" class="form-label">Breakdown (E-TRACS) ₱</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control" id="editBrkdown" name="brkdown" required oninput="formatCurrency(this)">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editHospitalFees" class="form-label">HOSPITAL FEES (PS) ₱</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control" id="editHospitalFees" name="hospital_fees" required oninput="formatCurrency(this)">
                            </div>
                        </div>
                    </div>

                    <!-- Consignor Fields -->
                    <div class="modal-header">
                        <h5 class="modal-title">Consignor ₱</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="editClearveu" class="form-label">Clearveu ₱</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control" id="editClearveu" name="Clearveu" required oninput="formatCurrency(this)">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="editFas" class="form-label">FAS ₱</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control" id="editFas" name="Fas" required oninput="formatCurrency(this)">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="editFresenius" class="form-label">Fresenius ₱</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control" id="editFresenius" name="Fresenius" required oninput="formatCurrency(this)">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="editInfimax" class="form-label">Infimax ₱</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control" id="editInfimax" name="Infimax" required oninput="formatCurrency(this)">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="editIvaxx" class="form-label">Ivaxx ₱</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control" id="editIvaxx" name="Ivaxx" required oninput="formatCurrency(this)">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="editMacrik" class="form-label">Macrik ₱</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control" id="editMacrik" name="Macrik" required oninput="formatCurrency(this)">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="editMahintana" class="form-label">Mahintana ₱</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control" id="editMahintana" name="Mahintana" required oninput="formatCurrency(this)">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="editRedCross" class="form-label">Red Cross ₱</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control" id="editRedCross" name="RedCross" required oninput="formatCurrency(this)">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="editRussan" class="form-label">Russan ₱</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control" id="editRussan" name="Russan" required oninput="formatCurrency(this)">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="editSannovex" class="form-label">Sannovex ₱</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control" id="editSannovex" name="Sannovex" required oninput="formatCurrency(this)">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="editTwincirca" class="form-label">Twincirca ₱</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control" id="editTwincirca" name="Twincirca" required oninput="formatCurrency(this)">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="editZion" class="form-label">Zion ₱</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control" id="editZion" name="Zion" required oninput="formatCurrency(this)">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="editPf" class="form-label">P-OTR-PAYBLS-PF ₱</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control" id="editPf" name="P-OTR-PAYBLS-PF" required oninput="formatCurrency(this)">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Modal Structure -->
    <div class="modal fade" id="addBreakdownModal" tabindex="-1" aria-labelledby="addBreakdownModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBreakdownModalLabel">Add Breakdown</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add your form fields here -->
                    <form action="add_breakdown.php" method="POST" onsubmit="cleanCurrencyInputs()">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="orNumber" class="form-label">OR Number</label>
                                <input type="text" class="form-control" id="orNumber" name="orNumber" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="particulars" class="form-label">Particulars</label>
                                <input type="text" class="form-control" id="particulars" name="particulars" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tlAmount" class="form-label">Total Amount (E-TRACS) ₱</label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control" id="tlAmount" name="tlAmount" required oninput="formatCurrency(this)">
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="brkdown" class="form-label">Breakdown (E-TRACS) ₱</label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control" id="brkdown" name="brkdown" required oninput="formatCurrency(this)">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="brkdown" class="form-label">HOSPITAL FEES (PS) ₱</label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control" id="hospital_fees" name="hospital_fees" required oninput="formatCurrency(this)">
                                </div>
                            </div>


                            <!-- Consignor Fields -->
                            <div class="modal-header">
                                <h5 class="modal-title" id="addBreakdownModalLabel">Consignor ₱</h5>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="Clearveu" class="form-label">Clearveu ₱</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="text" class="form-control" id="Clearveu" name="Clearveu" required oninput="formatCurrency(this)">
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="Fas" class="form-label">FAS ₱</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="text" class="form-control" id="Fas" name="Fas" required oninput="formatCurrency(this)">
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="Fresenius" class="form-label">Fresenius ₱</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="text" class="form-control" id="Fresenius" name="Fresenius" required oninput="formatCurrency(this)">
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="Infimax" class="form-label">Infimax ₱</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="text" class="form-control" id="Infimax" name="Infimax" required oninput="formatCurrency(this)">
                                    </div>
                                </div>

                                <!-- Ivaxx -->
                                <div class="col-md-3 mb-3">
                                    <label for="Ivaxx" class="form-label">Ivaxx ₱</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="text" class="form-control" id="Ivaxx" name="Ivaxx" required oninput="formatCurrency(this)">
                                    </div>
                                </div>

                                <!-- Macrik -->
                                <div class="col-md-3 mb-3">
                                    <label for="Macrik" class="form-label">Macrik ₱</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="text" class="form-control" id="Macrik" name="Macrik" required oninput="formatCurrency(this)">
                                    </div>
                                </div>

                                <!-- Mahintana -->
                                <div class="col-md-3 mb-3">
                                    <label for="Mahintana" class="form-label">Mahintana ₱</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="text" class="form-control" id="Mahintana" name="Mahintana" required oninput="formatCurrency(this)">
                                    </div>
                                </div>

                                <!-- Red Cross -->
                                <div class="col-md-3 mb-3">
                                    <label for="RedCross" class="form-label">Red Cross ₱</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="text" class="form-control" id="RedCross" name="RedCross" required oninput="formatCurrency(this)">
                                    </div>
                                </div>

                                <!-- Russan -->
                                <div class="col-md-3 mb-3">
                                    <label for="Russan" class="form-label">Russan ₱</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="text" class="form-control" id="Russan" name="Russan" required oninput="formatCurrency(this)">
                                    </div>
                                </div>

                                <!-- Sannovex -->
                                <div class="col-md-3 mb-3">
                                    <label for="Sannovex" class="form-label">Sannovex ₱</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="text" class="form-control" id="Sannovex" name="Sannovex" required oninput="formatCurrency(this)">
                                    </div>
                                </div>

                                <!-- Twincirca -->
                                <div class="col-md-3 mb-3">
                                    <label for="Twincirca" class="form-label">Twincirca ₱</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="text" class="form-control" id="Twincirca" name="Twincirca" required oninput="formatCurrency(this)">
                                    </div>
                                </div>

                                <!-- Zion -->
                                <div class="col-md-3 mb-3">
                                    <label for="Zion" class="form-label">Zion ₱</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="text" class="form-control" id="Zion" name="Zion" required oninput="formatCurrency(this)">
                                    </div>
                                </div>

                                <!-- Custom Field -->
                                <div class="col-md-3 mb-3">
                                    <label for="PoPayblsPF" class="form-label">P-OTR-Paybls-PF ₱</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="text" class="form-control" id="PoPayblsPF" name="PoPayblsPF" required oninput="formatCurrency(this)">
                                    </div>
                                </div>
                            </div>


                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Breakdown</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>

    <script>
        
        function deleteRecord(id) {
    if (confirm("Are you sure you want to delete this record?")) {
        fetch('delete_breakdown.php', {
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

        // Format the currency with commas
function formatCurrency(input) {
    let value = input.value.replace(/[^0-9.]/g, ''); // Remove all non-numeric characters except decimal point
    let parts = value.split('.'); // Split integer and decimal parts
    
    // Format integer part with commas
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    
    // Reconstruct value with decimal part (if exists)
    input.value = parts.length > 1 ? parts[0] + '.' + parts[1].replace(/[^0-9]/g, '') : parts[0];
}

// Clean up values before form submission (remove commas)
function cleanCurrencyInputs() {
    document.querySelectorAll('input[type="text"]').forEach(input => {
        input.value = input.value.replace(/,/g, ''); // Remove commas before submission
    });
}

        function fetchData(id) {
    fetch('fetch_breakdown.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({ id: id }) // Correct way to send POST data
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.status === "success") {
            const breakdown = data.data; // Extracting 'data' object from JSON response
            document.getElementById('id').value = breakdown.id || '';

            document.getElementById('editDate').value = breakdown.date || '';
            document.getElementById('editOrNumber').value = breakdown.or_number || '';
            document.getElementById('editParticulars').value = breakdown.particulars || '';
            document.getElementById('editTlAmount').value = breakdown.total_amount || '';
            document.getElementById('editBrkdown').value = breakdown.breakdown || '';
            document.getElementById('editHospitalFees').value = breakdown.hospital_fees || '';

            document.getElementById('editClearveu').value = breakdown.clearveu || '';
            document.getElementById('editFas').value = breakdown.fas || '';
            document.getElementById('editFresenius').value = breakdown.fresenius || '';
            document.getElementById('editInfimax').value = breakdown.infimax || '';
            document.getElementById('editIvaxx').value = breakdown.ivaxx || '';
            document.getElementById('editMacrik').value = breakdown.macrik || '';
            document.getElementById('editMahintana').value = breakdown.mahintana || '';
            document.getElementById('editRedCross').value = breakdown.red_cross || '';
            document.getElementById('editRussan').value = breakdown.russan || '';
            document.getElementById('editSannovex').value = breakdown.sannovex || '';
            document.getElementById('editTwincirca').value = breakdown.twincirca || '';
            document.getElementById('editZion').value = breakdown.zion || '';
            document.getElementById('editPf').value = breakdown.otr_paybls_pf || '';
        } else {
            console.error("Error fetching data:", data.message);
        }
    })
    .catch(error => console.error('Fetch Error:', error));
}

    </script>
</body>

</html>