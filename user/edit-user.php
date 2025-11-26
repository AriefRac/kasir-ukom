<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require '../config/config.php';
require '../config/function.php';
require '../module/mode-user.php';


$title = "Update User - Kasir Ukom";
require '../template/header.php';
require '../template/navbar.php';
require '../template/sidebar.php';

$id = $_GET['id'];

$sqlEdit    = "SELECT * FROM tbl_user WHERE userid = $id";
$user       = getData($sqlEdit)[0];
$privilege  = $user['privilege'];

if (isset($_POST['update'])) {
    if (updateUser($_POST)) {
        echo "<script>
                alert('Data user berhasil diupdate !');
                document.location.href = 'data-user.php';
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
                    <h1 class="m-0">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $main_url ?>dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= $main_url ?>user/data-user.php">Users</a></li>
                        <li class="breadcrumb-item active">Edit User</li>
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
                            Edit User
                        </h3>
                        <button type="submit" name="update" class="btn btn-primary btn-sm float-right"><i class="fas fa-save"></i> Update</button>
                        <button type="reset" name="reset" class="btn btn-danger btn-sm float-right mr-1"><i class="fas fa-times"></i> Reset</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" value="<?= $user['userid'] ?>" name="id">
                            <div class="col-lg-8 mb-3">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" class="form-control" id="username" placeholder="masukkan username" autofocus autocomplete="off" value="<?= $user['username'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="fullname">Fullname</label>
                                    <input type="text" name="fullname" class="form-control" id="fullname" placeholder="masukkan nama lengkap" value="<?= $user['fullname'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea name="address" id="address" class="form-control" cols="" rows="3" placeholder="masukkan alamat user" required><?= $user['address'] ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="telepon">Telepon</label>
                                    <input type="text" oninput="validateNumericInput(this)" name="telepon" class="form-control" id="telepon" placeholder="masukkan nomor telepon" value="<?= $user['telepon'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="privilege">Privilege</label>
                                    <select name="privilege" id="privilege" class="form-control">
                                        <option value="Admin" <?= selectUser1($privilege) ?>>Admin</option>
                                        <option value="Owner" <?= selectUser2($privilege) ?>>Owner</option>
                                        <option value="Pegawai" <?= selectUser3($privilege) ?>>Pegawai</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 text-center">
                                <input type="hidden" name="oldImg" value="<?= $user['foto'] ?>">
                                <img src="<?= $main_url ?>asset/image/<?= $user['foto'] ?>" class="profile-user-img img-circle mb-3" alt="user image">
                                <input type="file" class="form-control" name="image">
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