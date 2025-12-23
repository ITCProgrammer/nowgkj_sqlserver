<!-- Main content -->
      <div class="container-fluid">
		
	    <div class="card card-yellow">
              <div class="card-header">
                <h3 class="card-title">Stock Kain Jadi</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
          <table id="example1" class="table table-sm table-bordered table-striped" style="font-size:13px;">
                  <thead>
                  <tr>
                    <th colspan="2" style="text-align: center">ALL ZONA</th>
                    <th rowspan="2" style="text-align: center">ACTION</th>
                    <th colspan="2" style="text-align: center">ZONA W1 (Lantai 1)</th>
                    <th colspan="2" style="text-align: center">ZONA W3 (Lantai 3)</th>
                    <th colspan="2" style="text-align: center">ZONA X1 (Area PRT)</th>
                    <th colspan="2" style="text-align: center">ZONA X2 (Lantai 2)</th>
                    <th colspan="2" style="text-align: center">ZONA X6 (Trolly)</th>
                    <th colspan="2" style="text-align: center">ZONA X7 (Rak)</th>
                    <th rowspan="2" style="text-align: center">TGL</th>
                    </tr>
                  <tr>
                    <th style="text-align: center">ROLL</th>
                    <th style="text-align: center">WEIGHT</th>
                    <th style="text-align: center">ROLL</th>
                    <th style="text-align: center">WEIGHT</th>
                    <th style="text-align: center">ROLL</th>
                    <th style="text-align: center">WEIGHT</th>
                    <th style="text-align: center">ROLL</th>
                    <th style="text-align: center">WEIGHT</th>
                    <th style="text-align: center">ROLL</th>                    
                    <th style="text-align: center">WEIGHT</th>
                    <th style="text-align: center">ROLL</th>
                    <th style="text-align: center">WEIGHT</th>
                    <th style="text-align: center">ROLL</th>
                    <th style="text-align: center">WEIGHT</th>
					        </tr>
                  </thead>
                  <tbody>
				  <?php
					  
	$sqlDB2022 = " SELECT 
    tgl_tutup,
    SUM(CASE WHEN zone IN ('W1', 'W3', 'X1', 'X2', 'X6', 'X7') THEN weight ELSE 0 END) AS ALL_WEIGHT,
    COUNT(CASE WHEN zone IN ('W1', 'W3', 'X1', 'X2', 'X6', 'X7') THEN rol ELSE NULL END) AS ALL_ROLL,
    SUM(CASE WHEN zone = 'W1' THEN weight ELSE 0 END) AS W1_WEIGHT,
    COUNT(CASE WHEN zone = 'W1' THEN rol ELSE NULL END) AS W1_ROLL,
    SUM(CASE WHEN zone = 'W3' THEN weight ELSE 0 END) AS W3_WEIGHT,
    COUNT(CASE WHEN zone = 'W3' THEN rol ELSE NULL END) AS W3_ROLL,
    SUM(CASE WHEN zone = 'X1' THEN weight ELSE 0 END) AS X1_WEIGHT,
    COUNT(CASE WHEN zone = 'X1' THEN rol ELSE NULL END) AS X1_ROLL,
    SUM(CASE WHEN zone = 'X2' THEN weight ELSE 0 END) AS X2_WEIGHT,
    COUNT(CASE WHEN zone = 'X2' THEN rol ELSE NULL END) AS X2_ROLL,
	  SUM(CASE WHEN zone = 'X6' THEN weight ELSE 0 END) AS X6_WEIGHT,
    COUNT(CASE WHEN zone = 'X6' THEN rol ELSE NULL END) AS X6_ROLL,
	  SUM(CASE WHEN zone = 'X7' THEN weight ELSE 0 END) AS X7_WEIGHT,
    COUNT(CASE WHEN zone = 'X7' THEN rol ELSE NULL END) AS X7_ROLL
FROM 
    tbl_opname_detail_11 tod
WHERE 
    tgl_tutup >= DATE_SUB(CURDATE(), INTERVAL 5 DAY)
GROUP BY 
    tgl_tutup
ORDER BY 
    tgl_tutup DESC
 ";
	$stmt2022   = mysqli_query($con,$sqlDB2022);	
	while($rowdb2022 = mysqli_fetch_array($stmt2022)){
?>
	  <tr>
	    <td style="text-align: center"><?php echo number_format($rowdb2022['ALL_ROLL']);?></td>
	    <td style="text-align: right"><?php echo number_format($rowdb2022['ALL_WEIGHT'],2);?></td>
	    <td style="text-align: center"><div class="btn-group"><a href="pages/cetak/PersediaanKainJadiFullExcel11.php?tgl=<?php echo $rowdb2022['tgl_tutup'];?>" target="_blank" class="btn btn-outline-info btn-xs disabled"><i class="fa fa-download"></i> Download</a>&nbsp;<a href="pages/cetak/PersediaanKainJadiFullDetailExcel11.php?tgl=<?php echo $rowdb2022['tgl_tutup'];?>" target="_blank" class="btn btn-outline-warning btn-xs"><i class="fa fa-download"></i> Detail</a></div></td>
	    <td style="text-align: center"><?php echo number_format($rowdb2022['W1_ROLL']);?></td>
      <td style="text-align: right"><?php echo number_format($rowdb2022['W1_WEIGHT'],2);?></td>
      <td style="text-align: center"><?php echo number_format($rowdb2022['W3_ROLL']);?></td>
      <td style="text-align: right"><?php echo number_format($rowdb2022['W3_WEIGHT'],2);?></td>
      <td style="text-align: center"><?php echo number_format($rowdb2022['X1_ROLL']);?></td>
      <td style="text-align: right"><?php echo number_format($rowdb2022['X1_WEIGHT'],2);?></td>
      <td style="text-align: center"><?php echo number_format($rowdb2022['X2_ROLL']);?></td>
      <td style="text-align: right"><?php echo number_format($rowdb2022['X2_WEIGHT'],2);?></td>
      <td style="text-align: center"><?php echo number_format($rowdb2022['X6_ROLL']);?></td>
      <td style="text-align: right"><?php echo number_format($rowdb2022['X6_WEIGHT'],2);?></td>
      <td style="text-align: center"><?php echo number_format($rowdb2022['X7_ROLL']);?></td>
      <td style="text-align: right"><?php echo number_format($rowdb2022['X7_WEIGHT'],2);?></td>
      <td style="text-align: center"><?php echo $rowdb2022['tgl_tutup'];?></td>
      </tr>				  
<?php	} ?>
				  </tbody>
				<tfoot>
                  <tr>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    </tr>
                  </tfoot>                  
                </table>
              </div>
              <!-- /.card-body -->
        </div>        
		<div class="card card-green">
              <div class="card-header">
                <h3 class="card-title">Stock Kain Jadi BS</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
          <table id="example3" class="table table-sm table-bordered table-striped" style="font-size:13px;">
                  <thead>
                  <tr>
                    <th colspan="2" style="text-align: center">ALL ZONA</th>
                    <th rowspan="2" style="text-align: center">ACTION</th>
                    <th colspan="2" style="text-align: center">ZONA 01</th>
                    <th colspan="2" style="text-align: center">ZONA 03</th>
                    <th rowspan="2" style="text-align: center">TGL</th>
                    </tr>
                  <tr>
                    <th style="text-align: center">ROLL</th>
                    <th style="text-align: center">WEIGHT</th>
                    <th style="text-align: center">ROLL</th>
                    <th style="text-align: center">WEIGHT</th>
                    <th style="text-align: center">ROLL</th>
                    <th style="text-align: center">WEIGHT</th>
                    </tr>
                  </thead>
                  <tbody>
				  <?php
					  
	$sqlDB2022 = " SELECT 
    tgl_tutup,
    SUM(CASE WHEN zone IN ('01', '03') THEN weight ELSE 0 END) AS ALL_WEIGHT,
    COUNT(CASE WHEN zone IN ('01', '03') THEN rol ELSE NULL END) AS ALL_ROLL,
    SUM(CASE WHEN zone = '01' THEN weight ELSE 0 END) AS 01_WEIGHT,
    COUNT(CASE WHEN zone = '01' THEN rol ELSE NULL END) AS 01_ROLL,
    SUM(CASE WHEN zone = '03' THEN weight ELSE 0 END) AS 03_WEIGHT,
    COUNT(CASE WHEN zone = '03' THEN rol ELSE NULL END) AS 03_ROLL
FROM 
    tbl_opname_detail_bs_11 tod
WHERE 
    tgl_tutup >= DATE_SUB(CURDATE(), INTERVAL 5 DAY)
GROUP BY 
    tgl_tutup
ORDER BY 
    tgl_tutup DESC
 ";
	$stmt2022   = mysqli_query($con,$sqlDB2022);	
	while($rowdb2022 = mysqli_fetch_array($stmt2022)){
?>
	  <tr>
	    <td style="text-align: center"><?php echo number_format($rowdb2022['ALL_ROLL']);?></td>
	    <td style="text-align: right"><?php echo number_format($rowdb2022['ALL_WEIGHT'],2);?></td>
	    <td style="text-align: center"><div class="btn-group"><a href="pages/cetak/PersediaanKainDetailBSExcel11.php.php?tgl=<?php echo $rowdb2022['tgl_tutup'];?>" target="_blank" class="btn btn-outline-info btn-xs disabled"><i class="fa fa-download"></i> Download</a>&nbsp;<a href="pages/cetak/PersediaanKainJadiFullDetailBSExcel11.php?tgl=<?php echo $rowdb2022['tgl_tutup'];?>" target="_blank" class="btn btn-outline-warning btn-xs"><i class="fa fa-download"></i> Detail</a></div></td>
	    <td style="text-align: center"><?php echo number_format($rowdb2022['01_ROLL']);?></td>
      <td style="text-align: right"><?php echo number_format($rowdb2022['01_WEIGHT'],2);?></td>
      <td style="text-align: center"><?php echo number_format($rowdb2022['03_ROLL']);?></td>
      <td style="text-align: right"><?php echo number_format($rowdb2022['03_WEIGHT'],2);?></td>
      <td style="text-align: center"><?php echo $rowdb2022['tgl_tutup'];?></td>
      </tr>				  
<?php	} ?>
				  </tbody>
				<tfoot>
                  <tr>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    </tr>
                  </tfoot>                  
                </table>
              </div>
              <!-- /.card-body -->
        </div>
		<div class="card card-pink">
              <div class="card-header">
                <h3 class="card-title">Stock Kain Jadi BB</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
          <table id="example3" class="table table-sm table-bordered table-striped" style="font-size:13px;">
                  <thead>
                  <tr>
                    <th colspan="2" style="text-align: center">ALL ZONA</th>
                    <th rowspan="2" style="text-align: center">ACTION</th>
                    <th colspan="2" style="text-align: center">ZONA BS1</th>
                    <th colspan="2" style="text-align: center">ZONA BS2</th>
                    <th colspan="2" style="text-align: center">ZONA BS3</th>
                    <th colspan="2" style="text-align: center">ZONA JS1</th>
                    <th rowspan="2" style="text-align: center">TGL</th>
                    </tr>
                  <tr>
                    <th style="text-align: center">ROLL</th>
                    <th style="text-align: center">WEIGHT</th>
                    <th style="text-align: center">ROLL</th>
                    <th style="text-align: center">WEIGHT</th>
                    <th style="text-align: center">ROLL</th>
                    <th style="text-align: center">WEIGHT</th>
                    <th style="text-align: center">ROLL</th>
                    <th style="text-align: center">WEIGHT</th>
                    <th style="text-align: center">ROLL</th>
                    <th style="text-align: center">WEIGHT</th>
                    </tr>
                  </thead>
                  <tbody>
				  <?php
					  
	$sqlDB2022 = " SELECT 
    tgl_tutup,
    SUM(CASE WHEN zone IN ('BS1', 'BS2', 'BS3', 'JS1') THEN weight ELSE 0 END) AS ALL_WEIGHT,
    COUNT(CASE WHEN zone IN ('BS1', 'BS2', 'BS3', 'JS1') THEN rol ELSE NULL END) AS ALL_ROLL,
    SUM(CASE WHEN zone = 'BS1' THEN weight ELSE 0 END) AS BS1_WEIGHT,
    COUNT(CASE WHEN zone = 'BS1' THEN rol ELSE NULL END) AS BS1_ROLL,
    SUM(CASE WHEN zone = 'BS2' THEN weight ELSE 0 END) AS BS2_WEIGHT,
    COUNT(CASE WHEN zone = 'BS2' THEN rol ELSE NULL END) AS BS2_ROLL,
	SUM(CASE WHEN zone = 'BS3' THEN weight ELSE 0 END) AS BS3_WEIGHT,
    COUNT(CASE WHEN zone = 'BS3' THEN rol ELSE NULL END) AS BS3_ROLL,
    SUM(CASE WHEN zone = 'JS1' THEN weight ELSE 0 END) AS JS1_WEIGHT,
    COUNT(CASE WHEN zone = 'JS1' THEN rol ELSE NULL END) AS JS1_ROLL
FROM 
    tbl_opname_detail_bb_11 tod
WHERE 
    tgl_tutup >= DATE_SUB(CURDATE(), INTERVAL 5 DAY)
GROUP BY 
    tgl_tutup
ORDER BY 
    tgl_tutup DESC
 ";
	$stmt2022   = mysqli_query($con,$sqlDB2022);	
	while($rowdb2022 = mysqli_fetch_array($stmt2022)){
?>
	  <tr>
	    <td style="text-align: center"><?php echo number_format($rowdb2022['ALL_ROLL']);?></td>
	    <td style="text-align: right"><?php echo number_format($rowdb2022['ALL_WEIGHT'],2);?></td>
	    <td style="text-align: center"><div class="btn-group"><a href="pages/cetak/PersediaanKainDetailBBExcel11.php.php?tgl=<?php echo $rowdb2022['tgl_tutup'];?>" target="_blank" class="btn btn-outline-info btn-xs disabled"><i class="fa fa-download"></i> Download</a>&nbsp;<a href="pages/cetak/PersediaanKainJadiFullDetailBBExcel11.php?tgl=<?php echo $rowdb2022['tgl_tutup'];?>" target="_blank" class="btn btn-outline-warning btn-xs"><i class="fa fa-download"></i> Detail</a></div></td>
	    <td style="text-align: center"><?php echo number_format($rowdb2022['BS1_ROLL']);?></td>
      <td style="text-align: right"><?php echo number_format($rowdb2022['BS1_WEIGHT'],2);?></td>
      <td style="text-align: center"><?php echo number_format($rowdb2022['BS2_ROLL']);?></td>
      <td style="text-align: right"><?php echo number_format($rowdb2022['BS2_WEIGHT'],2);?></td>
      <td style="text-align: center"><?php echo number_format($rowdb2022['BS3_ROLL']);?></td>
      <td style="text-align: right"><?php echo number_format($rowdb2022['BS3_WEIGHT'],2);?></td>
      <td style="text-align: center"><?php echo number_format($rowdb2022['JS1_ROLL']);?></td>
      <td style="text-align: right"><?php echo number_format($rowdb2022['JS1_WEIGHT'],2);?></td>
      <td style="text-align: center"><?php echo $rowdb2022['tgl_tutup'];?></td>
      </tr>				  
<?php	} ?>
				  </tbody>
				<tfoot>
                  <tr>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    </tr>
                  </tfoot>                  
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