<?php
// =======================
// DEBUG / LOG (WAJIB)
// =======================
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php-error.log');

// =======================
// INPUT
// =======================
$Awal = isset($_POST['tgl_awal']) ? trim($_POST['tgl_awal']) : '';

// (optional) validasi format tanggal basic
if ($Awal !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $Awal)) {
	error_log("Invalid date format Awal: " . $Awal);
	$Awal = '';
}
?>

<!-- Main content -->
<div class="container-fluid">
	<form role="form" method="post" enctype="multipart/form-data" name="form1">
		<div class="card card-warning">
			<div class="card-header">
				<h3 class="card-title">Detail Data Persediaan Kain Jadi BB Perhari (Tutup Auto Jam 21:00)</h3>
			</div>

			<div class="card-body">
				<table id="example1" class="table table-sm table-bordered table-striped"
					style="font-size: 14px; text-align: center;">
					<thead>
						<tr>
							<th style="text-align:center">No</th>
							<th style="text-align:center">Detail</th>
							<th style="text-align:center">Tgl Tutup</th>
							<th style="text-align:center">Rol</th>
							<th style="text-align:center">KG</th>
							<th style="text-align:center">Action</th>
						</tr>
					</thead>
					<tbody>

						<?php
						// =======================
// LIST DATA (SQL SERVER)
// =======================
						$no = 1;

						$sqlList = " SELECT TOP (60)
										CONVERT(date, tgl_tutup) AS tgl_tutup,
										SUM(rol) AS rol,
										SUM([weight]) AS kg,
										CONVERT(date, GETDATE()) AS tgl
									FROM dbnow_gkj.tbl_opname_bb_11
									GROUP BY CONVERT(date, tgl_tutup)
									ORDER BY tgl_tutup DESC
								";

						$stmtList = sqlsrv_query($con, $sqlList);
						if ($stmtList === false) {
							error_log("SQLSRV LIST ERROR: " . print_r(sqlsrv_errors(), true));
							die("SQLSRV LIST ERROR. Cek php-error.log");
						}

						while ($r = sqlsrv_fetch_array($stmtList, SQLSRV_FETCH_ASSOC)) {

							$tgl_tutup = $r['tgl_tutup'] instanceof DateTime ? $r['tgl_tutup']->format('Y-m-d') : (string) $r['tgl_tutup'];
							$tgl_now = $r['tgl'] instanceof DateTime ? $r['tgl']->format('Y-m-d') : (string) $r['tgl'];

							$rol = (int) ($r['rol'] ?? 0);
							$kg = (float) ($r['kg'] ?? 0);
							?>
							<tr>
								<td style="text-align:center"><?php echo $no; ?></td>

								<td style="text-align:center">
									<div class="btn-group">
										<a href="DetailOpnameBB1-<?php echo $tgl_tutup; ?>" class="btn btn-danger btn-xs"
											target="_blank">
											<i class="fa fa-link"></i> Lihat Data 1
										</a>
										<a href="DetailOpnameBB-<?php echo $tgl_tutup; ?>" class="btn btn-info btn-xs"
											target="_blank">
											<i class="fa fa-link"></i> Lihat Data
										</a>
										<a href="pages/cetak/DetailOpnameBBExcel.php?tgl=<?php echo $tgl_tutup; ?>"
											class="btn btn-success btn-xs" target="_blank">
											<i class="fa fa-file"></i> Cetak Ke Excel
										</a>
										<a href="pages/cetak/DetailOpnameBB1Excel.php?tgl=<?php echo $tgl_tutup; ?>"
											class="btn btn-warning btn-xs" target="_blank">
											<i class="fa fa-file"></i> Cetak Ke Excel 1
										</a>
									</div>
								</td>

								<td style="text-align:center"><?php echo $tgl_tutup; ?></td>
								<td style="text-align:center"><?php echo $rol; ?></td>
								<td style="text-align:right"><?php echo number_format($kg, 3, '.', ','); ?></td>

								<td style="text-align:center">
									<a href="#"
										class="btn btn-xs btn-danger <?php echo ($tgl_now == $tgl_tutup) ? '' : 'disabled'; ?>"
										onclick="confirm_delete('DelOpnameBB-<?php echo $tgl_tutup; ?>');">
										<small class="fas fa-trash"></small> Hapus
									</a>
								</td>
							</tr>
							<?php
							$no++;
						}
						?>
					</tbody>
					<tfoot></tfoot>
				</table>
			</div>
		</div>
	</form>
</div>

<!-- MODAL DELETE -->
<div class="modal fade" id="delOpname" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content" style="margin-top:100px;">
			<div class="modal-header">
				<h4 class="modal-title">INFOMATION</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<h5 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h5>
			</div>
			<div class="modal-footer justify-content-between">
				<a href="#" class="btn btn-danger" id="delete_link">Delete</a>
				<button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<script>
	function confirm_delete(delete_url) {
		$('#delOpname').modal('show', { backdrop: 'static' });
		document.getElementById('delete_link').setAttribute('href', delete_url);
	}
</script>

<?php
// =======================
// SUBMIT PROSES TUTUP
// =======================
if (isset($_POST['submit'])) {

	$tsqlCek = " SELECT TOP (1)
            CONVERT(date, GETDATE()) AS tgl,
            COUNT(tgl_tutup) AS ck,
            DATEPART(HOUR, GETDATE()) AS jam,
            CONVERT(varchar(5), GETDATE(), 108) AS jam1
        FROM dbnow_gkj.tbl_opname
        WHERE CONVERT(date, tgl_tutup) = CONVERT(date, ?)
    ";

	$stmtCek = sqlsrv_query($con, $tsqlCek, [$Awal]);
	if ($stmtCek === false) {
		error_log("SQLSRV CEK ERROR: " . print_r(sqlsrv_errors(), true));
		die("SQLSRV CEK ERROR. Cek php-error.log");
	}

	$dcek = sqlsrv_fetch_array($stmtCek, SQLSRV_FETCH_ASSOC);

	$today = ($dcek['tgl'] instanceof DateTime) ? $dcek['tgl']->format('Y-m-d') : (string) $dcek['tgl'];
	$ck = (int) ($dcek['ck'] ?? 0);
	$jam = (int) ($dcek['jam'] ?? 0);
	$jam1 = (string) ($dcek['jam1'] ?? '');

	// hitung selh (tetap pakai rumus kamu)
	$t1 = strtotime($Awal);
	$t2 = strtotime($today);
	$selh = round(abs($t2 - $t1) / (60 * 60 * 45));

	if ($ck > 0) {
		echo "<script>$(function(){ toastr.error('Stok Tgl {$Awal} Ini Sudah Pernah ditutup'); });</script>";
	} elseif ($Awal > $today) {
		echo "<script>$(function(){ toastr.error('Tanggal Lebih dari {$selh} hari'); });</script>";
	} elseif ($Awal < $today) {
		echo "<script>$(function(){ toastr.error('Tanggal Kurang dari {$selh} hari'); });</script>";
	} elseif ($jam < 21 && $jam > 7) {
		echo "<script>$(function(){ toastr.error('Tidak Bisa Tutup Sebelum jam 9 Malam Sampai jam 7 Pagi, Sekarang Masih Jam {$jam1}'); });</script>";
	} else {

		// =======================
		// PROSES AMBIL DB2 & INSERT SQL SERVER
		// =======================
		$inserted = 0;

		$sqlDB21 = " SELECT bl.*,
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
                p.LONGDESCRIPTION AS JNSKAIN 
            FROM BALANCE b 
            LEFT OUTER JOIN PRODUCT p ON p.ITEMTYPECODE =b.ITEMTYPECODE AND 
                p.SUBCODE01=b.DECOSUBCODE01 AND 
                p.SUBCODE02=b.DECOSUBCODE02 AND 
                p.SUBCODE03=b.DECOSUBCODE03 AND 
                p.SUBCODE04=b.DECOSUBCODE04 AND 
                p.SUBCODE05=b.DECOSUBCODE05 AND 
                p.SUBCODE06=b.DECOSUBCODE06 AND 
                p.SUBCODE07=b.DECOSUBCODE07 AND 
                p.SUBCODE08=b.DECOSUBCODE08
            WHERE (b.ITEMTYPECODE='FKF' OR b.ITEMTYPECODE='KFF') 
                AND b.LOGICALWAREHOUSECODE='M031' 
                AND (
                    TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%Y%' OR 
                    TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%Z%' OR 
                    TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%W%' OR 
                    TRIM(b.WHSLOCATIONWAREHOUSEZONECODE) LIKE '%X%'
                )
            GROUP BY b.ITEMTYPECODE,b.DECOSUBCODE01,
                b.DECOSUBCODE02,b.DECOSUBCODE03,
                b.DECOSUBCODE04,b.DECOSUBCODE05,
                b.DECOSUBCODE06,b.DECOSUBCODE07,
                b.DECOSUBCODE08,b.PROJECTCODE,b.LOTCODE,
                b.BASEPRIMARYUNITCODE,b.BASESECONDARYUNITCODE,
                b.WHSLOCATIONWAREHOUSEZONECODE,b.WAREHOUSELOCATIONCODE,p.LONGDESCRIPTION
            ) bl 
            LEFT OUTER JOIN DB2ADMIN.SALESORDER SALESORDER ON bl.PROJECTCODE=SALESORDER.CODE
            LEFT OUTER JOIN DB2ADMIN.ITXVIEWAKJ ITXVIEWAKJ ON SALESORDER.CODE=ITXVIEWAKJ.CODE 
            WHERE (bl.ITEMTYPECODE='FKF' OR bl.ITEMTYPECODE='KFF')
        ";

		$stmt1 = db2_exec($conn1, $sqlDB21, ['cursor' => DB2_SCROLLABLE]);
		if (!$stmt1) {
			error_log("DB2 ERROR sqlDB21: " . db2_stmt_errormsg());
			die("DB2 ERROR sqlDB21. Cek php-error.log");
		}

		while ($rowdb21 = db2_fetch_assoc($stmt1)) {

			$itemNo = trim($rowdb21['DECOSUBCODE02']) . trim($rowdb21['DECOSUBCODE03']);
			$jns = ($rowdb21['ITEMTYPECODE'] == "KFF") ? "KAIN" : (($rowdb21['ITEMTYPECODE'] == "FKF") ? "KRAH" : "");

			$sqlDB22 = " SELECT SALESORDER.CODE, SALESORDER.EXTERNALREFERENCE, SALESORDER.ORDPRNCUSTOMERSUPPLIERCODE,
                ITXVIEWAKJ.LEGALNAME1, ITXVIEWAKJ.ORDERPARTNERBRANDCODE, ITXVIEWAKJ.LONGDESCRIPTION
                FROM DB2ADMIN.SALESORDER SALESORDER 
                LEFT OUTER JOIN DB2ADMIN.ITXVIEWAKJ ITXVIEWAKJ ON SALESORDER.CODE=ITXVIEWAKJ.CODE
                WHERE SALESORDER.CODE='{$rowdb21['PROJECTCODE']}'
            ";
			$stmt2 = db2_exec($conn1, $sqlDB22, ['cursor' => DB2_SCROLLABLE]);
			if (!$stmt2) {
				error_log("DB2 ERROR sqlDB22: " . db2_stmt_errormsg());
				continue;
			}
			$rowdb22 = db2_fetch_assoc($stmt2);

			$langganan = $rowdb22['LEGALNAME1'] ?? '';
			$buyer = $rowdb22['LONGDESCRIPTION'] ?? '';

			$sqlDB23 = " SELECT USERGENERICGROUP.CODE,USERGENERICGROUP.LONGDESCRIPTION 
                FROM DB2ADMIN.USERGENERICGROUP USERGENERICGROUP 
                WHERE USERGENERICGROUP.CODE='{$rowdb21['DECOSUBCODE05']}'
            ";
			$stmt3 = db2_exec($conn1, $sqlDB23, ['cursor' => DB2_SCROLLABLE]);
			if (!$stmt3) {
				error_log("DB2 ERROR sqlDB23: " . db2_stmt_errormsg());
				continue;
			}
			$rowdb23 = db2_fetch_assoc($stmt3);

			$sqlDB25 = " SELECT ORDERITEMORDERPARTNERLINK.ORDPRNCUSTOMERSUPPLIERCODE,
                   ORDERITEMORDERPARTNERLINK.LONGDESCRIPTION 
               FROM DB2ADMIN.ORDERITEMORDERPARTNERLINK ORDERITEMORDERPARTNERLINK WHERE
                   ORDERITEMORDERPARTNERLINK.ITEMTYPEAFICODE='{$rowdb21['ITEMTYPECODE']}' AND
                   ORDERITEMORDERPARTNERLINK.ORDPRNCUSTOMERSUPPLIERCODE='{$rowdb22['ORDPRNCUSTOMERSUPPLIERCODE']}' AND
                   ORDERITEMORDERPARTNERLINK.SUBCODE01='{$rowdb21['DECOSUBCODE01']}' AND
                   ORDERITEMORDERPARTNERLINK.SUBCODE02='{$rowdb21['DECOSUBCODE02']}' AND
                   ORDERITEMORDERPARTNERLINK.SUBCODE03='{$rowdb21['DECOSUBCODE03']}' AND
                   ORDERITEMORDERPARTNERLINK.SUBCODE04='{$rowdb21['DECOSUBCODE04']}' AND
                   ORDERITEMORDERPARTNERLINK.SUBCODE05='{$rowdb21['DECOSUBCODE05']}' AND
                   ORDERITEMORDERPARTNERLINK.SUBCODE06='{$rowdb21['DECOSUBCODE06']}' AND
                   ORDERITEMORDERPARTNERLINK.SUBCODE07='{$rowdb21['DECOSUBCODE07']}' AND
                   ORDERITEMORDERPARTNERLINK.SUBCODE08='{$rowdb21['DECOSUBCODE08']}'
            ";
			$stmt5 = db2_exec($conn1, $sqlDB25, ['cursor' => DB2_SCROLLABLE]);
			if (!$stmt5) {
				error_log("DB2 ERROR sqlDB25: " . db2_stmt_errormsg());
				continue;
			}
			$rowdb25 = db2_fetch_assoc($stmt5);

			$item = (!empty($rowdb25['LONGDESCRIPTION']))
				? $rowdb25['LONGDESCRIPTION']
				: (trim($rowdb21['DECOSUBCODE02']) . trim($rowdb21['DECOSUBCODE03']));

			// ======= INI YANG SAYA PERBAIKI: DB2 BUKAN LIMIT 1 =======
			$sqlDB26 = " SELECT SALESORDERLINE.EXTERNALREFERENCE 
                FROM DB2ADMIN.SALESORDERLINE SALESORDERLINE
                WHERE SALESORDERLINE.ITEMTYPEAFICODE='{$rowdb21['ITEMTYPECODE']}' AND
                    SALESORDERLINE.PROJECTCODE='{$rowdb21['PROJECTCODE']}' AND
                    SALESORDERLINE.SUBCODE01='{$rowdb21['DECOSUBCODE01']}' AND
                    SALESORDERLINE.SUBCODE02='{$rowdb21['DECOSUBCODE02']}' AND
                    SALESORDERLINE.SUBCODE03='{$rowdb21['DECOSUBCODE03']}' AND
                    SALESORDERLINE.SUBCODE04='{$rowdb21['DECOSUBCODE04']}' AND
                    SALESORDERLINE.SUBCODE05='{$rowdb21['DECOSUBCODE05']}' AND
                    SALESORDERLINE.SUBCODE06='{$rowdb21['DECOSUBCODE06']}' AND
                    SALESORDERLINE.SUBCODE07='{$rowdb21['DECOSUBCODE07']}' AND
                    SALESORDERLINE.SUBCODE08='{$rowdb21['DECOSUBCODE08']}'
                FETCH FIRST 1 ROW ONLY
            ";
			$stmt6 = db2_exec($conn1, $sqlDB26, ['cursor' => DB2_SCROLLABLE]);
			if (!$stmt6) {
				error_log("DB2 ERROR sqlDB26: " . db2_stmt_errormsg());
				continue;
			}
			$rowdb26 = db2_fetch_assoc($stmt6);

			$PO = (!empty($rowdb22['EXTERNALREFERENCE'])) ? $rowdb22['EXTERNALREFERENCE'] : ($rowdb26['EXTERNALREFERENCE'] ?? '');

			$sqlDB27 = " SELECT ADSTORAGE.NAMENAME,ADSTORAGE.VALUEDECIMAL 
                FROM DB2ADMIN.ADSTORAGE ADSTORAGE RIGHT OUTER JOIN DB2ADMIN.PRODUCT PRODUCT 
                ON ADSTORAGE.UNIQUEID=PRODUCT.ABSUNIQUEID WHERE
                PRODUCT.ITEMTYPECODE='{$rowdb21['ITEMTYPECODE']}' AND	
                PRODUCT.SUBCODE01='{$rowdb21['DECOSUBCODE01']}' AND
                PRODUCT.SUBCODE02='{$rowdb21['DECOSUBCODE02']}' AND
                PRODUCT.SUBCODE03='{$rowdb21['DECOSUBCODE03']}' AND
                PRODUCT.SUBCODE04='{$rowdb21['DECOSUBCODE04']}' AND
                PRODUCT.SUBCODE05='{$rowdb21['DECOSUBCODE05']}' AND
                PRODUCT.SUBCODE06='{$rowdb21['DECOSUBCODE06']}' AND
                PRODUCT.SUBCODE07='{$rowdb21['DECOSUBCODE07']}' AND
                PRODUCT.SUBCODE08='{$rowdb21['DECOSUBCODE08']}' AND 
                ADSTORAGE.NAMENAME='Width'
            ";
			$stmt7 = db2_exec($conn1, $sqlDB27, ['cursor' => DB2_SCROLLABLE]);
			if (!$stmt7) {
				error_log("DB2 ERROR sqlDB27: " . db2_stmt_errormsg());
				continue;
			}
			$rowdb27 = db2_fetch_assoc($stmt7);

			$sqlDB28 = " SELECT ADSTORAGE.NAMENAME,ADSTORAGE.VALUEDECIMAL 
                FROM DB2ADMIN.ADSTORAGE ADSTORAGE RIGHT OUTER JOIN DB2ADMIN.PRODUCT PRODUCT 
                ON ADSTORAGE.UNIQUEID=PRODUCT.ABSUNIQUEID WHERE
                PRODUCT.ITEMTYPECODE='{$rowdb21['ITEMTYPECODE']}' AND	
                PRODUCT.SUBCODE01='{$rowdb21['DECOSUBCODE01']}' AND
                PRODUCT.SUBCODE02='{$rowdb21['DECOSUBCODE02']}' AND
                PRODUCT.SUBCODE03='{$rowdb21['DECOSUBCODE03']}' AND
                PRODUCT.SUBCODE04='{$rowdb21['DECOSUBCODE04']}' AND
                PRODUCT.SUBCODE05='{$rowdb21['DECOSUBCODE05']}' AND
                PRODUCT.SUBCODE06='{$rowdb21['DECOSUBCODE06']}' AND
                PRODUCT.SUBCODE07='{$rowdb21['DECOSUBCODE07']}' AND
                PRODUCT.SUBCODE08='{$rowdb21['DECOSUBCODE08']}' AND 
                ADSTORAGE.NAMENAME='GSM'
            ";
			$stmt8 = db2_exec($conn1, $sqlDB28, ['cursor' => DB2_SCROLLABLE]);
			if (!$stmt8) {
				error_log("DB2 ERROR sqlDB28: " . db2_stmt_errormsg());
				continue;
			}
			$rowdb28 = db2_fetch_assoc($stmt8);

			// INSERT SQL SERVER (PARAMETERIZED)
			$sqlInsert = "
                INSERT INTO dbnow_gkj.dbo.tbl_opname (
                    itm, langganan, buyer, po, orderno, tipe, no_item, jns_kain, no_warna, warna,
                    rol, lot, [weight], satuan, [length], satuan_len, zone, lokasi, lebar, gramasi,
                    tgl_tutup, tgl_buat
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                    ?, GETDATE()
                )
            ";

			$params = [
				$item,
				$langganan,
				$buyer,
				$PO,
				$rowdb21['PROJECTCODE'],
				$jns,
				$itemNo,
				$rowdb21['JNSKAIN'],
				$rowdb21['DECOSUBCODE05'],
				($rowdb23['LONGDESCRIPTION'] ?? ''),

				(int) ($rowdb21['ROLL'] ?? 0),
				($rowdb21['LOTCODE'] ?? ''),
				round((float) ($rowdb21['BERAT'] ?? 0), 2),
				($rowdb21['BASEPRIMARYUNITCODE'] ?? ''),
				round((float) ($rowdb21['YD'] ?? 0), 2),
				($rowdb21['BASESECONDARYUNITCODE'] ?? ''),
				($rowdb21['WHSLOCATIONWAREHOUSEZONECODE'] ?? ''),
				($rowdb21['WAREHOUSELOCATIONCODE'] ?? ''),
				round((float) ($rowdb27['VALUEDECIMAL'] ?? 0), 0),
				round((float) ($rowdb28['VALUEDECIMAL'] ?? 0), 0),

				$Awal
			];

			$stmtIns = sqlsrv_query($con, $sqlInsert, $params);
			if ($stmtIns === false) {
				error_log("SQLSRV INSERT ERROR: " . print_r(sqlsrv_errors(), true));
				// kalau mau stop total:
				die("GAGAL SIMPAN. Cek php-error.log");
			}

			$inserted++;
		}

		if ($inserted > 0) {
			echo "<script>$(function(){ toastr.success('Stok Tgl {$Awal} Sudah ditutup ({$inserted} row)'); });</script>";
			echo "<meta http-equiv='refresh' content='0; url=TutupHarian'>";
		} else {
			echo "<script>$(function(){ toastr.error('Tidak ada data yang di-insert. Cek php-error.log'); });</script>";
		}
	}
}
?>