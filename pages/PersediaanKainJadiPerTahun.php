<!-- Main content -->
      <div class="container-fluid">
		<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-info"></i> Info</h5>
                Data Persediaan Kain hanya dari Zone W, X Lokasi W1, W3, X1, X2, X6 (Balance di NOW) </div> 
	</form>
<div class="row">
<div class="col-md-6">	
<div class="card card-pink">
              <div class="card-header">
                <h3 class="card-title">Stock Balance Tahun 2023 - Sekarang (NOW)</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
          <table id="" class="table table-sm table-bordered table-striped" style="font-size:14px;" width="100%">
                  <thead>
                  <tr>
                    <th style="text-align: center">Tahun</th>
                    <th style="text-align: center">Rol</th>
                    <th style="text-align: center">Weight</th>
                    <th style="text-align: center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
				  <?php	
   $no=1;   
   $c=0;
	$sqlDB21 = " SELECT SUM(STK.BERAT) AS BERAT,
SUM(STK.ROLL) AS ROLL,
STK.THN
FROM (SELECT 
			SUM(b.BASEPRIMARYQUANTITYUNIT) AS BERAT,
			COUNT(b.BASESECONDARYQUANTITYUNIT) AS ROLL,
			SUBSTR(b.PROJECTCODE,4,2) AS THN,
			b.PROJECTCODE
FROM 
		BALANCE b
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
			AND (ITEMTYPECODE = 'KFF'
				OR ITEMTYPECODE = 'FKF') 
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
			AND (ITEMTYPECODE = 'KFF'
				OR ITEMTYPECODE = 'FKF') 
		) GKJ
ON
		QCF.TRANSACTIONNUMBER = GKJ.TRANSACTIONNUMBER

		) mk ON
	b.ELEMENTSCODE = mk.ITEMELEMENTCODE
LEFT OUTER JOIN PRODUCT p ON
	p.ITEMTYPECODE = b.ITEMTYPECODE
	AND 
		p.SUBCODE01 = b.DECOSUBCODE01
	AND 
		p.SUBCODE02 = b.DECOSUBCODE02
	AND 
		p.SUBCODE03 = b.DECOSUBCODE03
	AND 
		p.SUBCODE04 = b.DECOSUBCODE04
	AND 
		p.SUBCODE05 = b.DECOSUBCODE05
	AND 
		p.SUBCODE06 = b.DECOSUBCODE06
	AND 
		p.SUBCODE07 = b.DECOSUBCODE07
	AND 
		p.SUBCODE08 = b.DECOSUBCODE08
WHERE
	(b.ITEMTYPECODE = 'FKF'
		OR b.ITEMTYPECODE = 'KFF')
	AND b.LOGICALWAREHOUSECODE = 'M031'
	AND (TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%W1%' OR 
		TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%W3%' OR 
		TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%X1%' OR 
		TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%X2%' OR
		TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%X6%')
	AND SUBSTR(b.PROJECTCODE,4,2) > '22' 
	AND LENGTH(trim(b.PROJECTCODE)) = '10'
GROUP BY 
SUBSTR(b.PROJECTCODE,4,2),
b.PROJECTCODE) STK
GROUP BY STK.THN ";
	$stmt1   = db2_exec($conn1,$sqlDB21, array('cursor'=>DB2_SCROLLABLE));
    while($rowdb21 = db2_fetch_assoc($stmt1)){		
	?>
	  <tr>
	    <td style="text-align: center"><?php if($rowdb21['THN']!=""){echo "20".$rowdb21['THN'];}else{echo "~";} ?></td>
	  <td style="text-align: center"><?php echo $rowdb21['ROLL'];?></td>
      <td style="text-align: right"><?php echo number_format(round($rowdb21['BERAT'],2),2);?></td>
      <td style="text-align: center"><div class="btn-group"><a href="pages/cetak/PersediaanKainJadi2023Excel.php?thn=<?php echo $rowdb21['THN']; ?>" target="_blank" class="btn btn-outline-info btn-xs disabled"><i class="fa fa-download"></i> Download</a>&nbsp;<a href="pages/cetak/PersediaanKainJadi2023DetailExcel.php?thn=<?php echo $rowdb21['THN']; ?>" target="_blank" class="btn btn-outline-warning btn-xs disabled"><i class="fa fa-download"></i> Detail</a></div></td>
      </tr>				  
<?php	$no++;
		$totrol=$totrol+$rowdb21['ROLL'];
		$totkg=$totkg+round($rowdb21['BERAT'],2);	
	} ?>
				  </tbody>
                <tfoot>
                  <tr>
                    <td style="text-align: center"><span style="text-align: right"><strong>TOTAL</strong></span></td>
                    <td style="text-align: right"><strong><?php echo $totrol; ?></strong></td>  
                    <td style="text-align: right"><strong><?php echo number_format(round($totkg,2),2); ?></strong></td>
                    <td style="text-align: right">&nbsp;</td>
                    </tr>
                  </tfoot>  
                </table>
              </div>
              <!-- /.card-body -->
        </div>
</div>
<div class="col-md-6">	
<div class="card card-yellow">
              <div class="card-header">
                <h3 class="card-title">Stock Balance Tahun 2022 Atau Tahun Sebelumnya</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
          <table id="" class="table table-sm table-bordered table-striped" style="font-size:14px;" width="100%">
                  <thead>
                  <tr>
                    <th style="text-align: center">Tahun</th>
                    <th style="text-align: center">Rol</th>
                    <th style="text-align: center">Weight</th>
                    <th style="text-align: center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
				  <?php	
	$sqlDB2022 = " SELECT SUM(STK.BERAT) AS BERAT,
SUM(STK.ROLL) AS ROLL
FROM (SELECT 
			SUM(b.BASEPRIMARYQUANTITYUNIT) AS BERAT,
			COUNT(b.BASESECONDARYQUANTITYUNIT) AS ROLL,
			b.PROJECTCODE
FROM 
		BALANCE b
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
			AND (ITEMTYPECODE = 'KFF'
				OR ITEMTYPECODE = 'FKF') 
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
			AND (ITEMTYPECODE = 'KFF'
				OR ITEMTYPECODE = 'FKF') 
		) GKJ
ON
		QCF.TRANSACTIONNUMBER = GKJ.TRANSACTIONNUMBER

		) mk ON
	b.ELEMENTSCODE = mk.ITEMELEMENTCODE
LEFT OUTER JOIN PRODUCT p ON
	p.ITEMTYPECODE = b.ITEMTYPECODE
	AND 
		p.SUBCODE01 = b.DECOSUBCODE01
	AND 
		p.SUBCODE02 = b.DECOSUBCODE02
	AND 
		p.SUBCODE03 = b.DECOSUBCODE03
	AND 
		p.SUBCODE04 = b.DECOSUBCODE04
	AND 
		p.SUBCODE05 = b.DECOSUBCODE05
	AND 
		p.SUBCODE06 = b.DECOSUBCODE06
	AND 
		p.SUBCODE07 = b.DECOSUBCODE07
	AND 
		p.SUBCODE08 = b.DECOSUBCODE08
WHERE
	(b.ITEMTYPECODE = 'FKF'
		OR b.ITEMTYPECODE = 'KFF')
	AND b.LOGICALWAREHOUSECODE = 'M031'
	AND (TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%W1%' OR 
		TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%W3%' OR 
		TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%X1%' OR 
		TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%X2%' OR
		TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%X6%')
	AND SUBSTR(b.PROJECTCODE,4,2) < '23' 
	AND LENGTH(trim(b.PROJECTCODE)) = '10'
GROUP BY b.PROJECTCODE) STK
 ";
	$stmt2022   = db2_exec($conn1,$sqlDB2022, array('cursor'=>DB2_SCROLLABLE));	
	$rowdb2022 = db2_fetch_assoc($stmt2022);					  
   ?>
                  <tr>
                    <td style="text-align: center">2022</td>
                    <td style="text-align: center"><?php echo $rowdb2022['ROLL'];?></td>
                    <td style="text-align: right"><?php echo number_format(round($rowdb2022['BERAT'],2),2);?></td>
                    <td style="text-align: center"><a href="pages/cetak/PersediaanKainJadi2022Excel.php?thn=2022" target="_blank" class="btn btn-outline-info btn-xs disabled"> <i class="fa fa-download"></i> Download</a>&nbsp;<a href="pages/cetak/PersediaanKainJadi2022DetailExcel.php?thn=2022" target="_blank" class="btn btn-outline-warning btn-xs disabled"><i class="fa fa-download"></i> Detail</a></td>
                  </tr>
				 </tbody>
                <tfoot>						  
                  <tr>
                    <td style="text-align: center"><span style="text-align: right"><strong>TOTAL</strong></span></td>
                    <td style="text-align: right"><strong><?php echo $totrol1=$rowdb2022['ROLL']; ?></strong></td>  
                    <td style="text-align: right"><strong><?php echo number_format($totkg1=round($rowdb2022['BERAT'],2),2); ?></strong></td>
                    <td style="text-align: right">&nbsp;</td>
                    </tr>
                  </tfoot>  
                </table>
              </div>
              <!-- /.card-body -->
      </div>
</div>	
</div>	
<div class="row">
<div class="col-md-6">	
<div class="card card-blue">
              <div class="card-header">
                <h3 class="card-title">Stock Balance PO Sample dan Tidak Ada ProjectCode </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
          <table id="" class="table table-sm table-bordered table-striped" style="font-size:14px;" width="100%">
                  <thead>
                  <tr>
                    <th style="text-align: center">Action</th>
                    <th style="text-align: center">Rol</th>
                    <th style="text-align: center">Weight</th>
                    </tr>
                  </thead>
                  <tbody>
				  <?php	
   $no=1;   
   $c=0;
	$sqlDB21 = " SELECT SUM(STK.BERAT) AS BERAT,
SUM(STK.ROLL) AS ROLL
FROM (SELECT 
			SUM(b.BASEPRIMARYQUANTITYUNIT) AS BERAT,
			COUNT(b.BASESECONDARYQUANTITYUNIT) AS ROLL,
			b.PROJECTCODE
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
		AND (TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%W1%' OR 
		TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%W3%' OR 
		TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%X1%' OR 
		TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%X2%' OR
		TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%X6%')
		AND (b.PROJECTCODE='' OR LENGTH(TRIM(b.PROJECTCODE)) > '10')
GROUP BY b.PROJECTCODE) STK ";
	$stmt1   = db2_exec($conn1,$sqlDB21, array('cursor'=>DB2_SCROLLABLE));
    while($rowdb21 = db2_fetch_assoc($stmt1)){		
	?>
	  <tr>
	    <td style="text-align: center"><a href="pages/cetak/PersediaanKainJadiNoOrderExcel.php" target="_blank" class="btn btn-outline-info btn-xs disabled"> <i class="fa fa-download"></i> Download</a>&nbsp;<a href="pages/cetak/PersediaanKainJadiNoOrderDetailExcel.php" target="_blank" class="btn btn-outline-warning btn-xs disabled" title="Detail"> <i class="fa fa-download"></i> Detail</a></td>
	  <td style="text-align: center"><?php echo $rowdb21['ROLL'];?></td>
      <td style="text-align: right"><?php echo number_format(round($rowdb21['BERAT'],2),2);?></td>
      </tr>				  
<?php	$no++;
		$totrol2=$totrol2+$rowdb21['ROLL'];
		$totkg2=$totkg2+round($rowdb21['BERAT'],2);	
	} ?>
				  </tbody>
                <tfoot>
                  <tr>
                    <td style="text-align: center"><span style="text-align: right"><strong>TOTAL</strong></span></td>
                    <td style="text-align: right"><strong><?php echo $totrol2; ?></strong></td>  
                    <td style="text-align: right"><strong><?php echo number_format(round($totkg2,2),2); ?></strong></td>
                    </tr>
                  </tfoot>  
                </table>
              </div>
              <!-- /.card-body -->
      </div>
</div>	
<div class="col-md-6">	
<div class="card card-red">
              <div class="card-header">
                <h3 class="card-title">Stock Balance</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
          <table id="" class="table table-sm table-bordered table-striped" style="font-size:14px;" width="100%">
                  <thead>
                  <tr>
                    <th style="text-align: center">Action</th>
                    <th style="text-align: center">Rol</th>
                    <th style="text-align: center">Weight</th>
                    </tr>
                  </thead>
                  <tbody>
				  <?php	
   $no=1;   
   $c=0;
	$sqlDB21 = " SELECT SUM(STK.BERAT) AS BERAT,
SUM(STK.ROLL) AS ROLL FROM (
SELECT 
			SUM(b.BASEPRIMARYQUANTITYUNIT) AS BERAT,
			COUNT(b.BASESECONDARYQUANTITYUNIT) AS ROLL,
			b.PROJECTCODE
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
		AND (TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%W1%' OR 
		TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%W3%' OR 
		TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%X1%' OR 
		TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%X2%' OR
		TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%X6%')
GROUP BY b.PROJECTCODE ) STK ";
	$stmt1   = db2_exec($conn1,$sqlDB21, array('cursor'=>DB2_SCROLLABLE));
    while($rowdb21 = db2_fetch_assoc($stmt1)){		
	?>
	  <tr>
	    <td style="text-align: center"><div class="btn-group"><a href="pages/cetak/PersediaanKainJadiFullExcel.php" target="_blank" class="btn btn-outline-info btn-xs disabled"><i class="fa fa-download"></i> Download</a>&nbsp;<a href="pages/cetak/PersediaanKainJadiFullDetailExcel.php" target="_blank" class="btn btn-outline-warning btn-xs disabled"><i class="fa fa-download"></i> Detail</a></div></td>
	  <td style="text-align: center"><?php echo $rowdb21['ROLL'];?></td>
      <td style="text-align: right"><?php echo number_format(round($rowdb21['BERAT'],2),2);?></td>
      </tr>				  
<?php	$no++;
		$totrol211=$totrol211+$rowdb21['ROLL'];
		$totkg211=$totkg211+round($rowdb21['BERAT'],2);	
	} ?>
				  </tbody>
                <tfoot>
                  <tr>
                    <td style="text-align: center"><span style="text-align: right"><strong>TOTAL</strong></span></td>
                    <td style="text-align: right"><strong><?php echo $totrol211; ?></strong></td>  
                    <td style="text-align: right"><strong><?php echo number_format($totkg211,2); ?></strong></td>
                    </tr>
                  </tfoot>  
                </table>
              </div>
              <!-- /.card-body -->
      </div>
</div>	
</div>	
</div><!-- /.container-fluid -->
    <!-- /.content -->
