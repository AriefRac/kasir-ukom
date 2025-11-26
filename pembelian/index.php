<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require '../config/config.php';
require '../config/function.php';
require '../module/mode-beli.php';


$title = "Transaksi Pembelian | Kasir Ukom";
require '../template/header.php';
require '../template/navbar.php';
require '../template/sidebar.php';

$msg = @$_GET['msg'] ? $_GET['msg'] : '';

$kode = @$_GET['pilihbrg'] ? @$_GET['pilihbrg'] : '';
if ($kode) {
    $selectBrg = getData("SELECT * FROM tbl_barang WHERE id_brg = '$kode'")[0];
}

if ($msg == 'deleted') {
    $idbrg = $_GET['idbrg'];
    $idbeli = $_GET['idbeli'];
    $qty = $_GET['qty'];
    $tgl = $_GET['tgl'];
    deleteBeli($idbrg, $idbeli, $qty);
    echo "
    <script>
        alert('Data pembelian berhasil dihapus..');
    </script>
    ";
}



if (isset($_POST['addBrg'])) {
    $tgl = $_POST['tglNota'];
    if (insertBeli($_POST)) {
        echo "<script>
            alert('Data barang berhasil ditambah..');
            document.location = '?tgl=$tgl';
        </script>
        ";
    }
}

if (isset($_POST['simpan'])) {
    if (insertHd($_POST)) {
        echo "<script>
            alert('data pembelian barhasil disimpan..');
            window.location = 'index.php?msg=sukses';
        </script>
        ";
    }
}

$noBeli = generateNo();

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pembelian Barang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $main_url ?>dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Tambah Pembelian</li>
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
                                    <input type="text" name="no_beli" class="form-control" id="no_nota" value="<?= $noBeli ?>">
                                </div>
                                <label for="tglNota" class="col-sm-2 col-form-label">Tanggal</label>
                                <div class="col-sm-4">
                                    <input type="date" name="tglNota" class="form-control" id="tglNota" value="<?= @$_GET['tgl'] ? $_GET['tgl'] : date('Y-m-d') ?>">
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="kodeBrg" class="col-sm-2 col-form-label">SKU</label>
                                <div class="col-sm-10">
                                    <select name="kodeBrg" id="kodeBrg" class="form-control">
                                        <option value="" class="text-center">-- Pilih Kode Barang --</option>
                                        <?php
                                        $barang = getData("SELECT * FROM tbl_barang");
                                        foreach ($barang as $brg) { ?>
                                            <option value="?pilihbrg=<?= $brg['id_brg'] ?>" class="text-center"><?= $brg['id_brg'] . " | " . $brg['nama_brg'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card card-outline card-danger pt-3 px-3 pb-2">
                            <h6 class="font-weight-bold text-right">Total Pembelian</h6>
                            <h1 class="font-weight-bold text-right" style="font-size: 40pt;">
                                <input type="hidden" name="total" value="<?= totalBeli($noBeli) ?>">
                                <?= number_format(totalBeli($noBeli), 0, ',', '.') ?>
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="card pt-1 pb-2 px-3">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="hidden" name="kodeBrg" value="<?= @$_GET['pilihbrg'] ? $selectBrg['id_brg'] : ''  ?>">
                                <label for="nmBrg">Nama Barang</label>
                                <input type="text" name="nmBrg" class="form-control form-control-sm" id="nmBrg" value="<?= @$_GET['pilihbrg'] ? $selectBrg['nama_brg'] : '' ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="form-group">
                                <label for="stok">Stok</label>
                                <input type="number" name="stok" value="<?= @$_GET['pilihbrg'] ? $selectBrg['stock'] : ''  ?>" class="form-control form-control-sm" id="stok" readonly>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="form-group">
                                <label for="satuan">Satuan</label>
                                <input type="text" name="satuan" value="<?= @$_GET['pilihbrg'] ? $selectBrg['satuan'] : ''  ?>" class="form-control form-control-sm" id="satuan" readonly>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input type="number" name="harga" value="<?= @$_GET['pilihbrg'] ? $selectBrg['harga_beli'] : ''  ?>" class="form-control form-control-sm" id="harga" readonly>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="form-group">
                                <label for="qty">Qty</label>
                                <input type="number" name="qty" value="<?= @$_GET['pilihbrg'] ? 1 : ''  ?>" class="form-control form-control-sm" id="qty">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="jmlHarga">Jumlah Harga</label>
                                <input type="number" name="jmlHarga" value="<?= @$_GET['pilihbrg'] ? $selectBrg['harga_beli'] : ''  ?>" class="form-control form-control-sm" id="jmlHarga" readonly>
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
                                <th class="text-right">Operasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $brgDetail = getData("SELECT * FROM tbl_beli_detail WHERE no_beli = '$noBeli'");
                            foreach ($brgDetail as $detail) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $detail['kode_brg'] ?></td>
                                    <td><?= $detail['nama_brg'] ?></td>
                                    <td class="text-right"><?= number_format($detail['harga_beli'], 0, ',', '.') ?></td>
                                    <td class="text-right"><?= $detail['qty'] ?></td>
                                    <td class="text-right"><?= number_format($detail['jml_harga'], 0, ',', '.') ?></td>
                                    <td class="text-center">
                                        <a href="?idbrg=<?= $detail['kode_brg'] ?>&idbeli=<?= $detail['no_beli'] ?>&qty=<?= $detail['qty'] ?>&tgl=<?= $detail['tgl_beli'] ?>&msg=deleted" class="btn btn-sm btn-danger" title="hapus barang" onclick="return confirm('Anda yakin ingin menghapus barang ini?')"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-lg-6 p-2">
                        <div class="form-group row mb-2">
                            <label for="supplier" class="col-sm-3 col-form-label col-form-label-sm">Supplier</label>
                            <div class="col-sm-9">
                                <select name="supplier" id="supplier" class="form-control form-control-sm">
                                    <option value="" class="text-center">-- Pilih Supplier --</option>
                                    <?php
                                    $suppliers = getData("SELECT * FROM tbl_supplier");
                                    foreach ($suppliers as $supp) { ?>
                                        <option value="<?= $supp['id_supplier'] ?>" class="text-center"><?= $supp['id_supplier'] . " | " . $supp['nama'] ?></option>
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
                    <div class="col-lg-6 p-2">
                        <button type="submit" name="simpan" id="simpan" class="btn btn-sm btn-primary btn-block"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<script>
    let pilihbrg = document.getElementById('kodeBrg');
    let tgl = document.getElementById('tglNota');
    pilihbrg.addEventListener('change', function() {
        document.location.href = this.options[this.selectedIndex].value + '&tgl=' + tgl.value;
    });

    let qty = document.getElementById('qty');
    let jmlHarga = document.getElementById('jmlHarga');
    let harga = document.getElementById('harga');

    qty.addEventListener('input', function() {
        jmlHarga.value = qty.value * harga.value;
    });
</script>

<?php

require '../template/footer.php';

?>