<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require '../config/config.php';
require '../config/function.php';



$title = "Data Barang | Kasir Ukom";
require '../template/header.php';
require '../template/navbar.php';
require '../template/sidebar.php';

$stockBrg = getData("SELECT * FROM tbl_barang");

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Stock Barang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $main_url ?>dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Stok Barang</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-list"></i> Stok</h3>
                    <a href="<?= $main_url ?>report/r-stock.php" class="btn btn-sm btn-outline-primary float-right" target="_blank"><i class="fas fa-print"></i> Cetak</a>
                </div>
                <div class="card-body table-responsive p-3">
                    <table class="table table-hover text-nowrap" id="tblData">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Jumlah Stock</th>
                                <th>Stock Minimal</th>
                                <th>Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($stockBrg as $brg) {
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $brg['id_brg'] ?></td>
                                    <td><?= $brg['nama_brg'] ?></td>
                                    <td><?= $brg['satuan'] ?></td>
                                    <td class="text-center"><?= $brg['stock'] ?></td>
                                    <td class="text-center"><?= $brg['stock_min'] ?></td>
                                    <td>
                                        <?php
                                        if ($brg['stock'] < $brg['stock_min']) {
                                            echo " <span class='text-danger'>
                                                Stock Kurang
                                            </span>
                                            ";
                                        } else {
                                            echo " 
                                                Stock Cukup
                                            ";
                                        }
                                        ?>
                                    </td>

                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </section>









</div>
<?php
require '../template/footer.php';
?>