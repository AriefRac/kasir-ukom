<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require '../config/config.php';
require '../config/function.php';
require '../module/mode-supplier.php';


$title = "Update Supplier - Kasir Ukom";
require '../template/header.php';
require '../template/navbar.php';
require '../template/sidebar.php';

$id = $_GET['id'];

$sqlEdit    = "SELECT * FROM tbl_supplier WHERE id_supplier = $id";
$supplier   = getData($sqlEdit)[0];


if (isset($_POST['update'])) {
    if (updateSupp($_POST)) {
        echo "<script>
                document.location.href = 'data-supplier.php?msg=updated';
            </script>";
    }
}

?>

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
                        <li class="breadcrumb-item"><a href="<?= $main_url ?>supplier/data-supplier.php">Suppliers</a></li>
                        <li class="breadcrumb-item active">Edit Supplier</li>
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
                            <i class="fas fa-edit fa-sm"></i>
                            Edit Supplier
                        </h3>
                        <button type="submit" name="update" class="btn btn-primary btn-sm float-right"><i class="fas fa-save"></i> Update</button>
                        <button type="reset" name="reset" class="btn btn-danger btn-sm float-right mr-1"><i class="fas fa-times"></i> Reset</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" value="<?= $supplier['id_supplier'] ?>" name="id">
                            <div class="col-lg-8 mb-3">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" class="form-control" id="nama" placeholder="masukkan nama" autofocus autocomplete="off" value="<?= $supplier['nama'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <input type="text" name="deskripsi" class="form-control" id="deskripsi" placeholder="masukkan deskripsi" value="<?= $supplier['deskripsi'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">alamat</label>
                                    <textarea name="alamat" id="alamat" class="form-control" cols="" rows="3" placeholder="masukkan alamat supplier" required><?= $supplier['alamat'] ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="telpon">Telpon</label>
                                    <input type="text" oninput="validateNumericInput(this)" name="telpon" class="form-control" id="telpon" placeholder="masukkan nomor telpon" value="<?= $supplier['telpon'] ?>" required>
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