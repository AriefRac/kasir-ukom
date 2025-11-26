<?php

function updatePass($data)
{
    global $koneksi;

    $currPass = trim(mysqli_real_escape_string($koneksi, $_POST['currPass']));
    $newPass = trim(mysqli_real_escape_string($koneksi, $_POST['newPass']));
    $confPass = trim(mysqli_real_escape_string($koneksi, $_POST['confPass']));
    $userActive = userLogin()['username'];

    // cek password baru
    if ($newPass !== $confPass) {
        echo "<script>
                alert('Gagal ganti password !');
                document.location = '?msg=err1';
            </script>";
        return false;
    }

    if (!password_verify($currPass, userLogin()['password'])) {
        echo "<script>
                alert('Gagal ganti password !');
                document.location = '?msg=err2';
            </script>";
        return false;
    } else {
        $pass = password_hash($newPass, PASSWORD_DEFAULT);
        $sqlPass = "UPDATE tbl_user SET password = '$pass' WHERE username ='$userActive'";
        mysqli_query($koneksi, $sqlPass);
        return mysqli_affected_rows($koneksi);
    }
}
