<?php
$Awal	= isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : '';
$Akhir	= isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : '';
?>
<!-- Main content -->
      <div class="container-fluid">		
		<div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Detail Laporan Harian Bagi Kain Greige Tgl <?php echo $_GET['tgl']; ?></h3>
				<!--<a href="pages/cetak/lapgkeluar_excel.php?awal=<?php echo $Awal;?>&akhir=<?php echo $Akhir;?>" class="btn bg-blue float-right" target="_blank">Cetak Excel</a>-->  
          </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-sm table-bordered table-striped" style="font-size: 13px; text-align: center;">
                  <thead>
                  <tr>
                    <th valign="middle" style="text-align: center">TglKeluar</th>
                    <th valign="middle" style="text-align: center">Tipe</th>
                    <th valign="middle" style="text-align: center">SJ</th>
                    <th valign="middle" style="text-align: center">Warna</th>
                    <th valign="middle" style="text-align: center">Buyer</th>
                    <th valign="middle" style="text-align: center">Customer</th>
                    <th valign="middle" style="text-align: center">No PO</th>
                    <th valign="middle" style="text-align: center">No Order</th>
                    <th valign="middle" style="text-align: center">Roll</th>
                    <th valign="middle" style="text-align: center">Berat/Kg</th>
                    <th valign="middle" style="text-align: center">Lot</th>
                    <th valign="middle" style="text-align: center">Lokasi</th>
                    <th valign="middle" style="text-align: center">FOC</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php
	 
$no=1;   
$c=0;
$sql = mysqli_query($con," SELECT * FROM tblkeluarkain WHERE tgl_tutup='$_GET[tgl]' ORDER BY id ASC");		  
    while($r = mysqli_fetch_array($sql)){		
?>
	  <tr>
	  <td style="text-align: center"><?php echo $r['tgl_keluar']; ?></td>
	  <td style="text-align: left"><?php echo $r['tipe']; ?></td>
	  <td style="text-align: left"><?php echo $r['no_sj']; ?></td>
	  <td style="text-align: center"><?php echo $r['warna']; ?></td>
	  <td style="text-align: center"><?php echo $r['buyer']; ?></td> 
      <td style="text-align: center"><?php echo $r['customer']; ?></td>
      <td style="text-align: left"><?php echo $r['no_po']; ?></td>
      <td style="text-align: left"><?php echo $r['no_order']; ?></td>
      <td style="text-align: center"><?php echo $r['qty']; ?></td>
      <td style="text-align: right"><?php echo $r['berat']; ?></td>
      <td style="text-align: center"><?php echo $r['lot']; ?></td>
      <td style="text-align: center"><?php echo $r['lokasi']; ?></td>
      <td style="text-align: center"><?php echo $r['foc']; ?></td>
      </tr>
	  				  
	<?php 
	 $no++; 
	$totRol=$totRol+$r['qty'];
	$totKG=$totKG+$r['berat'];	
	
	} ?>
				  </tbody>
     <tfoot>
	<tr>
	    <th style="text-align: center">&nbsp;</th>
	    <th style="text-align: left">&nbsp;</th>
	    <th style="text-align: left">&nbsp;</th>
	    <th style="text-align: center">&nbsp;</th>
	    <th>&nbsp;</th>
	    <th style="text-align: center">&nbsp;</th>
	    <th style="text-align: left">&nbsp;</th>
	    <th style="text-align: left">Total</th>
	    <th style="text-align: center"><?php echo $totRol;?></th>
	    <th style="text-align: right"><?php echo number_format(round($totKG,2),2);?></th>
	    <th style="text-align: center">&nbsp;</th>
	    <th style="text-align: center">&nbsp;</th>
	    <th style="text-align: center">&nbsp;</th>
	    </tr>				
	 </tfoot>             
                </table>
              </div>
              <!-- /.card-body -->
        </div> 		
      </div><!-- /.container-fluid -->
    <!-- /.content -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>	
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<script>
	$(function () {
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
	
});		
</script>
