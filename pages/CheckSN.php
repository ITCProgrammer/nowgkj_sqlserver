<?php
$Barcode	= substr($_POST['barcode'],-13);
?>

<?php 
if($_POST['cek']=="Cek" or $_POST['cari']=="Cari"){	
	$sqlCek=mysqli_query($cond,"SELECT COUNT(*) as jml FROM tmp_detail_kite WHERE SN='$Barcode'");
	$ck=mysqli_fetch_array($sqlCek);
	if ($ck['jml']>0){
	
	}
	else{
		echo"<script>alert('SN tidak ditemukan');</script>";
		
	}

}
?>
<!-- Main content -->
      <div class="container-fluid">
		<form role="form" method="post" enctype="multipart/form-data" name="form1">  
		<div class="card card-default">
         
          <!-- /.card-header -->
          <div class="card-body">
             <div class="form-group row">
               <label for="barcode" class="col-md-1">Barcode</label>               
               <input type="text" class="form-control"  name="barcode" placeholder="SN / Elements" id="barcode" on autofocus>			    
            </div>	
			  <button class="btn btn-primary" type="submit" name="cek" value="Cek">Check</button>
			  
          </div>
		  
		  <!-- /.card-body -->
          
        </div> 
			</form>
		    
<div class="card">
   <div class="card-header">
     <h3 class="card-title">Detail SN Legacy</h3>
   </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example3" class="table table-sm table-bordered table-striped" style="font-size:13px;">
                  <thead>
                  <tr>
                    <th style="text-align: center">SN</th>
                    <th style="text-align: center">NoKK</th>
                    <th style="text-align: center">Langganan</th>
                    <th style="text-align: center">Order</th>
                    <th style="text-align: center">PO</th>
                    <th style="text-align: center">Item</th>
                    <th style="text-align: center">Warna</th>
                    <th style="text-align: center">No Warna</th>
                    <th style="text-align: center">Jenis Kain</th>
                    <th style="text-align: center">Style</th>
                    <th style="text-align: center">Kgs</th>
                    <th style="text-align: center">Panjang</th>
					<th style="text-align: center">Satuan</th>  
                    <th style="text-align: center">Lot</th>
                    <th style="text-align: center">Lokasi</th>
                    <th style="text-align: center">Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
	  <?php 
	  $sql=mysqli_query($cond,"SELECT * FROM tmp_detail_kite WHERE SN='$Barcode'");					  
	  while($rowd=mysqli_fetch_array($sql)){ 
		  $sql1=mysqli_query($cond,"SELECT * FROM tbl_kite WHERE nokk='$rowd[nokkKite]'");
		  $rowd1=mysqli_fetch_array($sql1);
		  if($rowd['status']=="0"){
			  $sts="<small class='badge badge-info'>Mutasi QCF</small>";
		  }else if($rowd['status']=="1"){
			  $sts="<small class='badge badge-success'>In GKJ</small>";
		  }else if($rowd['status']=="2"){
			  $sts="<small class='badge badge-danger'>Out GKJ</small>";
		  }
	  ?>		  
	  <tr>
      <td style="text-align: center"><?php echo $rowd['SN']; ?></td>
      <td style="text-align: left"><?php echo $rowd['nokkKite']; ?></td>
      <td style="text-align: left"><?php echo $rowd1['pelanggan']; ?></td>
      <td style="text-align: center"><?php echo $rowd1['no_order']; ?></td>
      <td style="text-align: center"><?php echo $rowd1['no_po']; ?></td>
      <td style="text-align: center"><?php echo $rowd1['no_item']; ?></td>
      <td style="text-align: left"><?php echo $rowd1['warna']; ?></td>
      <td style="text-align: center"><?php echo $rowd1['no_warna']; ?></td>
      <td style="text-align: left"><?php echo $rowd1['jenis_kain']; ?></td>
      <td style="text-align: center"><?php echo $rowd1['no_style']; ?></td>
      <td style="text-align: left"><?php echo $rowd['net_wight']; ?></td>
      <td style="text-align: left"><?php echo $rowd['yard_']; ?></td>
	  <td style="text-align: center"><?php echo $rowd['satuan']; ?></td>	  
      <td style="text-align: center"><?php echo $rowd1['no_lot']; ?></td>
      <td style="text-align: center"><?php echo $rowd['lokasi']; ?></td>
      <td style="text-align: center"><?php echo $sts; ?></td>
      </tr>				  
	  <?php } ?>				  
				  </tbody>
                  
                </table>
              </div>
              <!-- /.card-body -->
            </div>      
</div><!-- /.container-fluid -->
    <!-- /.content -->
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