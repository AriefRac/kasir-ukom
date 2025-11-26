<?php

function uploadimg($url = null, $name = null)
{
    $namafile   = $_FILES['image']['name'];
    $ukuran     = $_FILES['image']['size'];
    $tmp        = $_FILES['image']['tmp_name'];

    // validasi file gambar yang boleh diupload
    $eksistensiGambarValid  = ['jpg', 'jpeg', 'png', 'gif']; //white list
    $eksistensiGambar       = explode('.', $namafile);
    $eksistensiGambar       = strtolower(end($eksistensiGambar));

    if (!in_array($eksistensiGambar, $eksistensiGambarValid)) {
        if ($url != null) {
            echo '<script>
                alert("file yang anda upload bukan gambar, Data gagal diupdate !");
                document.location.href = " ' . $url . ' ";
            </script>';
            die();
        } else {
            echo '<script>
            alert("file yang anda upload bukan gambar, Data gagal ditambahkan !");
            </script>';
            return false;
        }
    }

    // validasi ukuran gambar max 1 MB
    if ($ukuran > 1000000) {
        if ($url != null) {
            echo '<script>
                alert("Ukuran gambar melebihi 1 MB, Data gagal diupdate !");
                document.location.href = " ' . $url . ' ";
            </script>';
            die();
        } else {
            echo '<script>
                alert("Ukuran gambar tidak boleh melebihi 1MB");
            </script>';
            return false;
        }
    }

    if ($name != null) {
        $namaFileBaru = $name . '.' . $eksistensiGambar;
    } else {
        $namaFileBaru = rand(10, 1000) . '-' . $namafile;
    }

    move_uploaded_file($tmp, '../asset/image/' . $namaFileBaru);
    return $namaFileBaru;
}


function getData($sql)
{
    global $koneksi;

    $result = mysqli_query($koneksi, $sql);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function userLogin()
{
    $userActive = $_SESSION["ssUserPOS"];
    $dataUser = getData("SELECT * FROM tbl_user WHERE username = '$userActive'")[0];
    return $dataUser;
}

function in_date($tgl)
{
    $tg = substr($tgl, 8, 2);
    $bln = substr($tgl, 5, 2);
    $thn = substr($tgl, 0, 4);

    return $tg . "-" . $bln . "-" . $thn;
}

function omzet()
{
    global $koneksi;

    $queryOmzet = mysqli_query($koneksi, "SELECT sum(total) as omzet FROM tbl_jual_head");
    $data = mysqli_fetch_assoc($queryOmzet);
    $omzet = number_format($data['omzet'], 0, ',', '.');

    return $omzet;
}

// 
function userMenu()
{
    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri_segments = explode('/', $uri_path);
    $menu = $uri_segments[2];
    return $menu;
}

function menuHome()
{
    if (userMenu() == 'dashboard.php') {
        $result = 'active';
    } else {
        $result = null;
    }
    return $result;
}

function menuSetting()
{
    if (userMenu() == 'user') {
        $result = 'menu-is-opening menu-open';
    } else {
        $result = null;
    }
    return $result;
}

function menuMaster()
{
    if (userMenu() == 'supplier' || userMenu() == 'customer' || userMenu() == 'barang') {
        $result = 'menu-is-opening menu-open';
    } else {
        $result = null;
    }
    return $result;
}

function menuUser()
{
    if (userMenu() == 'user') {
        $result = 'active';
    } else {
        $result = null;
    }
    return $result;
}

function menuSupp()
{
    if (userMenu() == 'supplier') {
        $result = 'active';
    } else {
        $result = null;
    }
    return $result;
}

function menuCust()
{
    if (userMenu() == 'customer') {
        $result = 'active';
    } else {
        $result = null;
    }
    return $result;
}

function menuBrg()
{
    if (userMenu() == 'barang') {
        $result = 'active';
    } else {
        $result = null;
    }
    return $result;
}

function menuStok()
{
    if (userMenu() == 'stock') {
        $result = 'active';
    } else {
        $result = null;
    }
    return $result;
}

function menuLapBl()
{
    if (userMenu() == 'laporan-pembelian') {
        $result = 'active';
    } else {
        $result = null;
    }
    return $result;
}

function menuLapJl()
{
    if (userMenu() == 'laporan-penjualan') {
        $result = 'active';
    } else {
        $result = null;
    }
    return $result;
}

function menuPb()
{
    if (userMenu() == 'pembelian') {
        $result = 'active';
    } else {
        $result = null;
    }
    return $result;
}

function menuPj()
{
    if (userMenu() == 'penjualan') {
        $result = 'active';
    } else {
        $result = null;
    }
    return $result;
}
