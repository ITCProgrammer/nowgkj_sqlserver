<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=persediaanKainDetail_".$_GET['buyer']."_".$_GET['zone'].".xls");//ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");
//disini script laporan anda
?>
<?php
include "../../koneksi.php";
ini_set("error_reporting", 1);
?>
<?php
$Buyer1		= isset($_GET['buyer']) ? $_GET['buyer'] : '';
$Project	= isset($_GET['project']) ? $_GET['project'] : '';
$POno		= isset($_GET['pono']) ? $_GET['pono'] : '';
$Item		= isset($_GET['itemno']) ? $_GET['itemno'] : '';
$NoWarna	= isset($_GET['warnano']) ? $_GET['warnano'] : '';
$Zone		= isset($_GET['zone']) ? $_GET['zone'] : '';
?>
<table id="" class="" style=""><thead><tr><th>NO</th><th>TGLMasuk</th><th>TGLUpdate</th><th>Item</th><th>Langganan</th>
<th>Buyer</th><th>PO</th><th>Order</th><th>Tipe</th><th>No Item</th><th>No Warna</th>
                    <th>Warna</th>
                    <th>Lot</th>
                    <th>Element</th>
                    <th>Weight</th>
                    <th >Satuan</th>
                    <th >Grade</th>
                    <th >Length</th>
                    <th >Satuan</th>
                    <th >Zone</th>
                    <th >Lokasi</th>
                    <th >Lebar</th>
                    <th >Gramasi</th>
                    <th >Status</th>
                    </tr>
                  </thead>
                  <tbody>
				  <?php			  
   if($Project!=""){				  
	$WProject= " AND BALANCE.PROJECTCODE='$Project' " ;		
	}else{
	$WProject= " " ;	
	}
	
	if($Buyer1!=""){
	$WBuyer= " AND SALESORDER.ORDERPARTNERBRANDCODE LIKE '%$Buyer1%' " ;	
	}else{
	$WBuyer= " ";	
	}
	
	if($NoWarna!=""){
	$WNoWarna= " AND BALANCE.DECOSUBCODE05='$NoWarna' " ;	
	}else{
	$WNoWarna= " ";	
	}
	if($Item!=""){
	$WNoItem= " AND CONCAT(trim(BALANCE.DECOSUBCODE02),CONCAT('',trim(BALANCE.DECOSUBCODE03)))='$Item' " ;	
	}else{
	$WNoItem= " ";	
	}	
	if($Zone!=""){
	$WZone= " AND TRIM(BALANCE.WHSLOCATIONWAREHOUSEZONECODE)='$Zone' " ;	
	}else{
	$WZone= " ";	
	}			  
					  
	if($Project=="" and $Buyer1=="" and $NoWarna=="" and $Item=="" and $Zone==""){
		$WKosong= " AND SALESORDER.ORDERPARTNERBRANDCODE AND SALESORDER.CODE='' AND TRIM(BALANCE.WHSLOCATIONWAREHOUSEZONECODE)='' " ;
	}					  
   $no=1;   
   $c=0;
	$sqlDB21 = " SELECT
                            VARCHAR_FORMAT(BALANCE.CREATIONDATETIME, 'yyyy-mm-dd') AS TGL_BALANCE,
                            trim(BALANCE.DECOSUBCODE02) || trim(BALANCE.DECOSUBCODE03) AS NO_ITEM,
                            trim(BUSINESSPARTNER.LEGALNAME1) AS LANGGANAN,
                            CASE 
                                WHEN trim(SALESORDER.ORDERPARTNERBRANDCODE) IS NULL THEN 'Periksa kembali kolom BRAND di SALESORDER. User : ' || trim(SALESORDER.CREATIONUSER)
                                ELSE trim(SALESORDER.ORDERPARTNERBRANDCODE) 
                            END AS BUYER,
                            BALANCE.PROJECTCODE AS NO_ORDER,
                            trim(SALESORDERLINE.ITEMDESCRIPTION) AS JENIS_KAIN,
                            BALANCE.DECOSUBCODE05 AS NO_WARNA,
                            CASE 
                                WHEN trim(SALESORDER.REQUIREDDUEDATE) IS NULL THEN 'Periksa kembali kolom REQUEST DUE DATE & CONFIRM DUE DATE di SALESORDER. User : ' || trim(SALESORDER.CREATIONUSER)
                                ELSE VARCHAR_FORMAT(SALESORDER.REQUIREDDUEDATE, 'dd MONTH yyyy')
                            END AS DELIVERY,	
                            BALANCE.LOTCODE AS LOT,
                            BALANCE.ELEMENTSCODE AS SN ,
                            BALANCE.BASEPRIMARYQUANTITYUNIT AS KG,
							BALANCE.BASEPRIMARYUNITCODE AS SATUANKG,
                            CASE 
                                WHEN BALANCE.QUALITYLEVELCODE = '1' THEN 'A'
                                WHEN BALANCE.QUALITYLEVELCODE = '2' THEN 'B'
                                ELSE 'C'
                            END AS GRADE,
                            BALANCE.BASESECONDARYQUANTITYUNIT AS LENGTH,
                            BALANCE.BASESECONDARYUNITCODE AS SATUAN,
                            BALANCE.WHSLOCATIONWAREHOUSEZONECODE AS ZONA,
                            BALANCE.WAREHOUSELOCATIONCODE AS LOKASI,
                            trim(SALESORDER.CREATIONUSER) AS USER_SALESORDER,
							BALANCE.ITEMTYPECODE,
							BALANCE.DECOSUBCODE01,
							BALANCE.DECOSUBCODE02,
							BALANCE.DECOSUBCODE03,
							BALANCE.DECOSUBCODE04,
							BALANCE.DECOSUBCODE05,
							BALANCE.DECOSUBCODE06,
							BALANCE.DECOSUBCODE07,
							BALANCE.DECOSUBCODE08
                            
                        FROM
                            BALANCE BALANCE
                            LEFT JOIN SALESORDER SALESORDER ON BALANCE.PROJECTCODE = SALESORDER.CODE
                            LEFT JOIN ORDERPARTNER ORDERPARTNER ON ORDERPARTNER.CUSTOMERSUPPLIERCODE = SALESORDER.ORDPRNCUSTOMERSUPPLIERCODE
                            LEFT JOIN BUSINESSPARTNER BUSINESSPARTNER ON BUSINESSPARTNER.NUMBERID = ORDERPARTNER.ORDERBUSINESSPARTNERNUMBERID
                            LEFT JOIN PRODUCTIONRESERVATION PRODUCTIONRESERVATION ON PRODUCTIONRESERVATION.PRODUCTIONORDERCODE = BALANCE.LOTCODE AND PRODUCTIONRESERVATION.PROJECTCODE = BALANCE.PROJECTCODE 
                            LEFT JOIN PRODUCTIONDEMAND PRODUCTIONDEMAND ON PRODUCTIONDEMAND.CODE = PRODUCTIONRESERVATION.ORDERCODE 
                            LEFT JOIN SALESORDERLINE SALESORDERLINE ON SALESORDERLINE.SALESORDERCODE = BALANCE.PROJECTCODE 
                                    AND BALANCE.DECOSUBCODE01 = SALESORDERLINE.SUBCODE01 AND BALANCE.DECOSUBCODE02 = SALESORDERLINE.SUBCODE02 
                                    AND BALANCE.DECOSUBCODE03 = SALESORDERLINE.SUBCODE03 AND BALANCE.DECOSUBCODE04 = SALESORDERLINE.SUBCODE04 
                                    AND BALANCE.DECOSUBCODE05 = SALESORDERLINE.SUBCODE05 AND BALANCE.DECOSUBCODE06 = SALESORDERLINE.SUBCODE06 
                                    AND BALANCE.DECOSUBCODE07 = SALESORDERLINE.SUBCODE07 AND BALANCE.DECOSUBCODE08 = SALESORDERLINE.SUBCODE08 
                                    AND SALESORDERLINE.ORDERLINE = PRODUCTIONDEMAND.DLVSALESORDERLINEORDERLINE                            
                           
                        WHERE
                            (BALANCE.ITEMTYPECODE = 'KFF' OR BALANCE.ITEMTYPECODE = 'FKF') 
                            AND BALANCE.LOGICALWAREHOUSECODE = 'M031' 
                            AND NOT SALESORDER.CODE IS NULL 
							$WBuyer
							$WProject
							$WNoItem
							$WNoWarna
                            $WZone
							$WKosong
                        GROUP BY 
                            BALANCE.CREATIONDATETIME,
                            BALANCE.DECOSUBCODE02,
                            BALANCE.DECOSUBCODE03,
                            BUSINESSPARTNER.LEGALNAME1,
                            SALESORDER.ORDERPARTNERBRANDCODE,
                            SALESORDERLINE.ITEMDESCRIPTION,
                            BALANCE.PROJECTCODE,
                            BALANCE.DECOSUBCODE01,
							BALANCE.DECOSUBCODE02,
							BALANCE.DECOSUBCODE03,
							BALANCE.DECOSUBCODE04,
							BALANCE.DECOSUBCODE05,
							BALANCE.DECOSUBCODE06,
							BALANCE.DECOSUBCODE07,
							BALANCE.DECOSUBCODE08,
                            SALESORDER.REQUIREDDUEDATE,	
							BALANCE.ITEMTYPECODE,
                            BALANCE.LOTCODE,
                            BALANCE.ELEMENTSCODE,
                            BALANCE.BASEPRIMARYQUANTITYUNIT,
                            BALANCE.QUALITYLEVELCODE,
                            BALANCE.BASESECONDARYQUANTITYUNIT,
                            BALANCE.BASESECONDARYUNITCODE,
							BALANCE.BASEPRIMARYUNITCODE,
                            BALANCE.WHSLOCATIONWAREHOUSEZONECODE,
                            BALANCE.WAREHOUSELOCATIONCODE,
                            SALESORDER.CREATIONUSER";
	$stmt1   = db2_exec($conn1,$sqlDB21, array('cursor'=>DB2_SCROLLABLE));
    while($rowdb21 = db2_fetch_assoc($stmt1)){
	$sqlDB24 = " SELECT 
CASE
    WHEN STOCKTRANSACTION.QUALITYREASONCODE IS NULL THEN 
                                    CASE 
                                        WHEN trim(QUALITYREASON.LONGDESCRIPTION) IS NULL AND SUBSTRING(STOCKTRANSACTION.PROJECTCODE, 0,4) = 'OPN' THEN 'Booking'
                                        WHEN trim(QUALITYREASON.LONGDESCRIPTION) IS NULL AND SUBSTRING(STOCKTRANSACTION.PROJECTCODE, 0,4) = 'STO' THEN 'Booking'
                                        WHEN trim(QUALITYREASON.LONGDESCRIPTION) IS NULL AND SUBSTRING(STOCKTRANSACTION.PROJECTCODE, 0,4) = 'RPE' THEN 'Sisa Ganti Kain'
                                        WHEN trim(QUALITYREASON.LONGDESCRIPTION) IS NULL AND SUBSTRING(STOCKTRANSACTION.PROJECTCODE, 0,4) = 'REP' THEN 'Sisa Ganti Kain'
                                        WHEN trim(QUALITYREASON.LONGDESCRIPTION) IS NULL AND SUBSTRING(STOCKTRANSACTION.PROJECTCODE, 0,4) = 'SAM' THEN 'Sisa MOQ'
                                        WHEN trim(QUALITYREASON.LONGDESCRIPTION) IS NULL AND SUBSTRING(STOCKTRANSACTION.PROJECTCODE, 0,4) = 'SME' THEN 'Sisa MOQ'
                                        WHEN trim(QUALITYREASON.LONGDESCRIPTION) IS NULL AND SUBSTRING(STOCKTRANSACTION.PROJECTCODE, 0,4) = 'RFD' THEN 'Sisa Ganti Kain'
                                        WHEN trim(QUALITYREASON.LONGDESCRIPTION) IS NULL AND SUBSTRING(STOCKTRANSACTION.PROJECTCODE, 0,4) = 'RFE' THEN 'Sisa Ganti Kain'
                                        ---------------------------------------------------------------------------------------------------------------------
                                        WHEN trim(QUALITYREASON.LONGDESCRIPTION) = '.' AND SUBSTRING(STOCKTRANSACTION.PROJECTCODE, 0,4) = 'OPN' THEN 'Booking'
                                        WHEN trim(QUALITYREASON.LONGDESCRIPTION) = '.' AND SUBSTRING(STOCKTRANSACTION.PROJECTCODE, 0,4) = 'STO' THEN 'Booking'
                                        WHEN trim(QUALITYREASON.LONGDESCRIPTION) = '.' AND SUBSTRING(STOCKTRANSACTION.PROJECTCODE, 0,4) = 'RPE' THEN 'Sisa Ganti Kain'
                                        WHEN trim(QUALITYREASON.LONGDESCRIPTION) = '.' AND SUBSTRING(STOCKTRANSACTION.PROJECTCODE, 0,4) = 'REP' THEN 'Sisa Ganti Kain'
                                        WHEN trim(QUALITYREASON.LONGDESCRIPTION) = '.' AND SUBSTRING(STOCKTRANSACTION.PROJECTCODE, 0,4) = 'SAM' THEN 'Sisa MOQ'
                                        WHEN trim(QUALITYREASON.LONGDESCRIPTION) = '.' AND SUBSTRING(STOCKTRANSACTION.PROJECTCODE, 0,4) = 'SME' THEN 'Sisa MOQ'
                                        WHEN trim(QUALITYREASON.LONGDESCRIPTION) = '.' AND SUBSTRING(STOCKTRANSACTION.PROJECTCODE, 0,4) = 'RFD' THEN 'Sisa Ganti Kain'
                                        WHEN trim(QUALITYREASON.LONGDESCRIPTION) = '.' AND SUBSTRING(STOCKTRANSACTION.PROJECTCODE, 0,4) = 'RFE' THEN 'Sisa Ganti Kain'
                                        ELSE 'Tunggu Kirim'
                                    END
                                WHEN STOCKTRANSACTION.QUALITYREASONCODE IS NOT NULL THEN 
                                    CASE 
                                        WHEN trim(QUALITYREASON.LONGDESCRIPTION) = '.' THEN 'Tunggu Kirim'
                                        ELSE trim(QUALITYREASON.LONGDESCRIPTION)
                                    END
                            END AS STATUS_KAIN
    	
FROM (
                                SELECT
                                    *
                                FROM( SELECT 
                                            ROW_NUMBER() OVER(ORDER BY STOCKTRANSACTION.CREATIONDATETIME DESC) AS MYROW, 
                                            STOCKTRANSACTION.ITEMELEMENTCODE, 
                                            STOCKTRANSACTION.PROJECTCODE, 
                                            STOCKTRANSACTION.QUALITYREASONCODE   
                                        FROM STOCKTRANSACTION )
                            )STOCKTRANSACTION LEFT OUTER JOIN 
     DB2ADMIN.QUALITYREASON QUALITYREASON ON STOCKTRANSACTION.QUALITYREASONCODE=QUALITYREASON.CODE 
WHERE STOCKTRANSACTION.ITEMELEMENTCODE='$rowdb21[SN]'";
	$stmt4   = db2_exec($conn1,$sqlDB24, array('cursor'=>DB2_SCROLLABLE));
	$rowdb24 = db2_fetch_assoc($stmt4);	
	$sqlDB26 = " SELECT SALESORDERLINE.EXTERNALREFERENCE 
       FROM DB2ADMIN.SALESORDERLINE WHERE
       SALESORDERLINE.ITEMTYPEAFICODE='$rowdb21[ITEMTYPECODE]' AND	   
	   SALESORDERLINE.PROJECTCODE='$rowdb21[NO_ORDER]' AND
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
	$sqlDB29 = "SELECT TRANSACTIONDATE FROM STOCKTRANSACTION 
	WHERE ITEMELEMENTCODE='$rowdb21[SN]'  AND 
	(TEMPLATECODE ='304' OR TEMPLATECODE ='342' OR TEMPLATECODE ='OPN') AND (ITEMTYPECODE='FKF' OR ITEMTYPECODE='KFF') AND LOGICALWAREHOUSECODE ='M031' ";
	$stmt9   = db2_exec($conn1,$sqlDB29, array('cursor'=>DB2_SCROLLABLE));
	$rowdb29 = db2_fetch_assoc($stmt9);	
	$itemNo=$rowdb21['NO_ITEM'];	
	if($rowdb21['ITEMTYPECODE']=="KFF"){$jns="KAIN";}else if($rowdb21['ITEMTYPECODE']=="FKF"){$jns="KRAH";}
?>
	              <tr>
	                <td ><?php echo $no; ?></td>
	                <td ><?php echo substr($rowdb29['TRANSACTIONDATE'],0,10); ?></td>
	                <td ><?php echo $rowdb21['TGL_BALANCE']; ?></td>
	                <td ><?php echo $rowdb21['NO_ITEM']; ?></td>
	                <td ><?php echo $rowdb21['LANGGANAN'];  ?></td>
	                <td ><?php echo $rowdb21['BUYER']; ?></td>
	                <td ><?php echo $PO; ?></td>
	                <td ><?php echo $rowdb21['NO_ORDER']; ?></td>
	                <td ><?php echo $jns; ?></td>
	                <td ><?php echo $itemNo; ?></td>
	                <td ><?php echo $rowdb21['NO_WARNA']; ?></td>
	                <td ><?php echo $rowdb21['WARNA']; ?></td>
	                <td >'<?php echo $rowdb21['LOT'];?></td>
	                <td >'<?php echo $rowdb21['SN'];?></td>
	                <td ><?php echo number_format(round($rowdb21['KG'],2),2);?></td>
	                <td ><?php echo $rowdb21['SATUANKG'];?></td>
	                <td ><?php echo $rowdb21['GRADE'];?></td>
	                <td ><?php echo number_format(round($rowdb21['LENGTH'],2),2);?></td>
	                <td ><?php echo $rowdb21['SATUAN'];?></td>
	                <td ><?php echo $rowdb21['ZONA'];?></td>
	                <td ><?php echo $rowdb21['LOKASI'];?></td>
	                <td ><?php echo round($rowdb27['VALUEDECIMAL']);?></td>
	                <td ><?php echo round($rowdb28['VALUEDECIMAL']);?></td>
	                <td ><?php echo $rowdb24['STATUS_KAIN']; ?></td>
	                </tr>				  
<?php	$no++;
		$totkg=$totkg+$rowdb21['KG'];
		if(trim($rowdb21['SATUAN'])=="yd"){$tyd=$rowdb21['LENGTH'];}else{$tyd=0;}
		$totyd=$totyd+$tyd;
		if(trim($rowdb21['SATUAN'])=="m"){$tmtr=$rowdb21['LENGTH'];}else{$tmtr=0;}
		$totmtr=$totmtr+$tmtr;
	
	} ?>
				  </tbody>
      <tfoot>
                  <tr>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
					<td >&nbsp;</td>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
                    <td ><strong>TOTAL</strong></td>
                    <td ><strong><?php echo $no-1; ?> Roll</strong></td>
                    <td ><strong><?php echo number_format(round($totkg,2),2); ?></strong></td>
                    <td ><strong>KGs</strong></td>
                    <td >&nbsp;</td>
                    <td ><strong><?php echo number_format(round($totyd,2),2); ?></strong></td>
                    <td ><strong>YDs</strong></td>
                    <td ><strong><?php echo number_format(round($totmtr,2),2); ?></strong></td>
                    <td ><strong>MTRs</strong></td>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>  
                    <td >&nbsp;</td>
                    </tr>
                  </tfoot>            
                </table>