<?php

function generateNo()
{
    global $koneksi;

    $queryNo = mysqli_query($koneksi, "SELECT max(no_beli) as maxno FROM tbl_beli_head ");
    $row  = mysqli_fetch_assoc($queryNo);
    $maxNo = $row['maxno'];

    $noUrut = (int) substr($maxNo, 2, 4);
    $noUrut++;

    $maxNo = 'PB' . sprintf("%04s", $noUrut);

    return $maxNo;
}

function insertBeli($data)
{
    global $koneksi;

    $no     = mysqli_real_escape_string($koneksi, $data['no_beli']);
    $tgl     = mysqli_real_escape_string($koneksi, $data['tglNota']);
    $kode     = mysqli_real_escape_string($koneksi, $data['kodeBrg']);
    $nama     = mysqli_real_escape_string($koneksi, $data['nmBrg']);
    $qty     = mysqli_real_escape_string($koneksi, $data['qty']);
    $harga     = mysqli_real_escape_string($koneksi, $data['harga']);
    $jmlHarga     = mysqli_real_escape_string($koneksi, $data['jmlHarga']);

    $cekBrg = mysqli_query($koneksi, "SELECT * FROM tbl_beli_detail WHERE no_beli = '$no' AND kode_brg = '$kode'");
    if (mysqli_num_rows($cekBrg)) {
        echo "
        <script>
            alert('barang sudah ada, anda harus menghapus nya dulu jika ingin mengubah qty nya..');
        </script>
        ";
        return false;
    }

    if (empty($qty)) {
        echo "
        <script>
            alert('Qty tidak boleh kosong');
        </script>
        ";
        return false;
    } else {
        $sqlBeli = "INSERT INTO tbl_beli_detail VALUES (null, '$no', '$tgl', '$kode', '$nama', '$qty', '$harga', '$jmlHarga')";
        mysqli_query($koneksi, $sqlBeli);
    }

    mysqli_query($koneksi, "UPDATE tbl_barang SET stock = stock + $qty WHERE id_brg = '$kode'");

    return mysqli_affected_rows($koneksi);
}

function deleteBeli($idbrg, $idbeli, $qty)
{
    global $koneksi;
    $sqlDel = "DELETE FROM tbl_beli_detail WHERE kode_brg = '$idbrg' AND no_beli = '$idbeli'";
    mysqli_query($koneksi, $sqlDel);

    mysqli_query($koneksi, "UPDATE tbl_barang SET stock = stock - $qty WHERE id_brg = '$idbrg'");

    mysqli_affected_rows($koneksi);
}

function totalBeli($noBeli)
{
    global $koneksi;

    $totalBeli = mysqli_query($koneksi, "SELECT sum(jml_harga) AS total FROM tbl_beli_detail WHERE no_beli = '$noBeli'");
    $data = mysqli_fetch_assoc($totalBeli);
    $total = $data['total'];

    return $total;
}

function insertHd($data)
{
    global $koneksi;

    $noBeli = mysqli_real_escape_string($koneksi, $data['no_beli']);
    $tgl = mysqli_real_escape_string($koneksi, $data['tglNota']);
    $total = mysqli_real_escape_string($koneksi, $data['total']);
    $supplier = mysqli_real_escape_string($koneksi, $data['supplier']);
    $ketr = mysqli_real_escape_string($koneksi, $data['ketr']);

    $sqlBeli = "INSERT INTO tbl_beli_head VALUES ('$noBeli', '$tgl', '$supplier', '$total', '$ketr')";
    mysqli_query($koneksi, $sqlBeli);

    return mysqli_affected_rows($koneksi);
}
