
<?php
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=persediaanBalance_all.xls"); //ganti nama sesuai keperluan
	header("Pragma: no-cache");
	header("Expires: 0");
	// disini script laporan anda
?>
<?php
	include "../../koneksi.php";
	ini_set("error_reporting", 1);
?>
<?php
	$Buyer1		= isset($_POST['buyer']) ? $_POST['buyer'] : '';
	$Project	= isset($_POST['project']) ? $_POST['project'] : '';
	$POno		= isset($_POST['pono']) ? $_POST['pono'] : '';
	$Item		= isset($_POST['itemno']) ? $_POST['itemno'] : '';
	$NoWarna	= isset($_POST['warnano']) ? $_POST['warnano'] : '';
	$Zone		= isset($_POST['zone']) ? $_POST['zone'] : '';
?>
<table id="example1" class="table table-sm table-bordered table-striped" style="font-size:13px;" border="1">
	<thead>
		<tr>
			<th style="text-align: center">Item</th>
			<th style="text-align: center">Langganan</th>
			<th style="text-align: center">Buyer</th>
			<th style="text-align: center">PO</th>
			<th style="text-align: center">Order</th>
			<th style="text-align: center">Delivery</th>
			<th style="text-align: center">Tipe</th>
			<th style="text-align: center">No Item</th>
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
			<th style="text-align: center">Status</th>
			<th style="text-align: center">No Element</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$no = 1;
		$c = 0;
		$sqlDB21 = "SELECT 
						bl.*,
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
						b.ELEMENTSCODE
					FROM 
						BALANCE b 
					WHERE 
						(b.ITEMTYPECODE='FKF' OR b.ITEMTYPECODE='KFF') AND b.LOGICALWAREHOUSECODE='M031' 
						AND (TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%Y%' OR 
						TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%Z%' OR 
						TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%W%' OR 
						TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%X%')
						-- AND b.PROJECTCODE = 'EXP2300266' 
					GROUP BY 
						b.ITEMTYPECODE,b.DECOSUBCODE01,
						b.DECOSUBCODE02,b.DECOSUBCODE03,
						b.DECOSUBCODE04,b.DECOSUBCODE05,
						b.DECOSUBCODE06,b.DECOSUBCODE07,
						b.DECOSUBCODE08,b.PROJECTCODE,b.LOTCODE,
						b.BASEPRIMARYUNITCODE,b.BASESECONDARYUNITCODE,
						b.WHSLOCATIONWAREHOUSEZONECODE,b.WAREHOUSELOCATIONCODE,b.ELEMENTSCODE) bl 
				LEFT OUTER JOIN	DB2ADMIN.SALESORDER SALESORDER ON bl.PROJECTCODE=SALESORDER.CODE
				LEFT OUTER JOIN DB2ADMIN.ITXVIEWAKJ ITXVIEWAKJ ON SALESORDER.CODE=ITXVIEWAKJ.CODE 
				WHERE 
					(bl.ITEMTYPECODE='FKF' OR bl.ITEMTYPECODE='KFF')
					AND NOT bl.PROJECTCODE IS NULL 
					AND NOT bl.PROJECTCODE = ''";
		$stmt1   = db2_exec($conn1, $sqlDB21, array('cursor' => DB2_SCROLLABLE));
		while ($rowdb21 = db2_fetch_assoc($stmt1)) {
			$itemNo = trim($rowdb21['DECOSUBCODE02']) . "" . trim($rowdb21['DECOSUBCODE03']);
			if ($rowdb21['ITEMTYPECODE'] == "KFF") {
				$jns = "KAIN";
			} else if ($rowdb21['ITEMTYPECODE'] == "FKF") {
				$jns = "KRAH";
			}
			$sqlDB22 = "SELECT 
							TRIM(LANGGANAN) AS PELANGGAN, TRIM(BUYER) AS BUYER 
						FROM 
							ITXVIEW_PELANGGAN 
						WHERE 
							ORDPRNCUSTOMERSUPPLIERCODE = '$rowdb21[ORDPRNCUSTOMERSUPPLIERCODE]' AND CODE = '$rowdb21[PROJECTCODE]'";
			$stmt2   = db2_exec($conn1, $sqlDB22);
			$rowdb22 = db2_fetch_assoc($stmt2);
			$langganan	= $rowdb22['PELANGGAN'];
			$buyer 		= $rowdb22['BUYER'];

			$q_deliverydate	= db2_exec($conn1, "SELECT 
													LISTAGG(DELIVERYDATE, ', ') AS DELIVERYDATE
												FROM
												(SELECT 
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
			$sqlDB23 = " SELECT USERGENERICGROUP.CODE,USERGENERICGROUP.LONGDESCRIPTION 
							FROM DB2ADMIN.USERGENERICGROUP USERGENERICGROUP WHERE USERGENERICGROUP.CODE='$rowdb21[DECOSUBCODE05]' ";
			$stmt3   = db2_exec($conn1, $sqlDB23, array('cursor' => DB2_SCROLLABLE));
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
			$stmt5   = db2_exec($conn1, $sqlDB25, array('cursor' => DB2_SCROLLABLE));
			$rowdb25 = db2_fetch_assoc($stmt5);
			if ($rowdb25['LONGDESCRIPTION'] != "") {
				$item = $rowdb25['LONGDESCRIPTION'];
			} else {
				$item = trim($rowdb21['DECOSUBCODE02']) . "" . trim($rowdb21['DECOSUBCODE03']);
			}
			$sqlDB26 = "SELECT 
							SALESORDERLINE.EXTERNALREFERENCE 
						FROM DB2ADMIN.SALESORDERLINE 
						WHERE SALESORDERLINE.ITEMTYPEAFICODE='$rowdb21[ITEMTYPECODE]' AND	   
							SALESORDERLINE.SALESORDERCODE='$rowdb21[PROJECTCODE]' AND
							SALESORDERLINE.SUBCODE01='$rowdb21[DECOSUBCODE01]' AND
							SALESORDERLINE.SUBCODE02='$rowdb21[DECOSUBCODE02]' AND
							SALESORDERLINE.SUBCODE03='$rowdb21[DECOSUBCODE03]' AND
							SALESORDERLINE.SUBCODE04='$rowdb21[DECOSUBCODE04]' AND
							SALESORDERLINE.SUBCODE05='$rowdb21[DECOSUBCODE05]' AND
							SALESORDERLINE.SUBCODE06='$rowdb21[DECOSUBCODE06]' AND
							SALESORDERLINE.SUBCODE07='$rowdb21[DECOSUBCODE07]' AND
							SALESORDERLINE.SUBCODE08='$rowdb21[DECOSUBCODE08]' LIMIT 1";
			$stmt6   = db2_exec($conn1, $sqlDB26, array('cursor' => DB2_SCROLLABLE));
			$rowdb26 = db2_fetch_assoc($stmt6);

			$q_salesorder 	= db2_exec($conn1, "SELECT EXTERNALREFERENCE FROM SALESORDER WHERE CODE = '$rowdb21[PROJECTCODE]'");
			$row_po			= db2_fetch_assoc($q_salesorder);

			if ($row_po['EXTERNALREFERENCE']) {
				$PO = $row_po['EXTERNALREFERENCE'];
			} else {
				$PO = $rowdb26['EXTERNALREFERENCE'];
			}

			$sqlDB27 = "SELECT 
						ADSTORAGE.NAMENAME,
						ADSTORAGE.VALUEDECIMAL 
					FROM 
						DB2ADMIN.ADSTORAGE ADSTORAGE 
					RIGHT OUTER JOIN DB2ADMIN.PRODUCT PRODUCT ON ADSTORAGE.UNIQUEID=PRODUCT.ABSUNIQUEID 
					WHERE PRODUCT.ITEMTYPECODE='$rowdb21[ITEMTYPECODE]' AND	
						PRODUCT.SUBCODE01='$rowdb21[DECOSUBCODE01]' AND
						PRODUCT.SUBCODE02='$rowdb21[DECOSUBCODE02]' AND
						PRODUCT.SUBCODE03='$rowdb21[DECOSUBCODE03]' AND
						PRODUCT.SUBCODE04='$rowdb21[DECOSUBCODE04]' AND
						PRODUCT.SUBCODE05='$rowdb21[DECOSUBCODE05]' AND
						PRODUCT.SUBCODE06='$rowdb21[DECOSUBCODE06]' AND
						PRODUCT.SUBCODE07='$rowdb21[DECOSUBCODE07]' AND
						PRODUCT.SUBCODE08='$rowdb21[DECOSUBCODE08]' AND 
						ADSTORAGE.NAMENAME='Width' ";
			$stmt7   = db2_exec($conn1, $sqlDB27, array('cursor' => DB2_SCROLLABLE));
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
			$stmt8   = db2_exec($conn1, $sqlDB28, array('cursor' => DB2_SCROLLABLE));
			$rowdb28 = db2_fetch_assoc($stmt8);

			$sqlDB24 = "SELECT
							STOCKTRANSACTION.ITEMELEMENTCODE,
							STOCKTRANSACTION.PROJECTCODE,
							STOCKTRANSACTION.QUALITYREASONCODE,
							QUALITYREASON.LONGDESCRIPTION,
							STOCKTRANSACTION.CREATIONDATETIME
						FROM
							DB2ADMIN.STOCKTRANSACTION STOCKTRANSACTION
						LEFT JOIN ELEMENTS ELEMENTS ON STOCKTRANSACTION.ITEMELEMENTCODE = ELEMENTS.CODE
						LEFT JOIN QUALITYREASON QUALITYREASON ON STOCKTRANSACTION.QUALITYREASONCODE = QUALITYREASON.CODE
						WHERE
							STOCKTRANSACTION.ITEMELEMENTCODE = '$rowdb21[ELEMENTSCODE]'
						GROUP BY
							STOCKTRANSACTION.ITEMELEMENTCODE,
							STOCKTRANSACTION.PROJECTCODE,
							STOCKTRANSACTION.QUALITYREASONCODE,
							QUALITYREASON.LONGDESCRIPTION,
							STOCKTRANSACTION.CREATIONDATETIME,
							STOCKTRANSACTION.TRANSACTIONNUMBER
						ORDER BY
							STOCKTRANSACTION.CREATIONDATETIME DESC,
							STOCKTRANSACTION.TRANSACTIONNUMBER DESC
						LIMIT 1";
			$stmt4   = db2_exec($conn1, $sqlDB24, array('cursor' => DB2_SCROLLABLE));
			$rowdb24 = db2_fetch_assoc($stmt4);
			if (!empty($rowdb24['QUALITYREASONCODE']) and $rowdb24['QUALITYREASONCODE'] != "100") {
				$sts = $rowdb24['LONGDESCRIPTION'];
			} else if ((substr(trim($rowdb24['PROJECTCODE']), 0, 3) == "OPN" or substr(trim($rowdb24['PROJECTCODE']), 0, 3) == "STO") and $rowdb24['QUALITYREASONCODE'] == "100") {
				$sts = "Booking";
			} else if (substr(trim($rowdb24['PROJECTCODE']), 0, 3) == "OPN" or substr(trim($rowdb24['PROJECTCODE']), 0, 3) == "STO") {
				$sts = "Booking";
			} else if (substr(trim($rowdb24['PROJECTCODE']), 0, 3) == "RPE" and $rowdb24['QUALITYREASONCODE'] == "100") {
				$sts = "Ganti Kain";
			} else if (substr(trim($rowdb24['PROJECTCODE']), 0, 3) == "RPE") {
				$sts = "Ganti Kain";
			} else {
				$sts = "Tunggu Kirim";
			}
		?>
			<tr>
				<td style="text-align: center"><?php echo $item; ?></td>
				<td style="text-align: left"><?php echo $langganan; ?></td>
				<td style="text-align: left"><?php echo $buyer; ?></td>
				<td style="text-align: left"><?php echo $PO; ?></td>
				<td style="text-align: center"><?php echo $rowdb21['PROJECTCODE']; ?></td>
				<td style="text-align: center"><?php echo $row_deliverydate['DELIVERYDATE']; ?></td>
				<td style="text-align: center"><?php echo $jns; ?></td>
				<td style="text-align: center"><?php echo $itemNo; ?></td>
				<td style="text-align: center"><?php echo $rowdb21['DECOSUBCODE05']; ?></td>
				<td style="text-align: left"><?php echo $rowdb23['LONGDESCRIPTION']; ?></td>
				<td style="text-align: center"><?php echo $rowdb21['ROLL']; ?></td>
				<td style="text-align: left">'<?php echo $rowdb21['LOTCODE']; ?></td>
				<td style="text-align: right"><?php echo number_format(round($rowdb21['BERAT'], 2), 2); ?></td>
				<td style="text-align: center"><?php echo $rowdb21['BASEPRIMARYUNITCODE']; ?></td>
				<td style="text-align: right"><?php echo number_format(round($rowdb21['YD'], 2), 2); ?></td>
				<td style="text-align: center"><?php echo $rowdb21['BASESECONDARYUNITCODE']; ?></td>
				<td style="text-align: center"><?php echo $rowdb21['WHSLOCATIONWAREHOUSEZONECODE']; ?></td>
				<td style="text-align: center"><?php echo $rowdb21['WAREHOUSELOCATIONCODE']; ?></td>
				<td style="text-align: center"><?php echo round($rowdb27['VALUEDECIMAL']); ?></td>
				<td style="text-align: center"><?php echo round($rowdb28['VALUEDECIMAL']); ?></td>
				<td style="text-align: center"><?= $sts; ?></td>
				<td style="text-align: center"><?= $rowdb24['ITEMELEMENTCODE'] ?></td>
			</tr>
		<?php $no++;
			$totrol = $totrol + $rowdb21['ROLL'];
			$totkg = $totkg + $rowdb21['BERAT'];
			if (trim($rowdb21['BASESECONDARYUNITCODE']) == "yd") {
				$tyd = $rowdb21['YD'];
			} else {
				$tyd = 0;
			}
			$totyd = $totyd + $tyd;
			if (trim($rowdb21['BASESECONDARYUNITCODE']) == "m") {
				$tmtr = $rowdb21['YD'];
			} else {
				$tmtr = 0;
			}
			$totmtr = $totmtr + $tmtr;
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
			<td style="text-align: right"><strong>TOTAL</strong></td>
			<td style="text-align: right"><strong><?php echo $totrol; ?></strong></td>
			<td style="text-align: center">&nbsp;</td>
			<td style="text-align: right"><strong><?php echo number_format(round($totkg, 2), 2); ?></strong></td>
			<td style="text-align: center"><strong>KGs</strong></td>
			<td style="text-align: right"><strong><?php echo number_format(round($totyd, 2), 2); ?></strong></td>
			<td style="text-align: center"><strong>YDs</strong></td>
			<td style="text-align: right"><strong><?php echo number_format(round($totmtr, 2), 2); ?></strong></td>
			<td style="text-align: center"><strong>MTRs</strong></td>
			<td style="text-align: center">&nbsp;</td>
			<td style="text-align: center">&nbsp;</td>
		</tr>
	</tfoot>
</table>