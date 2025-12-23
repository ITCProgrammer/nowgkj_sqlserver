<?php
$Awal	= isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : '';
$Akhir	= isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : '';
?>
<!-- Main content -->
      <div class="container-fluid">  		
		<div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Detail Laporan  Masuk Kain Jadi Tgl <?php echo $_GET['tgl']; ?></h3>
				<!--<a href="pages/cetak/lapgmasuk_excel.php?awal=<?php echo $Awal;?>&akhir=<?php echo $Akhir;?>" class="btn bg-blue float-right" target="_blank">Cetak Excel</a>-->  
          </div>
              <!-- /.card-header -->
              <div class="card-body">				  
                <table id="example1" width="100%" class="table table-sm table-bordered table-striped" style="font-size: 13px; text-align: center;">
                  <thead>
                  <tr>
                    <th valign="middle" style="text-align: center">Tgl Masuk</th>
                    <th valign="middle" style="text-align: center">Tipe</th>
                    <th valign="middle" style="text-align: center">Item</th>
                    <th valign="middle" style="text-align: center">No Warna</th>
                    <th valign="middle" style="text-align: center">Warna</th>
                    <th valign="middle" style="text-align: center">Buyer</th>
                    <th valign="middle" style="text-align: center">Customer</th>
                    <th valign="middle" style="text-align: center">No PO</th>
                    <th valign="middle" style="text-align: center">No Order</th>
                    <th valign="middle" style="text-align: center">Jenis Kain</th>
                    <th valign="middle" style="text-align: center">Lebar</th>
                    <th valign="middle" style="text-align: center">Gramasi</th>
                    <th valign="middle" style="text-align: center">Qty</th>
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
$sql = mysqli_query($con," SELECT * FROM tblmasukkain WHERE tgl_tutup='$_GET[tgl]' ORDER BY id ASC");		  
    while($r = mysqli_fetch_array($sql)){										   
			
?>
	  <tr>
	  <td style="text-align: center"><?php echo $r['tgl_masuk']; ?></td>
      <td style="text-align: center"><?php echo $r['tipe']; ?></td>
      <td style="text-align: left"><?php echo $r['itemno']; ?></td>
      <td style="text-align: left"><?php echo $r['nowarna']; ?></td>
      <td style="text-align: center"><?php echo $r['warna']; ?></td>
      <td style="text-align: left"><?php echo $r['buyer']; ?></td> 
      <td style="text-align: left"><?php echo $r['customer']; ?></td>
      <td style="text-align: left"><?php echo $r['nopo']; ?></td>
      <td style="text-align: center"><?php echo $r['no_order']; ?></td>
      <td style="text-align: left"><?php echo $r['jenis_kain']; ?></td>
      <td style="text-align: right"><?php echo $r['lebar']; ?></td>
      <td style="text-align: right"><?php echo $r['gramasi']; ?></td>
      <td style="text-align: right"><?php echo $r['qty']; ?></td>
      <td style="text-align: right"><?php echo $r['berat']; ?></td>
      <td><?php echo $r['lot']; ?></td>
      <td><?php echo $r['lokasi']; ?></td>
      <td><?php echo $r['foc']; ?></td>
      </tr>
	  				  
	<?php 
	 $no++; 
	$tMRol+=$r['qty'];
	$tMKG +=$r['berat'];
	} ?>
				  </tbody>
                  <tfoot>
	 <tr>
	    <td style="text-align: center">&nbsp;</td>
	    <td style="text-align: center">&nbsp;</td>
	    <td style="text-align: center">&nbsp;</td>
	    <td style="text-align: center">&nbsp;</td>
	    <td style="text-align: center">&nbsp;</td>
	    <td>&nbsp;</td>
	    <td style="text-align: left">&nbsp;</td>
	    <td style="text-align: left">&nbsp;</td>
	    <td style="text-align: center">&nbsp;</td>
	    <td style="text-align: left">&nbsp;</td>
	    <td style="text-align: right">&nbsp;</td>
	    <td style="text-align: right">&nbsp;</td>
	    <td style="text-align: right"><strong><?php echo $tMRol;?></strong></td>
	    <td style="text-align: right"><strong><?php echo number_format(round($tMKG,2),2);?></strong></td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
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



