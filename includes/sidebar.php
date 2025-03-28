<?php
// Get the current page name
$current_page = basename($_SERVER['PHP_SELF']);

// List of consignors with their corresponding IDs
$consignors = [
    "clearveu.php" => ["id" => 13, "name" => "CLEARVEU"],
    "fas.php" => ["id" => 14, "name" => "FAS"],
    "fresenius.php" => ["id" => 15, "name" => "FRESENIUS"],
    "infimax.php" => ["id" => 16, "name" => "INFIMAX"],
    "ivaxx.php" => ["id" => 17, "name" => "IVAXX"],
    "macrik.php" => ["id" => 18, "name" => "MACRIK"],
    "mahintana.php" => ["id" => 19, "name" => "MAHINTANA"],
    "redcross.php" => ["id" => 20, "name" => "RED CROSS"],
    "russan.php" => ["id" => 21, "name" => "RUSSAN"],
    "sannovex.php" => ["id" => 22, "name" => "SANNOVEX"],
    "twincirca.php" => ["id" => 23, "name" => "TWINCIRCA"],
    "hea.php" => ["id" => 25, "name" => "HOSPITAL EMERGENCY ALLOWANCE"],
    "ps.php" => ["id" => 26, "name" => "PS"],
    "pool.php" => ["id" => 27, "name" => "POOL"],
    "otrpaybls.php" => ["id" => 28, "name" => "OTR-PAYBLS-PF"],
];

// Set consignor_id and consignor_name if the page is found in the array
$consignor_id = $consignors[$current_page]['id'] ?? null;
$consignor_name = $consignors[$current_page]['name'] ?? null;
?>



<!DOCTYPE html>
<html lang="en">

            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link" href="eapip.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                EAPIP Breakdown
                            </a>
                            <a class="nav-link" href="hospital.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Hospital Breakdown
                            </a>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Consignor
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="clearveu.php">Clearveu</a>
                                    <a class="nav-link" href="fresenius.php">Fresenius</a>
                                    <a class="nav-link" href="infimax.php">Infimax</a>
                                    <a class="nav-link" href="ivaxx.php">I-vaxx</a>
                                    <a class="nav-link" href="macrik.php">Macrik</a>
                                    <a class="nav-link" href="mahintana.php">Mahintana</a>
                                    <a class="nav-link" href="redcross.php">Red Cross</a>
                                    <a class="nav-link" href="russan.php">Russan</a>
                                    <a class="nav-link" href="sannovex.php">Sannovex</a>
                                    <a class="nav-link" href="twincirca.php">Twincirca</a>
                                    <a class="nav-link" href="hea.php">HEA</a>
                                    <a class="nav-link" href="ps.php">PS</a>
                                    <a class="nav-link" href="pool.php">Pool</a>
                                    <a class="nav-link" href="otrpaybls.php">OTR-Paybls-PF</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Admin
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link" href="add_users.php">Add Users</a>
                                    
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">Settings</div>
                            <a class="nav-link" href="charts.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Charts
                            </a>
                            <a class="nav-link" href="tables.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tables
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>
        </html>