<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=persediaanBalanceALLZoneP2.xls");//ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");
//disini script laporan anda
?>
<?php
include "../../koneksi.php";
ini_set("error_reporting", 1);
?>
<?php
$Zone		= isset($_GET['zone']) ? $_GET['zone'] : '';
$Lokasi		= isset($_GET['lokasi']) ? $_GET['lokasi'] : '';
?>
<table id="" class="">
                  <thead>
                  <tr>
                    <th>TGLMasuk</th>
                    <th>Item</th>
                    <th>Langganan</th>
                    <th>Buyer</th>
                    <th>PO</th>
                    <th>Order</th>
                    <th>Tipe</th>
                    <th>No Item</th>
                    <th>No Warna</th>
                    <th>Warna</th>
                    <th>Element</th>
                    <th>Lot</th>
                    <th>Weight</th>
                    <th>Satuan</th>
                    <th>Grade</th>
                    <th>Length</th>
                    <th>Satuan</th>
                    <th>Zone</th>
                    <th>Lokasi</th>
					<th>Lebar</th>
                    <th>Gramasi</th>  
                    <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
				  <?php	  
   $no=1;   
   $c=0;
	//if($Zone=="" and $Lokasi==""){
	//	echo"<script>alert('Zone atau Lokasi belum dipilih');</script>";
	//}else{
	$sqlDB21 = " SELECT * FROM 
	BALANCE b WHERE (b.ITEMTYPECODE='KFF' OR b.ITEMTYPECODE='FKF') AND b.LOGICALWAREHOUSECODE='M031' 
	AND (TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%Y%' OR TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%Z%' OR TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%W%' OR TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%X%')
	AND (b.PROJECTCODE IS NULL OR b.PROJECTCODE ='')
	ORDER BY ELEMENTSCODE ASC
	LIMIT 23000,46000";
	$stmt1   = db2_exec($conn1,$sqlDB21, array('cursor'=>DB2_SCROLLABLE));
	//}				  
    while($rowdb21 = db2_fetch_assoc($stmt1)){
	$itemNo=trim($rowdb21['DECOSUBCODE02'])."".trim($rowdb21['DECOSUBCODE03']);	
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
	if($rowdb21['QUALITYLEVELCODE']==1){
		$grade="A";
	}else if($rowdb21['QUALITYLEVELCODE']==2){
		$grade="B";
	}else if($rowdb21['QUALITYLEVELCODE']==3){
		$grade="C";
	} 	
	$sqlDB24 = " SELECT STOCKTRANSACTION.QUALITYREASONCODE,STOCKTRANSACTION.ITEMELEMENTCODE,
    	STOCKTRANSACTION.PROJECTCODE,QUALITYREASON.LONGDESCRIPTION 
		FROM DB2ADMIN.STOCKTRANSACTION STOCKTRANSACTION LEFT OUTER JOIN 
      	DB2ADMIN.QUALITYREASON QUALITYREASON ON 
      	STOCKTRANSACTION.QUALITYREASONCODE=QUALITYREASON.CODE 
		WHERE STOCKTRANSACTION.ITEMELEMENTCODE='$rowdb21[ELEMENTSCODE]' ";
	$stmt4   = db2_exec($conn1,$sqlDB24, array('cursor'=>DB2_SCROLLABLE));
	$rowdb24 = db2_fetch_assoc($stmt4);	
	if ($rowdb24['QUALITYREASONCODE']!="" and $rowdb24['QUALITYREASONCODE']!="100"){
		$sts=$rowdb24['LONGDESCRIPTION'];}	
	else if ((substr(trim($rowdb24['PROJECTCODE']),0,3)=="OPN" or substr(trim($rowdb24['PROJECTCODE']),0,3)=="STO") and $rowdb24['QUALITYREASONCODE']=="100"){
		$sts="Booking";}	
	else if (substr(trim($rowdb24['PROJECTCODE']),0,3)=="OPN" or substr(trim($rowdb24['PROJECTCODE']),0,3)=="STO" ){
		$sts="Booking";}	
	else if (substr(trim($rowdb24['PROJECTCODE']),0,3)=="RPE" and $rowdb24['QUALITYREASONCODE']=="100"){
		$sts="Ganti Kain";  }	
	else if (substr(trim($rowdb24['PROJECTCODE']),0,3)=="RPE"){
		$sts="Ganti Kain";  }
	else {
		$sts="Tunggu Kirim"; }		
		
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
	$sqlDB26 = " SELECT ITXVIEWKK.PROJECTCODE,ITXVIEWKK.PRODUCTIONORDERCODE,
       ITXVIEWKK.ITEMTYPEAFICODE,ITXVIEWKK.SUBCODE01,ITXVIEWKK.SUBCODE02,
       ITXVIEWKK.SUBCODE03,ITXVIEWKK.SUBCODE04,ITXVIEWKK.SUBCODE05,
       ITXVIEWKK.SUBCODE06,ITXVIEWKK.SUBCODE07,ITXVIEWKK.SUBCODE08,
       SALESORDERLINE.EXTERNALREFERENCE 
       FROM DB2ADMIN.ITXVIEWKK ITXVIEWKK LEFT OUTER JOIN DB2ADMIN.SALESORDERLINE 
       SALESORDERLINE ON 
       ITXVIEWKK.PROJECTCODE=SALESORDERLINE.PROJECTCODE AND 
       ITXVIEWKK.ORIGDLVSALORDERLINEORDERLINE=SALESORDERLINE.ORDERLINE WHERE
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
	if($stmt2['EXTERNALREFERENCE']!=""){
		$PO=$stmt2['EXTERNALREFERENCE'];
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
	$sqlDB29 = "SELECT TRANSACTIONDATE FROM STOCKTRANSACTION 
	WHERE ITEMELEMENTCODE='$rowdb21[ELEMENTSCODE]'  AND 
	TEMPLATECODE ='304' AND (ITEMTYPECODE='FKF' OR ITEMTYPECODE='KFF') AND LOGICALWAREHOUSECODE ='M031' ";
	$stmt9   = db2_exec($conn1,$sqlDB29, array('cursor'=>DB2_SCROLLABLE));
	$rowdb29 = db2_fetch_assoc($stmt9);	
	if($rowdb21['ITEMTYPECODE']=="KFF"){$jns="KAIN";}else if($rowdb21['ITEMTYPECODE']=="FKF"){$jns="KRAH";}	
	$sqlQC=mysqli_query($cond,"SELECT k.pelanggan,k.no_po,k.no_order,k.no_item  FROM db_qc.tmp_detail_kite tmp
inner join db_qc.tbl_kite k on k.id=tmp.id_kite 
WHERE SN='$rowdb21[ELEMENTSCODE]' ");
	$rQC=mysqli_fetch_array($sqlQC);
	$pos=strpos($rQC['pelanggan'],"/");
	$cust=substr($rQC['pelanggan'],0,$pos);	
	$byr=substr($rQC['pelanggan'],$pos+1,300);	
	$itemLama= $rQC['no_item'];		
?>
	  <tr>
      <td><?php if($rowdb29['TRANSACTIONDATE']!=""){echo substr($rowdb29['TRANSACTIONDATE'],0,10);}else{echo substr($rowdb21['CREATIONDATETIME'],0,10);} ?></td>
      <td><?php echo $itemLama; ?></td>
      <td><?php if($langganan!=""){echo $langganan;}else{ echo $cust; } ?></td>
      <td><?php if($buyer!=""){echo $buyer;}else{echo $byr;} ?></td>
      <td><?php if($PO!=""){echo $PO;}else{ echo $rQC['no_po']; } ?></td>
      <td><?php if(trim($rowdb21['PROJECTCODE'])!=""){echo $rowdb21['PROJECTCODE'];}else{ echo $rQC['no_order']; } ?></td>
      <td><?php echo $jns; ?></td>
      <td><?php echo $itemNo; ?></td>
      <td><?php echo $rowdb21['DECOSUBCODE05']; ?></td>
      <td><?php echo $rowdb23['LONGDESCRIPTION']; ?></td>
      <td>'<?php echo $rowdb21['ELEMENTSCODE'];?></td>
      <td>'<?php echo $rowdb21['LOTCODE'];?></td>
      <td><?php echo number_format(round($rowdb21['BASEPRIMARYQUANTITYUNIT'],2),2);?></td>
      <td><?php echo $rowdb21['BASEPRIMARYUNITCODE'];?></td>
      <td><?php echo $grade;?></td>
      <td><?php echo number_format(round($rowdb21['BASESECONDARYQUANTITYUNIT'],2),2);?></td>
      <td><?php echo $rowdb21['BASESECONDARYUNITCODE'];?></td>
      <td><?php echo $rowdb21['WHSLOCATIONWAREHOUSEZONECODE'];?></td>
      <td><?php echo $rowdb21['WAREHOUSELOCATIONCODE'];?></td>
	  <td><?php echo round($rowdb27['VALUEDECIMAL']);?></td>
      <td><?php echo round($rowdb28['VALUEDECIMAL']);?></td> 	  
      <td><?php echo $sts; ?></td>
      </tr>				  
<?php	$no++;
		$totkg=$totkg+$rowdb21['BASEPRIMARYQUANTITYUNIT'];
		if(trim($rowdb21['BASESECONDARYUNITCODE'])=="yd"){$tyd=$rowdb21['BASESECONDARYQUANTITYUNIT'];}else{$tyd=0;}
		$totyd=$totyd+$tyd;
		if(trim($rowdb21['BASESECONDARYUNITCODE'])=="m"){$tmtr=$rowdb21['BASESECONDARYQUANTITYUNIT'];}else{$tmtr=0;}
		$totmtr=$totmtr+$tmtr;
	} ?>
				  </tbody>
				<tfoot>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><strong>TOTAL</strong></td>
                    <td><strong><?php echo $no-1; ?> Roll</strong></td>
                    <td><strong><?php echo number_format(round($totkg,2),2); ?></strong></td>
                    <td><strong>KGs</strong></td>
                    <td>&nbsp;</td>
                    <td><strong><?php echo number_format(round($totyd,2),2); ?></strong></td>
                    <td><strong>YDs</strong></td>
                    <td><strong><?php echo number_format(round($totmtr,2),2); ?></strong></td>
                    <td><strong>MTRs</strong></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>  
                    <td>&nbsp;</td>
                    </tr>
                  </tfoot>                  
                </table>