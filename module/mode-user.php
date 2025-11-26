<?php



if (userLogin()['privilege'] !== 'Admin') {
    header("location:" . $main_url . "error-page.php");
    exit();
}


function insertUser($data)
{
    global $koneksi;

    $username   = strtolower(mysqli_real_escape_string($koneksi, $data['username']));
    $fullname   = mysqli_real_escape_string($koneksi, $data['fullname']);
    $password   = mysqli_real_escape_string($koneksi, $data['password']);
    $password2  = mysqli_real_escape_string($koneksi, $data['password2']);
    $address    = mysqli_real_escape_string($koneksi, $data['address']);
    $telepon    = mysqli_real_escape_string($koneksi, $data['telepon']);
    $privilege  = mysqli_real_escape_string($koneksi, $data['privilege']);
    $gambar     = mysqli_real_escape_string($koneksi, $_FILES['image']['name']);

    if ($password !== $password2) {
        echo '<script>
                alert("konfirmasi password tidak sesuai, user baru gagal diregistrasi !");
            </script>';
        return false;
    }

    $pass   = password_hash($password, PASSWORD_DEFAULT);

    $cekUsername    = mysqli_query($koneksi, "SELECT username FROM tbl_user WHERE username = '$username'");
    if (mysqli_num_rows($cekUsername) > 0) {
        echo '<script>
                alert("username sudah terpakai, user baru gagal diregistrasi !");
            </script>';
        return false;
    }

    // validasi nomor telepon

    if (strlen($telepon) > 13) {
        echo '<script>
                alert("nomor telepon tidak boleh lebih dari 13 angka!");
            </script>';
        return false;
    }

    $cekTelepon = mysqli_query($koneksi, "SELECT telepon FROM tbl_user WHERE telepon = '$telepon'");
    if (mysqli_num_rows($cekTelepon) > 0) {
        echo '<script>
                alert("nomor telepon sudah digunakan!");
            </script>';
        return false;
    }

    if ($gambar != null) {
        $gambar = uploadimg(null, $gambar);
    } else {
        $gambar = 'default.png';
    }

    // gambar tidak sesuai validasi
    if ($gambar == '') {
        return false;
    }

    $sqlUser    = "INSERT INTO tbl_user VALUE (null, '$username', '$fullname', '$pass', '$address', '$telepon', '$privilege', '$gambar')";
    mysqli_query($koneksi, $sqlUser);

    return mysqli_affected_rows($koneksi);
}


function deleteUser($id, $foto)
{
    global $koneksi;

    $sqlDel = "DELETE FROM tbl_user WHERE userid = $id";
    mysqli_query($koneksi, $sqlDel);
    if ($foto !== 'default.png') {
        unlink('../asset/image/' . $foto);
    }

    return mysqli_affected_rows($koneksi);
}


function updateUser($data)
{
    global $koneksi;

    $iduser     = mysqli_real_escape_string($koneksi, $data['id']);
    $username   = strtolower(mysqli_real_escape_string($koneksi, $data['username']));
    $fullname   = mysqli_real_escape_string($koneksi, $data['fullname']);
    $address    = mysqli_real_escape_string($koneksi, $data['address']);
    $telepon    = mysqli_real_escape_string($koneksi, $data['telepon']);
    $privilege  = mysqli_real_escape_string($koneksi, $data['privilege']);
    $gambar     = mysqli_real_escape_string($koneksi, $_FILES['image']['name']);
    $fotoLama   = mysqli_real_escape_string($koneksi, $data['oldImg']);

    // cek username sekarang
    $queryUsername  = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE userid = $iduser");
    $dataUsername   = mysqli_fetch_assoc($queryUsername);
    $curUsername    = $dataUsername['username'];

    // cek username  baru
    $newUsername    = mysqli_query($koneksi, "SELECT username FROM tbl_user WHERE username = '$username'");

    if ($username !== $curUsername) {
        if (mysqli_num_rows($newUsername)) {
            echo '<script>
                alert("username sudah terpakai, update data user gagal !");
            </script>';
            return false;
        }
    }

    if ($gambar != null) {
        $url        = "data-user.php";
        $imgUser    = uploadimg($url);
        if ($fotoLama != 'default.png') {
            @unlink('../asset/image/' . $fotoLama);
        }
    } else {
        $imgUser = $fotoLama;
    }


    $updateQuery = "UPDATE tbl_user SET username = '$username', fullname = '$fullname', address = '$address', telepon = '$telepon', privilege = '$privilege', foto = '$imgUser' WHERE userid = $iduser";
    mysqli_query($koneksi, $updateQuery);


    return mysqli_affected_rows($koneksi);
}


function selectUser1($level)
{
    $result = null;
    if ($level === 'Admin') {
        $result = "selected";
    }
    return $result;
}

function selectUser2($level)
{
    $result = null;
    if ($level === 'Owner') {
        $result = "selected";
    }
    return $result;
}

function selectUser3($level)
{
    $result = null;
    if ($level === 'Pegawai') {
        $result = "selected";
    }
    return $result;
}
