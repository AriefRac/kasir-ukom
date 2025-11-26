<?php

function generateNo()
{
    global $koneksi;

    $queryNo = mysqli_query($koneksi, "SELECT max(no_jual) as maxno FROM tbl_jual_head ");
    $row  = mysqli_fetch_assoc($queryNo);
    $maxNo = $row['maxno'];

    $noUrut = (int) substr($maxNo, 2, 4);
    $noUrut++;

    $maxNo = 'PJ' . sprintf("%04s", $noUrut);

    return $maxNo;
}

function insertJual($data)
{
    global $koneksi;

    $no = mysqli_real_escape_string($koneksi, $data['no_nota']);
    $tgl = mysqli_real_escape_string($koneksi, $data['tglNota']);
    $kode = mysqli_real_escape_string($koneksi, $data['barcode']);
    $nama     = mysqli_real_escape_string($koneksi, $data['nmBrg']);
    $qty     = mysqli_real_escape_string($koneksi, $data['qty']);
    $harga    = mysqli_real_escape_string($koneksi, $data['harga']);
    $jmlHarga     = mysqli_real_escape_string($koneksi, $data['jmlHarga']);
    $stok = mysqli_real_escape_string($koneksi, $data['stok']);

    $cekBrg = mysqli_query($koneksi, "SELECT * FROM tbl_jual_detail WHERE no_jual = '$no' AND barcode = '$kode'");
    if (mysqli_num_rows($cekBrg)) {
        echo "
        <script>
            alert('barang sudah ada, anda harus menghapus nya dulu jika ingin mengubah qty nya..');
        </script>
        ";
        return false;
    }

    if ($qty < 1) {
        echo "
        <script>
            alert('Qty tidak boleh kosong');
        </script>
        ";
        return false;
    } elseif ($qty > $stok) {
        echo "
        <script>
            alert('Stok tidak cukup');
        </script>
        ";
        return false;
    } else {
        $sqlJual = "INSERT INTO tbl_jual_detail VALUES (null, '$no', '$tgl', '$kode', '$nama', '$qty', '$harga', '$jmlHarga')";
        mysqli_query($koneksi, $sqlJual);
    }

    mysqli_query($koneksi, "UPDATE tbl_barang SET stock = stock - $qty WHERE barcode = '$kode'");

    return mysqli_affected_rows($koneksi);
}

function deleteJual($kode, $idJual, $qty)
{
    global $koneksi;
    $sqlDel = "DELETE FROM tbl_jual_detail WHERE barcode = '$kode' AND no_jual = '$idJual'";
    mysqli_query($koneksi, $sqlDel);

    mysqli_query($koneksi, "UPDATE tbl_barang SET stock = stock + $qty WHERE barcode = '$kode'");

    return mysqli_affected_rows($koneksi);
}

function totalJual($noJual)
{
    global $koneksi;

    $totalJual = mysqli_query($koneksi, "SELECT sum(jml_harga) AS total FROM tbl_jual_detail WHERE no_jual = '$noJual'");
    $data = mysqli_fetch_assoc($totalJual);
    $total = $data['total'];

    return $total;
}

function insertHd($data)
{
    global $koneksi;

    $no = mysqli_real_escape_string($koneksi, $data['no_nota']);
    $tgl = mysqli_real_escape_string($koneksi, $data['tglNota']);
    $total = mysqli_real_escape_string($koneksi, $data['total']);
    $customer = mysqli_real_escape_string($koneksi, $data['customer']);
    $ketr = mysqli_real_escape_string($koneksi, $data['ketr']);
    $bayar = mysqli_real_escape_string($koneksi, $data['bayar']);
    $kembalian = mysqli_real_escape_string($koneksi, $data['kembalian']);

    $sqlJual = "INSERT INTO tbl_jual_head VALUES ('$no', '$tgl', '$customer', '$total', '$ketr', '$bayar', '$kembalian')";
    mysqli_query($koneksi, $sqlJual);

    return mysqli_affected_rows($koneksi);
}
