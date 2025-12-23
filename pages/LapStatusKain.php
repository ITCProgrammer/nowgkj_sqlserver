<!-- Main content -->
<?php
$Tgl_6_Hari_Lalu = date('Y-m-d', strtotime('-6 day'));
$Tgl_5_Hari_Lalu = date('Y-m-d', strtotime('-5 day'));
$Tgl_4_Hari_Lalu = date('Y-m-d', strtotime('-4 day'));
$Tgl_3_Hari_Lalu = date('Y-m-d', strtotime('-3 day'));
$Tgl_2_Hari_Lalu = date('Y-m-d', strtotime('-2 day'));
$kemarin = date('Y-m-d', strtotime('-1 day'));

?>

      <div class="container-fluid">	
		<div class="card card-pink">
              <div class="card-header">
                <h3 class="card-title">Stock Status Kain Jadi (X1, X2, W1, W3) Tahun 2023 Ke Atas</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
          <table id="example17" class="table table-sm table-bordered table-striped" style="font-size:13px;" width="100%">
                  <thead>
                  <tr>
                    <th style="text-align: center">&nbsp;</th>
                    <th colspan="2" style="text-align: center"><?php echo $Tgl_6_Hari_Lalu; ?></th>
                    <th colspan="2" style="text-align: center"><?php echo $Tgl_5_Hari_Lalu; ?></th>
                    <th colspan="2" style="text-align: center"><?php echo $Tgl_4_Hari_Lalu; ?></th>
                    <th colspan="2" style="text-align: center"><?php echo $Tgl_3_Hari_Lalu; ?></th>
                    <th colspan="2" style="text-align: center"><?php echo $Tgl_2_Hari_Lalu; ?></th>
                    <th colspan="2" style="text-align: center"><?php echo $kemarin; ?></th>
                  </tr>
                  <tr>
                    <th style="text-align: center">STATUS</th>
                    <th style="text-align: center">&nbsp;</th>
                    <th style="text-align: center">QTY(KGs)</th>
                    <th style="text-align: center">&nbsp;</th>
                    <th style="text-align: center">QTY(KGs)</th>
                    <th style="text-align: center">&nbsp;</th>
                    <th style="text-align: center">QTY(KGs)</th>
                    <th style="text-align: center">&nbsp;</th>
                    <th style="text-align: center">QTY(KGs)</th>
                    <th style="text-align: center">&nbsp;</th>
                    <th style="text-align: center">QTY(KGs)</th>
                    <th style="text-align: center">&nbsp;</th>
                    <th style="text-align: center">QTY(KGs)</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php
					  
	$sqlDB2022 = " SELECT 
	sts_kain,
    SUM(CASE WHEN tgl_tutup = CURDATE() - INTERVAL 6 DAY THEN berat ELSE 0 END) 
        AS `Tgl_6_Hari_Lalu`,
    SUM(CASE WHEN tgl_tutup = CURDATE() - INTERVAL 5 DAY THEN berat ELSE 0 END) 
        AS `Tgl_5_Hari_Lalu`,
    SUM(CASE WHEN tgl_tutup = CURDATE() - INTERVAL 4 DAY THEN berat ELSE 0 END) 
        AS `Tgl_4_Hari_Lalu`,
    SUM(CASE WHEN tgl_tutup = CURDATE() - INTERVAL 3 DAY THEN berat ELSE 0 END) 
        AS `Tgl_3_Hari_Lalu`,
    SUM(CASE WHEN tgl_tutup = CURDATE() - INTERVAL 2 DAY THEN berat ELSE 0 END) 
        AS `Tgl_2_Hari_Lalu`,
    SUM(CASE WHEN tgl_tutup = CURDATE() - INTERVAL 1 DAY THEN berat ELSE 0 END) 
        AS `Tgl_Kemarin`
FROM (
    SELECT 
        tod.sts_kain, 
        tod.tgl_tutup, 
        SUM(tod.weight) AS berat
    FROM 
        tbl_opname_detail_11 tod
    WHERE 
        tod.tgl_tutup >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) 
		and substr(orderno, 4, 2) > 22
	    and length(trim(orderno)) = '10'
    GROUP BY 
        tod.sts_kain, tod.tgl_tutup
) AS subquery
GROUP BY sts_kain
ORDER BY sts_kain ASC
 ";
	$stmt2022   = mysqli_query($con,$sqlDB2022);	
	while($rowdb2022 = mysqli_fetch_array($stmt2022)){
?>
	  <tr>
	  <td style="text-align: center"><?php echo $rowdb2022['sts_kain'];?></td>
      <td style="text-align: center"><a href="pages/cetak/PersediaanKainJadiFullSTSExcel11.php?tgl=<?php echo $Tgl_6_Hari_Lalu; ?>&sts=<?php echo $rowdb2022['sts_kain'];?>" target="_blank" class="btn btn-outline-info btn-xs"><i class="fa fa-download"></i> Download</a></td>
      <td style="text-align: right"><?php echo number_format($rowdb2022['Tgl_6_Hari_Lalu'],2);?></td>
      <td style="text-align: center"><a href="pages/cetak/PersediaanKainJadiFullSTSExcel11.php?tgl=<?php echo $Tgl_5_Hari_Lalu; ?>&sts=<?php echo $rowdb2022['sts_kain'];?>" target="_blank" class="btn btn-outline-info btn-xs"><i class="fa fa-download"></i> Download</a></td>
      <td style="text-align: right"><?php echo number_format($rowdb2022['Tgl_5_Hari_Lalu'],2);?></td>
      <td style="text-align: center"><a href="pages/cetak/PersediaanKainJadiFullSTSExcel11.php?tgl=<?php echo $Tgl_4_Hari_Lalu; ?>&sts=<?php echo $rowdb2022['sts_kain'];?>" target="_blank" class="btn btn-outline-info btn-xs"><i class="fa fa-download"></i> Download</a></td>
      <td style="text-align: right"><?php echo number_format($rowdb2022['Tgl_4_Hari_Lalu'],2);?></td>
      <td style="text-align: center"><a href="pages/cetak/PersediaanKainJadiFullSTSExcel11.php?tgl=<?php echo $Tgl_3_Hari_Lalu; ?>&sts=<?php echo $rowdb2022['sts_kain'];?>" target="_blank" class="btn btn-outline-info btn-xs"><i class="fa fa-download"></i> Download</a></td>
      <td style="text-align: right"><?php echo number_format($rowdb2022['Tgl_3_Hari_Lalu'],2);?></td>
      <td style="text-align: center"><a href="pages/cetak/PersediaanKainJadiFullSTSExcel11.php?tgl=<?php echo $Tgl_2_Hari_Lalu; ?>&sts=<?php echo $rowdb2022['sts_kain'];?>" target="_blank" class="btn btn-outline-info btn-xs"><i class="fa fa-download"></i> Download</a></td>
      <td style="text-align: right"><?php echo number_format($rowdb2022['Tgl_2_Hari_Lalu'],2);?></td>
      <td style="text-align: center"><a href="pages/cetak/PersediaanKainJadiFullSTSExcel11.php?tgl=<?php echo $kemarin; ?>&sts=<?php echo $rowdb2022['sts_kain'];?>" target="_blank" class="btn btn-outline-info btn-xs"><i class="fa fa-download"></i> Download</a></td>
      <td style="text-align: right"><?php echo number_format($rowdb2022['Tgl_Kemarin'],2);?></td>
      </tr>				  
<?php	$tot6+=$rowdb2022['Tgl_6_Hari_Lalu'];
		$tot5+=$rowdb2022['Tgl_5_Hari_Lalu'];
		$tot4+=$rowdb2022['Tgl_4_Hari_Lalu'];
		$tot3+=$rowdb2022['Tgl_3_Hari_Lalu'];
		$tot2+=$rowdb2022['Tgl_2_Hari_Lalu'];
		$tot1+=$rowdb2022['Tgl_Kemarin'];
		}
?>
				  </tbody>
				<tfoot>
					<tr>
                    <th style="text-align: center">TOTAL</th>
                    <th style="text-align: center"><a href="pages/cetak/PersediaanKainJadiFullSTSALLExcel11.php?tgl=<?php echo $Tgl_6_Hari_Lalu; ?>" target="_blank" class="btn btn-outline-primary btn-xs"><i class="fa fa-download"></i> Download</a></th>
                    <th style="text-align: right"><strong><?php echo number_format($tot6,2); ?></strong></th>
                    <th style="text-align: center"><a href="pages/cetak/PersediaanKainJadiFullSTSALLExcel11.php?tgl=<?php echo $Tgl_5_Hari_Lalu; ?>" target="_blank" class="btn btn-outline-primary btn-xs"><i class="fa fa-download"></i> Download</a></th>
                    <th style="text-align: right"><strong><?php echo number_format($tot5,2); ?></strong></th>
                    <th style="text-align: center"><a href="pages/cetak/PersediaanKainJadiFullSTSALLExcel11.php?tgl=<?php echo $Tgl_4_Hari_Lalu; ?>" target="_blank" class="btn btn-outline-primary btn-xs"><i class="fa fa-download"></i> Download</a></th>
                    <th style="text-align: right"><strong><?php echo number_format($tot4,2); ?></strong></th>
                    <th style="text-align: center"><a href="pages/cetak/PersediaanKainJadiFullSTSALLExcel11.php?tgl=<?php echo $Tgl_3_Hari_Lalu; ?>" target="_blank" class="btn btn-outline-primary btn-xs"><i class="fa fa-download"></i> Download</a></th>
                    <th style="text-align: right"><strong><?php echo number_format($tot3,2); ?></strong></th>
                    <th style="text-align: center"><a href="pages/cetak/PersediaanKainJadiFullSTSALLExcel11.php?tgl=<?php echo $Tgl_2_Hari_Lalu; ?>" target="_blank" class="btn btn-outline-primary btn-xs"><i class="fa fa-download"></i> Download</a></th>
                    <th style="text-align: right"><strong><?php echo number_format($tot2,2); ?></strong></th>
                    <th style="text-align: center"><a href="pages/cetak/PersediaanKainJadiFullSTSALLExcel11.php?tgl=<?php echo $kemarin; ?>" target="_blank" class="btn btn-outline-primary btn-xs"><i class="fa fa-download"></i> Download</a></th>
                    <th style="text-align: right"><strong><?php echo number_format($tot1,2); ?></strong></th>
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