<?php
session_start();
//include config
include"koneksi.php";
ini_set("error_reporting", 1);

//request page
$page = isset($_GET['p'])?$_GET['p']:'';
$act  = isset($_GET['act'])?$_GET['act']:'';
$id   = isset($_GET['id'])?$_GET['id']:'';
$page = strtolower($page);
?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>NOWgkj | <?php if ($_GET['p']!="") {
    echo ucwords($_GET['p']);
} else {
    echo "Home";
}?></title>

  <!-- Google Font: Source Sans Pro -->
  <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">-->
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">	
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">	
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">	
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">	  
  <!-- Theme style -->
  <?php if($page=="persediaankain"){ ?>	
  <!-- X Editable -->
  <link rel="stylesheet" href="plugins/xeditable/bootstrap3-editable/css/bootstrap-editable.css">
  <?php } ?>	
  <style>
	  .blink_me {
  animation: blinker 1s linear infinite;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}
	</style>
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="icon" type="image/png" href="dist/img/ITTI_Logo index.ico">	
</head>
<body class="hold-transition sidebar-collapse layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-dark navbar-primary">
    <div class="container">
      <a href="Home" class="navbar-brand">
        <img src="dist/img/ITTI_Logo 2021.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">NOW<strong>gkj</strong></span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="Home" class="nav-link">Home</a>
          </li>
<!--
		  <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Pengiriman</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="PengirimanKain" class="dropdown-item">Pengiriman Kain</a></li>
			  <li><a href="BongkaranKain" class="dropdown-item">Bongkaran Kain</a></li>	
			</ul>
          </li>
-->
		  <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Full Check</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="CheckStock" class="dropdown-item">Check Stock</a></li>
              <li><a href="DataUpload" class="dropdown-item">Upload Data</a></li>
              <li><a href="CheckStockSN" class="dropdown-item">Check Upload Data Per SN</a></li>	
              <li><a href="CheckSN" class="dropdown-item">Check SN</a></li>
              <li><a href="StockBalance" class="dropdown-item">Stock Balance</a></li>	
              <li><a href="LotTransaction" class="dropdown-item">Change Lot Transaction</a></li>
              <li><a href="DataUploadBS" class="dropdown-item">Upload Data Jual BS</a></li>
			      </ul>
          </li>
		  <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Laporan Masuk</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
<!--              <li><a href="MasukKain" class="dropdown-item">Masuk Kain</a></li>-->
			  <li><a href="MasukKainNew" class="dropdown-item">Masuk Kain New</a></li>
<!--			  <li><a href="MasukKainNew7" class="dropdown-item">Masuk Kain 7 ke 7</a></li>-->
<!--			  <li><a href="MasukKainNew7Bulan" class="dropdown-item">Masuk Kain Bulan 7 ke 7</a></li>-->
			  <li><a href="MasukKainNew11" class="dropdown-item">Masuk Kain 11 ke 11</a></li>
			  <li><a href="MasukKainNew11Bulan" class="dropdown-item">Masuk Kain Bulan 11 ke 11</a></li>	
			  <li><a href="MasukKainLot" class="dropdown-item">Masuk Kain Per Lot</a></li>
<!--			  <li><a href="MasukKainThn" class="dropdown-item">Masuk Kain Per Tahun</a></li>-->
<!--			  <li><a href="MutasiKain" class="dropdown-item">Mutasi Kain</a></li>-->
<!--			  <li><a href="MutasiKainBulan" class="dropdown-item">Mutasi Kain Bulan</a></li>	-->
<!--			  <li><a href="GantiStiker" class="dropdown-item">Ganti Stiker</a></li>-->
			  <li><a href="MutasiKain11" class="dropdown-item">Mutasi Kain 11 ke 11</a></li>
			  <li><a href="MutasiKain11Bulan" class="dropdown-item">Mutasi Kain Bulan 11 ke 11</a></li>	
			  <li><a href="GantiStiker11" class="dropdown-item">Ganti Stiker 11 ke 11</a></li>	
			  <li><a href="TembakDokumen" class="dropdown-item">Tembak Dokumen</a></li>	
			  <li><a href="MasukKainTahanan" class="dropdown-item">Masuk Kain Tahanan</a></li>	
			</ul>
          </li>
		  <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Laporan Keluar</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
<!--              <li><a href="KeluarKain" class="dropdown-item">Keluar Kain</a></li>-->
<!--			  <li><a href="KeluarKainNew" class="dropdown-item">Keluar Kain New</a></li>	-->
			  <li><a href="KeluarKainNew11" class="dropdown-item">Keluar Kain New 11 ke 11</a></li>	
			  <li><a href="KeluarKainLot" class="dropdown-item">Keluar Kain Per Lot</a></li>
<!--			  <li><a href="KeluarKainDok" class="dropdown-item">Keluar Kain Ke Dok</a></li>	-->
<!--			  <li><a href="BongkaranKain" class="dropdown-item">Bongkaran</a></li>-->
<!--			  <li><a href="PotongSample" class="dropdown-item">Potong Sample</a></li>-->
<!--			  <li><a href="PassQty" class="dropdown-item">Pass Qty</a></li>	-->
			  <li><a href="BongkaranKain11" class="dropdown-item">Bongkaran 11 ke 11</a></li>
			  <li><a href="PotongSample11" class="dropdown-item">Potong Sample 11 ke 11</a></li>
			  <li><a href="PassQty11" class="dropdown-item">Pass Qty 11 ke 11</a></li>	
        <li><a href="LaporanTolakan" class="dropdown-item">Laporan Tolakan</a></li>	
			</ul>
          </li>	
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Laporan</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
<!--              <li><a href="MutasiKain" class="dropdown-item">Mutasi Kain</a></li>-->
<!--			  <li><a href="PersediaanKain" class="dropdown-item">Persediaan Kain</a></li>-->
<!--			  <li><a href="PersediaanKainItem" class="dropdown-item">Persediaan Kain Per Item</a></li>		-->
<!--			  <li><a href="PersediaanKainZone" class="dropdown-item">Persediaan Kain Zone</a></li>-->
<!--			  <li><a href="PersediaanKainDetail" class="dropdown-item">Persediaan Kain Detail</a></li>-->
			  <li><a href="PersediaanKainTahananDetail" class="dropdown-item">Persediaan Kain Tahanan Detail</a></li>	
<!--			  <li><a href="BulananKain" class="dropdown-item">Bulanan Kain</a></li>	-->
<!--			  <li><a href="PersediaanKainJadi" class="dropdown-item">Stock Balance</a></li>-->
<!--
			  <li><a href="PersediaanKainJadi2022" class="dropdown-item">Stock Tahun 2022 < </a></li>
			  <li><a href="PersediaanKainJadi2023" class="dropdown-item">Stock Tahun 2023 > </a></li>	
-->
<!--			  <li><a href="PersediaanKainJadiPerTahun" class="dropdown-item">Stock PerTahun</a></li>-->
<!--			  <li><a href="PersediaanKainJadiDetailPerTahun" class="dropdown-item">Stock Detail PerTahun</a></li>	-->
			  <li><a href="PersediaanKainJadiDetailPerTahun11" class="dropdown-item">Stock Detail PerTahun (Jam 11)</a></li>
			  <li><a href="PersediaanKainJadiBBDetailPerHari" class="dropdown-item">Stock BB Detail PerHari</a></li>
			  <li><a href="LapZona" class="dropdown-item">Laporan Zona PerHari</a></li>
			  <li><a href="LapStatusKain" class="dropdown-item">Laporan Status Kain</a></li>	
				
			</ul>
          </li>
		  <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Laporan BS</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
<!--			  <li><a href="PersediaanKainBBZone" class="dropdown-item">Persediaan Kain BB Zone</a></li>	-->
<!--              <li><a href="PersediaanKainBSZone" class="dropdown-item">Persediaan Kain BS Zone</a></li>-->
			  <li><a href="PenjualanBB" class="dropdown-item">Penjualan stock BB</a></li> 	
			  <li><a href="MutasiKainBS11" class="dropdown-item">Mutasi Kain BS 11 ke 11</a></li>	
			</ul>
          </li>
		  <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Stock Opname</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
<!--              <li><a href="TutupHarian" class="dropdown-item">Tutup Transaksi Harian</a></li>-->
			  <li><a href="TutupHariand11" class="dropdown-item">Tutup Transaksi Harian (Jam 11)</a></li>
<!--			  <li><a href="TutupHarian11" class="dropdown-item">Tutup Transaksi Harian (Jam 11)</a></li>	-->
<!--			  <li><a href="TutupInOutHarian" class="dropdown-item">Tutup Transaksi In-Out Harian</a></li>-->
<!--			  <li><a href="LapStokHarian" class="dropdown-item">Lap Stok Harian</a></li>-->
<!--			  <li><a href="TutupHarianShift" class="dropdown-item">Tutup Transaksi Harian Per Shift</a></li>-->
			  <li><a href="TutupHarianBB" class="dropdown-item">Tutup Transaksi Harian BB</a></li>	
			</ul>
          </li>	
        </ul>
      
      </div>
      
    </div>
  </nav>
  <!-- /.navbar -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
	<section class="content">  
    <div class="content">
     <?php
          if (!empty($page) and !empty($act)) {
              $files = 'pages/'.$page.'.'.$act.'.php';
          } elseif (!empty($page)) {
              $files = 'pages/'.$page.'.php';
          } else {
              $files = 'pages/home.php';
          }

          if (file_exists($files)) {
              include($files);
          } else {
              include_once("blank.php");
          }
          ?>
		
    </div>
	</section>	
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Indo Taichen Textile Industy
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="">DIT</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>	
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- DataTables  & Plugins -->
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="plugins/jszip/jszip.min.js"></script>
  <script src="plugins/pdfmake/pdfmake.min.js"></script>
  <script src="plugins/pdfmake/vfs_fonts.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>	
<!-- Bootstrap Switch -->
<script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="plugins/dropzone/min/dropzone.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<?php if($page=="persediaankain"){ ?>	
<!-- xeditablejs -->	
<script src="plugins/xeditable/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<?php } ?>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "excel", "pdf"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');	 
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
	$("#example3").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "excel", "pdf"]
    }).buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)'); 
	$("#example4").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false
    }).buttons().container().appendTo('#example4_wrapper .col-md-6:eq(0)');
	$('#example5').DataTable({
	  "paging": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "responsive": true,
	  "scrollX": true,
      "scrollY": '450px',
	  "buttons": ["copy", "excel", "pdf", "print", "colvis"]	
    }).buttons().container().appendTo('#example5_wrapper .col-md-6:eq(0)'); 
	$("#example11").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "excel", "pdf"]
    }).buttons().container().appendTo('#example11_wrapper .col-md-6:eq(0)'); 
	$("#example12").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "excel", "pdf"]
    }).buttons().container().appendTo('#example12_wrapper .col-md-6:eq(0)'); 
	$("#example13").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "excel", "pdf"]
    }).buttons().container().appendTo('#example13_wrapper .col-md-6:eq(0)');
	$("#example14").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "excel", "pdf"]
    }).buttons().container().appendTo('#example14_wrapper .col-md-6:eq(0)'); 
	$("#example15").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "excel", "pdf"]
    }).buttons().container().appendTo('#example15_wrapper .col-md-6:eq(0)');  
	$("#example16").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "excel", "pdf"]
    }).buttons().container().appendTo('#example16_wrapper .col-md-6:eq(0)');
	$("#example17").DataTable({
      "paging": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "responsive": true,
	  "scrollX": true,
      "scrollY": '1490px',
	  "buttons": ["copy", "excel", "pdf"]
    }).buttons().container().appendTo('#example17_wrapper .col-md-6:eq(0)');  
  });
</script>
<script>
	$(function () {
		
	//Initialize Select2 Elements
    $('.select2').select2()	
	//Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })	
		//Datepicker
    $('#datepicker').datetimepicker({
      format: 'YYYY-MM-DD'
    });
    $('#datepicker1').datetimepicker({
      format: 'YYYY-MM-DD'
    });
    $('#datepicker2').datetimepicker({
      format: 'YYYY-MM-DD'
    });
	//Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });
});		
</script>	
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
<script>	
$(document).on('click', '.show_editstatus', function(e) {
    var m = $(this).attr("id");
    $.ajax({
      url: "pages/show_editstatus.php",
      type: "GET",
      data: {
        id: m,
      },
      success: function(ajaxData) {
        $("#EditStatusUpload").html(ajaxData);
        $("#EditStatusUpload").modal('show', {
          backdrop: 'true'
        });
      }
    });
  });	
</script>	
<script>
/*$.fn.editable.defaults.mode = 'inline';*/
$.fn.editable.defaults.mode = 'inline';
$(document).ready(function() {	
$('.keterangan_kj').editable({
        type: 'textarea',
        disabled : false,
        url: 'pages/editable/editable_keterangan.php',
      });
})	
</script>	
</body>
</html>
