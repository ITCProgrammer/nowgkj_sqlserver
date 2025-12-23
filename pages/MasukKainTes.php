<?php
$Awal	= isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : '';
$Akhir	= isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : '';
?>
<!-- Main content -->
      <div class="container-fluid">
		<form role="form" method="post" enctype="multipart/form-data" name="form1">  
		<div class="card card-purple">
          <div class="card-header">
            <h3 class="card-title">Filter Data Masuk Kain Jadi</h3>

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
		  </div>
		  <div class="card-footer">
            <button class="btn btn-info" type="submit" value="Cari" name="cari">Cari Data</button>
          </div>
		  <!-- /.card-body -->
          
        </div> 
	</form>
		  <div class="card card-pink">
              <div class="card-header">
                <h3 class="card-title">Data Laporan Harian Masuk Kain Jadi</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
          <table id="example1" class="table table-sm table-bordered table-striped" style="font-size:13px;">
                  <thead>
                  <tr>
                    <th style="text-align: center">TglMasuk</th>
                    <th style="text-align: center">Tipe</th>
                    <th style="text-align: center">Item</th>
                    <th style="text-align: center">No Warna</th>
                    <th style="text-align: center">Warna</th>
                    <th style="text-align: center">Roll</th>
                    <th style="text-align: center">Qty(KG)</th>
                    <th style="text-align: center">Buyer</th>
                    <th style="text-align: center">Customer</th>
                    <th style="text-align: center">No PO</th>
                    <th style="text-align: center">No Order</th>
                    <th style="text-align: center">Jenis Kain</th>
                    <th style="text-align: center">Lebar</th>
                    <th style="text-align: center">Gramasi</th>
                    <th style="text-align: center">Lot</th>
                    <th style="text-align: center">Lokasi</th>
                    <th style="text-align: center">FOC</th>
                    </tr>
                  </thead>
                  <tbody>
				  <?php
   $no=1;   
   $c=0;
	$sqlDB21 = " SELECT TRANSACTIONDATE,ITEMTYPECODE,DECOSUBCODE01,
DECOSUBCODE02,DECOSUBCODE03,DECOSUBCODE04,DECOSUBCODE05,
DECOSUBCODE06,DECOSUBCODE07,DECOSUBCODE08, COUNT(BASEPRIMARYQUANTITY) AS ROL,
SUM(BASEPRIMARYQUANTITY) AS KGS,LOTCODE,PROJECTCODE,
LISTAGG(DISTINCT  TRIM(WHSLOCATIONWAREHOUSEZONECODE),',') AS ZN,
LISTAGG(DISTINCT TRIM(WAREHOUSELOCATIONCODE),',') AS LK,QUALITYREASONCODE FROM STOCKTRANSACTION 
WHERE TRANSACTIONDATE BETWEEN '$Awal' AND '$Akhir' AND 
TEMPLATECODE ='304' AND 
(ITEMTYPECODE='FKF' OR ITEMTYPECODE='KFF') AND 
LOGICALWAREHOUSECODE ='M031' AND NOT WAREHOUSELOCATIONCODE='DOK' AND
NOT WAREHOUSELOCATIONCODE LIKE 'BBS%' AND 
NOT WAREHOUSELOCATIONCODE LIKE 'ZER%' AND LOTCODE LIKE '00%' 
GROUP BY LOTCODE,TRANSACTIONDATE,ITEMTYPECODE,DECOSUBCODE01,
DECOSUBCODE02,DECOSUBCODE03,DECOSUBCODE04,DECOSUBCODE05,
DECOSUBCODE06,DECOSUBCODE07,DECOSUBCODE08,PROJECTCODE,
WHSLOCATIONWAREHOUSEZONECODE,WAREHOUSELOCATIONCODE,QUALITYREASONCODE ";
	$stmt1   = db2_exec($conn1,$sqlDB21, array('cursor'=>DB2_SCROLLABLE));
	//}				  
    while($rowdb21 = db2_fetch_assoc($stmt1)){
		
		
	
	$sqlDB29 = " SELECT ADSTORAGE.NAMENAME,ADSTORAGE.VALUEDECIMAL 
	   FROM DB2ADMIN.ADSTORAGE ADSTORAGE RIGHT OUTER JOIN DB2ADMIN.PRODUCT PRODUCT 
       ON ADSTORAGE.UNIQUEID=PRODUCT.ABSUNIQUEID WHERE
       PRODUCT.ITEMTYPECODE='$rowdb21[ITEMTYPECODE]' AND	
	   PRODUCT.SUBCODE01='$rowdb21[DECOSUBCODE01]' AND
       PRODUCT.SUBCODE02='$rowdb21[DECOSUBCODE02]' AND
       PRODUCT.SUBCODE03='$rowdb21[DECOSUBCODE03]' AND
	   PRODUCT.SUBCODE04='$rowdb21[DECOSUBCODE04]' AND
       PRODUCT.SUBCODE05='$rowdb21[DECOSUBCODE05]' AND
	   PRODUCT.SUBCODE06='$rowdb21[DECOSUBCODE06]' AND
       PRODUCT.SUBCODE07='$rowdb21[DECOSUBCODE07]' AND
	   PRODUCT.SUBCODE08='$rowdb21[DECOSUBCODE08]' AND 
	   ADSTORAGE.NAMENAME='Width' ";
	$stmt9   = db2_exec($conn1,$sqlDB29, array('cursor'=>DB2_SCROLLABLE));
	$rowdb29 = db2_fetch_assoc($stmt9);
	$sqlDB30 = " SELECT ADSTORAGE.NAMENAME,ADSTORAGE.VALUEDECIMAL 
	   FROM DB2ADMIN.ADSTORAGE ADSTORAGE RIGHT OUTER JOIN DB2ADMIN.PRODUCT PRODUCT 
       ON ADSTORAGE.UNIQUEID=PRODUCT.ABSUNIQUEID WHERE
       PRODUCT.ITEMTYPECODE='$rowdb21[ITEMTYPECODE]' AND	
	   PRODUCT.SUBCODE01='$rowdb21[DECOSUBCODE01]' AND
       PRODUCT.SUBCODE02='$rowdb21[DECOSUBCODE02]' AND
       PRODUCT.SUBCODE03='$rowdb21[DECOSUBCODE03]' AND
	   PRODUCT.SUBCODE04='$rowdb21[DECOSUBCODE04]' AND
       PRODUCT.SUBCODE05='$rowdb21[DECOSUBCODE05]' AND
	   PRODUCT.SUBCODE06='$rowdb21[DECOSUBCODE06]' AND
       PRODUCT.SUBCODE07='$rowdb21[DECOSUBCODE07]' AND
	   PRODUCT.SUBCODE08='$rowdb21[DECOSUBCODE08]' AND 
	   ADSTORAGE.NAMENAME='GSM' ";
	$stmt10   = db2_exec($conn1,$sqlDB30, array('cursor'=>DB2_SCROLLABLE));
	$rowdb30 = db2_fetch_assoc($stmt10);		
?>
	  <tr>
	  <td style="text-align: center"><?php echo substr($rowdb21['TRANSACTIONDATE'],0,10); ?></td>
      <td style="text-align: left"><?php if($rowdb21['ITEMTYPECODE']=="KFF"){echo "KAIN"; }else{echo "KRAH";}?></td>
      <td style="text-align: left"><?php echo $item; ?></td>
      <td style="text-align: left"><?php echo $rowdb21['DECOSUBCODE05']; ?></td>
      <td style="text-align: left"><?php echo $warna; ?></td>
      <td style="text-align: center"><?php echo $rowdb21['ROL']; ?></td>
      <td style="text-align: right"><?php echo number_format(round($rowdb21['KGS'],2),2); ?></td>
      <td style="text-align: left"><?php echo $buyer; ?></td>
      <td style="text-align: left"><?php echo $langganan; ?></td>
      <td style="text-align: left"><?php if($rowdb23['PO_HEADER']!=""){echo $rowdb23['PO_HEADER'];}else{echo $rowdb23['PO_LINE'];} ?></td>
      <td style="text-align: center"><?php echo $PJCODE; ?></td>
      <td style="text-align: left"><?php echo $rowdb27['SHORTDESCRIPTION']; ?></td>
      <td style="text-align: center"><?php echo round($rowdb29['VALUEDECIMAL']);?></td>
      <td style="text-align: center"><?php echo round($rowdb30['VALUEDECIMAL']);?></td>
      <td style="text-align: right"><span style="text-align: center"><?php echo $rowdb21['LOTCODE']; ?></span></td>
      <td style="text-align: center"><?php echo $rowdb21['LK']; ?></td>
      <td style="text-align: center"><?php if($rowdb21['QUALITYREASONCODE']=="FOC"){echo $rowdb21['QUALITYREASONCODE'];} ?></td>
      </tr>
	  				  
<?php	$no++;
	$tRol += $rowdb21['ROL'];
	$tKg +=	$rowdb21['KGS'];
	
	} ?>
				  </tbody>
      <tfoot>
	  <tr>
	    <td style="text-align: center">&nbsp;</td>
	    <td style="text-align: left">&nbsp;</td>
	    <td style="text-align: left">&nbsp;</td>
	    <td style="text-align: left">&nbsp;</td>
	    <td style="text-align: left"><strong>Total</strong></td>
	    <td style="text-align: center"><strong><?php echo $tRol; ?></strong></td>
	    <td style="text-align: right"><strong><?php echo number_format(round($tKg,2),2); ?></strong></td>
	    <td style="text-align: left">&nbsp;</td>
	    <td style="text-align: left">&nbsp;</td>
	    <td style="text-align: left">&nbsp;</td>
	    <td style="text-align: center">&nbsp;</td>
	    <td style="text-align: left">&nbsp;</td>
	    <td style="text-align: right">&nbsp;</td>
	    <td style="text-align: right">&nbsp;</td>
	    <td style="text-align: right">&nbsp;</td>
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