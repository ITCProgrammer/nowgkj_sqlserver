<?php
$Awal	= isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : '';
?>

<!-- Main content -->
      <div class="container-fluid">
		<form role="form" method="post" enctype="multipart/form-data" name="form1">  
		<div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Filter Tgl Tutup In-Out Kain Jadi</h3>

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
			 <div class="alert alert-primary alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-info"></i> Note!</h5>
                  * Tutup Transaksi Membutuhkan Waktu, Harap Tunggu...<br>
** Jangan di Tutup Sebelum Selesai.<br> 
                *** Bisa tutup Mulai jam 22:00 sampai jam 24:00 
                </div> 
             <div class="form-group row">
               <label for="tgl_awal" class="col-md-1">Tgl Tutup</label>
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
			  
          </div>	
		  <div class="card-footer">
			<button class="btn btn-info" type="submit" name="submit">Submit</button>
		</div>	
		  <!-- /.card-body -->          
        </div>  
		<div class="row">
			<div class="col-md-6">	
		<div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Detail Data Masuk Kain Jadi Perhari</h3>				 
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
                    <th valign="middle" style="text-align: center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
<?php	 
$no=1;   
$c=0;				  
$sql = mysqli_query($con," SELECT tgl_tutup,sum(qty) as rol,sum(berat) as kg,DATE_FORMAT(now(),'%Y-%m-%d') as tgl FROM tblmasukkain GROUP BY tgl_tutup ORDER BY tgl_tutup DESC LIMIT 30");		  
    while($r = mysqli_fetch_array($sql)){
		
?>
	  <tr>
	  <td style="text-align: center"><?php echo $no;?></td>
	  <td style="text-align: center"><a href="DetailInHarian-<?php echo $r['tgl_tutup'];?>" class="btn btn-info btn-xs" target="_blank"> <i class="fa fa-link"></i> Lihat Data</a></td>
	  <td style="text-align: center"><?php echo $r['tgl_tutup'];?></td>
      <td style="text-align: center"><?php echo $r['rol'];?></td>
      <td style="text-align: right"><?php echo number_format(round($r['kg'],2),2);?></td>
      <td style="text-align: center"><a href="#" class="btn btn-xs btn-danger <?php if($r['tgl']==$r['tgl_tutup']){ }else{/*echo"disabled";*/} ?>" onclick="confirm_deleteIn('DelInHarian-<?php echo $r['tgl_tutup']; ?>');" ><small class="fas fa-trash"> </small> Hapus</a></td>
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
			<div class="col-md-6">
		<div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Detail Data Keluar Kain Jadi Perhari</h3>				 
          </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example3" class="table table-sm table-bordered table-striped" style="font-size: 14px; text-align: center;">
                  <thead>
                  <tr>
                    <th valign="middle" style="text-align: center">No</th>
                    <th valign="middle" style="text-align: center">Detail</th>
                    <th valign="middle" style="text-align: center">Tgl Tutup</th>
                    <th valign="middle" style="text-align: center">Rol</th>
                    <th valign="middle" style="text-align: center">KG</th>
                    <th valign="middle" style="text-align: center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
<?php	 
$no=1;   
$c=0;				  
$sql = mysqli_query($con," SELECT tgl_tutup,sum(qty) as rol,sum(berat) as kg,DATE_FORMAT(now(),'%Y-%m-%d') as tgl FROM tblkeluarkain GROUP BY tgl_tutup ORDER BY tgl_tutup DESC LIMIT 30");		  
    while($r = mysqli_fetch_array($sql)){
		
?>
	  <tr>
	  <td style="text-align: center"><?php echo $no;?></td>
	  <td style="text-align: center"><a href="DetailOutHarian-<?php echo $r['tgl_tutup'];?>" class="btn btn-info btn-xs" target="_blank"> <i class="fa fa-link"></i> Lihat Data</a></td>
	  <td style="text-align: center"><?php echo $r['tgl_tutup'];?></td>
      <td style="text-align: center"><?php echo $r['rol'];?></td>
      <td style="text-align: right"><?php echo number_format(round($r['kg'],2),2);?></td>
      <td style="text-align: center"><a href="#" class="btn btn-xs btn-danger <?php if($r['tgl']==$r['tgl_tutup']){ }else{/*echo"disabled";*/} ?>" onclick="confirm_deleteOut('DelOutHarian-<?php echo $r['tgl_tutup']; ?>');" ><small class="fas fa-trash"> </small> Hapus</a></td>
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
				</form>		
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
		
	}else if($dcek['jam'] < 6){		
		echo "<script>
  		$(function() {
    		toastr.error('Tidak Bisa Tutup Sebelum jam 10 Malam Sampai jam 12 Malam, Sekarang Masih Jam ".$dcek['jam1']."')
  		});  
  		</script>";
			}
			else{	
	
	//Masuk Kain Jadi
$sqlDB2M = " SELECT TRANSACTIONDATE,ITEMTYPECODE,DECOSUBCODE01,
DECOSUBCODE02,DECOSUBCODE03,DECOSUBCODE04,DECOSUBCODE05,
DECOSUBCODE06,DECOSUBCODE07,DECOSUBCODE08, COUNT(BASEPRIMARYQUANTITY) AS ROL,
SUM(BASEPRIMARYQUANTITY) AS KGS,LOTCODE,PROJECTCODE,
LISTAGG(DISTINCT  TRIM(WHSLOCATIONWAREHOUSEZONECODE),',') AS ZN,
LISTAGG(DISTINCT TRIM(WAREHOUSELOCATIONCODE),',') AS LK,QUALITYREASONCODE FROM STOCKTRANSACTION 
WHERE TRANSACTIONDATE ='$Awal' AND 
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
warna 		= '".$warnaM."',
buyer		= '".$buyerM."',
customer	= '".$langgananM."',
nopo		= '".$nopoM."',
no_order	= '".$PJCODEM."',
jenis_kain	= '".str_replace("'","''",$rowdb27M['SHORTDESCRIPTION'])."',
lebar		= '".round($rowdb29M['VALUEDECIMAL'])."',
gramasi		= '".round($rowdb30M['VALUEDECIMAL'])."',
lot			= '".$rowdb2M['LOTCODE']."',
lokasi		= '".$rowdb2M['LK']."',
foc			= '".$focM."',
tgl_tutup 	= '".$Awal."',
tgl_buat 	= now()") or die("GAGAL SIMPAN MASUK KAIN");		
}


	//Keluar Kain Jadi
				
$sqlDB2K = " SELECT TRANSACTIONDATE, ORDERCODE, ITEMTYPECODE,DECOSUBCODE01,
DECOSUBCODE02,DECOSUBCODE03,DECOSUBCODE04,DECOSUBCODE05,
DECOSUBCODE06,DECOSUBCODE07,DECOSUBCODE08, COUNT(BASEPRIMARYQUANTITY) AS ROL,
SUM(BASEPRIMARYQUANTITY) AS KGS,LOTCODE,PROJECTCODE,
LISTAGG(DISTINCT  TRIM(WHSLOCATIONWAREHOUSEZONECODE),',') AS ZN,
LISTAGG(DISTINCT TRIM(WAREHOUSELOCATIONCODE),',') AS LK,QUALITYREASONCODE FROM STOCKTRANSACTION 
WHERE TRANSACTIONDATE ='$Awal' AND 
TEMPLATECODE ='S02' AND 
(ITEMTYPECODE='FKF' OR ITEMTYPECODE='KFF') AND 
LOGICALWAREHOUSECODE ='M031'
GROUP BY LOTCODE,TRANSACTIONDATE,ORDERCODE,ITEMTYPECODE,DECOSUBCODE01,
DECOSUBCODE02,DECOSUBCODE03,DECOSUBCODE04,DECOSUBCODE05,
DECOSUBCODE06,DECOSUBCODE07,DECOSUBCODE08,PROJECTCODE,
WHSLOCATIONWAREHOUSEZONECODE,WAREHOUSELOCATIONCODE,QUALITYREASONCODE ";
	$stmtK   = db2_exec($conn1,$sqlDB2K, array('cursor'=>DB2_SCROLLABLE));
	//}				  
    while($rowdb2K = db2_fetch_assoc($stmtK)){
		
	$sqlDB22K = " SELECT SALESORDER.CODE, SALESORDER.EXTERNALREFERENCE, SALESORDER.ORDPRNCUSTOMERSUPPLIERCODE,
		ITXVIEWAKJ.LEGALNAME1, ITXVIEWAKJ.ORDERPARTNERBRANDCODE, ITXVIEWAKJ.LONGDESCRIPTION
		FROM DB2ADMIN.SALESORDER SALESORDER LEFT OUTER JOIN DB2ADMIN.ITXVIEWAKJ 
       	ITXVIEWAKJ ON SALESORDER.CODE=ITXVIEWAKJ.CODE
		WHERE SALESORDER.CODE='$rowdb2K[PROJECTCODE]' ";
		
	$stmt2K   = db2_exec($conn1,$sqlDB22K, array('cursor'=>DB2_SCROLLABLE));
	$rowdb22K = db2_fetch_assoc($stmt2K);	
	if($rowdb22K['LEGALNAME1']==""){$langgananK="";}else{$langgananK=$rowdb22K['LEGALNAME1'];}
	if($rowdb22K['ORDERPARTNERBRANDCODE']==""){$buyerK="";}else{$buyerK=$rowdb22K['LONGDESCRIPTION'];}
		
	$sqlDB23K = " SELECT s.EXTERNALREFERENCE AS PO_HEADER ,s2.EXTERNALREFERENCE AS PO_LINE FROM ITXVIEWKK i 
LEFT OUTER JOIN SALESORDER s ON i.PROJECTCODE =s.CODE 
LEFT OUTER JOIN SALESORDERLINE s2 ON i.PROJECTCODE =s2.SALESORDERCODE AND i.ORDERLINE =s2.ORDERLINE  
WHERE i.DEAMAND ='$rowdb2K[LOTCODE]' ";
	$stmt3K   = db2_exec($conn1,$sqlDB23K, array('cursor'=>DB2_SCROLLABLE));
	$rowdb23K = db2_fetch_assoc($stmt3K);		
			
	$sqlDB24K = " SELECT PRODUCT.SHORTDESCRIPTION FROM PRODUCT WHERE
		ITEMTYPECODE='$rowdb2K[ITEMTYPECODE]' AND
		SUBCODE01='$rowdb2K[DECOSUBCODE01]' AND
		SUBCODE02='$rowdb2K[DECOSUBCODE02]' AND
		SUBCODE03='$rowdb2K[DECOSUBCODE03]' AND
		SUBCODE04='$rowdb2K[DECOSUBCODE04]' AND
		SUBCODE05='$rowdb2K[DECOSUBCODE05]' 
		";
	$stmt4K   = db2_exec($conn1,$sqlDB24K, array('cursor'=>DB2_SCROLLABLE));
	$rowdb24K = db2_fetch_assoc($stmt4K);			
		
	$sqlDB25K = " SELECT ITXVIEWRESEPCOLOR.LONGDESCRIPTION FROM ITXVIEWRESEPCOLOR WHERE
		ITXVIEWRESEPCOLOR.NO_WARNA='$rowdb2K[DECOSUBCODE05]' AND
		ITXVIEWRESEPCOLOR.ARTIKEL='$rowdb2K[DECOSUBCODE03]' ";
	$stmt5K   = db2_exec($conn1,$sqlDB25K, array('cursor'=>DB2_SCROLLABLE));
	$rowdb25K = db2_fetch_assoc($stmt5K);	
		
	$sqlDB26K = " SELECT DESIGN.SUBCODE01,
	   DESIGNCOMPONENT.VARIANTCODE,
       DESIGNCOMPONENT.SHORTDESCRIPTION 
	   FROM DB2ADMIN.DESIGN DESIGN LEFT OUTER JOIN DB2ADMIN.DESIGNCOMPONENT 
       DESIGNCOMPONENT ON DESIGN.NUMBERID=DESIGNCOMPONENT.DESIGNNUMBERID AND 
       DESIGN.SUBCODE01=DESIGNCOMPONENT.DESIGNSUBCODE01 
	   WHERE DESIGN.SUBCODE01='$rowdb2K[DECOSUBCODE07]' AND
	   DESIGNCOMPONENT.VARIANTCODE='$rowdb2K[DECOSUBCODE08]' ";
	$stmt6K   = db2_exec($conn1,$sqlDB26K, array('cursor'=>DB2_SCROLLABLE));
	$rowdb26K = db2_fetch_assoc($stmt6K);
		if(trim($rowdb2K['ITEMTYPECODE'])=="FKF"){
			$posK=strpos($rowdb24K['SHORTDESCRIPTION'],"-");
			$warnaK=substr($rowdb24K['SHORTDESCRIPTION'],0,$posK);
		}
		else if(trim($rowdb2K['DECOSUBCODE07'])=="-" and trim($rowdb2K['DECOSUBCODE08'])=="-"){
			$warnaK=$rowdb25K['LONGDESCRIPTION'];
		}else if(trim($rowdb2K['DECOSUBCODE07'])!="-" and trim($rowdb2K['DECOSUBCODE08'])!="-"){
			$warnaK=$rowdb26K['SHORTDESCRIPTION'];
		}
		$sqlDB27K = " SELECT PRODUCT.SHORTDESCRIPTION FROM PRODUCT WHERE
		ITEMTYPECODE='$rowdb2K[ITEMTYPECODE]' AND
		SUBCODE01='$rowdb2K[DECOSUBCODE01]' AND
		SUBCODE02='$rowdb2K[DECOSUBCODE02]' AND
		SUBCODE03='$rowdb2K[DECOSUBCODE03]' AND
		SUBCODE04='$rowdb2K[DECOSUBCODE04]' AND
		SUBCODE05='$rowdb2K[DECOSUBCODE05]' AND
		SUBCODE06='$rowdb2K[DECOSUBCODE06]' AND
		SUBCODE07='$rowdb2K[DECOSUBCODE07]' AND
		SUBCODE08='$rowdb2K[DECOSUBCODE08]' 
		";
	$stmt7K   = db2_exec($conn1,$sqlDB27K, array('cursor'=>DB2_SCROLLABLE));
	$rowdb27K = db2_fetch_assoc($stmt7K);
	if($rowdb2K['ITEMTYPECODE']=="KFF"){$tipe="KAIN"; }else{$tipe="KRAH";}
	if($rowdb23K['PO_HEADER']!=""){$PO=$rowdb23K['PO_HEADER'];}else{$PO=$rowdb23K['PO_LINE'];}	
$simpanK=mysqli_query($con,"INSERT INTO `tblkeluarkain` SET 
tgl_keluar 	= '".substr($rowdb2K['TRANSACTIONDATE'],0,10)."',
qty 		= '".$rowdb2K['ROL']."',
berat 		= '".round($rowdb2K['KGS'],2)."',
tipe 		= '".$tipe."',
no_sj 		= '".$rowdb2K['ORDERCODE']."',
warna 		= '".$warnaM."',
buyer 		= '".$buyerK."',
customer 	= '".$langgananK."',
no_po 		= '".$PO."',
no_order 	= '".$rowdb2K['PROJECTCODE']."',
jenis_kain 	= '".str_replace("'","''",$rowdb27K['SHORTDESCRIPTION'])."',
lot 		= '".$rowdb2K['LOTCODE']."',
foc 		= '".$FOC."',
tgl_tutup 	= '".$Awal."',
tgl_buat 	= now()") or die("GAGAL SIMPAN TRANSAKSI KELUAR");
		
}
 		
		echo "<script>";
		echo "alert('Stok Tgl ".$Awal." Sudah ditutup')";
		echo "</script>";
        echo "<meta http-equiv='refresh' content='0; url=TutupInOutHarian'>";
 }
}
?>