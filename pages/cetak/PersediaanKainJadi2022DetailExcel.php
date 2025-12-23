<?php
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=persediaankainjadi2022Detail.xls"); //ganti nama sesuai keperluan
	header("Pragma: no-cache");
	header("Expires: 0");
	// disini script laporan anda
?>
<?php
	include "../../koneksi.php";
	ini_set("error_reporting", 1);
?>
<table>
                  
                  <tr>
                    <th>Tgl Mutasi</th>
                    <th>Tgl Update</th>
                    <th>Item</th>
                    <th>Langganan</th>
                    <th>Buyer</th>
                    <th>PO</th>
                    <th>Order</th>
                    <th>Tipe</th>
                    <th>Tgl Delivery</th>
                    <th>No Item</th>
                    <th>Jns Kain</th>
                    <th>No Warna</th>
                    <th>Warna</th>
                    <th>Rol</th>
                    <th>Lot</th>
                    <th>Weight</th>
                    <th>Satuan</th>
                    <th>Length</th>
                    <th>Satuan</th>
                    <th>Zone</th>
                    <th>Lokasi</th>
                    <th>Lebar</th>
                    <th>Gramasi</th>
                    <th>Grouping</th>
                    <th>Hue</th>
                    <th>ElementsCode</th>
                    <th>Status</th>
                    </tr>
				  <?php	
   $no=1;   
   $c=0;
	$sqlDB21 = " SELECT 
			SUM(b.BASEPRIMARYQUANTITYUNIT) AS BERAT,
			SUM(b.BASESECONDARYQUANTITYUNIT) AS YD,
			COUNT(b.BASESECONDARYQUANTITYUNIT) AS ROLL,
			SUBSTR(b.CREATIONDATETIME,1,10) AS TGLCREATE,
			SUBSTR(b.LASTUPDATEDATETIME,1,10) AS TGLUPDATE,
			SUBSTR(b.PROJECTCODE,4,2) AS THN,
			mk.TRANSACTIONDATE,
			b.ELEMENTSCODE,
			b.LOTCODE,
			b.PROJECTCODE,
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
			p.LONGDESCRIPTION AS JNSKAIN ,
			t.QUALITYREASONCODE AS KET,
			Q1.LONGDESCRIPTION AS STS1 
		FROM 
		BALANCE b LEFT OUTER JOIN (SELECT * FROM (
		SELECT
			ITEMELEMENTCODE,
			QUALITYREASONCODE,
			CREATIONDATETIME,
			ROW_NUMBER() OVER (PARTITION BY ITEMELEMENTCODE
		ORDER BY
			CREATIONDATETIME DESC,TRANSACTIONDETAILNUMBER DESC) AS RN
		FROM
			STOCKTRANSACTION
		WHERE
			(ITEMTYPECODE = 'FKF'
				OR ITEMTYPECODE = 'KFF')
			AND 
	LOGICALWAREHOUSECODE = 'M031') T
	WHERE T.RN='1') t
	ON
		b.ELEMENTSCODE = t.ITEMELEMENTCODE
	LEFT OUTER JOIN QUALITYREASON Q1 ON
	t.QUALITYREASONCODE = Q1.CODE	
		LEFT OUTER JOIN (
		 
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
		AND (ITEMTYPECODE='KFF' OR ITEMTYPECODE='FKF') 
		) QCF
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
		AND (ITEMTYPECODE='KFF' OR ITEMTYPECODE='FKF') 
		) GKJ
ON
	QCF.TRANSACTIONNUMBER = GKJ.TRANSACTIONNUMBER

		) mk ON b.ELEMENTSCODE =mk.ITEMELEMENTCODE		
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
		AND (TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%W1%' OR 
		TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%W3%' OR 
		TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%X1%' OR 
		TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%X2%' OR
		TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%X6%')
		AND SUBSTR(b.PROJECTCODE,4,2) < '23' 
		AND LENGTH(trim(b.PROJECTCODE)) = '10'
GROUP BY b.ELEMENTSCODE,b.ITEMTYPECODE,b.DECOSUBCODE01,
b.DECOSUBCODE02,b.DECOSUBCODE03,
b.DECOSUBCODE04,b.DECOSUBCODE05,
b.DECOSUBCODE06,b.DECOSUBCODE07,
b.DECOSUBCODE08,b.PROJECTCODE,b.LOTCODE,SUBSTR(b.PROJECTCODE,4,2),
b.BASEPRIMARYUNITCODE,b.BASESECONDARYUNITCODE,
b.WHSLOCATIONWAREHOUSEZONECODE,b.WAREHOUSELOCATIONCODE,p.LONGDESCRIPTION, mk.TRANSACTIONDATE,t.QUALITYREASONCODE, Q1.LONGDESCRIPTION,SUBSTR(b.LASTUPDATEDATETIME,1,10),SUBSTR(b.CREATIONDATETIME,1,10) ";
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

$sqlDB23 = " SELECT i.WARNA FROM PRODUCT p
LEFT OUTER JOIN ITXVIEWCOLOR i ON
	   p.ITEMTYPECODE=i.ITEMTYPECODE  AND	
	   p.SUBCODE01=i.SUBCODE01  AND
       p.SUBCODE02=i.SUBCODE02 AND
       p.SUBCODE03=i.SUBCODE03 AND
	   p.SUBCODE04=i.SUBCODE04 AND
       p.SUBCODE05=i.SUBCODE05 AND
	   p.SUBCODE06=i.SUBCODE06 AND
       p.SUBCODE07=i.SUBCODE07 AND
	   p.SUBCODE08=i.SUBCODE08
WHERE	   
i.ITEMTYPECODE='$rowdb21[ITEMTYPECODE]' AND	
i.SUBCODE01='$rowdb21[DECOSUBCODE01]' AND
i.SUBCODE02='$rowdb21[DECOSUBCODE02]' AND
i.SUBCODE03='$rowdb21[DECOSUBCODE03]' AND
i.SUBCODE04='$rowdb21[DECOSUBCODE04]' AND
i.SUBCODE05='$rowdb21[DECOSUBCODE05]' AND
i.SUBCODE06='$rowdb21[DECOSUBCODE06]' AND
i.SUBCODE07='$rowdb21[DECOSUBCODE07]' AND
i.SUBCODE08='$rowdb21[DECOSUBCODE08]' ";
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
$sqlDB27 = " SELECT 
ADSTORAGE.VALUEDECIMAL AS GSM,
ADSTORAGE1.VALUEDECIMAL AS LEBAR
FROM DB2ADMIN.PRODUCT PRODUCT 
LEFT OUTER JOIN DB2ADMIN.ADSTORAGE ADSTORAGE 
ON ADSTORAGE.UNIQUEID=PRODUCT.ABSUNIQUEID AND ADSTORAGE.NAMENAME='GSM'
LEFT OUTER JOIN DB2ADMIN.ADSTORAGE ADSTORAGE1 
ON ADSTORAGE1.UNIQUEID=PRODUCT.ABSUNIQUEID AND ADSTORAGE1.NAMENAME='Width'
WHERE
       PRODUCT.ITEMTYPECODE='$rowdb21[ITEMTYPECODE]' AND	
	   PRODUCT.SUBCODE01='$rowdb21[DECOSUBCODE01]' AND
       PRODUCT.SUBCODE02='$rowdb21[DECOSUBCODE02]' AND
       PRODUCT.SUBCODE03='$rowdb21[DECOSUBCODE03]' AND
	   PRODUCT.SUBCODE04='$rowdb21[DECOSUBCODE04]' AND
       PRODUCT.SUBCODE05='$rowdb21[DECOSUBCODE05]' AND
	   PRODUCT.SUBCODE06='$rowdb21[DECOSUBCODE06]' AND
       PRODUCT.SUBCODE07='$rowdb21[DECOSUBCODE07]' AND
	   PRODUCT.SUBCODE08='$rowdb21[DECOSUBCODE08]'  ";
	$stmt7   = db2_exec($conn1,$sqlDB27, array('cursor'=>DB2_SCROLLABLE));
	$rowdb27 = db2_fetch_assoc($stmt7);	
		
$q_deliverydate	= db2_exec($conn1, " SELECT
	SUBSTR(LISTAGG(DELIVERYDATE, ', ') WITHIN GROUP (ORDER BY DELIVERYDATE), LENGTH(LISTAGG(DELIVERYDATE, ', ') WITHIN GROUP (ORDER BY DELIVERYDATE)) - 9) AS DELIVERYDATE
FROM
	(
	SELECT
		DISTINCT 
        DELIVERYDATE
	FROM
		SALESORDERDELIVERY
												WHERE
													SALESORDERLINESALESORDERCODE = '$rowdb21[PROJECTCODE]'
													AND ITEMTYPEAFICODE = '$rowdb21[ITEMTYPECODE]'
													AND SUBCODE01 = '$rowdb21[DECOSUBCODE01]'
													AND SUBCODE02 = '$rowdb21[DECOSUBCODE02]'
													AND SUBCODE03 = '$rowdb21[DECOSUBCODE03]'
													AND SUBCODE04 = '$rowdb21[DECOSUBCODE04]'
													AND SUBCODE05 = '$rowdb21[DECOSUBCODE05]'
													AND SUBCODE06 = '$rowdb21[DECOSUBCODE06]'
													AND SUBCODE07 = '$rowdb21[DECOSUBCODE07]'
													AND SUBCODE08 = '$rowdb21[DECOSUBCODE08]'
													)");
		$row_deliverydate	= db2_fetch_assoc($q_deliverydate);			
$sqlDB28 = " SELECT
   QUALITYDOCLINE.VALUEGROUPCODE  AS GROUPING1 ,HUE.VALUEGROUPCODE AS HUE1
FROM
    QUALITYDOCLINE 
LEFT OUTER JOIN 
(SELECT
  QUALITYDOCPRODUCTIONORDERCODE,VALUEGROUPCODE
FROM
    QUALITYDOCLINE
WHERE
	QUALITYDOCLINE.QUALITYDOCUMENTHEADERNUMBERID ='1005' AND
    QUALITYDOCLINE.CHARACTERISTICCODE = 'HUE' AND 
	QUALITYDOCUMENTITEMTYPEAFICODE ='KFF' AND 
	QUALITYDOCLINE.QUALITYDOCPRODUCTIONORDERCODE='".$rowdb21['LOTCODE']."'
	) HUE ON HUE.QUALITYDOCPRODUCTIONORDERCODE=QUALITYDOCLINE.QUALITYDOCPRODUCTIONORDERCODE
WHERE
	QUALITYDOCLINE.QUALITYDOCUMENTHEADERNUMBERID ='1005'  AND
	QUALITYDOCLINE.CHARACTERISTICCODE = 'GROUPING' AND
	QUALITYDOCUMENTITEMTYPEAFICODE ='KFF' AND
	QUALITYDOCLINE.QUALITYDOCPRODUCTIONORDERCODE='".$rowdb21['LOTCODE']."' ";
$stmt8   = db2_exec($conn1,$sqlDB28, array('cursor'=>DB2_SCROLLABLE));
$rowdb28 = db2_fetch_assoc($stmt8);		
		
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
	    <td><?php echo $rowdb21['TRANSACTIONDATE']; ?></td>
	    <td><?php if($rowdb21['TGLUPDATE']!=""){echo $rowdb21['TGLUPDATE'];}else{echo $rowdb21['TGLCREATE'];} ?></td>
	  <td><?php echo $item; ?></td>
      <td><?php echo $langganan; ?></td>
      <td><?php echo $buyer; ?></td>
      <td><?php echo $PO; ?></td>
      <td><?php echo $rowdb21['PROJECTCODE']; ?></td>
      <td><?php echo $jns; ?></td>
      <td><?php echo $row_deliverydate['DELIVERYDATE']; ?></td>
      <td><?php echo $itemNo; ?></td>
      <td><?php echo $rowdb21['JNSKAIN'];?></td>
      <td><?php echo $rowdb21['DECOSUBCODE05']; ?></td>
      <td><?php echo $rowdb23['WARNA']; ?></td>
      <td><?php echo $rowdb21['ROLL'];?></td>
      <td>'<?php echo $rowdb21['LOTCODE'];?></td>
      <td><?php echo number_format(round($rowdb21['BERAT'],2),2);?></td>
      <td><?php echo $rowdb21['BASEPRIMARYUNITCODE'];?></td>
      <td><?php echo number_format(round($rowdb21['YD'],2),2);?></td>
      <td><?php echo $rowdb21['BASESECONDARYUNITCODE'];?></td>
      <td><?php echo $rowdb21['WHSLOCATIONWAREHOUSEZONECODE'];?></td>
      <td><?php echo $rowdb21['WAREHOUSELOCATIONCODE'];?></td>
      <td><?php echo round($rowdb27['LEBAR']);?></td>
      <td><?php echo round($rowdb27['GSM']);?></td>
      <td><?php echo $rowdb28['GROUPING1']; ?></td>
      <td><?php echo $rowdb28['HUE1']; ?></td>
      <td>'<?php echo $rowdb21['ELEMENTSCODE'];?></td>
      <td><?php echo $sts1; ?></td>
      </tr>				  
<?php	$no++;
		$totrol=$totrol+$rowdb21['ROLL'];
		$totkg=$totkg+$rowdb21['BERAT'];
		if(trim($rowdb21['BASESECONDARYUNITCODE'])=="yd"){$tyd=$rowdb21['YD'];}else{$tyd=0;}
		$totyd=$totyd+$tyd;
		if(trim($rowdb21['BASESECONDARYUNITCODE'])=="m"){$tmtr=$rowdb21['YD'];}else{$tmtr=0;}
		$totmtr=$totmtr+$tmtr;
	
	
	} ?>
				  >
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
					<td>TOTAL</td>
                    <td><?php echo $totrol; ?></td>  
                    <td></td>                    
                    <td><?php echo number_format(round($totkg,2),2); ?></td>
                    <td>KGs</td>
                    <td><?php echo number_format(round($totyd,2),2); ?></td>
                    <td>YDs</strong></td>
                    <td><?php echo number_format(round($totmtr,2),2); ?></td>
                    <td>MTRs</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>  
                    </tr> 
                </table>