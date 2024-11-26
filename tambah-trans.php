<?php
include 'koneksi.php';
session_start();
$queryCustomer = mysqli_query($koneksi, "SELECT * FROM customer");
$id = isset($_GET['detail']) ? $_GET['detail'] : '';
$queryTransDetail = mysqli_query($koneksi, "SELECT customer.customer_name,customer.adress, customer.phone,trans_order.no_transaksi, trans_order.tanggal_laundry, 
trans_order.status,paket.nama_paket, paket.harga, trans_order_detail.* FROM trans_order_detail 
LEFT JOIN paket ON paket.id=trans_order_detail.id_paket
LEFT JOIN trans_order ON trans_order.id=trans_order_detail.id_order 
LEFT JOIN customer ON trans_order.id_customer=customer.id 
WHERE trans_order_detail.id_order='$id'");
$row = [];
while ($dataTrans = mysqli_fetch_assoc($queryTransDetail)) {
    $row[] = $dataTrans;
}

$queryPaket = mysqli_query($koneksi, "SELECT * FROM paket");
$rowPaket = [];
while ($data = mysqli_fetch_assoc($queryPaket)) {
    $rowPaket[] = $data;
}
if (isset($_POST['simpan'])) {
    $id_customer = $_POST['id_customer'];
    $no_transaksi = $_POST['no_transaksi'];
    $tanggal_laundry = $_POST['tanggal_laundry'];
    $id_paket = $_POST['id_paket'];


    $id_paket = $_POST['id_paket'];
    $insertTransOrder = mysqli_query($koneksi, "INSERT INTO trans_order (id_customer,no_transaksi,tanggal_laundry) 
    VALUES ('$id_customer','$no_transaksi','$tanggal_laundry')");

    $last_id = mysqli_insert_id($koneksi);
    foreach ($id_paket as $key => $value) {
        // $id_paket = array_filter($_POST['id_paket']);
        // $qty = array_filter($_POST['qty']);;
        $id_paket = $_POST['id_paket'][$key];
        $qty = $_POST['qty'][$key];
        $queryPaket1 = mysqli_query($koneksi, " SELECT id, harga FROM paket WHERE id='$id_paket'");
        $rowPaket = mysqli_fetch_assoc($queryPaket1);

        $harga = isset($rowPaket['harga']) ? $rowPaket['harga'] : '';

        $subtotal = (int)$qty * (int)$harga;
        // print_r($subtotal);
        // die;
        if ($id_paket > 0) {
            $insertTransDetail = mysqli_query($koneksi, "INSERT INTO trans_order_detail (id_order, id_paket ,qty, subtotal) 
        VALUES ('$last_id','$id_paket','$qty','$subtotal') ");
        }
    }
    header("location: trans_order.php?tambah=berhasil");
}



//no invoice code
//001 jika ada auto increment,id+1=002, selain itu 001
// max : terbesar min:terkecil
$queryInvoice = mysqli_query($koneksi, "SELECT MAX(id) AS no_invoice FROM trans_order");
// jika di dalam table trans order ada datanya 
$str_unique = "INV";
$date_now = date("dmY");
if (mysqli_num_rows($queryInvoice) > 0) {
    $rowInvoice = mysqli_fetch_assoc($queryInvoice);
    $incrementPlus = $rowInvoice['no_invoice'] + 1;
    $code = $str_unique . "" . $date_now . "" . "000" . $incrementPlus;
} else {
    $code =  $str_unique . "" . $date_now . "" . "001";
}
?>

<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../asset/admin/assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard - Analytics | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <?php include 'inc/head.php' ?>
</head>
<style>
    placeholder {
        margin-top: 2rem;
    }
</style>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <?php include 'inc/sidebar.php' ?>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <?php include 'inc/nav.php' ?>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <?php if (isset($_GET['detail'])): ?>
                        <div class="container-xxl flex-grow-1 container-p-y">

                            <div class="row">
                                <div class="col-sm-12 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <h5>Transaksi Laundry <?php echo $row[0]["customer_name"] ?></h5>
                                                </div>
                                                <div class="col-sm-6" align="right">
                                                    <a href="trans_order.php" class="btn btn-secondary">Kembali</a>
                                                    <a href="print.php?id=<?php echo $id ?>" class="btn btn-success">Print</a>
                                                    <?php if ($row[0]['status'] == 0): ?>
                                                        <a href="tambah-trans-pickup.php?ambil=<?php echo $row[0]['id_order'] ?>" class="btn btn-warning">Ambil Cucian</a>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Data Transaksi</h5>
                                        </div>
                                        <div class="card-body">
                                            <?php include 'helper.php'; ?>
                                            <table class=" table table-bordered table-striped">
                                                <tr>
                                                    <th>No Invoice</th>
                                                    <td><?php echo $row[0]["no_transaksi"] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Laundry</th>
                                                    <td><?php echo $row[0]["tanggal_laundry"] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <td><?php echo changeStatus($row[0]["status"]) ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Data Pelanggan</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class=" table table-bordered table-striped">
                                                <tr>
                                                    <th>Nama</th>
                                                    <td><?php echo $row[0]['customer_name'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Telepon</th>
                                                    <td><?php echo $row[0]['phone'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Alamat</th>
                                                    <td><?php echo $row[0]['adress'] ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-2">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Transaksi Detail</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class=" table table-bordered table-striped">
                                                <thead>

                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Paket</th>
                                                        <th>Qty</th>
                                                        <th>Harga</th>
                                                        <th>Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1;
                                                    foreach ($row as $key => $value): ?>
                                                        <tr>
                                                            <td><?php echo $no++ ?></td>
                                                            <td><?php echo $value['nama_paket'] ?></td>
                                                            <td><?php echo $value['qty'] ?></td>
                                                            <td><?php echo $value['harga'] ?></td>
                                                            <td><?php echo $value['subtotal'] ?></td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php else: ?>
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="card mt-5">
                                            <div class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> Transaksi</div>
                                            <div class="card-body">
                                                <?php if (isset($_GET['hapus'])) : ?>
                                                    <div class="alert alert-success" role="alert">
                                                        Data berhasil Di hapus
                                                    </div>
                                                <?php endif; ?>

                                                <div class="mb-3 row">
                                                    <div class="col-sm-6">
                                                        <label for="">Nama Pelanggan</label>
                                                        <select name="id_customer" id="" class="form-control">
                                                            <option value="">Pilih Customer</option>
                                                            <?php while ($row = mysqli_fetch_assoc($queryCustomer)): ?>

                                                                <option value="<?php echo $row['id'] ?>"><?php echo $row['customer_name'] ?></option>
                                                            <?php endwhile ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="">No invoice</label>
                                                        <input type="text" class="form-control" name="no_transaksi" id="" placeholder="Masukan Nama anda" value="#<?php echo $code ?>" required readonly>
                                                    </div>
                                                    <div class="col-sm-6 mb-4">
                                                        <label for="">Tanggal Laundry</label>
                                                        <input type="date" class="form-control" name="tanggal_laundry" id="" placeholder="Masukan email anda" value="" required>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="card mt-5">
                                            <div class="card-header">Detail Transaksi</div>
                                            <div class="card-body">
                                                <?php if (isset($_GET['hapus'])) : ?>
                                                    <div class="alert alert-success" role="alert">
                                                        Data berhasil Di hapus
                                                    </div>
                                                <?php endif; ?>

                                                <div class="mb-3 row">
                                                    <div class="col-sm-3">
                                                        <label for="">Nama Paket</label>
                                                    </div>
                                                    <div class="col-sm-9 mb-3">
                                                        <select name="id_paket[]" id="" class="form-control">
                                                            <option value="">Pilih Paket</option>
                                                            <?php foreach ($rowPaket as $key => $value) { ?>
                                                                <option value="<?php echo $value['id'] ?>"><?php echo $value['nama_paket'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="">Qty</label>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <input type="number" class="form-control" name="qty[]" id="" placeholder="Masukan Nama anda" value="" required>
                                                    </div>
                                                    <div class="mb-3 row mt-3">
                                                        <div class="col-sm-3">
                                                            <label for="">Nama Paket</label>
                                                        </div>
                                                        <div class="col-sm-9 mb-3">
                                                            <select name="id_paket[]" id="" class="form-control">
                                                                <option value="">Pilih Paket</option>
                                                                <?php foreach ($rowPaket as $key => $value) { ?>

                                                                    <option value="<?php echo $value['id'] ?>"><?php echo $value['nama_paket'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label for="">Qty</label>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <input type="number" class="form-control" name="qty[]" id="" placeholder="Masukan Nama anda" value="" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">

                                                        <div class="col-sm-6">
                                                            <button type="submit" class=" btn btn-primary" name="<?php echo isset($_GET['edit']) ? 'edit' : 'simpan' ?>">Simpan</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <!-- / Content -->

                    <!-- Footer -->
                    <div class="container">
                        <div class="row ">
                            <?php include 'inc/footer.php' ?>
                        </div>
                    </div>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- <div class="buy-now">
      <a
        href="https://themeselection.com/products/sneat-bootstrap-html-admin-template/"
        target="_blank"
        class="btn btn-danger btn-buy-now"
        >Upgrade to Pro</a
      >
    </div> -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../asset/admin/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../asset/admin/assets/vendor/libs/popper/popper.js"></script>
    <script src="../asset/admin/assets/vendor/js/bootstrap.js"></script>
    <script src="../asset/admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../asset/admin/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../asset/admin/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="../asset/admin/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../asset/admin/assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>