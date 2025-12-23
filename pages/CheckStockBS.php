<?php
   $tOK=0;
   $tTOK=0;	
   $Where1= " AND sf.`id_upload`='$_GET[id]' " ;	 
   $sql1=mysqli_query($con," SELECT sf.* FROM tbl_stokfull_bs sf
		LEFT JOIN tbl_upload_bs tu ON tu.id=sf.id_upload  
		WHERE tu.status='Open' $Where1 ");	
   while($ck1=mysqli_fetch_array($sql1)){
	$sqlDB22 = " SELECT WHSLOCATIONWAREHOUSEZONECODE, WAREHOUSELOCATIONCODE, LOGICALWAREHOUSECODE FROM 
	BALANCE b WHERE (b.ITEMTYPECODE='KFF' OR b.ITEMTYPECODE='FKF') AND b.ELEMENTSCODE='$ck1[SN]' ";
	$stmt2   = db2_exec($conn1,$sqlDB22, array('cursor'=>DB2_SCROLLABLE));
	$rowdb22 = db2_fetch_assoc($stmt2);
	
	if(trim($rowdb22['LOGICALWAREHOUSECODE'])=="M034"){ 
		$OK = 1;
		$TOK = 0;
	}
	else { 
		$TOK = 1;
		$OK = 0;
	}
	$tOK+=$OK;
    $tTOK+=$TOK;
}
?>
<div class="card">
              <div class="card-header">
                <h3 class="card-title"><a href="DataUploadBS" class="btn btn-info">Kembali</a></h3>
				
              </div>
              <!-- /.card-header -->
              <div class="card-body">
				 <strong>Stok OK Sesuai Data</strong> <small class='badge badge-success'> <?php echo $tOK;?> roll </small><br>
				 <strong>Stok Tidak OK</strong> <small class='badge badge-danger'> <?php echo $tTOK;?> roll </small> 
                <table id="example1" class="table table-sm table-bordered table-striped" style="font-size:13px;">
                  <thead>
                  <tr>
                    <th style="text-align: center">SN</th>
                    <th style="text-align: center">Kg</th>
					<th style="text-align: center">Lot</th>
                    <th style="text-align: center">Warna</th>
                    <th style="text-align: center">Gudang</th>
                    <th style="text-align: center">Lokasi</th>                    
                    <th style="text-align: center">Status</th>
                    </tr>
                  </thead>
                  <tbody>
				  <?php   
   $Where= " AND sf.`id_upload`='$_GET[id]' " ;	 
   $sql=mysqli_query($con," SELECT sf.* FROM tbl_stokfull_bs sf
		LEFT JOIN tbl_upload_bs tu ON tu.id=sf.id_upload  
		WHERE tu.status='Open' $Where ");				  
   $no=1;   
   $c=0;
    while($rowd=mysqli_fetch_array($sql)){
	$sqlDB22 = " SELECT WHSLOCATIONWAREHOUSEZONECODE, WAREHOUSELOCATIONCODE, LOGICALWAREHOUSECODE FROM 
	BALANCE b WHERE (b.ITEMTYPECODE='KFF' OR b.ITEMTYPECODE='FKF') AND b.ELEMENTSCODE='$rowd[SN]' ";
	$stmt2   = db2_exec($conn1,$sqlDB22, array('cursor'=>DB2_SCROLLABLE));
	$rowdb22 = db2_fetch_assoc($stmt2);
	$lokasiBalance=trim($rowdb22['WHSLOCATIONWAREHOUSEZONECODE'])."-".trim($rowdb22['WAREHOUSELOCATIONCODE']);
	if(trim($rowdb22['LOGICALWAREHOUSECODE'])=="M034"){ 
		$sts="OK";}
	else { 
		$sts="Tidak OK";}
	   ?>
	  <tr>
      <td style="text-align: center"><?php echo $rowd['SN']; ?></td>
      <td style="text-align: right"><?php echo $rowd['KG']; ?></td>
	  <td style="text-align: center"><?php echo $rowd['lot']; ?></td>
      <td style="text-align: left"><?php echo $rowd['warna']; ?></td>
      <td style="text-align: center"><?php echo $rowdb22['LOGICALWAREHOUSECODE']; ?></td>
      <td style="text-align: center"><?php echo $lokasiBalance; ?></td>      
      <td style="text-align: center"><small class='badge <?php if(trim($rowdb22['LOGICALWAREHOUSECODE'])=="M034"){ echo"badge-success";}else { echo"badge-danger";}?>'> <?php echo $sts; ?></small></td>
      </tr>				  
					  <?php 
	 
	 $no++;} ?>
				  </tbody>
                  
                </table>
	<br> 
	<strong>Stok Tidak OK dari Upload-an</strong>			  
    <table id="example3" class="table table-sm table-bordered table-striped" style="font-size:13px;">
  <thead>
    <tr>
      <th style="text-align: center">SN</th>
      <th style="text-align: center">Gudang</th>
      <th style="text-align: center">Lokasi</th>                    
      <th style="text-align: center">Status</th>
    </tr>
  </thead>
  <tbody>
    <?php   
    $sqlDB221 = "
      SELECT b.ELEMENTSCODE, b.WHSLOCATIONWAREHOUSEZONECODE, 
             b.WAREHOUSELOCATIONCODE, b.LOGICALWAREHOUSECODE 
      FROM BALANCE b 
      WHERE (b.ITEMTYPECODE='KFF' OR b.ITEMTYPECODE='FKF') 
        AND b.LOGICALWAREHOUSECODE='M034' ";
    
    $stmt21 = db2_exec($conn1, $sqlDB221, array('cursor'=>DB2_SCROLLABLE));
    while($rowdb221 = db2_fetch_assoc($stmt21)){
        
        $sql12 = mysqli_query($con, " 
          SELECT sf.* 
          FROM tbl_stokfull_bs sf
          LEFT JOIN tbl_upload_bs tu ON tu.id=sf.id_upload  
          WHERE tu.status='Open' 
            AND sf.id_upload='$_GET[id]' 
            AND sf.SN='{$rowdb221['ELEMENTSCODE']}' 
        ");	
        $rowd12 = mysqli_fetch_array($sql12);	

        $lokasiBalance = trim($rowdb221['WHSLOCATIONWAREHOUSEZONECODE'])."-".trim($rowdb221['WAREHOUSELOCATIONCODE']);
        
        if(trim($rowd12['SN']) == $rowdb221['ELEMENTSCODE']){ 
            $sts1 = "OK";
        } else { 
            $sts1 = "Tidak OK";
        }

        // Tampilkan hanya jika status BUKAN OK
        if($sts1 != "OK"){ ?>
          <tr>
            <td style="text-align: center"><?php echo $rowdb221['ELEMENTSCODE']; ?></td>
            <td style="text-align: center"><?php echo $rowdb221['LOGICALWAREHOUSECODE']; ?></td>
            <td style="text-align: center"><?php echo $lokasiBalance; ?></td>      
            <td style="text-align: center">
              <small class='badge badge-danger'><?php echo $sts1; ?></small>
            </td>
          </tr>
        <?php } 
    } ?>
  </tbody>
</table>
			  
  </div>
              <!-- /.card-body -->
        </div> 