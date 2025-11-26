<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: auth/login.php");
    exit();
}

require 'config/config.php';
require 'config/function.php';

$title = "Dashboard | Kasir Ukom";
require 'template/header.php';
require 'template/navbar.php';
require 'template/sidebar.php';

// total user
$sqlUser = getData("SELECT * FROM tbl_user");
$totalUser = count($sqlUser);


$sqlSupp = getData("SELECT * FROM tbl_user");
$totalSupp = count($sqlSupp);

$sqlBrg = getData("SELECT * FROM tbl_barang");
$totalBrg = count($sqlBrg);

$sqlCust = getData("SELECT * FROM tbl_customer");
$totalCust = count($sqlCust);


?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $main_url ?>dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $totalUser ?></h3>

                            <p>Users</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="<?= $main_url ?>user/data-user.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $totalSupp ?></h3>

                            <p>Supplier</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-bus"></i>
                        </div>
                        <a href="<?= $main_url ?>supplier/data-supplier.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $totalCust ?></h3>

                            <p>Customer</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-stalker"></i>
                        </div>
                        <a href="<?= $main_url ?>customer/data-customer.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= $totalBrg ?></h3>

                            <p>Item Barang</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-cart"></i>
                        </div>
                        <a href="<?= $main_url ?>barang/index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-outline card-danger">
                        <div class="card-header text-info">
                            <div class="card-title">Info Stock Barang</div>
                            <h5><a href="stock" class="float-right" title="laporan stock"><i class="fas fa-arrow-right"></i></a></h5>
                        </div>
                        <table class="table">
                            <tbody>
                                <?php
                                $stockMin = getData('SELECT * FROM tbl_barang WHERE stock < stock_min');
                                foreach ($stockMin as $min) {
                                ?>
                                    <tr>
                                        <td><?= $min['nama_brg'] ?></td>
                                        <td class="text-danger">Stock Kurang</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-outline card-success">
                        <div class="card-header text-info">
                            <h5>Omzet Penjualan</h5>
                        </div>
                        <div class="card-body text-primary">
                            <h2><span class="h4">Rp</span><?= omzet() ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->



</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<?php

require 'template/footer.php'

?>