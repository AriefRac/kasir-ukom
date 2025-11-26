<?php


if (userLogin()['privilege'] !== 'Admin') {
    header("location:" . $main_url . "error-page.php");
    exit();
}

function generateId()
{
    global $koneksi;

    $queryId    = mysqli_query($koneksi, "SELECT max(id_brg) as maxid FROM tbl_barang");
    $data       = mysqli_fetch_array($queryId);
    $maxid      = $data['maxid'];

    $noUrut     = (int) substr($maxid, 4, 3);
    $noUrut++;
    $maxid      = "BRG-" . sprintf("%03s", $noUrut);

    return $maxid;
}

function insertBrg($data)
{
    global $koneksi;

    $id_brg     = mysqli_real_escape_string($koneksi, $data['id_brg']);
    $barcode    = mysqli_real_escape_string($koneksi, $data['barcode']);
    $nama_brg   = mysqli_real_escape_string($koneksi, $data['name']);
    $satuan     = mysqli_real_escape_string($koneksi, $data['satuan']);
    $harga_beli = mysqli_real_escape_string($koneksi, $data['harga_beli']);
    $harga_jual = mysqli_real_escape_string($koneksi, $data['harga_jual']);
    $stock_min  = mysqli_real_escape_string($koneksi, $data['stock_min']);
    $gambar     = mysqli_real_escape_string($koneksi, $_FILES['image']['name']);

    $cekBarcode = mysqli_query($koneksi, "SELECT * FROM tbl_barang WHERE barcode = '$barcode'");

    if (mysqli_num_rows($cekBarcode)) {
        echo "<script>alert('Kode barcode sudah ada, barang gagal ditambahkan')</script>";
        return false;
    }

    // upload gambar
    if ($gambar != null) {
        $gambar = uploadimg(null, $id_brg);
    } else {
        $gambar = 'default-brg.jpg';
    }


    $AddQuery    = "INSERT INTO tbl_barang VALUE ('$id_brg', '$barcode', '$nama_brg', '$harga_beli', '$harga_jual', 0, '$satuan', '$stock_min', '$gambar')";
    mysqli_query($koneksi, $AddQuery);

    return mysqli_affected_rows($koneksi);
}


function deleteBrg($id, $img)
{
    global $koneksi;

    $sqlDel = "DELETE FROM tbl_barang WHERE id_brg = '$id'";
    mysqli_query($koneksi, $sqlDel);
    if ($img !== 'default-brg.jpg') {
        unlink('../asset/image/' . $img);
    }


    return mysqli_affected_rows($koneksi);
}


function updateBrg($data)
{
    global $koneksi;

    $id_brg     = mysqli_real_escape_string($koneksi, $data['id_brg']);
    $barcode    = mysqli_real_escape_string($koneksi, $data['barcode']);
    $nama_brg   = mysqli_real_escape_string($koneksi, $data['name']);
    $satuan     = mysqli_real_escape_string($koneksi, $data['satuan']);
    $harga_beli = mysqli_real_escape_string($koneksi, $data['harga_beli']);
    $harga_jual = mysqli_real_escape_string($koneksi, $data['harga_jual']);
    $stock_min  = mysqli_real_escape_string($koneksi, $data['stock_min']);
    $gbrLama    = mysqli_real_escape_string($koneksi, $data['oldImg']);
    $gambar     = mysqli_real_escape_string($koneksi, $_FILES['image']['name']);

    // barcode lama
    $queryBar = mysqli_query($koneksi, "SELECT * FROM tbl_barang WHERE id_brg = '$id_brg'");
    $dataBrg = mysqli_fetch_assoc($queryBar);
    $curBar = $dataBrg['barcode'];

    // barcode baru
    $cekBarcode = mysqli_query($koneksi, "SELECT * FROM tbl_barang WHERE barcode = '$barcode'");

    // jika barcode ganti
    if ($barcode !== $curBar) {
        // jika barcode sudah ada
        if (mysqli_num_rows($cekBarcode)) {
            echo "<script>alert('Kode barcode sudah ada, data barang gagal diperbarui')</script>";
            return false;
        }
    }

    // cek gambar 
    if ($gambar != null) {
        $url = 'index.php';
        if ($gbrLama == 'default-brg.jpg') {
            $nmImg = $id_brg;
        } else {
            $nmImg = $id_brg . '-' . rand(10, 1000);
        }
        $imgBrg = uploadimg($url, $nmImg);
        if ($gbrLama != 'default-brg.jpg') {
            @unlink('../asset/image/' . $gbrLama);
        }
    } else {
        $imgBrg = $gbrLama;
    }


    $updateQuery = "UPDATE tbl_barang SET 
                    barcode = '$barcode', 
                    nama_brg = '$nama_brg', 
                    satuan = '$satuan', 
                    harga_beli = '$harga_beli', 
                    harga_jual = '$harga_jual', 
                    stock_min = '$stock_min', 
                    gambar = '$imgBrg'
                    WHERE id_brg = '$id_brg'";
    mysqli_query($koneksi, $updateQuery);


    return mysqli_affected_rows($koneksi);
}
