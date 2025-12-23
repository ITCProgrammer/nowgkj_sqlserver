<!-- Main content -->
      <div class="container-fluid">		  
		<div class="row">
			<div class="col-md-4">	
		<div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Detail Data Shift 1 Per Hari</h3>				 
          </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-sm table-bordered table-striped" style="font-size: 14px; text-align: center;">
                  <thead>
                  <tr>
                    <th valign="middle" style="text-align: center">No</th>
                    <th valign="middle" style="text-align: center">Detail</th>
                    <th valign="middle" style="text-align: center">Tipe</th>
                    <th valign="middle" style="text-align: center">Tgl Tutup</th>
                    <th valign="middle" style="text-align: center">Rol</th>
                    <th valign="middle" style="text-align: center">KG</th>
                    </tr>
                  </thead>
                  <tbody>
<?php					  
$no=1;   
$c=0;				  
$sql = mysqli_query($con," SELECT tipe, tgl_tutup,sum(weight) as kg,sum(rol) as rol,DATE_FORMAT(now(),'%Y-%m-%d') as tgl FROM tbl_opname_shift WHERE shift='1' GROUP BY tgl_tutup,tipe ORDER BY tgl_tutup DESC LIMIT 60");		  
    while($r = mysqli_fetch_array($sql)){
		
?>
	  <tr>
	  <td style="text-align: center"><?php echo $no;?></td>
	  <td style="text-align: center"><div class="btn-group"><a href="DetailOpnameShift1-<?php echo $r['tipe'];?>-<?php echo $r['tgl_tutup'];?>" class="btn btn-info btn-xs" target="_blank"> <i class="fa fa-link"></i> Lihat Data</a><a href="pages/cetak/DetailOpnameShift1Excel.php?tgl=<?php echo $r['tgl_tutup'];?>&tipe=<?php echo $r['tipe'];?>" class="btn btn-success btn-xs" target="_blank"> <i class="fa fa-file"></i> Cetak Ke Excel</a></div></td>
	  <td style="text-align: center"><?php echo $r['tipe'];?></td>
	  <td style="text-align: center"><?php echo $r['tgl_tutup'];?></td>
      <td style="text-align: center"><?php echo $r['rol'];?></td>
      <td style="text-align: right"><?php echo number_format(round($r['kg'],2),2);?></td>
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
			</div>
			<div class="col-md-4">
		<div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Detail Data Shift 2 Per Hari</h3>				 
          </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example3" class="table table-sm table-bordered table-striped" style="font-size: 14px; text-align: center;">
                  <thead>
                  <tr>
                    <th valign="middle" style="text-align: center">No</th>
                    <th valign="middle" style="text-align: center">Detail</th>
                    <th valign="middle" style="text-align: center">Tipe</th>
                    <th valign="middle" style="text-align: center">Tgl Tutup</th>
                    <th valign="middle" style="text-align: center">Rol</th>
                    <th valign="middle" style="text-align: center">KG</th>
                    </tr>
                  </thead>
                  <tbody>
<?php	 
$no=1;   
$c=0;				  
$sql = mysqli_query($con," SELECT tipe, tgl_tutup,sum(weight) as kg,sum(rol) as rol,DATE_FORMAT(now(),'%Y-%m-%d') as tgl FROM tbl_opname_shift WHERE shift='2' GROUP BY tgl_tutup,tipe ORDER BY tgl_tutup DESC LIMIT 60
");		  
    while($r = mysqli_fetch_array($sql)){
		
?>
	  <tr>
	  <td style="text-align: center"><?php echo $no;?></td>
	  <td style="text-align: center"><div class="btn-group"><a href="DetailOpnameShift2-<?php echo $r['tipe'];?>-<?php echo $r['tgl_tutup'];?>" class="btn btn-info btn-xs" target="_blank"> <i class="fa fa-link"></i> Lihat Data</a><a href="pages/cetak/DetailOpnameShift2Excel.php?tgl=<?php echo $r['tgl_tutup'];?>&tipe=<?php echo $r['tipe'];?>" class="btn btn-success btn-xs" target="_blank"> <i class="fa fa-file"></i> Cetak Ke Excel</a></div></td>
	  <td style="text-align: center"><?php echo $r['tipe'];?></td>
	  <td style="text-align: center"><?php echo $r['tgl_tutup'];?></td>
      <td style="text-align: center"><?php echo $r['rol'];?></td>
      <td style="text-align: right"><?php echo number_format(round($r['kg'],2),2);?></td>
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
			</div>	
			<div class="col-md-4">
		<div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Detail Data Shift 3 Per Hari</h3>				 
          </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example11" class="table table-sm table-bordered table-striped" style="font-size: 14px; text-align: center;">
                  <thead>
                  <tr>
                    <th valign="middle" style="text-align: center">No</th>
                    <th valign="middle" style="text-align: center">Detail</th>
                    <th valign="middle" style="text-align: center">Tipe</th>
                    <th valign="middle" style="text-align: center">Tgl Tutup</th>
                    <th valign="middle" style="text-align: center">Rol</th>
                    <th valign="middle" style="text-align: center">KG</th>
                    </tr>
                  </thead>
                  <tbody>
<?php	 
$no=1;   
$c=0;				  
$sql = mysqli_query($con," SELECT tipe, tgl_tutup,sum(weight) as kg,sum(rol) as rol,DATE_FORMAT(now(),'%Y-%m-%d') as tgl FROM tbl_opname_shift WHERE shift='3' GROUP BY tgl_tutup,tipe ORDER BY tgl_tutup DESC LIMIT 60
");		  
    while($r = mysqli_fetch_array($sql)){
		
?>
	  <tr>
	  <td style="text-align: center"><?php echo $no;?></td>
	  <td style="text-align: center"><div class="btn-group"><a href="DetailOpnameShift3-<?php echo $r['tipe'];?>-<?php echo $r['tgl_tutup'];?>" class="btn btn-info btn-xs" target="_blank"> <i class="fa fa-link"></i> Lihat Data</a><a href="pages/cetak/DetailOpnameShift3Excel.php?tgl=<?php echo $r['tgl_tutup'];?>&tipe=<?php echo $r['tipe'];?>" class="btn btn-success btn-xs" target="_blank"> <i class="fa fa-file"></i> Cetak Ke Excel</a></div></td>
	  <td style="text-align: center"><?php echo $r['tipe'];?></td>
	  <td style="text-align: center"><?php echo $r['tgl_tutup'];?></td>
      <td style="text-align: center"><?php echo $r['rol'];?></td>
      <td style="text-align: right"><?php echo number_format(round($r['kg'],2),2);?></td>
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
			</div>
		  </div>		
      </div><!-- /.container-fluid -->
    <!-- /.content -->
<div class="modal fade" id="delInHarian" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content" style="margin-top:100px;">
                  <div class="modal-header">
					<h4 class="modal-title">INFOMATION IN</h4>  
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    
                  </div>
					<div class="modal-body">
						<h5 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h5>
					</div>	
                  <div class="modal-footer justify-content-between">
                    <a href="#" class="btn btn-danger" id="delete_In">Delete</a>
                    <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                  </div>
                </div>
              </div>
            </div>
<div class="modal fade" id="delOutHarian" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content" style="margin-top:100px;">
                  <div class="modal-header">
					<h4 class="modal-title">INFOMATION OUT</h4> 
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    
                  </div>
					<div class="modal-body">
						<h5 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h5>
					</div>	
                  <div class="modal-footer justify-content-between">
                    <a href="#" class="btn btn-danger" id="delete_Out">Delete</a>
                    <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                  </div>
                </div>
              </div>
            </div>
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
<script type="text/javascript">
              function confirm_deleteIn(delete_url) {
                $('#delInHarian').modal('show', {
                  backdrop: 'static'
                });
                document.getElementById('delete_In').setAttribute('href', delete_url);
              }
			  function confirm_deleteOut(delete_url) {
                $('#delOutHarian').modal('show', {
                  backdrop: 'static'
                });
                document.getElementById('delete_Out').setAttribute('href', delete_url);
              }
</script>
<?php	
if(isset($_POST['submit'])){

$cektgl=mysqli_query($con,"SELECT DATE_FORMAT(NOW(),'%Y-%m-%d') as tgl,COUNT(tgl_tutup) as ck ,DATE_FORMAT(NOW(),'%H') as jam,DATE_FORMAT(NOW(),'%H:%i') as jam1 FROM tblmasukkain WHERE tgl_tutup='".$Awal."' LIMIT 1");
$dcek=mysqli_fetch_array($cektgl);
$t1=strtotime($Awal);
$t2=strtotime($dcek['tgl']);
$selh=round(abs($t2-$t1)/(60*60*45));

if($dcek['ck']>0){	
		echo "<script>
  	$(function() {
    toastr.error('Stok Tgl ".$Awal." Ini Sudah Pernah ditutup')
  });
  
</script>";
	/*}else if($Awal == $dcek['tgl']){
		echo "<script>
  	$(function() {
    toastr.error('Tanggal Harus Sebelumnya')
  });
  
</script>";*/
	}else if($Awal > $dcek['tgl']){
		echo "<script>
  	$(function() {
    toastr.error('Tanggal Lebih dari $selh hari')
  });
  
</script>";
		
	}else if($dcek['jam'] < 0){		
		echo "<script>
  		$(function() {
    		toastr.error('Tidak Bisa Tutup Sebelum jam 10 Malam Sampai jam 12 Malam, Sekarang Masih Jam ".$dcek['jam1']."')
  		});  
  		</script>";
			}
			else{	
/*Masuk Kain Jadi*/
$sqlDB2M = " SELECT TRANSACTIONDATE,ITEMTYPECODE,DECOSUBCODE01,
DECOSUBCODE02,DECOSUBCODE03,DECOSUBCODE04,DECOSUBCODE05,
DECOSUBCODE06,DECOSUBCODE07,DECOSUBCODE08, COUNT(BASEPRIMARYQUANTITY) AS ROL,
SUM(BASEPRIMARYQUANTITY) AS KGS,LOTCODE,PROJECTCODE,
LISTAGG(DISTINCT  TRIM(WHSLOCATIONWAREHOUSEZONECODE),',') AS ZN,
LISTAGG(DISTINCT TRIM(WAREHOUSELOCATIONCODE),',') AS LK,QUALITYREASONCODE FROM STOCKTRANSACTION 
WHERE CONCAT(TRIM(TRANSACTIONDATE),CONCAT(' ',TRIM(TRANSACTIONTIME))) BETWEEN '$ysrdy' AND '$tody' AND 
TEMPLATECODE ='304' AND 
(ITEMTYPECODE='FKF' OR ITEMTYPECODE='KFF') AND 
LOGICALWAREHOUSECODE ='M031' AND NOT WAREHOUSELOCATIONCODE='DOK' AND
NOT WAREHOUSELOCATIONCODE LIKE 'BBS%' AND 
NOT WAREHOUSELOCATIONCODE LIKE 'ZER%' AND LOTCODE LIKE '00%' 
GROUP BY LOTCODE,TRANSACTIONDATE,ITEMTYPECODE,DECOSUBCODE01,
DECOSUBCODE02,DECOSUBCODE03,DECOSUBCODE04,DECOSUBCODE05,
DECOSUBCODE06,DECOSUBCODE07,DECOSUBCODE08,PROJECTCODE,
WHSLOCATIONWAREHOUSEZONECODE,WAREHOUSELOCATIONCODE,QUALITYREASONCODE ";
	$stmtM   = db2_exec($conn1,$sqlDB2M, array('cursor'=>DB2_SCROLLABLE));
	//}				  
    while($rowdb2M = db2_fetch_assoc($stmtM)){	
	$sqlDB23M = " SELECT s.EXTERNALREFERENCE AS PO_HEADER ,s2.EXTERNALREFERENCE AS PO_LINE,i.PROJECTCODE FROM ITXVIEWKK i 
LEFT OUTER JOIN SALESORDER s ON i.PROJECTCODE =s.CODE 
LEFT OUTER JOIN SALESORDERLINE s2 ON i.PROJECTCODE =s2.SALESORDERCODE AND i.ORDERLINE =s2.ORDERLINE  
WHERE i.PRODUCTIONORDERCODE ='$rowdb2M[LOTCODE]' ";
	$stmt3M   = db2_exec($conn1,$sqlDB23M, array('cursor'=>DB2_SCROLLABLE));
	$rowdb23M = db2_fetch_assoc($stmt3M);		
		if($rowdb2M['PROJECTCODE']!=""){$PJCODEM=$rowdb2M['PROJECTCODE'];}else{ $PJCODEM= $rowdb2M['PROJECTCODE'];}
	$sqlDB22M = " SELECT SALESORDER.CODE, SALESORDER.EXTERNALREFERENCE, SALESORDER.ORDPRNCUSTOMERSUPPLIERCODE,
		ITXVIEWAKJ.LEGALNAME1, ITXVIEWAKJ.ORDERPARTNERBRANDCODE, ITXVIEWAKJ.LONGDESCRIPTION
		FROM DB2ADMIN.SALESORDER SALESORDER LEFT OUTER JOIN DB2ADMIN.ITXVIEWAKJ 
       	ITXVIEWAKJ ON SALESORDER.CODE=ITXVIEWAKJ.CODE
		WHERE SALESORDER.CODE='$PJCODEM' ";
		
	$stmt2M   = db2_exec($conn1,$sqlDB22M, array('cursor'=>DB2_SCROLLABLE));
	$rowdb22M = db2_fetch_assoc($stmt2M);	
	if($rowdb22M['LEGALNAME1']==""){$langgananM="";}else{$langgananM=$rowdb22M['LEGALNAME1'];}
	if($rowdb22M['ORDERPARTNERBRANDCODE']==""){$buyerM="";}else{$buyerM=$rowdb22M['LONGDESCRIPTION'];}
		
	$sqlDB24M = " SELECT PRODUCT.SHORTDESCRIPTION FROM PRODUCT WHERE
		ITEMTYPECODE='$rowdb2M[ITEMTYPECODE]' AND
		SUBCODE01='$rowdb2M[DECOSUBCODE01]' AND
		SUBCODE02='$rowdb2M[DECOSUBCODE02]' AND
		SUBCODE03='$rowdb2M[DECOSUBCODE03]' AND
		SUBCODE04='$rowdb2M[DECOSUBCODE04]' AND
		SUBCODE05='$rowdb2M[DECOSUBCODE05]' 
		";
	$stmt4M   = db2_exec($conn1,$sqlDB24M, array('cursor'=>DB2_SCROLLABLE));
	$rowdb24M = db2_fetch_assoc($stmt4M);			
		
	$sqlDB25M = " SELECT ITXVIEWRESEPCOLOR.LONGDESCRIPTION FROM ITXVIEWRESEPCOLOR WHERE
		ITXVIEWRESEPCOLOR.NO_WARNA='$rowdb2M[DECOSUBCODE05]' AND
		ITXVIEWRESEPCOLOR.ARTIKEL='$rowdb2M[DECOSUBCODE03]' ";
	$stmt5M   = db2_exec($conn1,$sqlDB25M, array('cursor'=>DB2_SCROLLABLE));
	$rowdb25M = db2_fetch_assoc($stmt5M);	
		
	$sqlDB26M = " SELECT DESIGN.SUBCODE01,
	   DESIGNCOMPONENT.VARIANTCODE,
       DESIGNCOMPONENT.SHORTDESCRIPTION 
	   FROM DB2ADMIN.DESIGN DESIGN LEFT OUTER JOIN DB2ADMIN.DESIGNCOMPONENT 
       DESIGNCOMPONENT ON DESIGN.NUMBERID=DESIGNCOMPONENT.DESIGNNUMBERID AND 
       DESIGN.SUBCODE01=DESIGNCOMPONENT.DESIGNSUBCODE01 
	   WHERE DESIGN.SUBCODE01='$rowdb2M[DECOSUBCODE07]' AND
	   DESIGNCOMPONENT.VARIANTCODE='$rowdb2M[DECOSUBCODE08]' ";
	$stmt6M   = db2_exec($conn1,$sqlDB26M, array('cursor'=>DB2_SCROLLABLE));
	$rowdb26M = db2_fetch_assoc($stmt6M);
		if(trim($rowdb2M['ITEMTYPECODE'])=="FKF"){
			$posM=strpos($rowdb24M['SHORTDESCRIPTION'],"-");
			$warnaM=substr($rowdb24M['SHORTDESCRIPTION'],0,$posM);
		}
		else if(trim($rowdb2M['DECOSUBCODE07'])=="-" and trim($rowdb2M['DECOSUBCODE08'])=="-"){
			$warnaM=$rowdb25M['LONGDESCRIPTION'];
		}else if(trim($rowdb2M['DECOSUBCODE07'])!="-" and trim($rowdb2M['DECOSUBCODE08'])!="-"){
			$warnaM=$rowdb26M['SHORTDESCRIPTION'];
		}
		$sqlDB27M = " SELECT PRODUCT.SHORTDESCRIPTION FROM PRODUCT WHERE
		ITEMTYPECODE='$rowdb2M[ITEMTYPECODE]' AND
		SUBCODE01='$rowdb2M[DECOSUBCODE01]' AND
		SUBCODE02='$rowdb2M[DECOSUBCODE02]' AND
		SUBCODE03='$rowdb2M[DECOSUBCODE03]' AND
		SUBCODE04='$rowdb2M[DECOSUBCODE04]' AND
		SUBCODE05='$rowdb2M[DECOSUBCODE05]' AND
		SUBCODE06='$rowdb2M[DECOSUBCODE06]' AND
		SUBCODE07='$rowdb2M[DECOSUBCODE07]' AND
		SUBCODE08='$rowdb2M[DECOSUBCODE08]' 
		";
	$stmt7M   = db2_exec($conn1,$sqlDB27M, array('cursor'=>DB2_SCROLLABLE));
	$rowdb27M = db2_fetch_assoc($stmt7M);
	$sqlDB28M = " SELECT ORDERITEMORDERPARTNERLINK.ORDPRNCUSTOMERSUPPLIERCODE,
       ORDERITEMORDERPARTNERLINK.LONGDESCRIPTION 
	   FROM DB2ADMIN.ORDERITEMORDERPARTNERLINK ORDERITEMORDERPARTNERLINK WHERE
       ORDERITEMORDERPARTNERLINK.ITEMTYPEAFICODE='$rowdb2M[ITEMTYPECODE]' AND
	   ORDERITEMORDERPARTNERLINK.ORDPRNCUSTOMERSUPPLIERCODE='$rowdb22M[ORDPRNCUSTOMERSUPPLIERCODE]' AND
	   ORDERITEMORDERPARTNERLINK.SUBCODE01='$rowdb2M[DECOSUBCODE01]' AND
       ORDERITEMORDERPARTNERLINK.SUBCODE02='$rowdb2M[DECOSUBCODE02]' AND
       ORDERITEMORDERPARTNERLINK.SUBCODE03='$rowdb2M[DECOSUBCODE03]' AND
	   ORDERITEMORDERPARTNERLINK.SUBCODE04='$rowdb2M[DECOSUBCODE04]' AND
       ORDERITEMORDERPARTNERLINK.SUBCODE05='$rowdb2M[DECOSUBCODE05]' AND
	   ORDERITEMORDERPARTNERLINK.SUBCODE06='$rowdb2M[DECOSUBCODE06]' AND
       ORDERITEMORDERPARTNERLINK.SUBCODE07='$rowdb2M[DECOSUBCODE07]' AND
	   ORDERITEMORDERPARTNERLINK.SUBCODE08='$rowdb2M[DECOSUBCODE08]'";
	$stmt8M   = db2_exec($conn1,$sqlDB28M, array('cursor'=>DB2_SCROLLABLE));
	$rowdb28M = db2_fetch_assoc($stmt8M);	
	if($rowdb28M['LONGDESCRIPTION']!=""){
		$itemM=$rowdb25M['LONGDESCRIPTION'];
	}else{
		$itemM=trim($rowdb2M['DECOSUBCODE02'])."".trim($rowdb2M['DECOSUBCODE03']);
	}
	$sqlDB29M = " SELECT ADSTORAGE.NAMENAME,ADSTORAGE.VALUEDECIMAL 
	   FROM DB2ADMIN.ADSTORAGE ADSTORAGE RIGHT OUTER JOIN DB2ADMIN.PRODUCT PRODUCT 
       ON ADSTORAGE.UNIQUEID=PRODUCT.ABSUNIQUEID WHERE
       PRODUCT.ITEMTYPECODE='$rowdb2M[ITEMTYPECODE]' AND	
	   PRODUCT.SUBCODE01='$rowdb2M[DECOSUBCODE01]' AND
       PRODUCT.SUBCODE02='$rowdb2M[DECOSUBCODE02]' AND
       PRODUCT.SUBCODE03='$rowdb2M[DECOSUBCODE03]' AND
	   PRODUCT.SUBCODE04='$rowdb2M[DECOSUBCODE04]' AND
       PRODUCT.SUBCODE05='$rowdb2M[DECOSUBCODE05]' AND
	   PRODUCT.SUBCODE06='$rowdb2M[DECOSUBCODE06]' AND
       PRODUCT.SUBCODE07='$rowdb2M[DECOSUBCODE07]' AND
	   PRODUCT.SUBCODE08='$rowdb2M[DECOSUBCODE08]' AND 
	   ADSTORAGE.NAMENAME='Width' ";
	$stmt9M   = db2_exec($conn1,$sqlDB29M, array('cursor'=>DB2_SCROLLABLE));
	$rowdb29M = db2_fetch_assoc($stmt9M);
	$sqlDB30M = " SELECT ADSTORAGE.NAMENAME,ADSTORAGE.VALUEDECIMAL 
	   FROM DB2ADMIN.ADSTORAGE ADSTORAGE RIGHT OUTER JOIN DB2ADMIN.PRODUCT PRODUCT 
       ON ADSTORAGE.UNIQUEID=PRODUCT.ABSUNIQUEID WHERE
       PRODUCT.ITEMTYPECODE='$rowdb2M[ITEMTYPECODE]' AND	
	   PRODUCT.SUBCODE01='$rowdb2M[DECOSUBCODE01]' AND
       PRODUCT.SUBCODE02='$rowdb2M[DECOSUBCODE02]' AND
       PRODUCT.SUBCODE03='$rowdb2M[DECOSUBCODE03]' AND
	   PRODUCT.SUBCODE04='$rowdb2M[DECOSUBCODE04]' AND
       PRODUCT.SUBCODE05='$rowdb2M[DECOSUBCODE05]' AND
	   PRODUCT.SUBCODE06='$rowdb2M[DECOSUBCODE06]' AND
       PRODUCT.SUBCODE07='$rowdb2M[DECOSUBCODE07]' AND
	   PRODUCT.SUBCODE08='$rowdb2M[DECOSUBCODE08]' AND 
	   ADSTORAGE.NAMENAME='GSM' ";
	$stmt10M   = db2_exec($conn1,$sqlDB30M, array('cursor'=>DB2_SCROLLABLE));
	$rowdb30M = db2_fetch_assoc($stmt10M);
	if($rowdb2M['ITEMTYPECODE']=="KFF"){$tipeM="KAIN"; }else{$tipeM="KRAH";}
	if($rowdb23M['PO_HEADER']!=""){$nopoM=$rowdb23M['PO_HEADER'];}else{$nopoM=$rowdb23M['PO_LINE'];}
		
$simpanM=mysqli_query($con,"INSERT INTO `tblmasukkain` SET 
tgl_masuk	= '".substr($rowdb2M['TRANSACTIONDATE'],0,10)."',
qty			= '".$rowdb2M['ROL']."',
berat		= '".round($rowdb2M['KGS'],2)."',
tipe		= '".$tipeM."',
itemno		= '".$itemM."',
nowarna		= '".$rowdb2M['DECOSUBCODE05']."',
warna 		= '".str_replace("'","''",$warnaM)."',
buyer		= '".str_replace("'","''",$buyerM)."',
customer	= '".str_replace("'","''",$langgananM)."',
nopo		= '".str_replace("'","''",$nopoM)."',
no_order	= '".str_replace("'","''",$PJCODEM)."',
jenis_kain	= '".str_replace("'","''",$rowdb27M['SHORTDESCRIPTION'])."',
lebar		= '".round($rowdb29M['VALUEDECIMAL'])."',
gramasi		= '".round($rowdb30M['VALUEDECIMAL'])."',
lot			= '".$rowdb2M['LOTCODE']."',
lokasi		= '".$rowdb2M['LK']."',
foc			= '".$focM."',
tgl_tutup 	= '".$Awal."',
jns_trans	= 'packing',
tgl_buat 	= now()") or die("GAGAL SIMPAN MASUK KAIN");		
}
/*End Masuk Kain Jadi*/		

//Pengiriman Kain				
$sqlDB21PK = " SELECT
	SUM(BASEPRIMARYQUANTITY) AS KG,
	ORDERCODE AS NOSJ,
	ORDERLINE,
	PROJECTCODE,
	LOTCODE,
	DECOSUBCODE01,
	DECOSUBCODE02,
	DECOSUBCODE03,
	DECOSUBCODE04,
	DECOSUBCODE05,
	DECOSUBCODE06,
	DECOSUBCODE07,
	DECOSUBCODE08,
	DECOSUBCODE09,
	DECOSUBCODE10,
	DERIVATIONCODE, 
	CONCAT(TRANSACTIONDATE, CONCAT(' ', TRANSACTIONTIME)) AS TGL
FROM
	STOCKTRANSACTION
WHERE
	TEMPLATECODE = 'S02'
	AND CONCAT(TRANSACTIONDATE, CONCAT(' ', TRANSACTIONTIME)) BETWEEN '$ysrdy' AND '$tody'
	AND ITEMTYPECODE = 'KFF'
	AND LOGICALWAREHOUSECODE = 'M031'
GROUP BY 
	ORDERCODE,
	ORDERLINE,
	PROJECTCODE,
	LOTCODE,
	DECOSUBCODE01,
	DECOSUBCODE02,
	DECOSUBCODE03,
	DECOSUBCODE04,
	DECOSUBCODE05,
	DECOSUBCODE06,
	DECOSUBCODE07,
	DECOSUBCODE08,
	DECOSUBCODE09,
	DECOSUBCODE10,
	DERIVATIONCODE, 
	TRANSACTIONDATE,
	TRANSACTIONTIME";
          $stmt1PK   = db2_exec($conn1, $sqlDB21PK, array('cursor' => DB2_SCROLLABLE));			  
          while ($rowdb21PK = db2_fetch_assoc($stmt1PK)) {
            if ($rowdb21PK['PROJECTCODE'] != "") {
              $projectPK = $rowdb21PK['PROJECTCODE'];
            } else {
              $projectPK = $rowdb21PK['DLVSALORDERLINESALESORDERCODE'];
            }
            if ($rowdb21PK['PAYMENTMETHODCODE'] == "FOC") {
              $focPK = $rowdb21PK['PAYMENTMETHODCODE'];;
            } else {
              $focPK = "";
            }
            $sqlDB22PK = "SELECT SALESORDERLINE.ORDERLINE, SALESORDERLINE.EXTERNALREFERENCE AS NOPO, SALESORDER.CODE, SALESORDER.EXTERNALREFERENCE, SALESORDER.ORDPRNCUSTOMERSUPPLIERCODE,
		ITXVIEWAKJ.LEGALNAME1, ITXVIEWAKJ.ORDERPARTNERBRANDCODE, ITXVIEWAKJ.LONGDESCRIPTION
		FROM DB2ADMIN.SALESORDER SALESORDER LEFT OUTER JOIN DB2ADMIN.ITXVIEWAKJ 
       	ITXVIEWAKJ ON SALESORDER.CODE=ITXVIEWAKJ.CODE
       	LEFT OUTER JOIN DB2ADMIN.SALESORDERLINE ON SALESORDER.CODE=SALESORDERLINE.SALESORDERCODE  
		WHERE SALESORDER.CODE='$projectPK' AND SALESORDERLINE.ORDERLINE='" . $rowdb21PK['ORDERLINE'] . "'";
            $stmt2PK   = db2_exec($conn1, $sqlDB22PK, array('cursor' => DB2_SCROLLABLE));
            $rowdb22PK = db2_fetch_assoc($stmt2PK);
            if ($rowdb22PK['LEGALNAME1'] == "") {
              $langgananPK = "";
            } else {
              $langgananPK = $rowdb22PK['LEGALNAME1'];
            }
            if ($rowdb22PK['ORDERPARTNERBRANDCODE'] == "") {
              $buyerPK = "";
            } else {
              $buyerPK = $rowdb22PK['LONGDESCRIPTION'];
            }
            if ($rowdb22PK['EXTERNALREFERENCE'] != "") {
              $PONOPK = $rowdb22PK['EXTERNALREFERENCE'];
            } else {
              $PONOPK = $rowdb22PK['NOPO'];
            }

            $sqlDB23PK = " SELECT COUNT(BASEPRIMARYQUANTITY) AS ROL,SUM(BASEPRIMARYQUANTITY) AS KG,
	LISTAGG(DISTINCT  TRIM(LOTCODE),', ') AS LOTCODE,LISTAGG(DISTINCT  TRIM(WHSLOCATIONWAREHOUSEZONECODE),', ') AS ZN, LISTAGG(DISTINCT TRIM(WAREHOUSELOCATIONCODE),', ') AS LK,
	ITEMTYPECODE, DECOSUBCODE01, DECOSUBCODE02, DECOSUBCODE03, DECOSUBCODE04, DECOSUBCODE05, DECOSUBCODE06, DECOSUBCODE07, DECOSUBCODE08
	FROM ITXVIEW_ALLOCATION_SURATJALAN_PPC 
		 WHERE ITXVIEW_ALLOCATION_SURATJALAN_PPC.CODE='".$rowdb21PK['DERIVATIONCODE']."' 
	GROUP BY ITEMTYPECODE, DECOSUBCODE01, DECOSUBCODE02, DECOSUBCODE03, DECOSUBCODE04, DECOSUBCODE05, DECOSUBCODE06, DECOSUBCODE07, DECOSUBCODE08";
            $stmt3PK   = db2_exec($conn1, $sqlDB23PK, array('cursor' => DB2_SCROLLABLE));
            $rowdb23PK = db2_fetch_assoc($stmt3PK);
            $itemCodePK = $rowdb23PK['ITEMTYPECODE'] . " " . $rowdb23PK['DECOSUBCODE01'] . "" . $rowdb23PK['DECOSUBCODE02'] . "" . $rowdb23PK['DECOSUBCODE03'] . "" . $rowdb23PK['DECOSUBCODE04'] . "" . $rowdb23PK['DECOSUBCODE05'] . "" . $rowdb23PK['DECOSUBCODE06'] . "" . $rowdb23PK['DECOSUBCODE07'] . "" . $rowdb23PK['DECOSUBCODE08'];
            $sqlDB24PK = " SELECT PRODUCT.SHORTDESCRIPTION FROM PRODUCT WHERE
		ITEMTYPECODE='$rowdb23PK[ITEMTYPECODE]' AND
		SUBCODE01='$rowdb23PK[DECOSUBCODE01]' AND
		SUBCODE02='$rowdb23PK[DECOSUBCODE02]' AND
		SUBCODE03='$rowdb23PK[DECOSUBCODE03]' AND
		SUBCODE04='$rowdb23PK[DECOSUBCODE04]' AND
		SUBCODE05='$rowdb23PK[DECOSUBCODE05]' 
		";
            $stmt4PK   = db2_exec($conn1, $sqlDB24PK, array('cursor' => DB2_SCROLLABLE));
            $rowdb24PK = db2_fetch_assoc($stmt4PK);
			  
            $sqlDB25PK = "SELECT i.WARNA FROM ITXVIEWCOLOR i
LEFT OUTER JOIN PRODUCT p ON
i.ITEMTYPECODE =p.ITEMTYPECODE AND 
i.SUBCODE01 = p.SUBCODE01 AND
i.SUBCODE02 = p.SUBCODE02 AND
i.SUBCODE03 = p.SUBCODE03 AND
i.SUBCODE04 = p.SUBCODE04 AND
i.SUBCODE05 = p.SUBCODE05 AND
i.SUBCODE06 = p.SUBCODE06 AND
i.SUBCODE07 = p.SUBCODE07 AND
i.SUBCODE08 = p.SUBCODE08
WHERE 
		i.SUBCODE01='" . trim($rowdb23PK['DECOSUBCODE01']) . "' AND
		i.SUBCODE02='" . trim($rowdb23PK['DECOSUBCODE02']) . "' AND
		i.SUBCODE03='" . trim($rowdb23PK['DECOSUBCODE03']) . "' AND
		i.SUBCODE04='" . trim($rowdb23PK['DECOSUBCODE04']) . "' AND
		i.SUBCODE05='" . trim($rowdb23PK['DECOSUBCODE05']) . "' AND
		i.SUBCODE06='" . trim($rowdb23PK['DECOSUBCODE06']) . "' AND
		i.SUBCODE07='" . trim($rowdb23PK['DECOSUBCODE07']) . "' AND
		i.SUBCODE08 ='" . trim($rowdb23PK['DECOSUBCODE08']) . "'";
            $stmt5PK   = db2_exec($conn1, $sqlDB25PK, array('cursor' => DB2_SCROLLABLE));
            $rowdb25PK = db2_fetch_assoc($stmt5PK);

            $sqlDB26PK = " SELECT DESIGN.SUBCODE01,
	   DESIGNCOMPONENT.VARIANTCODE,
       DESIGNCOMPONENT.SHORTDESCRIPTION 
	   FROM DB2ADMIN.DESIGN DESIGN LEFT OUTER JOIN DB2ADMIN.DESIGNCOMPONENT 
       DESIGNCOMPONENT ON DESIGN.NUMBERID=DESIGNCOMPONENT.DESIGNNUMBERID AND 
       DESIGN.SUBCODE01=DESIGNCOMPONENT.DESIGNSUBCODE01 
	   WHERE DESIGN.SUBCODE01='$rowdb23PK[DECOSUBCODE07]' AND
	   DESIGNCOMPONENT.VARIANTCODE='$rowdb23PK[DECOSUBCODE08]' ";
            $stmt6PK   = db2_exec($conn1, $sqlDB26PK, array('cursor' => DB2_SCROLLABLE));
            $rowdb26PK = db2_fetch_assoc($stmt6PK);
            if (trim($rowdb23PK['ITEMTYPECODE']) == "FKF") {
              $posPK = strpos($rowdb24PK['SHORTDESCRIPTION'], "-");
              $warnaPK = substr($rowdb24PK['SHORTDESCRIPTION'], 0, $posPK);
            } else if (trim($rowdb23PK['DECOSUBCODE07']) == "-" and trim($rowdb23PK['DECOSUBCODE08']) == "-") {
              $warnaPK = $rowdb25PK['WARNA'];
            } else if (trim($rowdb23PK['DECOSUBCODE07']) != "-" and trim($rowdb23PK['DECOSUBCODE08']) != "-") {
              $warnaPK = $rowdb26PK['SHORTDESCRIPTION'];
            }	
			  
$simpanK=mysqli_query($con,"INSERT INTO `tblkeluarkain` SET 
tgl_keluar 	= '".substr($rowdb21PK['TGL'], 0, 10)."',
qty 		= '".$rowdb23PK['ROL']."',
berat 		= '".round($rowdb23PK['KG'], 2)."',
tipe 		= '".$tipe."',
no_sj 		= '".$rowdb21PK['NOSJ']."',
warna 		= '".str_replace("'","''",$warnaPK)."',
buyer 		= '".str_replace("'","''",$buyerPK)."',
customer 	= '".str_replace("'","''",$langgananPK)."',
no_po 		= '".str_replace("'","''",$PONOPK)."',
no_order 	= '".str_replace("'","''",$projectPK)."',
jenis_kain 	= '".str_replace("'","''",$rowdb21PK['ITEMDESCRIPTION'])."',
lot 		= '".$rowdb23PK['LOTCODE']."',
foc 		= '".$focPK."',
tgl_tutup 	= '".$Awal."',
jns_trans	= 'pengiriman',
tgl_buat 	= now()") or die("GAGAL SIMPAN TRANSAKSI KELUAR");			  
			  
}
	//Bongkaran
$sqlDB21B = " SELECT 
s.CREATIONUSER, s.TRANSACTIONDATE, s.ORDERCODE, s.DECOSUBCODE02, s.DECOSUBCODE03, s.DECOSUBCODE04, s.DECOSUBCODE05, s.DECOSUBCODE06, s.DECOSUBCODE07, s.DECOSUBCODE08, 
s.LOTCODE, SUM(s.BASEPRIMARYQUANTITY) AS KG, s.ITEMELEMENTCODE, COUNT(s.ITEMELEMENTCODE) AS JML, s.PROJECTCODE  
FROM STOCKTRANSACTION s
WHERE s.ITEMTYPECODE='KFF' AND s.LOGICALWAREHOUSECODE ='M031' AND
s.TEMPLATECODE = '120' AND CONCAT(s.TRANSACTIONDATE, CONCAT(' ', s.TRANSACTIONTIME)) BETWEEN '$ysrdy' AND '$tody' 
GROUP BY s.TRANSACTIONDATE, s.ORDERCODE, s.DECOSUBCODE02, s.DECOSUBCODE03, s.DECOSUBCODE04, s.DECOSUBCODE05, s.DECOSUBCODE06, s.DECOSUBCODE07, s.DECOSUBCODE08, 
s.LOTCODE,s.CREATIONUSER, s.PROJECTCODE, s.ITEMELEMENTCODE ";
	$stmt1B   = db2_exec($conn1,$sqlDB21B, array('cursor'=>DB2_SCROLLABLE));
	//}				  
    while($rowdb21B = db2_fetch_assoc($stmt1B)){ 
	$kdbenangB=trim($rowdb21B['DECOSUBCODE01'])." ".trim($rowdb21B['DECOSUBCODE02'])." ".trim($rowdb21B['DECOSUBCODE03'])." ".trim($rowdb21B['DECOSUBCODE04'])." ".trim($rowdb21B['DECOSUBCODE05'])." ".trim($rowdb21B['DECOSUBCODE06'])." ".trim($rowdb21B['DECOSUBCODE07'])." ".trim($rowdb21B['DECOSUBCODE08']);

$simpanB=mysqli_query($con,"INSERT INTO `tblkeluarkain` SET 
tgl_keluar 	= '".substr($rowdb21B['TRANSACTIONDATE'], 0, 10)."',
qty 		= '".$rowdb21B['JML']."',
berat 		= '".round($rowdb21B['KG'], 2)."',
tipe 		= '".$tipeB."',
no_order 	= '".$rowdb21B['PROJECTCODE']."',
lot 		= '".$rowdb21B['LOTCODE']."',
element 	= '".$rowdb21B['ITEMELEMENTCODE']."',
tgl_tutup 	= '".$Awal."',
jns_trans	= 'bongkaran',
tgl_buat 	= now()") or die("GAGAL SIMPAN TRANSAKSI KELUAR BONGKARAN");		
}
//Potong Sample
$sqlDB21PS = " SELECT 
s.CREATIONUSER, s.TRANSACTIONDATE, s.DECOSUBCODE02, s.DECOSUBCODE03, s.DECOSUBCODE04, s.DECOSUBCODE05, s.DECOSUBCODE06, s.DECOSUBCODE07, s.DECOSUBCODE08, 
s.LOTCODE, SUM(s.BASEPRIMARYQUANTITY) AS KG, SUM(s.BASESECONDARYQUANTITY) AS YARD, s.ITEMELEMENTCODE, COUNT(s.ITEMELEMENTCODE) AS JML, a.VALUESTRING AS PTG, a1.VALUESTRING as NOTE, s.PROJECTCODE  
FROM STOCKTRANSACTION s
LEFT OUTER JOIN ADSTORAGE a ON a.UNIQUEID = s.ABSUNIQUEID AND a.NAMENAME = 'StatusPotongS'
LEFT OUTER JOIN ADSTORAGE a1 ON a1.UNIQUEID = s.ABSUNIQUEID AND a1.NAMENAME = 'NotePotongS'
WHERE s.ITEMTYPECODE='KFF' AND s.LOGICALWAREHOUSECODE ='M031' AND a.VALUESTRING ='1' AND
(s.TEMPLATECODE = '098' OR s.TEMPLATECODE = '342') AND CONCAT(s.TRANSACTIONDATE, CONCAT(' ', s.TRANSACTIONTIME)) BETWEEN '$ysrdy' AND '$tody' 
GROUP BY s.TRANSACTIONDATE, s.DECOSUBCODE02, s.DECOSUBCODE03, s.DECOSUBCODE04, s.DECOSUBCODE05, s.DECOSUBCODE06, s.DECOSUBCODE07, s.DECOSUBCODE08, 
s.LOTCODE,s.CREATIONUSER,a.VALUESTRING, s.PROJECTCODE, a1.VALUESTRING, s.ITEMELEMENTCODE ";
	$stmt1PS   = db2_exec($conn1,$sqlDB21PS, array('cursor'=>DB2_SCROLLABLE));				  
    while($rowdb21PS = db2_fetch_assoc($stmt1PS)){ 
	$kdbenangPS=trim($rowdb21PS['DECOSUBCODE01'])." ".trim($rowdb21PS['DECOSUBCODE02'])." ".trim($rowdb21PS['DECOSUBCODE03'])." ".trim($rowdb21PS['DECOSUBCODE04'])." ".trim($rowdb21PS['DECOSUBCODE05'])." ".trim($rowdb21PS['DECOSUBCODE06'])." ".trim($rowdb21PS['DECOSUBCODE07'])." ".trim($rowdb21PS['DECOSUBCODE08']);

$simpanPS=mysqli_query($con,"INSERT INTO `tblkeluarkain` SET 
tgl_keluar 	= '".substr($rowdb21PS['TRANSACTIONDATE'], 0, 10)."',
qty 		= '".$rowdb21PS['JML']."',
berat 		= '".round($rowdb21PS['KG'], 2)."',
tipe 		= '".$tipeB."',
no_order 	= '".$rowdb21PS['PROJECTCODE']."',
lot 		= '".$rowdb21PS['LOTCODE']."',
element 	= '".$rowdb21PS['ITEMELEMENTCODE']."',
tgl_tutup 	= '".$Awal."',
jns_trans	= 'potong sample',
tgl_buat 	= now()") or die("GAGAL SIMPAN TRANSAKSI KELUAR POTONG SAMPLE");		
} 
				
//Pass QTY
				
$sqlDB21PQ = " SELECT 
s.CREATIONUSER, s.TRANSACTIONDATE, s.DECOSUBCODE02, s.DECOSUBCODE03, s.DECOSUBCODE04, s.DECOSUBCODE05, s.DECOSUBCODE06, s.DECOSUBCODE07, s.DECOSUBCODE08, 
s.LOTCODE, SUM(s.BASEPRIMARYQUANTITY) AS KG, SUM(s.BASESECONDARYQUANTITY) AS YARD, s.ITEMELEMENTCODE, COUNT(s.ITEMELEMENTCODE) AS JML, a.VALUESTRING AS PTG, a1.VALUESTRING as NOTE, s.PROJECTCODE  
FROM STOCKTRANSACTION s
LEFT OUTER JOIN ADSTORAGE a ON a.UNIQUEID = s.ABSUNIQUEID AND a.NAMENAME = 'StatusPotongS'
LEFT OUTER JOIN ADSTORAGE a1 ON a1.UNIQUEID = s.ABSUNIQUEID AND a1.NAMENAME = 'NotePotongS'
WHERE s.ITEMTYPECODE='KFF' AND s.LOGICALWAREHOUSECODE ='M031' AND a.VALUESTRING ='2' AND
s.TEMPLATECODE = '098' AND CONCAT(s.TRANSACTIONDATE, CONCAT(' ', s.TRANSACTIONTIME)) BETWEEN '$ysrdy' AND '$tody'
GROUP BY s.TRANSACTIONDATE, s.DECOSUBCODE02, s.DECOSUBCODE03, s.DECOSUBCODE04, s.DECOSUBCODE05, s.DECOSUBCODE06, s.DECOSUBCODE07, s.DECOSUBCODE08, 
s.LOTCODE,s.CREATIONUSER,a.VALUESTRING, s.PROJECTCODE, a1.VALUESTRING, s.ITEMELEMENTCODE ";
	$stmt1PQ   = db2_exec($conn1,$sqlDB21PQ, array('cursor'=>DB2_SCROLLABLE));
				  
    while($rowdb21PQ = db2_fetch_assoc($stmt1PQ)){ 
	$kdbenangPQ=trim($rowdb21PQ['DECOSUBCODE01'])." ".trim($rowdb21PQ['DECOSUBCODE02'])." ".trim($rowdb21PQ['DECOSUBCODE03'])." ".trim($rowdb21PQ['DECOSUBCODE04'])." ".trim($rowdb21PQ['DECOSUBCODE05'])." ".trim($rowdb21PQ['DECOSUBCODE06'])." ".trim($rowdb21PQ['DECOSUBCODE07'])." ".trim($rowdb21PQ['DECOSUBCODE08']);

$simpanPQ=mysqli_query($con,"INSERT INTO `tblkeluarkain` SET 
tgl_keluar 	= '".substr($rowdb21PQ['TRANSACTIONDATE'], 0, 10)."',
qty 		= '".$rowdb21PQ['JML']."',
berat 		= '".round($rowdb21PQ['KG'], 2)."',
tipe 		= '".$tipePQ."',
no_order 	= '".$rowdb21PQ['PROJECTCODE']."',
lot 		= '".$rowdb21PQ['LOTCODE']."',
element 	= '".$rowdb21PQ['ITEMELEMENTCODE']."',
tgl_tutup 	= '".$Awal."',
jns_trans	= 'pass qty',
tgl_buat 	= now()") or die("GAGAL SIMPAN TRANSAKSI KELUAR POTONG SAMPLE");		
}
		echo "<script>";
		echo "alert('Stok Tgl ".$Awal." Sudah ditutup')";
		echo "</script>";
        echo "<meta http-equiv='refresh' content='0; url=TutupInOutHarian'>";
 }
}
?>