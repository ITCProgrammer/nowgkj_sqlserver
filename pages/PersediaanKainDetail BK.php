<?php
$Buyer1		= isset($_POST['buyer']) ? $_POST['buyer'] : '';
$Project	= isset($_POST['project']) ? $_POST['project'] : '';
$POno		= isset($_POST['pono']) ? $_POST['pono'] : '';
$Item		= isset($_POST['itemno']) ? $_POST['itemno'] : '';
$NoWarna	= isset($_POST['warnano']) ? $_POST['warnano'] : '';
$Zone		= isset($_POST['zone']) ? $_POST['zone'] : '';
?>
<!-- Main content -->
      <div class="container-fluid">
		<form role="form" method="post" enctype="multipart/form-data" name="form1" >  
		<div class="card card-purple">
          <div class="card-header">
            <h3 class="card-title">Filter Data Persediaan Kain Jadi Detail</h3>

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
               <label for="buyer" class="col-md-1">Buyer</label>
               <div class="col-md-2">  
                 <input name="buyer" value="<?php echo $Buyer1;?>" type="text" class="form-control form-control-sm">
               </div>	
            </div>
			  <div class="form-group row">
               <label for="project" class="col-md-1">Project Code</label>
               <div class="col-md-2">  
                 <input name="project" value="<?php echo $Project;?>" type="text" class="form-control form-control-sm">
               </div>	
            </div>
			  <!--<div class="form-group row">
               <label for="pono" class="col-md-1">No PO</label>
               <div class="col-md-2">  
                 <input name="pono" value="<?php //echo $POno;?>" type="text" class="form-control form-control-sm">
               </div>	
            </div>-->
			<div class="form-group row">
               <label for="itemno" class="col-md-1">No. Item</label>
               <div class="col-md-2">  
                 <input name="itemno" value="<?php echo $Item;?>" type="text" class="form-control form-control-sm">
               </div>	
            </div>
			<div class="form-group row">
               <label for="warnano" class="col-md-1">No. Warna</label>
               <div class="col-md-2">  
                 <input name="warnano" value="<?php echo $NoWarna;?>" type="text" class="form-control form-control-sm">
               </div>	
            </div>
			<div class="form-group row">
               <label for="zone" class="col-md-1">Zone</label>
			   <div class="col-md-2"> 	
                 <select class="form-control select2bs4" name="zone">
				   <option value="">Pilih</option>	 
					<?php $sqlZ=mysqli_query($con," SELECT * FROM tbl_zone order by nama ASC"); 
					  while($rZ=mysqli_fetch_array($sqlZ)){
					 ?>
                    <option value="<?php echo $rZ['nama'];?>" <?php if($rZ['nama']==$Zone){ echo "SELECTED"; }?>><?php echo $rZ['nama'];?></option>
                    <?php  } ?>
                  </select>
				</div>   
            </div>  
		  </div>
		  <div class="card-footer">
            <button class="btn btn-info" type="submit" value="Cari" name="cari">Cari Data</button>
			<div class="btn-group float-right">  
			<a href="pages/cetak/PersediaanKainDetailExcel.php?buyer=<?php echo $Buyer1; ?>&zone=<?php echo $Zone; ?>&project=<?php echo $Project; ?>&pono=<?php echo $POno; ?>&itemno=<?php echo $Item; ?>&warnano=<?php echo $NoWarna; ?>" class="btn btn-warning" target="_blank">Excel Stok GKJ</a>  
			<a href="pages/cetak/PersediaanKainALLExcel.php" class="btn btn-danger" target="_blank">Download Stok GKJ</a>  
			</div>	
          </div>
		  <!-- /.card-body -->
          
        </div> 
	</form>
		  <div class="card card-pink">
              <div class="card-header">
                <h3 class="card-title">Stock Detail Data</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
          <table id="example1" class="table table-sm table-bordered table-striped" style="font-size:13px;">
                  <thead>
                  <tr>
                    <th style="text-align: center">#</th>
                    <th style="text-align: center">TGLMasuk</th>
                    <th style="text-align: center">TGLUpdate</th>
                    <th style="text-align: center">Item</th>
                    <th style="text-align: center">Langganan</th>
                    <th style="text-align: center">Buyer</th>
                    <th style="text-align: center">PO</th>
                    <th style="text-align: center">Order</th>
                    <th style="text-align: center">Tipe</th>
                    <th style="text-align: center">No Item</th>
                    <th style="text-align: center">No Warna</th>
                    <th style="text-align: center">Warna</th>
                    <th style="text-align: center">Lot</th>
                    <th style="text-align: center">Elements</th>
                    <th style="text-align: center">Weight</th>
                    <th style="text-align: center">Satuan</th>
                    <th style="text-align: center">Grade</th>
                    <th style="text-align: center">Length</th>
                    <th style="text-align: center">Satuan</th>
                    <th style="text-align: center">Zone</th>
                    <th style="text-align: center">Lokasi</th>
                    <th style="text-align: center">Lebar</th>
                    <th style="text-align: center">Gramasi</th>
                    <th style="text-align: center">Status</th>
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
	$sqlDB21 = "SELECT
                            VARCHAR_FORMAT(BALANCE.CREATIONDATETIME, 'yyyy-mm-dd') AS TGL_BALANCE,
                            trim(BALANCE.DECOSUBCODE02) || trim(BALANCE.DECOSUBCODE03) AS NO_ITEM,
                            trim(BUSINESSPARTNER.LEGALNAME1) AS LANGGANAN,
                            CASE 
                                WHEN trim(SALESORDER.ORDERPARTNERBRANDCODE) IS NULL THEN 'Periksa kembali kolom BRAND di SALESORDER. User : ' || trim(SALESORDER.CREATIONUSER)
                                ELSE trim(SALESORDER.ORDERPARTNERBRANDCODE) 
                            END AS BUYER,
                            CASE 
                                WHEN trim(SALESORDER.EXTERNALREFERENCE) IS NULL THEN trim(SALESORDERLINE.EXTERNALREFERENCE)
                                ELSE trim(SALESORDER.EXTERNALREFERENCE)
                            END AS PO,
                            BALANCE.PROJECTCODE AS NO_ORDER,
                            trim(SALESORDERLINE.ITEMDESCRIPTION) AS JENIS_KAIN,
                            BALANCE.DECOSUBCODE05 AS NO_WARNA,
                            ITXVIEWCOLOR.WARNA AS WARNA,
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
							BALANCE.DECOSUBCODE08,
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
                            LEFT JOIN ITXVIEWCOLOR ITXVIEWCOLOR ON ITXVIEWCOLOR.SUBCODE03 = BALANCE.DECOSUBCODE03 AND ITXVIEWCOLOR.SUBCODE05 = BALANCE.DECOSUBCODE05
                            LEFT JOIN (
                                SELECT
                                    *
                                FROM( SELECT 
                                            ROW_NUMBER() OVER(ORDER BY STOCKTRANSACTION.CREATIONDATETIME DESC) AS MYROW, 
                                            STOCKTRANSACTION.ITEMELEMENTCODE, 
                                            STOCKTRANSACTION.PROJECTCODE, 
                                            STOCKTRANSACTION.QUALITYREASONCODE   
                                        FROM STOCKTRANSACTION )
                            )STOCKTRANSACTION ON STOCKTRANSACTION.ITEMELEMENTCODE = BALANCE.ELEMENTSCODE AND STOCKTRANSACTION.PROJECTCODE = BALANCE.PROJECTCODE
                            LEFT JOIN QUALITYREASON QUALITYREASON ON STOCKTRANSACTION.QUALITYREASONCODE = QUALITYREASON.CODE
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
                            SALESORDER.EXTERNALREFERENCE,
                            SALESORDERLINE.EXTERNALREFERENCE,
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
                            SALESORDER.CREATIONUSER,
                            STOCKTRANSACTION.QUALITYREASONCODE,
                            STOCKTRANSACTION.PROJECTCODE,
                            QUALITYREASON.LONGDESCRIPTION,
                            ITXVIEWCOLOR.WARNA";				  
	$stmt1   = db2_exec($conn1,$sqlDB21, array('cursor'=>DB2_SCROLLABLE));
    while($rowdb21 = db2_fetch_assoc($stmt1)){
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
	    <td style="text-align: center"><?php echo $no; ?></td>
	  <td style="text-align: center"><?php echo substr($rowdb29['TRANSACTIONDATE'],0,10); ?></td>
	  <td style="text-align: center"><?php echo $rowdb21['TGL_BALANCE']; ?></td>
      <td style="text-align: center"><?php echo $rowdb21['NO_ITEM']; ?></td>
      <td style="text-align: left"><?php echo $rowdb21['LANGGANAN'];  ?></td>
      <td style="text-align: left"><?php echo $rowdb21['BUYER']; ?></td>
      <td style="text-align: left"><?php echo $rowdb21['PO']; ?></td>
      <td style="text-align: center"><?php echo $rowdb21['NO_ORDER']; ?></td>
      <td style="text-align: center"><?php echo $jns; ?></td>
      <td style="text-align: center"><?php echo $itemNo; ?></td>
      <td style="text-align: center"><?php echo $rowdb21['NO_WARNA']; ?></td>
      <td style="text-align: left"><?php echo $rowdb21['WARNA']; ?></td>
      <td style="text-align: left"><?php echo $rowdb21['LOT'];?></td>
      <td style="text-align: right"><?php echo $rowdb21['SN'];?></td>
      <td style="text-align: right"><?php echo number_format(round($rowdb21['KG'],2),2);?></td>
      <td style="text-align: center"><?php echo $rowdb21['SATUANKG'];?></td>
      <td style="text-align: center"><?php echo $rowdb21['GRADE'];?></td>
      <td style="text-align: right"><?php echo number_format(round($rowdb21['LENGTH'],2),2);?></td>
      <td style="text-align: center"><?php echo $rowdb21['SATUAN'];?></td>
      <td style="text-align: center"><?php echo $rowdb21['ZONA'];?></td>
      <td style="text-align: center"><?php echo $rowdb21['LOKASI'];?></td>
      <td style="text-align: center"><?php echo round($rowdb27['VALUEDECIMAL']);?></td>
      <td style="text-align: center"><?php echo round($rowdb28['VALUEDECIMAL']);?></td>
      <td style="text-align: left"><?php echo $rowdb21['STATUS_KAIN']; ?></td>
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
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center"><span style="text-align: right"><strong>TOTAL</strong></span></td>
                    <td style="text-align: right">&nbsp;</td>
                    <td style="text-align: right"><strong><?php echo $no-1; ?> Roll</strong></td>
                    <td style="text-align: right"><strong><?php echo number_format(round($totkg,2),2); ?></strong></td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: right"><strong><?php echo number_format(round($totyd,2),2); ?></strong></td>
                    <td style="text-align: center"><strong>YDs</strong></td>
                    <td style="text-align: right"><strong><?php echo number_format(round($totmtr,2),2); ?></strong></td>
                    <td style="text-align: center"><strong>MTRs</strong></td>
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