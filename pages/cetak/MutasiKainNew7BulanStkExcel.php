<?php
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=MutasiKainNew7PerBulanSTK".$_GET['awal']."_".$_GET['akhir'].".xls"); //ganti nama sesuai keperluan
	header("Pragma: no-cache");
	header("Expires: 0");
	// disini script laporan anda
?>
<?php
$Awal	= isset($_GET['awal']) ? $_GET['awal'] : '';
$Akhir	= isset($_GET['akhir']) ? $_GET['akhir'] : '';
?>
<?php
	include "../../koneksi.php";
	ini_set("error_reporting", 1);
?>
<table id="example1" class="table table-sm table-bordered table-striped" style="font-size:13px;">
                  <thead>
                  <tr>
                    <th style="text-align: center">&nbsp;</th>
                    <th style="text-align: center">&nbsp;</th>
                    <th style="text-align: center">&nbsp;</th>
                    <th style="text-align: center">&nbsp;</th>
                    <th style="text-align: center">&nbsp;</th>
                    <th style="text-align: center">&nbsp;</th>
                    <th style="text-align: center">&nbsp;</th>
                    <th style="text-align: center">&nbsp;</th>
                    <th style="text-align: center">&nbsp;</th>
                    <th style="text-align: center">&nbsp;</th>
                    <th style="text-align: center">&nbsp;</th>
                    <th style="text-align: center">&nbsp;</th>
                    <th style="text-align: center">&nbsp;</th>
                    <th colspan="4" style="text-align: center">Masuk</th>
                    <th colspan="4" style="text-align: center">Stok</th>
                    </tr>
                  <tr>
                    <th style="text-align: center">TglMasuk</th>
                    <th style="text-align: center">Tipe</th>
                    <th style="text-align: center">Item</th>
                    <th style="text-align: center">No Warna</th>
                    <th style="text-align: center">Warna</th>
                    <th style="text-align: center">Buyer</th>
                    <th style="text-align: center">Customer</th>
                    <th style="text-align: center">No PO</th>
                    <th style="text-align: center">No Order</th>
                    <th style="text-align: center">Jenis Kain</th>
                    <th style="text-align: center">Lebar</th>
                    <th style="text-align: center">Gramasi</th>
                    <th style="text-align: center">Lot</th>
                    <th style="text-align: center">Roll</th>
                    <th style="text-align: center">Qty(KG)</th>
                    <th style="text-align: center">Lokasi</th>
                    <th style="text-align: center">Status</th>
                    <th style="text-align: center">Roll</th>
                    <th style="text-align: center">Qty(KG)</th>
                    <th style="text-align: center">Lokasi</th>
                    <th style="text-align: center">Status</th>
                    </tr>
                  </thead>
                  <tbody>
<?php   					  
   $no=1;   
   $c=0;
$sqlDB21 = " SELECT
	STOCKTRANSACTION.TRANSACTIONDATE,
	STOCKTRANSACTION.ITEMTYPECODE,
	STOCKTRANSACTION.DECOSUBCODE01,
	STOCKTRANSACTION.DECOSUBCODE02,
	STOCKTRANSACTION.DECOSUBCODE03,
	STOCKTRANSACTION.DECOSUBCODE04,
	STOCKTRANSACTION.DECOSUBCODE05,
	STOCKTRANSACTION.DECOSUBCODE06,
	STOCKTRANSACTION.DECOSUBCODE07,
	STOCKTRANSACTION.DECOSUBCODE08,
	COUNT(STOCKTRANSACTION.BASEPRIMARYQUANTITY) AS ROL,
	SUM(STOCKTRANSACTION.BASEPRIMARYQUANTITY) AS KGS,
	STOCKTRANSACTION.LOTCODE,
	STOCKTRANSACTION.PROJECTCODE,
	LISTAGG(DISTINCT TRIM(STOCKTRANSACTION.WHSLOCATIONWAREHOUSEZONECODE),
	',') AS ZN,
	LISTAGG(DISTINCT TRIM(STOCKTRANSACTION.WAREHOUSELOCATIONCODE),
	',') AS LK,
	STOCKTRANSACTION.QUALITYREASONCODE,
	QUALITYREASON.LONGDESCRIPTION,
	COUNT(BALANCE.BASEPRIMARYQUANTITYUNIT) AS ROL_BALANCE,
	SUM(BALANCE.BASEPRIMARYQUANTITYUNIT) AS KGS_BALANCE,
	LISTAGG(DISTINCT TRIM(BALANCE.WHSLOCATIONWAREHOUSEZONECODE),
	',') AS ZN_BALANCE,
	LISTAGG(DISTINCT TRIM(BALANCE.WAREHOUSELOCATIONCODE),
	',') AS LK_BALANCE,
	BALANCE.QUALITYREASONCODE AS KET,
	Q1.LONGDESCRIPTION AS STS1
FROM
	(
	SELECT
		GKJ.*
	FROM
		(
		SELECT
			*
		FROM
			STOCKTRANSACTION s
		WHERE
			TRANSACTIONDETAILNUMBER = '1'
			AND TEMPLATECODE = '303'
			AND LOGICALWAREHOUSECODE = 'M033'
			AND (ITEMTYPECODE = 'KFF'
				OR ITEMTYPECODE = 'FKF')
			AND TRIM(TRANSACTIONDATE) BETWEEN '$Awal' AND '$Akhir') QCF
	INNER JOIN  
(
		SELECT
			*
		FROM
			STOCKTRANSACTION s
		WHERE
			TRANSACTIONDETAILNUMBER = '2'
			AND TEMPLATECODE = '304'
			AND LOGICALWAREHOUSECODE = 'M031'
			AND (ITEMTYPECODE = 'KFF'
				OR ITEMTYPECODE = 'FKF')
			AND TRIM(TRANSACTIONDATE) BETWEEN '$Awal' AND '$Akhir') GKJ
ON
		QCF.TRANSACTIONNUMBER = GKJ.TRANSACTIONNUMBER
) STOCKTRANSACTION
LEFT OUTER JOIN (
	SELECT
		*
	FROM
		(
		SELECT
			ITEMELEMENTCODE,
			QUALITYREASONCODE,
			CREATIONDATETIME,
			ROW_NUMBER() OVER (PARTITION BY ITEMELEMENTCODE
		ORDER BY
			CREATIONDATETIME DESC) AS RN
		FROM
			STOCKTRANSACTION
		WHERE
			(ITEMTYPECODE = 'FKF'
				OR ITEMTYPECODE = 'KFF')
			AND 
	LOGICALWAREHOUSECODE = 'M031') T
	INNER JOIN BALANCE B ON
		B.ELEMENTSCODE = T.ITEMELEMENTCODE
	WHERE
		T.RN = '1'
	) BALANCE ON
	BALANCE.ELEMENTSCODE = STOCKTRANSACTION.ITEMELEMENTCODE
LEFT OUTER JOIN QUALITYREASON ON
	STOCKTRANSACTION.QUALITYREASONCODE = QUALITYREASON.CODE
LEFT OUTER JOIN QUALITYREASON Q1 ON
	BALANCE.QUALITYREASONCODE = Q1.CODE	
 WHERE
 TIMESTAMP(STOCKTRANSACTION.TRANSACTIONDATE,STOCKTRANSACTION.TRANSACTIONTIME) BETWEEN '$Awal 07:00:00' AND '$Akhir 08:00:00'
GROUP BY
	STOCKTRANSACTION.LOTCODE,
	STOCKTRANSACTION.TRANSACTIONDATE,
	STOCKTRANSACTION.ITEMTYPECODE,
	STOCKTRANSACTION.DECOSUBCODE01,
	STOCKTRANSACTION.DECOSUBCODE02,
	STOCKTRANSACTION.DECOSUBCODE03,
	STOCKTRANSACTION.DECOSUBCODE04,
	STOCKTRANSACTION.DECOSUBCODE05,
	STOCKTRANSACTION.DECOSUBCODE06,
	STOCKTRANSACTION.DECOSUBCODE07,
	STOCKTRANSACTION.DECOSUBCODE08,
	STOCKTRANSACTION.PROJECTCODE,
	STOCKTRANSACTION.WHSLOCATIONWAREHOUSEZONECODE,
	STOCKTRANSACTION.WAREHOUSELOCATIONCODE,
	STOCKTRANSACTION.QUALITYREASONCODE,
	QUALITYREASON.LONGDESCRIPTION,
	BALANCE.QUALITYREASONCODE,
	Q1.LONGDESCRIPTION 
 ";
	$stmt1   = db2_exec($conn1,$sqlDB21, array('cursor'=>DB2_SCROLLABLE));
	//}				  
    while($rowdb21 = db2_fetch_assoc($stmt1)){
	
	$sqlDB23 = " SELECT s.EXTERNALREFERENCE AS PO_HEADER ,s2.EXTERNALREFERENCE AS PO_LINE,i.PROJECTCODE FROM ITXVIEWKK i 
LEFT OUTER JOIN SALESORDER s ON i.PROJECTCODE =s.CODE 
LEFT OUTER JOIN SALESORDERLINE s2 ON i.PROJECTCODE =s2.SALESORDERCODE AND i.ORDERLINE =s2.ORDERLINE  
WHERE i.PRODUCTIONORDERCODE ='$rowdb21[LOTCODE]' ";
	$stmt3   = db2_exec($conn1,$sqlDB23, array('cursor'=>DB2_SCROLLABLE));
	$rowdb23 = db2_fetch_assoc($stmt3);		
		if($rowdb21['PROJECTCODE']!=""){$PJCODE=$rowdb21['PROJECTCODE'];}else{ $PJCODE= $rowdb23['PROJECTCODE'];}
	$sqlDB22 = " SELECT SALESORDER.CODE, SALESORDER.EXTERNALREFERENCE, SALESORDER.ORDPRNCUSTOMERSUPPLIERCODE,
		ITXVIEWAKJ.LEGALNAME1, ITXVIEWAKJ.ORDERPARTNERBRANDCODE, ITXVIEWAKJ.LONGDESCRIPTION
		FROM DB2ADMIN.SALESORDER SALESORDER LEFT OUTER JOIN DB2ADMIN.ITXVIEWAKJ 
       	ITXVIEWAKJ ON SALESORDER.CODE=ITXVIEWAKJ.CODE
		WHERE SALESORDER.CODE='$PJCODE' ";
		
	$stmt2   = db2_exec($conn1,$sqlDB22, array('cursor'=>DB2_SCROLLABLE));
	$rowdb22 = db2_fetch_assoc($stmt2);	
	if($rowdb22['LEGALNAME1']==""){$langganan="";}else{$langganan=$rowdb22['LEGALNAME1'];}
	if($rowdb22['ORDERPARTNERBRANDCODE']==""){$buyer="";}else{$buyer=$rowdb22['LONGDESCRIPTION'];}
		
	$sqlDB24 = " SELECT PRODUCT.SHORTDESCRIPTION FROM PRODUCT WHERE
		ITEMTYPECODE='$rowdb21[ITEMTYPECODE]' AND
		SUBCODE01='$rowdb21[DECOSUBCODE01]' AND
		SUBCODE02='$rowdb21[DECOSUBCODE02]' AND
		SUBCODE03='$rowdb21[DECOSUBCODE03]' AND
		SUBCODE04='$rowdb21[DECOSUBCODE04]' AND
		SUBCODE05='$rowdb21[DECOSUBCODE05]' 
		";
	$stmt4   = db2_exec($conn1,$sqlDB24, array('cursor'=>DB2_SCROLLABLE));
	$rowdb24 = db2_fetch_assoc($stmt4);			
		
	$sqlDB25 = " SELECT ITXVIEWRESEPCOLOR.LONGDESCRIPTION FROM ITXVIEWRESEPCOLOR WHERE
		ITXVIEWRESEPCOLOR.NO_WARNA='$rowdb21[DECOSUBCODE05]' AND
		ITXVIEWRESEPCOLOR.ARTIKEL='$rowdb21[DECOSUBCODE03]' ";
	$stmt5   = db2_exec($conn1,$sqlDB25, array('cursor'=>DB2_SCROLLABLE));
	$rowdb25 = db2_fetch_assoc($stmt5);	
		
	$sqlDB26 = " SELECT DESIGN.SUBCODE01,
	   DESIGNCOMPONENT.VARIANTCODE,
       DESIGNCOMPONENT.SHORTDESCRIPTION 
	   FROM DB2ADMIN.DESIGN DESIGN LEFT OUTER JOIN DB2ADMIN.DESIGNCOMPONENT 
       DESIGNCOMPONENT ON DESIGN.NUMBERID=DESIGNCOMPONENT.DESIGNNUMBERID AND 
       DESIGN.SUBCODE01=DESIGNCOMPONENT.DESIGNSUBCODE01 
	   WHERE DESIGN.SUBCODE01='$rowdb21[DECOSUBCODE07]' AND
	   DESIGNCOMPONENT.VARIANTCODE='$rowdb21[DECOSUBCODE08]' ";
	$stmt6   = db2_exec($conn1,$sqlDB26, array('cursor'=>DB2_SCROLLABLE));
	$rowdb26 = db2_fetch_assoc($stmt6);
		if(trim($rowdb21['ITEMTYPECODE'])=="FKF"){
			$pos=strpos($rowdb24['SHORTDESCRIPTION'],"-");
			$warna=substr($rowdb24['SHORTDESCRIPTION'],0,$pos);
		}
		else if(trim($rowdb21['DECOSUBCODE07'])=="-" and trim($rowdb21['DECOSUBCODE08'])=="-"){
			$warna=$rowdb25['LONGDESCRIPTION'];
		}else if(trim($rowdb21['DECOSUBCODE07'])!="-" and trim($rowdb21['DECOSUBCODE08'])!="-"){
			$warna=$rowdb26['SHORTDESCRIPTION'];
		}
		$sqlDB27 = " SELECT PRODUCT.SHORTDESCRIPTION FROM PRODUCT WHERE
		ITEMTYPECODE='$rowdb21[ITEMTYPECODE]' AND
		SUBCODE01='$rowdb21[DECOSUBCODE01]' AND
		SUBCODE02='$rowdb21[DECOSUBCODE02]' AND
		SUBCODE03='$rowdb21[DECOSUBCODE03]' AND
		SUBCODE04='$rowdb21[DECOSUBCODE04]' AND
		SUBCODE05='$rowdb21[DECOSUBCODE05]' AND
		SUBCODE06='$rowdb21[DECOSUBCODE06]' AND
		SUBCODE07='$rowdb21[DECOSUBCODE07]' AND
		SUBCODE08='$rowdb21[DECOSUBCODE08]' 
		";
	$stmt7   = db2_exec($conn1,$sqlDB27, array('cursor'=>DB2_SCROLLABLE));
	$rowdb27 = db2_fetch_assoc($stmt7);
	$sqlDB28 = " SELECT ORDERITEMORDERPARTNERLINK.ORDPRNCUSTOMERSUPPLIERCODE,
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
	$stmt8   = db2_exec($conn1,$sqlDB28, array('cursor'=>DB2_SCROLLABLE));
	$rowdb28 = db2_fetch_assoc($stmt8);	
	if($rowdb28['LONGDESCRIPTION']!=""){
		$item=$rowdb28['LONGDESCRIPTION'];
	}else{
		$item=trim($rowdb21['DECOSUBCODE02'])."".trim($rowdb21['DECOSUBCODE03']);
	}
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
	if ($rowdb21['QUALITYREASONCODE']!="" and $rowdb21['QUALITYREASONCODE']!="100"){
		$sts=$rowdb21['LONGDESCRIPTION'];}	
	else if ((substr(trim($rowdb21['PROJECTCODE']),0,3)=="OPN" or substr(trim($rowdb21['PROJECTCODE']),0,3)=="STO") and $rowdb21['QUALITYREASONCODE']=="100"){
		$sts="Booking";}	
	else if (substr(trim($rowdb21['PROJECTCODE']),0,3)=="OPN" or substr(trim($rowdb21['PROJECTCODE']),0,3)=="STO" ){
		$sts="Booking";}	
	else if (substr(trim($rowdb21['PROJECTCODE']),0,3)=="RPE" and $rowdb21['QUALITYREASONCODE']=="100"){
		$sts="Ganti Kain";  }	
	else if (substr(trim($rowdb21['PROJECTCODE']),0,3)=="RPE"){
		$sts="Ganti Kain";  }
	else {
		$sts="Tunggu Kirim"; } 
		
	if ($rowdb21['KET']!="" and $rowdb21['KET']!="100"){
		$sts1=$rowdb21['STS1'];}	
	else if ((substr(trim($rowdb21['PROJECTCODE']),0,3)=="OPN" or substr(trim($rowdb21['PROJECTCODE']),0,3)=="STO") and $rowdb21['KET']=="100"){
		$sts1="Booking";}	
	else if (substr(trim($rowdb21['PROJECTCODE']),0,3)=="OPN" or substr(trim($rowdb21['PROJECTCODE']),0,3)=="STO" ){
		$sts1="Booking";}	
	else if (substr(trim($rowdb21['PROJECTCODE']),0,3)=="RPE" and $rowdb21['KET']=="100"){
		$sts1="Ganti Kain";  }	
	else if (substr(trim($rowdb21['PROJECTCODE']),0,3)=="RPE"){
		$sts1="Ganti Kain";  }
	else {
		$sts1="Tunggu Kirim"; } 	
?>
	  <tr>
	  <td style="text-align: center"><?php echo substr($rowdb21['TRANSACTIONDATE'],0,10); ?></td>
	  <td style="text-align: left"><?php if($rowdb21['ITEMTYPECODE']=="KFF"){echo "KAIN"; }else{echo "KRAH";}?></td>
      <td style="text-align: left"><?php echo $item; ?></td>
      <td style="text-align: left"><?php echo $rowdb21['DECOSUBCODE05']; ?></td>
      <td style="text-align: left"><?php echo $warna; ?></td>
      <td style="text-align: left"><?php echo $buyer; ?></td>
      <td style="text-align: left"><?php echo $langganan; ?></td>
      <td style="text-align: left"><?php if($rowdb23['PO_HEADER']!=""){echo $rowdb23['PO_HEADER'];}else{echo $rowdb23['PO_LINE'];} ?></td>
      <td style="text-align: center"><?php echo $PJCODE; ?></td>
      <td style="text-align: left"><?php echo $rowdb27['SHORTDESCRIPTION']; ?></td>
      <td style="text-align: center"><?php echo round($rowdb29['VALUEDECIMAL']);?></td>
      <td style="text-align: center"><?php echo round($rowdb30['VALUEDECIMAL']);?></td>
      <td style="text-align: right"><span style="text-align: center"><?php echo $rowdb21['LOTCODE']; ?></span></td>
      <td style="text-align: center"><?php echo $rowdb21['ROL']; ?></td>
      <td style="text-align: right"><?php echo number_format(round($rowdb21['KGS'],2),2); ?></td>
      <td style="text-align: center"><?php echo $rowdb21['LK']; ?></td>
      <td style="text-align: center"><?php echo $sts; ?></td>
      <td style="text-align: center"><?php echo $rowdb21['ROL_BALANCE']; ?></td>
      <td style="text-align: right"><?php echo number_format(round($rowdb21['KGS_BALANCE'],2),2); ?></td>
      <td style="text-align: center"><?php echo $rowdb21['LK_BALANCE']; ?></td>
      <td style="text-align: center"><?php echo $sts1; ?></td>
      </tr>
	  				  
<?php	$no++;
	$tRol += $rowdb21['ROL'];
	$tKg +=	$rowdb21['KGS'];
	$tRolB += $rowdb21['ROL_BALANCE'];
	$tKgB +=	$rowdb21['KGS_BALANCE'];
	} ?>
				  </tbody>
      <tfoot>
	  <tr>
	    <td style="text-align: center">&nbsp;</td>
	    <td style="text-align: left">&nbsp;</td>
	    <td style="text-align: left">&nbsp;</td>
	    <td style="text-align: left">&nbsp;</td>
	    <td style="text-align: left">&nbsp;</td>
	    <td style="text-align: left">&nbsp;</td>
	    <td style="text-align: left">&nbsp;</td>
	    <td style="text-align: left">&nbsp;</td>
	    <td style="text-align: center">&nbsp;</td>
	    <td style="text-align: left">&nbsp;</td>
	    <td style="text-align: right">&nbsp;</td>
	    <td style="text-align: right">&nbsp;</td>
	    <td style="text-align: right"><span style="text-align: left"><strong>Total</strong></span></td>
	    <td style="text-align: center"><strong><?php echo $tRol; ?></strong></td>
	    <td style="text-align: right"><strong><?php echo number_format(round($tKg,2),2); ?></strong></td>
	    <td style="text-align: center">&nbsp;</td>
	    <td style="text-align: center">&nbsp;</td>
	    <td style="text-align: center"><strong><?php echo $tRolB; ?></strong></td>
	    <td style="text-align: right"><strong><?php echo number_format(round($tKgB,2),2); ?></strong></td>
	    <td style="text-align: center">&nbsp;</td>
	    <td style="text-align: center">&nbsp;</td>
	    </tr>		  
			  </tfoot>            
                </table>