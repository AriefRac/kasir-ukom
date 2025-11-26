<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require '../config/config.php';
require '../config/function.php';
require '../module/mode-barang.php';


$title = "Data Barang | Kasir Ukom";
require '../template/header.php';
require '../template/navbar.php';
require '../template/sidebar.php';

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
} else {
    $msg = '';
}

$alert = '';
// jalankan fungsi barang
if ($msg == 'deleted') {
    $id = $_GET['id'];
    $img = $_GET['img'];
    deleteBrg($id, $img);
    $alert = "<script>
                $(document).ready(function(){
                    $(document).Toasts('create', {
                        title: 'Sukses',
                        body: 'Data Barang berhasil dihapus dari database..',
                        class: 'bg-success',
                        icon: 'fas fa-check-circle',
                        position: 'bottomRight',
                        autohide: true,
                        delay: 5000,
                      })
                });
            </script>";
}

if ($msg == 'updated') {
    $user = userLogin()['username'];
    $gbrUser = userLogin()['foto'];
    $alert = "<script>
                $(document).ready(function(){
                    $(document).Toasts('create', {
                        title: '$user',
                        body: 'Data Barang berhasil diperbarui dari database..',
                        class: 'bg-success',
                        image: '../asset/image/$gbrUser',
                        icon: 'fas fa-check-circle',
                        position: 'bottomRight',
                        autohide: true,
                        delay: 5000,
                      })
                });
            </script>";
}

?>

<!-- Content Wrapper. Contains page content -->
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
                        <li class="breadcrumb-item active">Barang</li>
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
                    <div class="card-title"><i class="fas fa-list fa-sm"></i> Data Barang</div>
                    <div class="card-tools">
                        <a href="<?= $main_url ?>barang/form-barang.php" class="btn btn-sm btn-primary"><i class="fas fa-dolly fa-sm"></i> Add Barang</a>
                    </div>
                </div>
                <div class="card-body table-responsive p-3">
                    <table class="table table-hover text-nowrap" id="tblData">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>ID Barang</th>
                                <th>Nama Barang</th>
                                <th>Stok</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th style="width: 10%;">Operasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $barang = getData("SELECT * FROM tbl_barang");
                            foreach ($barang as $brg) :  ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><img src="../asset/image/<?= $brg['gambar'] ?>" class="" width="50px" height="50px" alt="gambar barang"></td>
                                    <td><?= $brg['id_brg'] ?></td>
                                    <td><?= $brg['nama_brg'] ?></td>
                                    <td><?= $brg['stock'] ?></td>
                                    <td class="text-center"><?= number_format($brg['harga_beli'], 0, ',', '.') ?></td>
                                    <td class="text-center"><?= number_format($brg['harga_jual'], 0, ',', '.') ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-secondary" id="btnCetakBar" data-barcode="<?= $brg['barcode'] ?>" data-nama="<?= $brg['nama_brg'] ?>" title="cetak barcode"><i class="fas fa-barcode"></i></button>
                                        <a href="form-barang.php?id=<?= $brg['id_brg'] ?>&msg=editing" class="btn btn-sm btn-warning" title="edit barang"><i class="fas fa-pen"></i></a>
                                        <a href="?id=<?= $brg['id_brg'] ?>&img=<?= $brg['gambar'] ?>&msg=deleted" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus Barang ini?')" title="delete barang"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- modal barcode -->
    <div class="modal fade" id="mdlCetakBar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cetak Barcode</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nmBrg" class="col-sm-3 col-form-label">Nama Barang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nmBrg" value="<?= $brg['nama_brg'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="barcode" class="col-sm-3 col-form-label">Barcode</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="barcode" value="<?= $brg['barcode'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jmlCetak" class="col-sm-3 col-form-label">Jumlah Cetak</label>
                        <div class="col-sm-9">
                            <input type="number" min="1" max="10" value="1" title="maximal 10" id="jmlCetak" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="prev"><i class="fas fa-print"></i>Print</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- end wrapper -->
</div>
<script>
    $(document).ready(function() {
        $(document).on("click", "#btnCetakBar", function() {
            $('#mdlCetakBar').modal('show');
            let barcode = $(this).data('barcode');
            let nama = $(this).data('nama');
            $('#nmBrg').val(nama);
            $('#barcode').val(barcode);
        })
    });

    $(document).ready(function() {
        $(document).on("click", "#prev", function() {
            let barcode = $('#barcode').val();
            let jmlCetak = $('#jmlCetak').val();
            if (jmlCetak > 0 && jmlCetak <= 10) {
                window.open("../report/r-barcode.php?barcode=" + barcode + "&jmlCetak=" + jmlCetak)
            }
        })
    });
</script>

<?php

require '../template/footer.php';

?>