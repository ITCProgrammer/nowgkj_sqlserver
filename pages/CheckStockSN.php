<?php
$Zone		= isset($_POST['zone']) ? $_POST['zone'] : '';
$Lokasi		= isset($_POST['lokasi']) ? $_POST['lokasi'] : '';
$Barcode	= substr($_POST['barcode'],-13);
?>

<!-- Main content -->
      <div class="container-fluid">
		<form role="form" method="post" enctype="multipart/form-data" name="form1">  
		<div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Filter Data</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
             <div class="form-group row">
               <label for="barcode" class="col-md-1">Barcode</label>               
               <input type="text" class="form-control" value="<?php echo $Barcode; ?>" name="barcode" placeholder="SN / Elements" id="barcode" on autofocus>			    
            </div>	 
			   <button class="btn btn-info" type="submit" value="Cari" name="cari">Cari Data</button>
          </div>
		  
		  <!-- /.card-body -->
          
        </div> 
		<!--	</form>
		<form role="form" method="post" enctype="multipart/form-data" name="form2">-->  
		 
			</form>
		  <div class="card">
              <div class="card-header">
                <h3 class="card-title">Stock</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">				  
                <table id="example1" class="table table-sm table-bordered table-striped" style="font-size:13px;">
                  <thead>
                  <tr>
                    <th style="text-align: center">SN</th>
                    <th style="text-align: center">Kg</th>
                    <th style="text-align: center">Status</th>
                    <th style="text-align: center">Lokasi</th>
                    <th style="text-align: center">NOW</th>
                    <th style="text-align: center">Lot</th>
                    <th style="text-align: center">Warna</th>
                    </tr>
                  </thead>
                  <tbody>
				  <?php					  
   $sql=mysqli_query($con," SELECT sf.* FROM tbl_stokfull sf
		LEFT JOIN tbl_upload tu ON tu.id=sf.id_upload  
		WHERE tu.status='Open' AND sf.`SN`='$Barcode' ");
   $no=1;   
   $c=0;
    while($rowd=mysqli_fetch_array($sql)){
	$sqlDB22 = " SELECT WHSLOCATIONWAREHOUSEZONECODE, WAREHOUSELOCATIONCODE FROM 
	BALANCE b WHERE b.ITEMTYPECODE='KFF' AND b.ELEMENTSCODE='$rowd[SN]' ";
	$stmt2   = db2_exec($conn1,$sqlDB22, array('cursor'=>DB2_SCROLLABLE));
	$rowdb22 = db2_fetch_assoc($stmt2);
	$lokasiBalance=trim($rowdb22['WHSLOCATIONWAREHOUSEZONECODE'])."-".trim($rowdb22['WAREHOUSELOCATIONCODE']);
	   ?>
	  <tr>
      <td style="text-align: center"><?php echo $rowd['SN']; ?></td>
      <td style="text-align: right"><?php echo $rowd['KG']; ?></td>
      <td style="text-align: center"><small class='badge <?php if($rowd['status']=="ok"){ echo"badge-success";}else if($rowd['status']=="belum cek"){ echo"badge-danger";}?>'> <?php echo $rowd['status']; ?></small></td>
      <td style="text-align: center"><?php echo $rowd['zone']."-".$rowd['lokasi']; ?></td>
      <td style="text-align: center"><?php echo $lokasiBalance; ?></td>
      <td style="text-align: center"><?php echo $rowd['lot']; ?></td>
      <td style="text-align: center"><?php echo $rowd['warna']; ?></td>
      </tr>				  
					  <?php 
	 
	 $no++;} ?>
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