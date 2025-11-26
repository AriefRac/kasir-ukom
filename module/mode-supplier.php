<?php

if (userLogin()['privilege'] === 'Pegawai') {
    header("location:" . $main_url . "error-page.php");
    exit();
}


function insertSupp($data)
{
    global $koneksi;

    $nama   = strtolower(mysqli_real_escape_string($koneksi, $data['nama']));
    $telpon    = mysqli_real_escape_string($koneksi, $data['telpon']);
    $deskripsi   = mysqli_real_escape_string($koneksi, $data['deskripsi']);
    $alamat    = mysqli_real_escape_string($koneksi, $data['alamat']);


    // validasi nomor telepon

    if (strlen($telpon) > 13) {
        echo '<script>
                alert("nomor telepon tidak boleh lebih dari 13 angka!");
            </script>';
        return false;
    }

    $cekTelepon = mysqli_query($koneksi, "SELECT telpon FROM tbl_supplier WHERE telpon = '$telpon'");
    if (mysqli_num_rows($cekTelepon) > 0) {
        echo '<script>
                alert("nomor telepon sudah digunakan!");
            </script>';
        return false;
    }



    $AddQuery    = "INSERT INTO tbl_supplier VALUE (null, '$nama', '$telpon', '$deskripsi', '$alamat')";
    mysqli_query($koneksi, $AddQuery);

    return mysqli_affected_rows($koneksi);
}


function deleteSupp($id)
{
    global $koneksi;

    $DelQuery = "DELETE FROM tbl_supplier WHERE id_supplier = $id";
    mysqli_query($koneksi, $DelQuery);

    return mysqli_affected_rows($koneksi);
}


function updateSupp($data)
{
    global $koneksi;

    $id_supp    = mysqli_real_escape_string($koneksi, $data['id']);
    $nama       = strtolower(mysqli_real_escape_string($koneksi, $data['nama']));
    $deskripsi  = mysqli_real_escape_string($koneksi, $data['deskripsi']);
    $alamat     = mysqli_real_escape_string($koneksi, $data['alamat']);
    $telpon     = mysqli_real_escape_string($koneksi, $data['telpon']);



    // cek username sekarang
    $queryNama  = mysqli_query($koneksi, "SELECT * FROM tbl_supplier WHERE id_supplier = $id_supp");
    $dataNama   = mysqli_fetch_assoc($queryNama);
    $curNama    = $dataNama['nama'];

    // cek username  baru
    $newNama   = mysqli_query($koneksi, "SELECT nama FROM tbl_supplier WHERE nama = '$nama'");

    if ($nama !== $curNama) {
        if (mysqli_num_rows($newNama)) {
            echo '<script>
                alert("username sudah terpakai, update data user gagal !");
            </script>';
            return false;
        }
    }




    $updateQuery = "UPDATE tbl_supplier SET nama = '$nama', telpon = '$telpon', deskripsi = '$deskripsi', alamat = '$alamat' WHERE id_supplier = $id_supp";
    mysqli_query($koneksi, $updateQuery);


    return mysqli_affected_rows($koneksi);
}
