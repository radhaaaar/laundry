<?php
include 'koneksi.php';
session_start();
// Munculkan / Pilih sebuah kolom dari tabel users(database)
$tanggal_dari = isset($_GET['tanggal_dari']) ? $_GET['tanggal_dari'] : '';
$tanggal_sampai = isset($_GET['tanggal_sampai']) ? $_GET['tanggal_sampai'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

$query = "SELECT customer.customer_name, trans_order.* FROM trans_order
 LEFT JOIN customer ON trans_order.id_customer = customer.id WHERE trans_order.id >= 0 ";
// jika status tidak kosong

if ($tanggal_dari != "") {
    $query .= " AND trans_order.tanggal_laundry >= '$tanggal_dari' ";
}
if ($tanggal_sampai != "") {
    $query .= " AND trans_order.tanggal_laundry <= '$tanggal_dari' ";
}
if ($status != "") {
    $query .= " AND trans_order.status=$status ";
}
$query .= " ORDER BY trans_order.id DESC";

$queryUser = mysqli_query($koneksi, $query);

if (isset($_GET['clear'])) {
    header("Location: ?");
}

//untuk menjadikan hasil query(data dari queryUser) = menjadi sebuah data objek
//Delete 
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM trans_order WHERE id = '$id'");
    header("Location:trans_order.php?login=berhasil");
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
    data-assets-path="assets/assets/"
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
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card mt-5">
                                    <div class="card-header">transaksi laundry </div>
                                    <div class="card-body">
                                        <?php if (isset($_GET['hapus'])) : ?>
                                            <div class="alert alert-success" role="alert">
                                                Data berhasil Di hapus
                                            </div>
                                        <?php endif; ?>
                                        <!-- filter data transaksi -->
                                        <form action="" method="get">
                                            <div class="mb-3-row">
                                                <div class="col-sm-3">
                                                    <label for="">Tanggal dari</label>
                                                    <input type="date" name=tanggal_dari class="form-control" value="<?= isset($_GET['tanggal_dari']) ? $_GET['tanggal_dari'] : '' ?>">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="">Tanggal Sampai</label>
                                                    <input type="date" name=tanggal_sampai class="form-control" value="<?= isset($_GET['tanggal_sampai']) ? $_GET['tanggal_sampai'] : '' ?>">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="">Tanggal Sampai</label>
                                                    <select name="status" class="form-control">
                                                        <option value="">Pilih Status</option>
                                                        <option value="0" <?= isset($_GET['status']) && ($_GET['status'] == 0) ? 'selected' : '' ?>>Baru</option>
                                                        <option value="1" <?= isset($_GET['status']) && ($_GET['status'] == 1) ? 'selected' : '' ?>>Sudah Dikembalikan</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <button name="filter" class="btn btn-primary"> tampilkan laporan </button>
                                                    <button name="clear" class="btn btn-secondary"> Clear </button>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="table">
                                            <table class="table table-responsive table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>No invoice</th>
                                                        <th>pelanggan</th>
                                                        <th>tanggal laudnry</th>
                                                        <th>status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1;
                                                    while ($rowTrans = mysqli_fetch_assoc($queryUser)) { ?>
                                                        <tr>
                                                            <td><?php echo $no++ ?></td>
                                                            <td><?php echo $rowTrans['no_transaksi'] ?></td>
                                                            <td><?php echo $rowTrans['customer_name'] ?></td>
                                                            <td><?php echo $rowTrans['tanggal_laundry'] ?></td>
                                                            <td>
                                                                <?php
                                                                switch ($rowTrans['status']) {
                                                                    case '1':
                                                                        $badge = "<span class='badge bg-success'>sudah dikembalikan</span>";
                                                                        break;
                                                                    default:
                                                                        $badge = "<span class='badge bg-warning '>baru</span>";
                                                                        break;
                                                                }
                                                                echo $badge;
                                                                ?>
                                                            </td>

                                                            <td>
                                                                <a href="tambah-trans.php?detail=<?php echo $rowTrans['id'] ?>">
                                                                    <span class="btn btn-primary bx bx-show bx-18px"></span>
                                                                </a>
                                                                <a target="_blank" href="print.php?id=<?php echo $rowTrans['id'] ?>">
                                                                    <span class="tf-icon btn btn-success bx bx-print bx-18px"></span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
    <script src="assets/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/assets/vendor/js/bootstrap.js"></script>
    <script src="assets/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="assets/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="assets/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="assets/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="assets/assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>