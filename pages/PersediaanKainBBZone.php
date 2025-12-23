<?php
$Zone		= isset($_POST['zone']) ? $_POST['zone'] : '';
$Lokasi		= isset($_POST['lokasi']) ? $_POST['lokasi'] : '';
$CKLokasi	= isset($_POST['cklokasi']) ? $_POST['cklokasi'] : '';
$CKExcel	= isset($_POST['ckexcel']) ? $_POST['ckexcel'] : '';
?>
<!-- Main content -->
      <div class="container-fluid">
		<form role="form" method="post" enctype="multipart/form-data" name="form1">  
		<div class="card card-purple">
          <div class="card-header">
            <h3 class="card-title">Filter Data</h3>

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
               <label for="zone" class="col-md-1">Zone</label>               
                 <select class="form-control select2bs4" style="width: 100%;" name="zone">
				   <option value="">Pilih</option>	 
					<?php $sqlZ=mysqli_query($con," SELECT * FROM tbl_zone_bb order by nama ASC"); 
					  while($rZ=mysqli_fetch_array($sqlZ)){
					 ?>
                    <option value="<?php echo $rZ['nama'];?>" <?php if($rZ['nama']==$Zone){ echo "SELECTED"; }?>><?php echo $rZ['nama'];?></option>
                    <?php  } ?>
                  </select>			   
            </div>
				 <div class="form-group row">
                    <label for="lokasi" class="col-md-1"><input type="checkbox" value="1" name="cklokasi" <?php if($CKLokasi=="1"){echo "checked";}?> > Location</label>
					<select class="form-control select2bs4 " style="width: 100%;" name="lokasi" <?php if($CKLokasi!="1"){ ?> disabled <?php }?>>
                    <option value="">Pilih</option>	 
					<?php $sqlL=mysqli_query($con," SELECT * FROM tbl_lokasi_bb WHERE zone='$Zone' order by nama ASC"); 
					  while($rL=mysqli_fetch_array($sqlL)){
					 ?>
                    <option value="<?php echo $rL['nama'];?>" <?php if($rL['nama']==$Lokasi){ echo "SELECTED"; }?>><?php echo $rL['nama'];?></option>
                    <?php  } ?>
                  </select>	
                  </div> 
			  	 <div class="form-group row">
					 <label for="exceld" class="col-md-1"><input type="checkbox" value="1" name="ckexcel" <?php if($CKExcel=="1"){echo "checked";}?> > Download Excel</label>
			  	 </div>	 
          </div>
		  <div class="card-footer">
            <button class="btn btn-info" type="submit" value="Cari" name="cari">Cari Data</button>
			<?php if($CKExcel=="1"){ ?>  
			<div class="btn-group float-right">  
			<a href="pages/cetak/PersediaanKainBBExcel.php?zone=<?php echo $Zone; ?>&lokasi=<?php echo $Lokasi; ?>" class="btn btn-warning" target="_blank">Excel Kain BB</a> 			
			</div> 
			<?php } ?>  
          </div>
		  <!-- /.card-body -->
          
        </div> 
	</form>
		  <div class="card card-pink">
              <div class="card-header">
                <h3 class="card-title">Stock Kain BB</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
          <table id="example1" class="table table-sm table-bordered table-striped" style="font-size:13px;">
                  <thead>
                  <tr>
                    <th style="text-align: center">TGLMasuk</th>
                    <th style="text-align: center">Item</th>
                    <th style="text-align: center">Langganan</th>
                    <th style="text-align: center">Buyer</th>
                    <th style="text-align: center">PO</th>
                    <th style="text-align: center">Order</th>
                    <th style="text-align: center">Tipe</th>
                    <th style="text-align: center">No Item</th>
                    <th style="text-align: center">Jenis Kain</th>
                    <th style="text-align: center">No Warna</th>
                    <th style="text-align: center">Warna</th>
                    <th style="text-align: center">Element</th>
                    <th style="text-align: center">Lot</th>
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
					  
	if( $Zone!="" and $Lokasi!=""){				  
	$Where= " AND b.WHSLOCATIONWAREHOUSEZONECODE='$Zone' AND b.WAREHOUSELOCATIONCODE LIKE '$Lokasi%' " ;		
	}else if($CKLokasi!="1"){
	$Where= " AND b.WHSLOCATIONWAREHOUSEZONECODE='$Zone' " ;	
	}else{
		$Where= " AND b.WHSLOCATIONWAREHOUSEZONECODE='$Zone' AND b.WAREHOUSELOCATIONCODE='$Lokasi' " ;
	}
					  
   $no=1;   
   $c=0;
	if($CKExcel=="1"){
	$sqlDB21 = " SELECT b.*
	-- ,i.WARNA 
	FROM 
	BALANCE b 
-- LEFT OUTER JOIN ITXVIEWCOLOR i ON 
-- b.ITEMTYPECODE = i.ITEMTYPECODE AND
-- b.DECOSUBCODE01= i.SUBCODE01 AND
-- b.DECOSUBCODE02= i.SUBCODE02 AND
-- b.DECOSUBCODE03= i.SUBCODE03 AND
-- b.DECOSUBCODE04= i.SUBCODE04 AND
-- b.DECOSUBCODE05= i.SUBCODE05 AND
-- b.DECOSUBCODE06= i.SUBCODE06 AND
-- b.DECOSUBCODE07= i.SUBCODE07 AND
-- b.DECOSUBCODE08= i.SUBCODE08 AND
-- b.DECOSUBCODE09= i.SUBCODE09 AND
-- b.DECOSUBCODE10= i.SUBCODE10
	WHERE (b.ITEMTYPECODE='KFF' OR b.ITEMTYPECODE='FKF') AND b.LOGICALWAREHOUSECODE='M631' AND b.WHSLOCATIONWAREHOUSEZONECODE='TEXT' ";
	}else{
	$sqlDB21 = " SELECT b.*
	-- ,i.WARNA 
	FROM 
	BALANCE b 
-- LEFT OUTER JOIN ITXVIEWCOLOR i ON 
-- b.ITEMTYPECODE = i.ITEMTYPECODE AND
-- b.DECOSUBCODE01= i.SUBCODE01 AND
-- b.DECOSUBCODE02= i.SUBCODE02 AND
-- b.DECOSUBCODE03= i.SUBCODE03 AND
-- b.DECOSUBCODE04= i.SUBCODE04 AND
-- b.DECOSUBCODE05= i.SUBCODE05 AND
-- b.DECOSUBCODE06= i.SUBCODE06 AND
-- b.DECOSUBCODE07= i.SUBCODE07 AND
-- b.DECOSUBCODE08= i.SUBCODE08 AND
-- b.DECOSUBCODE09= i.SUBCODE09 AND
-- b.DECOSUBCODE10= i.SUBCODE10
	WHERE (b.ITEMTYPECODE='KFF' OR b.ITEMTYPECODE='FKF') AND b.LOGICALWAREHOUSECODE='M631' $Where ";
	}
//	$sqlDB21 = " SELECT b.* 
//	FROM 
//	BALANCE b 
//	WHERE b.ITEMTYPECODE='KFF' AND b.LOGICALWAREHOUSECODE='M631' $Where ";				  
	$stmt1   = db2_exec($conn1,$sqlDB21, array('cursor'=>DB2_SCROLLABLE));					  
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
		WHERE STOCKTRANSACTION.ITEMELEMENTCODE='$rowdb21[ELEMENTSCODE]' 
		ORDER BY TRANSACTIONDATE DESC, TRANSACTIONTIME DESC	";
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
	   ITXVIEWKK.ITEMDESCRIPTION,
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
	   SALESORDERLINE.SUBCODE08='$rowdb21[DECOSUBCODE08]' LIMIT 1 ";
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
	TEMPLATECODE ='304' AND (ITEMTYPECODE='FKF' OR ITEMTYPECODE='KFF') AND LOGICALWAREHOUSECODE ='M631' ";
	$stmt9   = db2_exec($conn1,$sqlDB29, array('cursor'=>DB2_SCROLLABLE));
	$rowdb29 = db2_fetch_assoc($stmt9);
	$sqlDB30 = "SELECT PRODUCT.LONGDESCRIPTION FROM PRODUCT WHERE
       PRODUCT.ITEMTYPECODE='$rowdb21[ITEMTYPECODE]' AND	
	   PRODUCT.SUBCODE01='$rowdb21[DECOSUBCODE01]' AND
       PRODUCT.SUBCODE02='$rowdb21[DECOSUBCODE02]' AND
       PRODUCT.SUBCODE03='$rowdb21[DECOSUBCODE03]' AND
	   PRODUCT.SUBCODE04='$rowdb21[DECOSUBCODE04]' AND
       PRODUCT.SUBCODE05='$rowdb21[DECOSUBCODE05]' AND
	   PRODUCT.SUBCODE06='$rowdb21[DECOSUBCODE06]' AND
       PRODUCT.SUBCODE07='$rowdb21[DECOSUBCODE07]' AND
	   PRODUCT.SUBCODE08='$rowdb21[DECOSUBCODE08]' ";
	$stmt10   = db2_exec($conn1,$sqlDB30, array('cursor'=>DB2_SCROLLABLE));
	$rowdb30 = db2_fetch_assoc($stmt10);
		
	$sqlDB31 = "SELECT WARNA FROM (SELECT
    ITEMTYPECODE,
    SUBCODE01,
    SUBCODE02,
    SUBCODE03,
    SUBCODE04,
    SUBCODE05,
    SUBCODE06,
    SUBCODE07,
    SUBCODE08,
    SUBCODE09,
    SUBCODE10,
    CASE
        WHEN WARNA = 'NULL' THEN WARNA_FKF
        ELSE WARNA
    END AS WARNA,
    WARNA_DASAR
FROM
    (
    SELECT
        PRODUCT.ITEMTYPECODE AS ITEMTYPECODE,
        PRODUCT.SUBCODE01 AS SUBCODE01,
        PRODUCT.SUBCODE02 AS SUBCODE02,
        PRODUCT.SUBCODE03 AS SUBCODE03,
        PRODUCT.SUBCODE04 AS SUBCODE04,
        PRODUCT.SUBCODE05 AS SUBCODE05,
        PRODUCT.SUBCODE06 AS SUBCODE06,
        PRODUCT.SUBCODE07 AS SUBCODE07,
        PRODUCT.SUBCODE08 AS SUBCODE08,
        PRODUCT.SUBCODE09 AS SUBCODE09,
        PRODUCT.SUBCODE10 AS SUBCODE10,
        CASE
            WHEN PRODUCT.ITEMTYPECODE = 'KFF'
            AND PRODUCT.SUBCODE07 = '-' THEN A.LONGDESCRIPTION
            WHEN PRODUCT.ITEMTYPECODE = 'KFF'
            AND PRODUCT.SUBCODE07 <> '-'
            OR PRODUCT.SUBCODE07 <> '' THEN B.COLOR_PRT
            ELSE 'NULL'
        END AS WARNA,
        CASE
            WHEN PRODUCT.ITEMTYPECODE = 'FKF'
            AND LOCATE('-', PRODUCT.LONGDESCRIPTION) = 0 THEN PRODUCT.LONGDESCRIPTION
            WHEN PRODUCT.ITEMTYPECODE = 'FKF'
            AND LOCATE('-', PRODUCT.LONGDESCRIPTION) > 0 THEN SUBSTR(PRODUCT.LONGDESCRIPTION , 1, LOCATE('-', PRODUCT.LONGDESCRIPTION)-1)
            ELSE 'NULL'
        END AS WARNA_FKF,
        WARNA_DASAR
    FROM
        PRODUCT PRODUCT
    LEFT JOIN(
        SELECT
            CAST(SUBSTR(RECIPE.SUBCODE01, 1, LOCATE('/', RECIPE.SUBCODE01)-1) AS CHARACTER(10)) AS ARTIKEL,
            CAST(SUBSTR(RECIPE.SUBCODE01, LOCATE('/', RECIPE.SUBCODE01)+ 1, 7) AS CHARACTER(10)) AS NO_WARNA,
            SUBSTR(SUBSTR(RECIPE.SUBCODE01, LOCATE('/', RECIPE.SUBCODE01)+ 1), LOCATE('/', SUBSTR(RECIPE.SUBCODE01, LOCATE('/', RECIPE.SUBCODE01)+ 1))+ 1) AS CELUP,
            RECIPE.LONGDESCRIPTION,
            RECIPE.SHORTDESCRIPTION,
            RECIPE.SEARCHDESCRIPTION,
            RECIPE.NUMBERID,
            PRODUCT.SUBCODE03,
            PRODUCT.SUBCODE05,
            PRODUCT.LONGDESCRIPTION AS PRODUCT_LONG
        FROM
            RECIPE RECIPE
        LEFT JOIN PRODUCT PRODUCT ON
            SUBSTR(RECIPE.SUBCODE01, 1, LOCATE('/', RECIPE.SUBCODE01)-1) = PRODUCT.SUBCODE03
            AND SUBSTR(RECIPE.SUBCODE01, LOCATE('/', RECIPE.SUBCODE01)+ 1, 7) = PRODUCT.SUBCODE05
        WHERE
            RECIPE.ITEMTYPECODE = 'RFD'
            AND LOCATE('/', RECIPE.SUBCODE01) > 0
            AND RECIPE.SUFFIXCODE = '001'
            --            AND NOT RECIPE.SEARCHDESCRIPTION LIKE '%DELETE%' AND NOT RECIPE.SEARCHDESCRIPTION LIKE '%delete%'
            ) A ON
        PRODUCT.SUBCODE03 = A.SUBCODE03
        AND PRODUCT.SUBCODE05 = A.SUBCODE05
    LEFT JOIN(
        SELECT
            DESIGN.SUBCODE01,
            DESIGNCOMPONENT.VARIANTCODE,
            DESIGNCOMPONENT.LONGDESCRIPTION AS COLOR_PRT,
            DESIGNCOMPONENT.SHORTDESCRIPTION AS WARNA_DASAR
        FROM
            DESIGN DESIGN
        LEFT JOIN DESIGNCOMPONENT DESIGNCOMPONENT ON
            DESIGN.NUMBERID = DESIGNCOMPONENT.DESIGNNUMBERID
            AND DESIGN.SUBCODE01 = DESIGNCOMPONENT.DESIGNSUBCODE01) B ON
        PRODUCT.SUBCODE07 = B.SUBCODE01
        AND PRODUCT.SUBCODE08 = B.VARIANTCODE
    WHERE
        (PRODUCT.ITEMTYPECODE = 'KFF'
            OR PRODUCT.ITEMTYPECODE = 'FKF')
    GROUP BY
        PRODUCT.ITEMTYPECODE,
        PRODUCT.SUBCODE01,
        PRODUCT.SUBCODE02,
        PRODUCT.SUBCODE03,
        PRODUCT.SUBCODE04,
        PRODUCT.SUBCODE05,
        PRODUCT.SUBCODE06,
        PRODUCT.SUBCODE07,
        PRODUCT.SUBCODE08,
        PRODUCT.SUBCODE09,
        PRODUCT.SUBCODE10,
         PRODUCT.LONGDESCRIPTION,
        A.LONGDESCRIPTION,
        B.COLOR_PRT,
        WARNA_DASAR,
        PRODUCT.SHORTDESCRIPTION)) ITXVIEWCOLOR WHERE
       ITXVIEWCOLOR.ITEMTYPECODE='$rowdb21[ITEMTYPECODE]' AND	
	   ITXVIEWCOLOR.SUBCODE01='$rowdb21[DECOSUBCODE01]' AND
       ITXVIEWCOLOR.SUBCODE02='$rowdb21[DECOSUBCODE02]' AND
       ITXVIEWCOLOR.SUBCODE03='$rowdb21[DECOSUBCODE03]' AND
	   ITXVIEWCOLOR.SUBCODE04='$rowdb21[DECOSUBCODE04]' AND
       ITXVIEWCOLOR.SUBCODE05='$rowdb21[DECOSUBCODE05]' AND
	   ITXVIEWCOLOR.SUBCODE06='$rowdb21[DECOSUBCODE06]' AND
       ITXVIEWCOLOR.SUBCODE07='$rowdb21[DECOSUBCODE07]' AND
	   ITXVIEWCOLOR.SUBCODE08='$rowdb21[DECOSUBCODE08]' ";
	$stmt11   = db2_exec($conn1,$sqlDB31, array('cursor'=>DB2_SCROLLABLE));
	$rowdb31 = db2_fetch_assoc($stmt11);
		
	if($rowdb21['ITEMTYPECODE']=="KFF"){$jns="KAIN";}else if($rowdb21['ITEMTYPECODE']=="FKF"){$jns="KRAH";}	
	$sqlQC=mysqli_query($cond,"SELECT k.pelanggan,k.no_po,k.no_order,k.jenis_kain  FROM db_qc.tmp_detail_kite tmp
inner join db_qc.tbl_kite k on k.id=tmp.id_kite 
WHERE SN='$rowdb21[ELEMENTSCODE]' ");
	$rQC=mysqli_fetch_array($sqlQC);
	$pos=strpos($rQC['pelanggan'],"/");
	$cust=substr($rQC['pelanggan'],0,$pos);	
	$byr=substr($rQC['pelanggan'],$pos+1,300);	
?>
	  <tr>
      <td style="text-align: center"><?php if($rowdb29['TRANSACTIONDATE']!=""){echo substr($rowdb29['TRANSACTIONDATE'],0,10);}else{echo substr($rowdb21['CREATIONDATETIME'],0,10);} ?></td>
      <td style="text-align: center"><?php echo $item; ?></td>
      <td style="text-align: left"><?php if($langganan!=""){echo $langganan;}else{ echo $cust; } ?></td>
      <td style="text-align: left"><?php if($buyer!=""){echo $buyer;}else{echo $byr;} ?></td>
      <td style="text-align: left"><?php if($PO!=""){echo $PO;}else{ echo $rQC['no_po']; } ?></td>
      <td style="text-align: center"><?php if(trim($rowdb21['PROJECTCODE'])!=""){echo $rowdb21['PROJECTCODE'];}else{ echo $rQC['no_order']; } ?></td>
      <td style="text-align: center"><?php echo $jns; ?></td>
      <td style="text-align: center"><?php echo $itemNo; ?></td>
      <td style="text-align: left"><?php if(trim($rowdb26['ITEMDESCRIPTION'])!=""){echo $rowdb26['ITEMDESCRIPTION'];}else if($rQC['jenis_kain']!=""){ echo $rQC['jenis_kain']; }else{ echo $rowdb30['LONGDESCRIPTION']; } ?></td>
      <td style="text-align: left"><?php echo $rowdb21['DECOSUBCODE05']; ?></td>
      <td style="text-align: left"><?php if($rowdb31['WARNA']!=""){echo $rowdb31['WARNA'];}else{echo $rowdb23['LONGDESCRIPTION'];} ?></td>
      <td style="text-align: center"><?php echo $rowdb21['ELEMENTSCODE'];?></td>
      <td style="text-align: center"><?php echo $rowdb21['LOTCODE'];?></td>
      <td style="text-align: right"><?php echo number_format(round($rowdb21['BASEPRIMARYQUANTITYUNIT'],2),2);?></td>
      <td style="text-align: center"><?php echo $rowdb21['BASEPRIMARYUNITCODE'];?></td>
      <td style="text-align: center"><?php echo $grade;?></td>
      <td style="text-align: right"><?php echo number_format(round($rowdb21['BASESECONDARYQUANTITYUNIT'],2),2);?></td>
      <td style="text-align: center"><?php echo $rowdb21['BASESECONDARYUNITCODE'];?></td>
      <td style="text-align: center"><?php echo $rowdb21['WHSLOCATIONWAREHOUSEZONECODE'];?></td>
      <td style="text-align: left"><?php echo $rowdb21['WAREHOUSELOCATIONCODE'];?></td>
	  <td style="text-align: center"><?php echo round($rowdb27['VALUEDECIMAL']);?></td>
      <td style="text-align: center"><?php echo round($rowdb28['VALUEDECIMAL']);?></td> 	  
      <td style="text-align: left"><?php echo $sts; ?></td>
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
                    <td style="text-align: right"><strong>TOTAL</strong></td>
                    <td style="text-align: right"><strong><?php echo $no-1; ?> Roll</strong></td>
                    <td style="text-align: right"><strong><?php echo number_format(round($totkg,2),2); ?></strong></td>
                    <td style="text-align: center"><strong>KGs</strong></td>
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