<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require '../config/config.php';
require '../config/function.php';
require '../module/mode-user.php';


$title = "Tambah User - Kasir Ukom";
require '../template/header.php';
require '../template/navbar.php';
require '../template/sidebar.php';

$alert = '';

if (isset($_POST['simpan'])) {
    if (insertUser($_POST)) {
        $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    User Berhasil ditambahkan..
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
                    <h1 class="m-0">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $main_url ?>dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= $main_url ?>user/data-user.php">Users</a></li>
                        <li class="breadcrumb-item active">Add User</li>
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
                            Add User
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
                                    <label for="username">Username</label>
                                    <input type="text" name="username" class="form-control" id="username" placeholder="masukkan username" autofocus autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label for="fullname">Fullname</label>
                                    <input type="text" name="fullname" class="form-control" id="fullname" placeholder="masukkan nama lengkap" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control" id="password" placeholder="masukkan password" required>
                                </div>
                                <div class="form-group">
                                    <label for="password2">Konfirmasi Password</label>
                                    <input type="password" name="password2" class="form-control" id="password2" placeholder="masukkan kembali password anda" required>
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea name="address" id="address" class="form-control" cols="" rows="3" placeholder="masukkan alamat user" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="telepon">Telepon</label>
                                    <input type="text" oninput="validateNumericInput(this)" name="telepon" class="form-control" id="telepon" placeholder="masukkan nomor telepon" required>
                                </div>
                                <div class="form-group">
                                    <label for="privilege">Privilege</label>
                                    <select name="privilege" id="privilege" class="form-control">
                                        <option value="Admin">Admin</option>
                                        <option value="Owner">Owner</option>
                                        <option value="Pegawai">Pegawai</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 text-center">
                                <img src="<?= $main_url ?>asset/image/default.png" class="profile-user-img img-circle mb-3" alt="image user" id="prev">
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