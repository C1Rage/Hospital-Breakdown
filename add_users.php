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
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 25px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 25px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 17px;
            width: 17px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #28a745;
        }

        input:checked+.slider:before {
            transform: translateX(25px);
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
                    <h1 class="mt-4">ADD USERS</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Admin</li>
                    </ol>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBreakdownModal">Add Users</button>
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
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Status</th>
                                        <th>User Type</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Status</th>
                                        <th>User Type</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>
                                            <div class="btnAction">
                                                <button class='btn btn-primary shadow btn-xs sharp' onclick='openEditModal(this)'>
                                                    <i class='fas fa-edit'></i>
                                                </button>

                                                <a href='javascript:void(0);' class='btn btn-danger shadow btn-xs sharp' onclick=''>
                                                    <i class='fas fa-trash'></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>

    <!-- Modal Structure -->
    <div class="modal fade" id="addBreakdownModal" tabindex="-1" aria-labelledby="addBreakdownModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBreakdownModalLabel">Add Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add your form fields here -->
                    <form>
                        <div class="row">
                            <!-- Column 1 -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="number" class="form-control" id="username" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="pword" class="form-label">Password</label>
                                <input type="password" class="form-control" id="pword">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <label class="switch">
                                    <input type="checkbox" id="statusSwitch">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="userType" class="form-label">User Type</label>
                                <input type="text" class="form-control" id="userType">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

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
                        <input type="hidden" id="editId">
                        <div class="row">
                        <div class="col-md-6 mb-3">
                                <label for="editName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="editName" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editUsername" class="form-label">Username</label>
                                <input type="number" class="form-control" id="editUsername" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editPword" class="form-label">Password</label>
                                <input type="password" class="form-control" id="editPword">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editStatus" class="form-label">Status</label>
                                <label class="switch">
                                    <input type="checkbox" id="editStatusSwitch">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editUserType" class="form-label">User Type</label>
                                <input type="text" class="form-control" id="editUserType">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveEdit()">Save Changes</button>
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

    <script>
        function openEditModal(button) {
        // Get the row data from the table
        let row = button.closest("tr");
        let cells = row.getElementsByTagName("td");

        // Populate modal fields with row data
        document.getElementById("editId").value = cells[0].innerText; // ID
        document.getElementById("editName").value = cells[1].innerText; // Name
        document.getElementById("editUsername").value = cells[2].innerText; // Username
        document.getElementById("editUserType").value = cells[4].innerText; // User Type

        // Set status toggle (Active/Inactive)
        let statusSwitch = document.getElementById("editStatusSwitch");
        if (cells[3].innerText.trim().toLowerCase() === "active") {
            statusSwitch.checked = true;
        } else {
            statusSwitch.checked = false;
        }

        // Show the modal
        let editModal = new bootstrap.Modal(document.getElementById("editBreakdownModal"));
        editModal.show();
    }

    function saveEdit() {
        let id = document.getElementById("editId").value;
        let name = document.getElementById("editName").value;
        let username = document.getElementById("editUsername").value;
        let userType = document.getElementById("editUserType").value;
        let status = document.getElementById("editStatusSwitch").checked ? "Active" : "Inactive";

        // Here, add AJAX call or backend form submission to update data in the database
        console.log("Saving data:", {
            id,
            name,
            username,
            userType,
            status
        });

        // Close the modal
        let editModal = bootstrap.Modal.getInstance(document.getElementById("editBreakdownModal"));
        editModal.hide();
    }

        document.getElementById("statusSwitch").addEventListener("change", function() {
            document.getElementById("statusText").textContent = this.checked ? "Active" : "Inactive";
        });
    </script>
</body>

</html>