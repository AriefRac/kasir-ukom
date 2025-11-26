<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require '../config/config.php';
require '../config/function.php';
require '../module/mode-customer.php';



$title = "Tambah Customer - Kasir Ukom";
require '../template/header.php';
require '../template/navbar.php';
require '../template/sidebar.php';

$alert = '';

if (isset($_POST['simpan'])) {
    if (insertCust($_POST) > 0) {
        $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Customer Berhasil ditambahkan..
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
    }
}

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Customers</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $main_url ?>dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= $main_url ?>customer/data-customer.php">Customers</a></li>
                        <li class="breadcrumb-item active">Add Customer</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-plus fa-sm"></i>
                            Add Customer
                        </h3>
                        <button type="submit" name="simpan" class="btn btn-primary btn-sm float-right"><i class="fas fa-save"></i> Simpan</button>
                        <button type="reset" name="reset" class="btn btn-danger btn-sm float-right mr-1"><i class="fas fa-times"></i> Reset</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8 mb-3">
                                <?php
                                if ($alert != '') {
                                    echo $alert;
                                }
                                ?>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" class="form-control" id="nama" placeholder="masukkan nama" autofocus autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea class="form-control" name="deskripsi" id="deskripsi" rows="1" placeholder="masukkan deskripsi" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea name="alamat" id="alamat" class="form-control" rows="3" placeholder="masukkan alamat customer" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="telpon">Telpon</label>
                                    <input type="text" pattern="[0-9]{5,}" name="telpon" class="form-control" id="telpon" placeholder="masukkan nomor telpon" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

</div>


<?php

require '../template/footer.php';

?>