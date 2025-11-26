<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require '../config/config.php';
require '../config/function.php';
require '../module/mode-jual.php';


$title = "Transaksi Penjualan | Kasir Ukom";
require '../template/header.php';
require '../template/navbar.php';
require '../template/sidebar.php';

$msg = @$_GET['msg'] ? @$_GET['msg'] : '';

$kode   = @$_GET['barcode'] ? @$_GET['barcode'] : '';

if ($kode) {
    $tgl = $_GET['tgl'];
    $dataBrg = mysqli_query($koneksi, "SELECT * FROM tbl_barang WHERE barcode = '$kode'");
    $selectBrg = mysqli_fetch_assoc($dataBrg);
    if (!mysqli_num_rows($dataBrg)) {
        echo "
        <script>
        alert('Barang dengan barcode tersebut tidak ada');
        document.location.href = '?tgl=$tgl'
        </script>
        ";
    }
}

if ($msg == 'deleted') {
    $kode = $_GET['barcode'];
    $idJual = $_GET['idjual'];
    $qty = $_GET['qty'];
    $tgl = $_GET['tgl'];
    deleteJual($kode, $idJual, $qty);
    echo "
    <script>
        alert('Data penjualan berhasil dihapus..');
    </script>
    ";
}

if (isset($_POST['addBrg'])) {
    $tgl = $_POST['tglNota'];
    if (insertJual($_POST)) {
        echo "<script>
            alert('Data barang berhasil ditambah..');
            document.location = '?tgl=$tgl';
        </script>
        ";
    }
}


if (isset($_POST['simpan'])) {
    $nota = $_POST['no_nota'];
    if (insertHd($_POST)) {
        echo "<script>
        alert('data penjualan berhasil disimpan..');
        let win = window.open('../report/r-struk.php?nota=$nota', 'Struk Belanja', 'width=260,height=400,left=10,top=10');
        if (win) {
            win.focus();
            window.location = 'index.php';
        } else {
            alert('Popup blocker is enabled! Please allow popups for this site.');
            window.location = 'index.php';
        }
    </script>
    
        ";
    }
}


$noJual = generateNo();

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Penjualan Barang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $main_url ?>dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Tambah Penjualan</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section>
        <div class="container-fluid">
            <form action="" method="post">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card card-outline card-warning p-3">
                            <div class="form-group row mb-2">
                                <label for="no_nota" class="col-sm-2 col-form-label">No Nota</label>
                                <div class="col-sm-4">
                                    <input type="text" name="no_nota" class="form-control" id="no_nota" value="<?= $noJual ?>">
                                </div>
                                <label for="tglNota" class="col-sm-2 col-form-label">Tanggal</label>
                                <div class="col-sm-4">
                                    <input type="date" name="tglNota" class="form-control" id="tglNota" value="<?= @$_GET['tgl'] ? $_GET['tgl'] : date('Y-m-d') ?>">
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="barcode" class="col-sm-2 col-form-label">Barcode</label>
                                <div class="col-sm-10 input-group">
                                    <input type="text" name="barcode" id="barcode" class="form-control" value="<?= @$_GET['barcode'] ? $_GET['barcode'] : '' ?>" placeholder="masukkan barcode barang">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="icon-barcode">
                                            <i class="fas fa-barcode"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card card-outline card-danger pt-3 px-3 pb-2">
                            <h6 class="font-weight-bold text-right">Total</h6>
                            <h1 class="font-weight-bold text-right" style="font-size: 40pt;">
                                <input type="hidden" name="total" id="total" value="<?= totalJual($noJual) ?>">
                                <?= number_format(totalJual($noJual), 0, ',', '.') ?>
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="card pt-1 pb-2 px-3">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="hidden" name="barcode" value="<?= @$_GET['barcode'] ? $selectBrg['barcode'] : '' ?>">
                                <label for="nmBrg">Nama Barang</label>
                                <input type="text" name="nmBrg" class="form-control form-control-sm" id="nmBrg" value="<?= @$_GET['barcode'] ? $selectBrg['nama_brg'] : '' ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="form-group">
                                <label for="stok">Stok</label>
                                <input type="number" name="stok" value="<?= @$_GET['barcode'] ? $selectBrg['stock'] : '' ?>" class="form-control form-control-sm" id="stok" readonly>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="form-group">
                                <label for="satuan">Satuan</label>
                                <input type="text" name="satuan" value="<?= @$_GET['barcode'] ? $selectBrg['satuan'] : '' ?>" class="form-control form-control-sm" id="satuan" readonly>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input type="number" name="harga" id="harga" value="<?= @$_GET['barcode'] ? $selectBrg['harga_jual'] : '' ?>" class="form-control form-control-sm" readonly>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="form-group">
                                <label for="qty">Qty</label>
                                <input type="number" name="qty" id="qty" value="<?= @$_GET['barcode'] ? 1 : '' ?>" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="jmlHarga">Jumlah Harga</label>
                                <input type="number" name="jmlHarga" id="jmlHarga" value="<?= @$_GET['barcode'] ? $selectBrg['harga_jual'] : '' ?>" class="form-control form-control-sm" readonly>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-info btn-block" name="addBrg"><i class="fas fa-cart-plus fa-sm"></i> Tambah Barang</button>
                </div>


                <div class="card card-outline card-success table-responsive-px-2">
                    <table class="table table-sm table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th class="text-right">Harga</th>
                                <th class="text-right">Qty</th>
                                <th class="text-right">Jumlah Harga</th>
                                <th class="text-center">Operasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $brgDetail = getData("SELECT * FROM tbl_jual_detail WHERE no_jual = '$noJual'");
                            foreach ($brgDetail as $detail) {
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $detail['barcode'] ?></td>
                                    <td><?= $detail['nama_brg'] ?></td>
                                    <td class="text-right"><?= number_format($detail['harga_jual'], 0, ',', '.') ?></td>
                                    <td class="text-right"><?= number_format($detail['qty'], 0, ',', '.') ?></td>
                                    <td class="text-right"><?= number_format($detail['jml_harga'], 0, ',', '.') ?></td>
                                    <td class="text-center">
                                        <a href="?barcode=<?= $detail['barcode'] ?> &idjual=<?= $detail['no_jual'] ?> &tgl=<?= $detail['tgl_jual'] ?> &qty=<?= $detail['qty'] ?> &msg=deleted" class="btn btn-sm btn-danger" title="hapus barang" onclick="return confirm('Anda yakin akan menghapus barang ini?')"><i class=" fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-4 p-2">
                        <div class="form-group row mb-2">
                            <label for="customer" class="col-sm-3 col-form-label col-form-label-sm">Customer</label>
                            <div class="col-sm-9">
                                <select name="customer" id="customer" class="form-control form-control-sm">
                                    <option value="umum" class="text-center">Umum</option>
                                    <?php
                                    $customers = getData("SELECT * FROM tbl_customer");
                                    foreach ($customers as $cust) { ?>
                                        <option value="<?= $cust['id_customer'] ?>" class="text-center"><?= $cust['id_customer'] . " | " . $cust['nama'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="ketr" class="col-sm-3 col-form-label">Keterangan</label>
                            <div class="col-sm-9">
                                <textarea name="ketr" id="ketr" class="form-control form-control-sm"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 py-2 px-3">
                        <div class="form-group row mb-2">
                            <label for="bayar" class="col-sm-3 col-form-label">Bayar</label>
                            <div class="col-sm-9">
                                <input type="number" name="bayar" id="bayar" class="form-control form-control-sm text-right">
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="kembalian" class="col-sm-3 col-form-label">Kembalian</label>
                            <div class="col-sm-9">
                                <input type="number" name="kembalian" id="kembalian" class="form-control form-control-sm text-right" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 p-2">
                        <button type="submit" name="simpan" class="btn btn-sm btn-primary btn-block"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<script>
    let barcode = document.getElementById('barcode');
    let tglNota = document.getElementById('tglNota');
    let qty = document.getElementById('qty');
    let harga = document.getElementById('harga');
    let jml_harga = document.getElementById('jmlHarga');
    let bayar = document.getElementById('bayar');
    let kembalian = document.getElementById('kembalian');
    let total = document.getElementById('total');

    barcode.addEventListener('change', function() {
        document.location.href = '?barcode=' + barcode.value + '&tgl=' + tglNota.value;
    });

    qty.addEventListener('input', function() {
        jml_harga.value = qty.value * harga.value;
    });

    bayar.addEventListener('input', function() {
        kembalian.value = bayar.value - total.value;
    });
</script>
<?php
require '../template/footer.php';
?>