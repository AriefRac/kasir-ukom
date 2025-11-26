<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require '../config/config.php';
require '../config/function.php';
require '../module/mode-supplier.php';


$title = "Data Suppliers | Kasir Ukom";
require '../template/header.php';
require '../template/navbar.php';
require '../template/sidebar.php';

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
} else {
    $msg = '';
}

$alert = '';
if ($msg == 'deleted') {
    $alert = '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> Alert!</h5>
                Data Supplier Berhasil Dihapus..
            </div>';
}

if ($msg == 'aborted') {
    $alert = '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-exclamination-triangel"></i> Alert!</h5>
                Data Gagal Dihapus!
            </div>';
}

if ($msg == 'updated') {
    $alert = '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check-circle"></i> Alert!</h5>
                Data Supplier Barhasil Diperbarui..
            </div>';
}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Suppliers</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $main_url ?>dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Suppliers</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <?php
                if ($alert != '') {
                    echo $alert;
                }
                ?>
                <div class="card-header">
                    <div class="card-title"><i class="fas fa-list fa-sm"></i> Data Suppliers</div>
                    <div class="card-tools">
                        <a href="<?= $main_url ?>supplier/add-supplier.php" class="btn btn-sm btn-primary"><i class="fas fa-user-plus fa-sm"></i> Add Supplier</a>
                    </div>
                </div>
                <div class="card-body table-responsive p-3">
                    <table class="table table-hover text-nowrap" id="tblData">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Supplier</th>
                                <th>Telpon</th>
                                <th>Deskripsi</th>
                                <th>Alamat</th>
                                <th style="width: 10%;">Operasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $suppliers = getData("SELECT * FROM tbl_supplier");
                            foreach ($suppliers as $supplier) :  ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $supplier['nama'] ?></td>
                                    <td><?= $supplier['telpon'] ?></td>
                                    <td><?= $supplier['deskripsi'] ?></td>
                                    <td><?= $supplier['alamat'] ?></td>
                                    <td>
                                        <a href="edit-supplier.php?id=<?= $supplier['id_supplier'] ?>" class="btn btn-sm btn-warning" title="edit supplier"><i class="fas fa-pen"></i></a>
                                        <a href="del-supplier.php?id=<?= $supplier['id_supplier'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus Supplier ini?')" title="delete supplier"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>


    <!-- end wrapper -->
</div>

<?php

require '../template/footer.php';

?>