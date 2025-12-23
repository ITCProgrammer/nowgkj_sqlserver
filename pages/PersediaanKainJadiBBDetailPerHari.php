<?php
$Awal	= isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : '';
?>

<!-- Main content -->
      
<div class="container-fluid">
		<form role="form" method="post" enctype="multipart/form-data" name="form1">  
			
		<div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Detail Data Persediaan Kain Jadi BB Perhari (Tutup Auto Jam 21:00)</h3>				 
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
$sql = mysqli_query($con," SELECT tgl_tutup,sum(rol) as rol,sum(weight) as kg,DATE_FORMAT(now(),'%Y-%m-%d') as tgl 
FROM tbl_opname_detail_bb_11 GROUP BY tgl_tutup ORDER BY tgl_tutup DESC LIMIT 60");		  
    while($r = mysqli_fetch_array($sql)){
		
?>
	  <tr>
	  <td style="text-align: center"><?php echo $no;?></td>
	  <td style="text-align: center"><div class="btn-group"><a href="DetailKainBB-<?php echo $r['tgl_tutup'];?>" class="btn btn-info btn-xs" target="_blank"> <i class="fa fa-link"></i> Lihat Data</a><a href="pages/cetak/DetailKainBBExcel.php?tgl=<?php echo $r['tgl_tutup'];?>" class="btn btn-success btn-xs" target="_blank"> <i class="fa fa-file"></i> Cetak Ke Excel</a></div></td>
	  <td style="text-align: center"><?php echo $r['tgl_tutup'];?></td>
      <td style="text-align: center"><?php echo $r['rol'];?></td>
      <td style="text-align: right"><?php echo number_format($r['kg'],3);?></td>
      <td style="text-align: center"><a href="#" class="btn btn-xs btn-danger <?php if($r['tgl']==$r['tgl_tutup']){ }else{echo"disabled";} ?>" onclick="confirm_delete('DelDetailKainBB-<?php echo $r['tgl_tutup']; ?>');" ><small class="fas fa-trash"> </small> Hapus</a></td>
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
	</form>		
      </div><!-- /.container-fluid -->
    <!-- /.content -->
<div class="modal fade" id="delOpname" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content" style="margin-top:100px;">
                  <div class="modal-header">
					<h4 class="modal-title">INFOMATION</h4>  
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    
                  </div>
					<div class="modal-body">
						<h5 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h5>
					</div>	
                  <div class="modal-footer justify-content-between">
                    <a href="#" class="btn btn-danger" id="delete_link">Delete</a>
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
              function confirm_delete(delete_url) {
                $('#delOpname').modal('show', {
                  backdrop: 'static'
                });
                document.getElementById('delete_link').setAttribute('href', delete_url);
              }
</script>
<?php	
if(isset($_POST['submit'])){

$cektgl=mysqli_query($con,"SELECT DATE_FORMAT(NOW(),'%Y-%m-%d') as tgl,COUNT(tgl_tutup) as ck ,DATE_FORMAT(NOW(),'%H') as jam,DATE_FORMAT(NOW(),'%H:%i') as jam1 FROM tbl_opname WHERE tgl_tutup='".$Awal."' LIMIT 1");
$dcek=mysqli_fetch_array($cektgl);
$t1=strtotime($Awal);
$t2=strtotime($dcek['tgl']);
$selh=round(abs($t2-$t1)/(60*60*45));

if($dcek['ck']>0){
	//echo "<script>";
		//echo "alert('Stok Tgl ".$Awal." Ini Sudah Pernah ditutup')";
		//echo "</script>";
		echo "<script>
  	$(function() {
    toastr.error('Stok Tgl ".$Awal." Ini Sudah Pernah ditutup')
  });
  
</script>";
		// Refresh form
		// echo "<meta http-equiv='refresh' content='0; url=index1.php?p=data-stok-kj'>";
	}else if($Awal > $dcek['tgl']){
		//echo "<script>";
		//echo "alert('Tanggal Lebih dari $selh hari')";
		//echo "</script>";
		echo "<script>
  	$(function() {
    toastr.error('Tanggal Lebih dari $selh hari')
  });
  
</script>";
		// Refresh form
		// echo "<meta http-equiv='refresh' content='0; url=index1.php?p=data-stok-kj'>";
	}else if($Awal < $dcek['tgl']){
		//echo "<script>";
		//echo "alert('Tanggal Kurang dari $selh hari')";
		//echo "</script>";
		echo "<script>
  		$(function() {
    		toastr.error('Tanggal Kurang dari $selh hari')
  		});  
  		</script>";
		// Refresh form
		// echo "<meta http-equiv='refresh' content='0; url=index1.php?p=data-stok-kj'>";
	}else if($dcek['jam'] < 21 and $dcek['jam'] > 7){
		//echo "<script>";
		//echo "alert('Tidak Bisa Tutup Sebelum jam 6 Pagi Sampai jam 12 Malam, Sekarang Masih Jam ".$dcek['jam1']."')";
		//echo "</script>";
		echo "<script>
  		$(function() {
    		toastr.error('Tidak Bisa Tutup Sebelum jam 9 Malam Sampai jam 7 Pagi, Sekarang Masih Jam ".$dcek['jam1']."')
  		});  
  		</script>";
		// Refresh form
		// echo "<meta http-equiv='refresh' content='0; url=index1.php?p=data-stok-kj'>";
			}
			else{	
	
	$no=1;   
   $c=0;
	$sqlDB21 = " SELECT bl.*,
	SALESORDER.CODE,
	SALESORDER.EXTERNALREFERENCE,
	SALESORDER.ORDPRNCUSTOMERSUPPLIERCODE,
	ITXVIEWAKJ.LEGALNAME1,
	ITXVIEWAKJ.ORDERPARTNERBRANDCODE,
	ITXVIEWAKJ.LONGDESCRIPTION
	FROM 
		(SELECT 
			SUM(b.BASEPRIMARYQUANTITYUNIT) AS BERAT,
			SUM(b.BASESECONDARYQUANTITYUNIT) AS YD,
			COUNT(b.BASESECONDARYQUANTITYUNIT) AS ROLL,
			b.LOTCODE,b.PROJECTCODE,
			b.ITEMTYPECODE,
			b.DECOSUBCODE01,
			b.DECOSUBCODE02,
			b.DECOSUBCODE03,
			b.DECOSUBCODE04,
			b.DECOSUBCODE05,
			b.DECOSUBCODE06,
			b.DECOSUBCODE07,
			b.DECOSUBCODE08,
			b.BASEPRIMARYUNITCODE,
			b.BASESECONDARYUNITCODE,
			b.WHSLOCATIONWAREHOUSEZONECODE,
			b.WAREHOUSELOCATIONCODE,
			p.LONGDESCRIPTION AS JNSKAIN 
		FROM 
		BALANCE b 
		LEFT OUTER JOIN PRODUCT p ON p.ITEMTYPECODE =b.ITEMTYPECODE AND 
		p.SUBCODE01=b.DECOSUBCODE01 AND 
		p.SUBCODE02=b.DECOSUBCODE02 AND 
		p.SUBCODE03=b.DECOSUBCODE03 AND 
		p.SUBCODE04=b.DECOSUBCODE04 AND 
		p.SUBCODE05=b.DECOSUBCODE05 AND 
		p.SUBCODE06=b.DECOSUBCODE06 AND 
		p.SUBCODE07=b.DECOSUBCODE07 AND 
		p.SUBCODE08=b.DECOSUBCODE08
		WHERE (b.ITEMTYPECODE='FKF' OR b.ITEMTYPECODE='KFF') AND b.LOGICALWAREHOUSECODE='M031' 
		AND (TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%Y%' OR 
		TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%Z%' OR 
		TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%W%' OR 
		TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%X%')
GROUP BY b.ITEMTYPECODE,b.DECOSUBCODE01,
b.DECOSUBCODE02,b.DECOSUBCODE03,
b.DECOSUBCODE04,b.DECOSUBCODE05,
b.DECOSUBCODE06,b.DECOSUBCODE07,
b.DECOSUBCODE08,b.PROJECTCODE,b.LOTCODE,
b.BASEPRIMARYUNITCODE,b.BASESECONDARYUNITCODE,
b.WHSLOCATIONWAREHOUSEZONECODE,b.WAREHOUSELOCATIONCODE,p.LONGDESCRIPTION) bl LEFT OUTER JOIN
		DB2ADMIN.SALESORDER SALESORDER  ON bl.PROJECTCODE=SALESORDER.CODE
	    LEFT OUTER JOIN DB2ADMIN.ITXVIEWAKJ ITXVIEWAKJ ON SALESORDER.CODE=ITXVIEWAKJ.CODE 
		WHERE (bl.ITEMTYPECODE='FKF' OR bl.ITEMTYPECODE='KFF') 
		";
	$stmt1   = db2_exec($conn1,$sqlDB21, array('cursor'=>DB2_SCROLLABLE));
    while($rowdb21 = db2_fetch_assoc($stmt1)){
	$itemNo=trim($rowdb21['DECOSUBCODE02'])."".trim($rowdb21['DECOSUBCODE03']);	
	if($rowdb21['ITEMTYPECODE']=="KFF"){$jns="KAIN";}else if($rowdb21['ITEMTYPECODE']=="FKF"){$jns="KRAH";}
	$sqlDB22 = " SELECT SALESORDER.CODE, SALESORDER.EXTERNALREFERENCE, SALESORDER.ORDPRNCUSTOMERSUPPLIERCODE,
		ITXVIEWAKJ.LEGALNAME1, ITXVIEWAKJ.ORDERPARTNERBRANDCODE, ITXVIEWAKJ.LONGDESCRIPTION
		FROM DB2ADMIN.SALESORDER SALESORDER LEFT OUTER JOIN DB2ADMIN.ITXVIEWAKJ 
       	ITXVIEWAKJ ON SALESORDER.CODE=ITXVIEWAKJ.CODE
		WHERE SALESORDER.CODE='$rowdb21[PROJECTCODE]' ";
	$stmt2   = db2_exec($conn1,$sqlDB22, array('cursor'=>DB2_SCROLLABLE));
	$rowdb22 = db2_fetch_assoc($stmt2);		
	if($rowdb22['LEGALNAME1']==""){$langganan="";}else{$langganan=$rowdb22['LEGALNAME1'];}
	if($rowdb22['ORDERPARTNERBRANDCODE']==""){$buyer="";}else{$buyer=$rowdb22['LONGDESCRIPTION'];}	
	$sqlDB23 = " SELECT USERGENERICGROUP.CODE,USERGENERICGROUP.LONGDESCRIPTION 
		FROM DB2ADMIN.USERGENERICGROUP USERGENERICGROUP WHERE USERGENERICGROUP.CODE='$rowdb21[DECOSUBCODE05]' ";
	$stmt3   = db2_exec($conn1,$sqlDB23, array('cursor'=>DB2_SCROLLABLE));
	$rowdb23 = db2_fetch_assoc($stmt3);	
	$sqlDB25 = " SELECT ORDERITEMORDERPARTNERLINK.ORDPRNCUSTOMERSUPPLIERCODE,
       ORDERITEMORDERPARTNERLINK.LONGDESCRIPTION 
	   FROM DB2ADMIN.ORDERITEMORDERPARTNERLINK ORDERITEMORDERPARTNERLINK WHERE
       ORDERITEMORDERPARTNERLINK.ITEMTYPEAFICODE='$rowdb21[ITEMTYPECODE]' AND
	   ORDERITEMORDERPARTNERLINK.ORDPRNCUSTOMERSUPPLIERCODE='$rowdb22[ORDPRNCUSTOMERSUPPLIERCODE]' AND
	   ORDERITEMORDERPARTNERLINK.SUBCODE01='$rowdb21[DECOSUBCODE01]' AND
       ORDERITEMORDERPARTNERLINK.SUBCODE02='$rowdb21[DECOSUBCODE02]' AND
       ORDERITEMORDERPARTNERLINK.SUBCODE03='$rowdb21[DECOSUBCODE03]' AND
	   ORDERITEMORDERPARTNERLINK.SUBCODE04='$rowdb21[DECOSUBCODE04]' AND
       ORDERITEMORDERPARTNERLINK.SUBCODE05='$rowdb21[DECOSUBCODE05]' AND
	   ORDERITEMORDERPARTNERLINK.SUBCODE06='$rowdb21[DECOSUBCODE06]' AND
       ORDERITEMORDERPARTNERLINK.SUBCODE07='$rowdb21[DECOSUBCODE07]' AND
	   ORDERITEMORDERPARTNERLINK.SUBCODE08='$rowdb21[DECOSUBCODE08]'";
	$stmt5   = db2_exec($conn1,$sqlDB25, array('cursor'=>DB2_SCROLLABLE));
	$rowdb25 = db2_fetch_assoc($stmt5);	
	if($rowdb25['LONGDESCRIPTION']!=""){
		$item=$rowdb25['LONGDESCRIPTION'];
	}else{
		$item=trim($rowdb21['DECOSUBCODE02'])."".trim($rowdb21['DECOSUBCODE03']);
	}	
	$sqlDB26 = " SELECT SALESORDERLINE.EXTERNALREFERENCE 
       FROM DB2ADMIN.SALESORDERLINE WHERE
       SALESORDERLINE.ITEMTYPEAFICODE='$rowdb21[ITEMTYPECODE]' AND	   
	   SALESORDERLINE.PROJECTCODE='$rowdb21[PROJECTCODE]' AND
	   SALESORDERLINE.SUBCODE01='$rowdb21[DECOSUBCODE01]' AND
       SALESORDERLINE.SUBCODE02='$rowdb21[DECOSUBCODE02]' AND
       SALESORDERLINE.SUBCODE03='$rowdb21[DECOSUBCODE03]' AND
	   SALESORDERLINE.SUBCODE04='$rowdb21[DECOSUBCODE04]' AND
       SALESORDERLINE.SUBCODE05='$rowdb21[DECOSUBCODE05]' AND
	   SALESORDERLINE.SUBCODE06='$rowdb21[DECOSUBCODE06]' AND
       SALESORDERLINE.SUBCODE07='$rowdb21[DECOSUBCODE07]' AND
	   SALESORDERLINE.SUBCODE08='$rowdb21[DECOSUBCODE08]' LIMIT 1";
	$stmt6   = db2_exec($conn1,$sqlDB26, array('cursor'=>DB2_SCROLLABLE));
	$rowdb26 = db2_fetch_assoc($stmt6);
	if($rowdb22['EXTERNALREFERENCE']!=""){
		$PO=$rowdb22['EXTERNALREFERENCE'];
	}else{
		$PO=$rowdb26['EXTERNALREFERENCE'];
	}	
	$sqlDB27 = " SELECT ADSTORAGE.NAMENAME,ADSTORAGE.VALUEDECIMAL 
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
	$stmt7   = db2_exec($conn1,$sqlDB27, array('cursor'=>DB2_SCROLLABLE));
	$rowdb27 = db2_fetch_assoc($stmt7);
	$sqlDB28 = " SELECT ADSTORAGE.NAMENAME,ADSTORAGE.VALUEDECIMAL 
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
	$stmt8   = db2_exec($conn1,$sqlDB28, array('cursor'=>DB2_SCROLLABLE));
	$rowdb28 = db2_fetch_assoc($stmt8);	
	$simpan=mysqli_query($con,"INSERT INTO `tbl_opname` SET 
	itm	= '".$item."',
	langganan	= '".str_replace("'","''",$langganan)."',
	buyer = '".str_replace("'","''",$buyer)."',
	po = '".str_replace("'","''",$PO)."',
	orderno = '".$rowdb21['PROJECTCODE']."',
	tipe = '".$jns."',
	no_item = '".$itemNo."',
	jns_kain = '".str_replace("'","''",$rowdb21['JNSKAIN'])."',
	no_warna = '".$rowdb21['DECOSUBCODE05']."',
	warna = '".str_replace("'","''",$rowdb23['LONGDESCRIPTION'])."',
	rol = '".$rowdb21['ROLL']."',
	lot = '".$rowdb21['LOTCODE']."',
	weight = '".round($rowdb21['BERAT'],2)."',
	satuan = '".$rowdb21['BASEPRIMARYUNITCODE']."',
	length = '".round($rowdb21['YD'],2)."',
	satuan_len = '".$rowdb21['BASESECONDARYUNITCODE']."',
	zone = '".$rowdb21['WHSLOCATIONWAREHOUSEZONECODE']."',
	lokasi = '".$rowdb21['WAREHOUSELOCATIONCODE']."',
	lebar = '".round($rowdb27['VALUEDECIMAL'])."',
	gramasi = '".round($rowdb28['VALUEDECIMAL'])."',
	tgl_tutup = '".$Awal."',
	tgl_buat =now()") or die("GAGAL SIMPAN");	
	
	}
	if($simpan){		
		echo "<script>";
		echo "alert('Stok Tgl ".$Awal." Sudah ditutup')";
		echo "</script>";
        echo "<meta http-equiv='refresh' content='0; url=TutupHarian'>";
		
		}			
 }
}
?>