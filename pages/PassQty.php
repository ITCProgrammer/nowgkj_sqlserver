<?php
$Awal	= isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : '';
$Akhir	= isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : '';
?>
<!-- Main content -->
      <div class="container-fluid">
		<form role="form" method="post" enctype="multipart/form-data" name="form1">  
		<div class="card card-purple">
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
               <label for="tgl_awal" class="col-md-1">Tgl Awal</label>
               <div class="col-md-2">  
                 <div class="input-group date" id="datepicker1" data-target-input="nearest">
                    <div class="input-group-prepend" data-target="#datepicker1" data-toggle="datetimepicker">
                      <span class="input-group-text btn-info">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input name="tgl_awal" value="<?php echo $Awal;?>" type="text" class="form-control form-control-sm" id=""  autocomplete="off" required>
                 </div>
			   </div>	
            </div>
			 <div class="form-group row">
               <label for="tgl_akhir" class="col-md-1">Tgl Akhir</label>
               <div class="col-md-2">  
                 <div class="input-group date" id="datepicker2" data-target-input="nearest">
                    <div class="input-group-prepend" data-target="#datepicker2" data-toggle="datetimepicker">
                      <span class="input-group-text btn-info">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input name="tgl_akhir" value="<?php echo $Akhir;?>" type="text" class="form-control form-control-sm" id=""  autocomplete="off" required>
                 </div>
			   </div>	
            </div> 
			  <button class="btn btn-info" type="submit" value="Cari" name="cari">Cari Data</button>
          </div>
		  
		  <!-- /.card-body -->
          
        </div> 
	</form>
		  <div class="card-pink">
              <div class="card-header">
                <h3 class="card-title">Data Laporan Harian Pass Qty</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
          <table id="example1" class="table table-sm table-bordered table-striped" style="font-size:13px;">
                  <thead>
                  <tr>
                    <th style="text-align: center">No.</th>
                    <th style="text-align: center">Tanggal</th>
                    <th style="text-align: center">Lot</th>
                    <th style="text-align: center">Kode</th>
                    <th style="text-align: center">SN</th>
                    <th style="text-align: center">Qty</th>
                    <th style="text-align: center">KG</th>
                    <th style="text-align: center">Yard</th>
                    <th style="text-align: center">Ket</th>
                    <th style="text-align: center">Userid</th>
                    </tr>
                  </thead>
                  <tbody>
				  <?php	 
$no=1;   
$c=0;
					  
	$sqlDB21 = " SELECT 
s.CREATIONUSER, s.TRANSACTIONDATE, s.DECOSUBCODE02, s.DECOSUBCODE03, s.DECOSUBCODE04, s.DECOSUBCODE05, s.DECOSUBCODE06, s.DECOSUBCODE07, s.DECOSUBCODE08, 
s.LOTCODE, SUM(s.BASEPRIMARYQUANTITY) AS KG, SUM(s.BASESECONDARYQUANTITY) AS YARD, s.ITEMELEMENTCODE, COUNT(s.ITEMELEMENTCODE) AS JML, a.VALUESTRING AS PTG, a1.VALUESTRING as NOTE, s.PROJECTCODE  
FROM STOCKTRANSACTION s
LEFT OUTER JOIN ADSTORAGE a ON a.UNIQUEID = s.ABSUNIQUEID AND a.NAMENAME = 'StatusPotongS'
LEFT OUTER JOIN ADSTORAGE a1 ON a1.UNIQUEID = s.ABSUNIQUEID AND a1.NAMENAME = 'NotePotongS'
WHERE s.ITEMTYPECODE='KFF' AND s.LOGICALWAREHOUSECODE ='M031' AND a.VALUESTRING ='2' AND
s.TEMPLATECODE = '098' AND s.TRANSACTIONDATE BETWEEN '$Awal' AND '$Akhir' 
GROUP BY s.TRANSACTIONDATE, s.DECOSUBCODE02, s.DECOSUBCODE03, s.DECOSUBCODE04, s.DECOSUBCODE05, s.DECOSUBCODE06, s.DECOSUBCODE07, s.DECOSUBCODE08, 
s.LOTCODE,s.CREATIONUSER,a.VALUESTRING, s.PROJECTCODE, a1.VALUESTRING, s.ITEMELEMENTCODE ";
	$stmt1   = db2_exec($conn1,$sqlDB21, array('cursor'=>DB2_SCROLLABLE));
	//}				  
    while($rowdb21 = db2_fetch_assoc($stmt1)){ 
	$kdbenang=trim($rowdb21['DECOSUBCODE01'])." ".trim($rowdb21['DECOSUBCODE02'])." ".trim($rowdb21['DECOSUBCODE03'])." ".trim($rowdb21['DECOSUBCODE04'])." ".trim($rowdb21['DECOSUBCODE05'])." ".trim($rowdb21['DECOSUBCODE06'])." ".trim($rowdb21['DECOSUBCODE07'])." ".trim($rowdb21['DECOSUBCODE08']);	
?>
	  <tr>
	  <td style="text-align: center"><?php echo $no; ?></td>
      <td style="text-align: center"><?php echo substr($rowdb21['TRANSACTIONDATE'],0,10); ?></td>
      <td style="text-align: center"><?php echo $rowdb21['LOTCODE']; ?></td>
      <td style="text-align: left"><?php echo $kdbenang; ?></td>
      <td style="text-align: center"><?php echo $rowdb21['ITEMELEMENTCODE']; ?></td>
      <td style="text-align: center"><?php echo $rowdb21['JML']; ?></td>
      <td style="text-align: right"><?php echo $rowdb21['KG']; ?></td>
      <td style="text-align: right"><?php echo $rowdb21['YARD']; ?></td>
      <td style="text-align: left"><?php echo $rowdb21['NOTE']; ?></td>
      <td style="text-align: center"><?php echo $rowdb21['CREATIONUSER']; ?></td>
      </tr>
	  				  
<?php	$no++;
		$totJml+=$rowdb21['JML'];
		$totKg+=$rowdb21['KG'];	
		$totYard+=$rowdb21['YARD'];
	} ?>
				  </tbody>
        <tfoot>
	    <tr>
	    <td style="text-align: center">&nbsp;</td>
	    <td style="text-align: center">&nbsp;</td>
	    <td style="text-align: center">&nbsp;</td>
	    <td style="text-align: center">&nbsp;</td>
	    <td style="text-align: center"><strong>Total</strong></td>
	    <td style="text-align: center"><strong><?php echo $totJml; ?></strong></td>
	    <td style="text-align: right"><strong><?php echo number_format(round($totKg,5),5); ?></strong></td>
	    <td style="text-align: left"><strong><?php echo number_format(round($totYard,5),5); ?></strong></td>
	    <td style="text-align: left">&nbsp;</td>
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