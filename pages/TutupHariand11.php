<?php
$Awal	= isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : '';
?>

<!-- Main content -->
      <div class="container-fluid">		
		<div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Detail Data Persediaan Kain Jadi Perhari (Tutup Auto Jam 11:00 Malam)</h3>				 
          </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-sm table-bordered table-striped" style="font-size: 14px; text-align: center;">
                  <thead>
                  <tr>
                    <th valign="middle" style="text-align: center">No</th>
                    <th valign="middle" style="text-align: center">Detail</th>
                    <th valign="middle" style="text-align: center">Tgl Tutup</th>
                    <th valign="middle" style="text-align: center">Rol</th>
                    <th valign="middle" style="text-align: center">KG</th>
                    </tr>
                  </thead>
                  <tbody>
<?php	 
$no=1;   
$c=0;				  
$sql = mysqli_query($con," SELECT tgl_tutup,sum(rol) as rol,sum(weight) as kg,DATE_FORMAT(now(),'%Y-%m-%d') as tgl 
FROM tbl_opname_detail_11 GROUP BY tgl_tutup ORDER BY tgl_tutup DESC LIMIT 60");		  
    while($r = mysqli_fetch_array($sql)){
		
?>
	  <tr>
	  <td style="text-align: center"><?php echo $no;?></td>
	  <td style="text-align: center"><div class="btn-group"><a href="DetailOpnamed11-<?php echo $r['tgl_tutup'];?>" class="btn btn-info btn-xs" target="_blank"> <i class="fa fa-link"></i> Lihat Data</a><a href="pages/cetak/DetailOpnamed11Excel.php?tgl=<?php echo $r['tgl_tutup'];?>" class="btn btn-success btn-xs" target="_blank"> <i class="fa fa-file"></i> Cetak Ke Excel</a></div></td>
	  <td style="text-align: center"><?php echo $r['tgl_tutup'];?></td>
      <td style="text-align: center"><?php echo $r['rol'];?></td>
      <td style="text-align: right"><?php echo number_format($r['kg'],3);?></td>
      </tr>
	  				  
	<?php 
	 $no++; 
	
	} ?>
				  </tbody>
                  <tfoot>				
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

