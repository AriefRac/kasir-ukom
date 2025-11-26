<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require '../config/config.php';
require '../config/function.php';
require '../module/mode-barang.php';


$title = "Tambah Barang - Kasir Ukom";
require '../template/header.php';
require '../template/navbar.php';
require '../template/sidebar.php';

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
    $id = $_GET['id'];
    $sqlEdit = "SELECT * FROM tbl_barang WHERE id_brg = '$id'";
    $barang = getData($sqlEdit)[0];
} else {
    $msg = '';
}

$alert = '';



if (isset($_POST['simpan'])) {
    if ($msg != '') {
        if (updateBrg($_POST)) {
            echo "
                <script>document.location.href = 'index.php?msg=updated';</script>
            ";
        } else {
            echo "
                <script>document.location.href = 'index.php';</script>
            ";
        }
    } else {
        if (insertBrg($_POST)) {
            $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Barang berhasil ditambahkan..
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>';
        }
    }
}

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Barang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $main_url ?>dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= $main_url ?>barang/index.php">Barang</a></li>
                        <li class="breadcrumb-item active"><?= $msg != '' ? 'Edit Barang' : 'Add Barang' ?></li>
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
                            <?= $msg != '' ? 'Edit Barang' : 'Add Barang' ?>
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
                                    <label for="id_brg">ID Barang</label>
                                    <input type="text" name="id_brg" class="form-control" id="id_brg" value="<?= $msg != '' ? $barang['id_brg'] : generateId() ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="barcode">Barcode *</label>
                                    <input type="text" name="barcode" class="form-control" id="barcode" placeholder="masukkan barcode" value="<?= $msg != '' ? $barang['barcode'] : null ?>" autocomplete="off" autofocus required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Nama Barang *</label>
                                    <input type="name" name="name" class="form-control" id="name" value="<?= $msg != '' ? $barang['nama_brg'] : null ?>" placeholder="masukkan nama barang" required>
                                </div>
                                <div class="form-group">
                                    <label for="satuan">Satuan</label>
                                    <select name="satuan" id="satuan" class="form-control">
                                        <?php
                                        if ($msg != '') {
                                            $satuan = ["piece", "botol", "kaleng", "pouch"];
                                            foreach ($satuan as $sat) {
                                                if ($barang['satuan'] == $sat) { ?>
                                                    <option value="<?= $sat ?>" selected><?= $sat ?></option>
                                                <?php } else { ?>
                                                    <option value="<?= $sat ?>"><?= $sat ?></option>
                                            <?php
                                                }
                                            }
                                        } else { ?>
                                            <option value="">-- Satuan Barang --</option>
                                            <option value="piece">piece</option>
                                            <option value="botol">botol</option>
                                            <option value="kaleng">kaleng</option>
                                            <option value="pouch">pouch</option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="harga_beli">Harga Beli *</label>
                                    <input type="number" oninput="validateNumericInput(this)" name="harga_beli" class="form-control" id="harga_beli" value="<?= $msg != '' ? $barang['harga_beli'] : null ?>" placeholder="Rp.0" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label for="harga_jual">Harga Jual *</label>
                                    <input type="number" oninput="validateNumericInput(this)" name="harga_jual" class="form-control" id="harga_jual" value="<?= $msg != '' ? $barang['harga_jual'] : null ?>" placeholder="Rp.0" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label for="stock_min">Stock Minimal *</label>
                                    <input type="number" oninput="validateNumericInput(this)" name="stock_min" class="form-control" id="stock_min" value="<?= $msg != '' ? $barang['stock_min'] : null ?>" placeholder="0" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-lg-4 text-center">
                                <input type="hidden" name="oldImg" value="<?= $msg != '' ? $barang['gambar'] : null ?>">
                                <img src="<?= $main_url ?>asset/image/<?= $msg != '' ? $barang['gambar'] : 'default-brg.jpg' ?>" class="profile-user-img mb-3 mt-4" id="prev" alt="gambar barang">
                                <input type="file" class="form-control" name="image" onchange="readURL(this);">
                                <span class="text-sm">Type file gambar JPG | PNG | GIF </span><br>
                                <span>Width = Height</span>
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