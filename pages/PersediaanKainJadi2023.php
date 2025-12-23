
<!-- Main content -->
      <div class="container-fluid">
		<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-info"></i> Info</h5>
                  Data Persediaan Kain hanya dari Zone W, X (Balance di NOW)
                </div> 
	</form>
		  <div class="card card-pink">
              <div class="card-header">
                <h3 class="card-title">Stock Balance</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
          <table id="example5" class="table table-sm table-bordered table-striped" style="font-size:10px;" width="100%">
                  <thead>
                  <tr>
                    <th style="text-align: center">Tgl Mutasi</th>
                    <th style="text-align: center">Item</th>
                    <th style="text-align: center">Langganan</th>
                    <th style="text-align: center">Buyer</th>
                    <th style="text-align: center">PO</th>
                    <th style="text-align: center">Order</th>
                    <th style="text-align: center">Tipe</th>
                    <th style="text-align: center">No Item</th>
                    <th style="text-align: center">Jns Kain</th>
                    <th style="text-align: center">No Warna</th>
                    <th style="text-align: center">Warna</th>
                    <th style="text-align: center">Rol</th>
                    <th style="text-align: center">Lot</th>
                    <th style="text-align: center">Weight</th>
                    <th style="text-align: center">Satuan</th>
                    <th style="text-align: center">Length</th>
                    <th style="text-align: center">Satuan</th>
                    <th style="text-align: center">Zone</th>
                    <th style="text-align: center">Lokasi</th>
                    <th style="text-align: center">Lebar</th>
                    <th style="text-align: center">Gramasi</th>
                    <th style="text-align: center">Grouping</th>
                    <th style="text-align: center">Hue</th>
                    </tr>
                  </thead>
                  <tbody>
				  <?php	
   $no=1;   
   $c=0;
	$sqlDB21 = " SELECT 
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
			p.LONGDESCRIPTION AS JNSKAIN ,
			mk.TRANSACTIONDATE
		FROM 
		BALANCE b 
		LEFT OUTER JOIN (
		 
SELECT
	GKJ.*
FROM
	(
	SELECT
		*, TIMESTAMP(TRANSACTIONDATE,TRANSACTIONTIME ) AS JAM 
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
		*, TIMESTAMP(TRANSACTIONDATE,TRANSACTIONTIME ) AS JAM
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
		AND (TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%W%' OR 
		TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%X%')
		AND NOT ( b.ELEMENTSCODE like'141000%' OR b.ELEMENTSCODE like'151000%' OR b.ELEMENTSCODE like'161000%' OR b.ELEMENTSCODE like'171000%' OR b.ELEMENTSCODE like'181000%' 
		OR b.ELEMENTSCODE like'191000%' OR b.ELEMENTSCODE like'201000%' OR b.ELEMENTSCODE like'211000%' 
		OR b.ELEMENTSCODE like'221000%' OR b.ELEMENTSCODE like'231000%' OR b.ELEMENTSCODE like'241000%')
		AND ( b.ELEMENTSCODE like'00%' or b.ELEMENTSCODE LIKE '80%' )
GROUP BY b.ITEMTYPECODE,b.DECOSUBCODE01,
b.DECOSUBCODE02,b.DECOSUBCODE03,
b.DECOSUBCODE04,b.DECOSUBCODE05,
b.DECOSUBCODE06,b.DECOSUBCODE07,
b.DECOSUBCODE08,b.PROJECTCODE,b.LOTCODE,
b.BASEPRIMARYUNITCODE,b.BASESECONDARYUNITCODE,
b.WHSLOCATIONWAREHOUSEZONECODE,b.WAREHOUSELOCATIONCODE,p.LONGDESCRIPTION, mk.TRANSACTIONDATE ";
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
	?>
	  <tr>
	    <td style="text-align: center"><?php echo $rowdb21['TRANSACTIONDATE']; ?></td>
	  <td style="text-align: center"><?php echo $item; ?></td>
      <td style="text-align: left"><?php echo $langganan; ?></td>
      <td style="text-align: left"><?php echo $buyer; ?></td>
      <td style="text-align: left"><?php echo $PO; ?></td>
      <td style="text-align: center"><?php echo $rowdb21['PROJECTCODE']; ?></td>
      <td style="text-align: center"><?php echo $jns; ?></td>
      <td style="text-align: center"><?php echo $itemNo; ?></td>
      <td style="text-align: left"><?php echo $rowdb21['JNSKAIN'];?></td>
      <td style="text-align: center"><?php echo $rowdb21['DECOSUBCODE05']; ?></td>
      <td style="text-align: left"><?php echo $rowdb23['WARNA']; ?></td>
      <td style="text-align: center"><?php echo $rowdb21['ROLL'];?></td>
      <td style="text-align: left"><?php echo $rowdb21['LOTCODE'];?></td>
      <td style="text-align: right"><?php echo number_format(round($rowdb21['BERAT'],2),2);?></td>
      <td style="text-align: center"><?php echo $rowdb21['BASEPRIMARYUNITCODE'];?></td>
      <td style="text-align: right"><?php echo number_format(round($rowdb21['YD'],2),2);?></td>
      <td style="text-align: center"><?php echo $rowdb21['BASESECONDARYUNITCODE'];?></td>
      <td style="text-align: center"><?php echo $rowdb21['WHSLOCATIONWAREHOUSEZONECODE'];?></td>
      <td style="text-align: center"><?php echo $rowdb21['WAREHOUSELOCATIONCODE'];?></td>
      <td style="text-align: center"><?php echo round($rowdb27['LEBAR']);?></td>
      <td style="text-align: center"><?php echo round($rowdb27['GSM']);?></td>
      <td style="text-align: center"><?php echo $rowdb28['GROUPING1']; ?></td>
      <td style="text-align: center"><?php echo $rowdb28['HUE1']; ?></td>
      </tr>				  
<?php	$no++;
		$totrol=$totrol+$rowdb21['ROLL'];
		$totkg=$totkg+$rowdb21['BERAT'];
		if(trim($rowdb21['BASESECONDARYUNITCODE'])=="yd"){$tyd=$rowdb21['YD'];}else{$tyd=0;}
		$totyd=$totyd+$tyd;
		if(trim($rowdb21['BASESECONDARYUNITCODE'])=="m"){$tmtr=$rowdb21['YD'];}else{$tmtr=0;}
		$totmtr=$totmtr+$tmtr;
	
	
	} ?>
				  </tbody>
                <tfoot>
                  <tr>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
					<td style="text-align: right"><strong>TOTAL</strong></td>
                    <td style="text-align: right"><strong><?php echo $totrol; ?></strong></td>  
                    <td style="text-align: center">&nbsp;</td>                    
                    <td style="text-align: right"><strong><?php echo number_format(round($totkg,2),2); ?></strong></td>
                    <td style="text-align: center"><strong>KGs</strong></td>
                    <td style="text-align: right"><strong><?php echo number_format(round($totyd,2),2); ?></strong></td>
                    <td style="text-align: center"><strong>YDs</strong></td>
                    <td style="text-align: right"><strong><?php echo number_format(round($totmtr,2),2); ?></strong></td>
                    <td style="text-align: center"><strong>MTRs</strong></td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
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