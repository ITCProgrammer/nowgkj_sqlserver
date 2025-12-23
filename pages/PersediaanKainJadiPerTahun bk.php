<!-- Main content -->
      <div class="container-fluid">
		<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-info"></i> Info</h5>
                  Data Persediaan Kain hanya dari Zone W, X (Balance di NOW)
                </div> 
	</form>
<div class="row">
<div class="col-md-6">	
<div class="card card-pink">
              <div class="card-header">
                <h3 class="card-title">Stock Balance Lot NOW</h3>
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
	$sqlDB21 = " SELECT 
			SUM(b.BASEPRIMARYQUANTITYUNIT) AS BERAT,
			COUNT(b.BASESECONDARYQUANTITYUNIT) AS ROLL,
			SUBSTR(mk.TRANSACTIONDATE,1,4) AS thn
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
		AND NOT ( b.ELEMENTSCODE like'141000%' OR b.ELEMENTSCODE like'151000%' OR b.ELEMENTSCODE like'161000%' OR b.ELEMENTSCODE like'171000%' OR b.ELEMENTSCODE like'171000%' OR b.ELEMENTSCODE like'17110%' OR b.ELEMENTSCODE like'181000%' 
		OR b.ELEMENTSCODE like'191000%' OR b.ELEMENTSCODE like'201000%' OR b.ELEMENTSCODE like'211000%' 
		OR b.ELEMENTSCODE like'22081501%' OR b.ELEMENTSCODE like'221000%' OR b.ELEMENTSCODE like'231000%' OR b.ELEMENTSCODE like'241000%')
		AND ( b.ELEMENTSCODE like'00%' OR b.ELEMENTSCODE LIKE '80%' OR b.ELEMENTSCODE LIKE '70%' )
GROUP BY SUBSTR(mk.TRANSACTIONDATE,1,4) ";
	$stmt1   = db2_exec($conn1,$sqlDB21, array('cursor'=>DB2_SCROLLABLE));
    while($rowdb21 = db2_fetch_assoc($stmt1)){		
	?>
	  <tr>
	    <td style="text-align: center"><?php if($rowdb21['THN']!=""){echo $rowdb21['THN'];}else{echo "~";} ?></td>
	  <td style="text-align: center"><?php echo $rowdb21['ROLL'];?></td>
      <td style="text-align: right"><?php echo number_format(round($rowdb21['BERAT'],2),2);?></td>
      <td style="text-align: center"><a href="pages/cetak/PersediaanKainJadi2023Excel.php?thn=<?php echo $rowdb21['THN']; ?>" target="_blank" class="btn btn-xs btn-info"> <i class="fa fa-download"></i></a></td>
      </tr>				  
<?php	$no++;
		$totrol=$totrol+$rowdb21['ROLL'];
		$totkg=$totkg+$rowdb21['BERAT'];	
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
                <h3 class="card-title">Stock Balance Lot Legacy</h3>
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
	$sqlDB2014 = " SELECT 
			SUM(b.BASEPRIMARYQUANTITYUNIT) AS BERAT,
			COUNT(b.BASESECONDARYQUANTITYUNIT) AS ROLL
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
		AND b.ELEMENTSCODE like'141000%'
		AND NOT ( b.ELEMENTSCODE like'00%' OR b.ELEMENTSCODE LIKE '80%' OR b.ELEMENTSCODE LIKE '70%' )";
	$stmt2014   = db2_exec($conn1,$sqlDB2014, array('cursor'=>DB2_SCROLLABLE));	
	$rowdb2014 = db2_fetch_assoc($stmt2014);
	$sqlDB2015 = " SELECT 
			SUM(b.BASEPRIMARYQUANTITYUNIT) AS BERAT,
			COUNT(b.BASESECONDARYQUANTITYUNIT) AS ROLL
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
		AND b.ELEMENTSCODE like'151000%'
		AND NOT ( b.ELEMENTSCODE like'00%' OR b.ELEMENTSCODE LIKE '80%' OR b.ELEMENTSCODE LIKE '70%' ) ";
	$stmt2015   = db2_exec($conn1,$sqlDB2015, array('cursor'=>DB2_SCROLLABLE));	
	$rowdb2015 = db2_fetch_assoc($stmt2015);
	$sqlDB2016 = " SELECT 
			SUM(b.BASEPRIMARYQUANTITYUNIT) AS BERAT,
			COUNT(b.BASESECONDARYQUANTITYUNIT) AS ROLL
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
		AND b.ELEMENTSCODE like'161000%'
		AND NOT ( b.ELEMENTSCODE like'00%' OR b.ELEMENTSCODE LIKE '80%' OR b.ELEMENTSCODE LIKE '70%' ) ";
	$stmt2016   = db2_exec($conn1,$sqlDB2016, array('cursor'=>DB2_SCROLLABLE));	
	$rowdb2016 = db2_fetch_assoc($stmt2016);
	$sqlDB2017 = " SELECT 
			SUM(b.BASEPRIMARYQUANTITYUNIT) AS BERAT,
			COUNT(b.BASESECONDARYQUANTITYUNIT) AS ROLL
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
		AND (b.ELEMENTSCODE like'171000%' OR b.ELEMENTSCODE like'17110%')
		AND NOT ( b.ELEMENTSCODE like'00%' OR b.ELEMENTSCODE LIKE '80%' OR b.ELEMENTSCODE LIKE '70%' ) ";
	$stmt2017   = db2_exec($conn1,$sqlDB2017, array('cursor'=>DB2_SCROLLABLE));	
	$rowdb2017 = db2_fetch_assoc($stmt2017);
		$sqlDB2018 = " SELECT 
			SUM(b.BASEPRIMARYQUANTITYUNIT) AS BERAT,
			COUNT(b.BASESECONDARYQUANTITYUNIT) AS ROLL
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
		AND b.ELEMENTSCODE like'181000%'
		AND NOT ( b.ELEMENTSCODE like'00%' OR b.ELEMENTSCODE LIKE '80%' OR b.ELEMENTSCODE LIKE '70%' ) ";
	$stmt2018   = db2_exec($conn1,$sqlDB2018, array('cursor'=>DB2_SCROLLABLE));	
	$rowdb2018 = db2_fetch_assoc($stmt2018);
	$sqlDB2019 = " SELECT 
			SUM(b.BASEPRIMARYQUANTITYUNIT) AS BERAT,
			COUNT(b.BASESECONDARYQUANTITYUNIT) AS ROLL
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
		AND b.ELEMENTSCODE like'191000%'
		AND NOT ( b.ELEMENTSCODE like'00%' OR b.ELEMENTSCODE LIKE '80%' OR b.ELEMENTSCODE LIKE '70%' ) ";
	$stmt2019   = db2_exec($conn1,$sqlDB2019, array('cursor'=>DB2_SCROLLABLE));	
	$rowdb2019 = db2_fetch_assoc($stmt2019);
		$sqlDB2020 = " SELECT 
			SUM(b.BASEPRIMARYQUANTITYUNIT) AS BERAT,
			COUNT(b.BASESECONDARYQUANTITYUNIT) AS ROLL
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
		AND b.ELEMENTSCODE like'201000%'
		AND NOT ( b.ELEMENTSCODE like'00%' OR b.ELEMENTSCODE LIKE '80%' OR b.ELEMENTSCODE LIKE '70%' ) ";
	$stmt2020   = db2_exec($conn1,$sqlDB2020, array('cursor'=>DB2_SCROLLABLE));	
	$rowdb2020 = db2_fetch_assoc($stmt2020);
			$sqlDB2021 = " SELECT 
			SUM(b.BASEPRIMARYQUANTITYUNIT) AS BERAT,
			COUNT(b.BASESECONDARYQUANTITYUNIT) AS ROLL
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
		AND b.ELEMENTSCODE like'211000%'
		AND NOT ( b.ELEMENTSCODE like'00%' OR b.ELEMENTSCODE LIKE '80%' OR b.ELEMENTSCODE LIKE '70%' ) ";
	$stmt2021   = db2_exec($conn1,$sqlDB2021, array('cursor'=>DB2_SCROLLABLE));	
	$rowdb2021 = db2_fetch_assoc($stmt2021);	
	$sqlDB2022 = " SELECT 
			SUM(b.BASEPRIMARYQUANTITYUNIT) AS BERAT,
			COUNT(b.BASESECONDARYQUANTITYUNIT) AS ROLL
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
		AND (b.ELEMENTSCODE like'22081501%' OR b.ELEMENTSCODE like'221000%')
		AND NOT ( b.ELEMENTSCODE like'00%' OR b.ELEMENTSCODE LIKE '80%' OR b.ELEMENTSCODE LIKE '70%' ) ";
	$stmt2022   = db2_exec($conn1,$sqlDB2022, array('cursor'=>DB2_SCROLLABLE));	
	$rowdb2022 = db2_fetch_assoc($stmt2022);
	$sqlDB2023 = " SELECT 
			SUM(b.BASEPRIMARYQUANTITYUNIT) AS BERAT,
			COUNT(b.BASESECONDARYQUANTITYUNIT) AS ROLL
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
		AND b.ELEMENTSCODE like'231000%'
		AND NOT ( b.ELEMENTSCODE like'00%' OR b.ELEMENTSCODE LIKE '80%' OR b.ELEMENTSCODE LIKE '70%' ) ";
	$stmt2023   = db2_exec($conn1,$sqlDB2023, array('cursor'=>DB2_SCROLLABLE));	
	$rowdb2023 = db2_fetch_assoc($stmt2023);
	$sqlDB2024 = " SELECT 
			SUM(b.BASEPRIMARYQUANTITYUNIT) AS BERAT,
			COUNT(b.BASESECONDARYQUANTITYUNIT) AS ROLL
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
		AND b.ELEMENTSCODE like'241000%'
		AND NOT ( b.ELEMENTSCODE like'00%' OR b.ELEMENTSCODE LIKE '80%' OR b.ELEMENTSCODE LIKE '70%' ) ";
	$stmt2024   = db2_exec($conn1,$sqlDB2024, array('cursor'=>DB2_SCROLLABLE));	
	$rowdb2024 = db2_fetch_assoc($stmt2024);				  
   ?> 
                  <tr>
                    <td style="text-align: center">2024</td>
                    <td style="text-align: center"><?php echo $rowdb2024['ROLL'];?></td>
                    <td style="text-align: right"><?php echo number_format(round($rowdb2024['BERAT'],2),2);?></td>
                    <td style="text-align: right"><a href="pages/cetak/PersediaanKainJadi2022Excel.php?thn=2024" target="_blank" class="btn btn-xs btn-info"> <i class="fa fa-download"></i></a></td>
                  </tr>
                  <tr>
                    <td style="text-align: center">2023</td>
                    <td style="text-align: center"><?php echo $rowdb2023['ROLL'];?></td>
                    <td style="text-align: right"><?php echo number_format(round($rowdb2023['BERAT'],2),2);?></td>
                    <td style="text-align: right"><a href="pages/cetak/PersediaanKainJadi2022Excel.php?thn=2023" target="_blank" class="btn btn-xs btn-info"> <i class="fa fa-download"></i></a></td>
                  </tr>
                  <tr>
                    <td style="text-align: center">2022</td>
                    <td style="text-align: center"><?php echo $rowdb2022['ROLL'];?></td>
                    <td style="text-align: right"><?php echo number_format(round($rowdb2022['BERAT'],2),2);?></td>
                    <td style="text-align: right"><a href="pages/cetak/PersediaanKainJadi2022Excel.php?thn=2022" target="_blank" class="btn btn-xs btn-info"> <i class="fa fa-download"></i></a></td>
                  </tr>
                  <tr>
                    <td style="text-align: center">2021</td>
                    <td style="text-align: center"><?php echo $rowdb2021['ROLL'];?></td>
                    <td style="text-align: right"><?php echo number_format(round($rowdb2021['BERAT'],2),2);?></td>
                    <td style="text-align: right"><a href="pages/cetak/PersediaanKainJadi2022Excel.php?thn=2021" target="_blank" class="btn btn-xs btn-info"> <i class="fa fa-download"></i></a></td>
                  </tr>
                  <tr>
                    <td style="text-align: center">2020</td>
                    <td style="text-align: center"><?php echo $rowdb2020['ROLL'];?></td>
                    <td style="text-align: right"><?php echo number_format(round($rowdb2020['BERAT'],2),2);?></td>
                    <td style="text-align: right"><a href="pages/cetak/PersediaanKainJadi2022Excel.php?thn=2020" target="_blank" class="btn btn-xs btn-info"> <i class="fa fa-download"></i></a></td>
                  </tr>
                  <tr>
                    <td style="text-align: center">2019</td>
                    <td style="text-align: center"><?php echo $rowdb2019['ROLL'];?></td>
                    <td style="text-align: right"><?php echo number_format(round($rowdb2019['BERAT'],2),2);?></td>
                    <td style="text-align: right"><a href="pages/cetak/PersediaanKainJadi2022Excel.php?thn=2019" target="_blank" class="btn btn-xs btn-info"> <i class="fa fa-download"></i></a></td>
                  </tr>
                  <tr>
                    <td style="text-align: center">2018</td>
                    <td style="text-align: center"><?php echo $rowdb2018['ROLL'];?></td>
                    <td style="text-align: right"><?php echo number_format(round($rowdb2018['BERAT'],2),2);?></td>
                    <td style="text-align: right"><a href="pages/cetak/PersediaanKainJadi2022Excel.php?thn=2018" target="_blank" class="btn btn-xs btn-info"> <i class="fa fa-download"></i></a></td>
                  </tr>
                  <tr>
                    <td style="text-align: center">2017</td>
                    <td style="text-align: center"><?php echo $rowdb2017['ROLL'];?></td>
                    <td style="text-align: right"><?php echo number_format(round($rowdb2017['BERAT'],2),2);?></td>
                    <td style="text-align: right"><a href="pages/cetak/PersediaanKainJadi2022Excel.php?thn=2017" target="_blank" class="btn btn-xs btn-info"> <i class="fa fa-download"></i></a></td>
                  </tr>
                  <tr>
                    <td style="text-align: center">2016</td>
                    <td style="text-align: center"><?php echo $rowdb2016['ROLL'];?></td>
                    <td style="text-align: right"><?php echo number_format(round($rowdb2016['BERAT'],2),2);?></td>
                    <td style="text-align: right"><a href="pages/cetak/PersediaanKainJadi2022Excel.php?thn=2016" target="_blank" class="btn btn-xs btn-info"> <i class="fa fa-download"></i></a></td>
                  </tr>
                  <tr>
                    <td style="text-align: center">2015</td>
                    <td style="text-align: center"><?php echo $rowdb2015['ROLL'];?></td>
                    <td style="text-align: right"><?php echo number_format(round($rowdb2015['BERAT'],2),2);?></td>
                    <td style="text-align: right"><a href="pages/cetak/PersediaanKainJadi2022Excel.php?thn=2015" target="_blank" class="btn btn-xs btn-info"> <i class="fa fa-download"></i></a></td>
                  </tr>
                  <tr>
                    <td style="text-align: center">2014</td>
                    <td style="text-align: center"><?php echo $rowdb2014['ROLL'];?></td>
                    <td style="text-align: right"><?php echo number_format(round($rowdb2014['BERAT'],2),2);?></td>
                    <td style="text-align: right"><a href="pages/cetak/PersediaanKainJadi2022Excel.php?thn=2014" target="_blank" class="btn btn-xs btn-info"> <i class="fa fa-download"></i></a></td>
                  </tr>
				 </tbody>
                <tfoot>						  
                  <tr>
                    <td style="text-align: center"><span style="text-align: right"><strong>TOTAL</strong></span></td>
                    <td style="text-align: right"><strong><?php echo $totrol1=$rowdb2014['ROLL']+$rowdb2015['ROLL']+$rowdb2016['ROLL']+$rowdb2017['ROLL']+$rowdb2018['ROLL']+$rowdb2019['ROLL']+$rowdb2020['ROLL']+$rowdb2021['ROLL']+$rowdb2022['ROLL']+$rowdb2023['ROLL']+$rowdb2024['ROLL']; ?></strong></td>  
                    <td style="text-align: right"><strong><?php echo number_format($totkg1=round($rowdb2014['BERAT'],2)+round($rowdb2015['BERAT'],2)+round($rowdb2016['BERAT'],2)+round($rowdb2017['BERAT'],2)+round($rowdb2018['BERAT'],2)+round($rowdb2019['BERAT'],2)+round($rowdb2020['BERAT'],2)+round($rowdb2021['BERAT'],2)+round($rowdb2022['BERAT'],2)+round($rowdb2023['BERAT'],2)+round($rowdb2024['BERAT'],2),2); ?></strong></td>
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
<div class="col-md-12">	
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
	$sqlDB21 = " SELECT 
			SUM(b.BASEPRIMARYQUANTITYUNIT) AS BERAT,
			COUNT(b.BASESECONDARYQUANTITYUNIT) AS ROLL
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
		TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%X%') ";
	$stmt1   = db2_exec($conn1,$sqlDB21, array('cursor'=>DB2_SCROLLABLE));
    while($rowdb21 = db2_fetch_assoc($stmt1)){		
	?>
	  <tr>
	    <td style="text-align: center"><a href="pages/cetak/PersediaanKainJadiFullExcel.php" target="_blank" class="btn btn-xs btn-info"> <i class="fa fa-download"></i></a></td>
	  <td style="text-align: center"><?php echo $rowdb21['ROLL'];?></td>
      <td style="text-align: right"><?php echo number_format(round($rowdb21['BERAT'],2),2);?></td>
      </tr>				  
<?php	$no++;
		$totrol2=$totrol2+$rowdb21['ROLL'];
		$totkg2=$totkg2+$rowdb21['BERAT'];	
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
</div>	
</div><!-- /.container-fluid -->
    <!-- /.content -->
