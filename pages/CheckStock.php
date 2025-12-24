<?php
	$Zone      = isset($_POST['zone']) ? $_POST['zone'] : '';
	$Lokasi    = isset($_POST['lokasi']) ? $_POST['lokasi'] : '';
	$Barcode   = substr($_POST['barcode'], -13);
	$Shift     = "";
	$sqlErrors = [];

	$schema       = 'dbnow_gkj';
	$tblStokfull  = "[$schema].[tbl_stokfull]";
	$tblUpload    = "[$schema].[tbl_upload]";
	$tblStokloss  = "[$schema].[tbl_stokloss]";
	$tblZone      = "[$schema].[tbl_zone]";
	$tblLokasi    = "[$schema].[tbl_lokasi]";

	// Helpers
	function logSqlError($stmt, $label = '', $line = null) {
		global $sqlErrors;
		if ($stmt !== false) {
			return;
		}
		$err = sqlsrv_errors();
		if (!empty($err)) {
			$msg = $label !== '' ? $label . ': ' : '';
			if ($line !== null) {
				$msg = "[line $line] " . $msg;
			}
			$msg .= $err[0]['message'];
			$sqlErrors[] = $msg;
			echo "<script>console.error('SQLSRV error: " . addslashes($msg) . "');</script>";
		}
	}

	function fetchOrDefault($stmt, $default = array('jml' => 0), $label = '', $line = null) {
		if ($stmt === false) {
			logSqlError($stmt, $label, $line);
			return $default;
		}
		$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
		return $row ?: $default;
	}

	// Filter builder
	if (strlen($Lokasi) > 2) {
		if ($Lokasi == "ALL") {
			$WhereLokasi  = " ";
			$WhereLokasi1 = " ";
		} else {
			$WhereLokasi  = " AND sf.lokasi = '$Lokasi' ";
			$WhereLokasi1 = " AND lokasi = '$Lokasi' ";
		}
	} else {
		$WhereLokasi  = " AND sf.lokasi LIKE '$Lokasi%' ";
		$WhereLokasi1 = " AND lokasi LIKE '$Lokasi%' ";
	}

	// Counters
	$qryCek1 = "SELECT 
					COUNT(*) as jml 
				FROM 
					$tblStokfull sf
				LEFT JOIN $tblUpload tu ON tu.id=sf.id_upload
				WHERE 
					tu.status='Open' 
					AND sf.status='ok' 
					AND sf.zone='$Zone' $WhereLokasi";
	$sqlCek1 = sqlsrv_query($con, $qryCek1, [], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
	$ck1 = fetchOrDefault($sqlCek1, array('jml' => 0), 'cek stok ok count', __LINE__);

	$qryCek2 = "SELECT 
					COUNT(*) as jml 
				FROM 
					$tblStokfull sf
				LEFT JOIN $tblUpload tu ON tu.id=sf.id_upload
				WHERE 
					tu.status='Open' 
					AND sf.status='belum cek' 
					AND sf.zone='$Zone' $WhereLokasi";
	$sqlCek2 = sqlsrv_query($con, $qryCek2, [], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
	$ck2 = fetchOrDefault($sqlCek2, array('jml' => 0), 'cek stok belum count', __LINE__);

	// Submit handler
	if ($_POST['cek'] == "Cek" || $_POST['cari'] == "Cari") {
		$qryCekSN = "SELECT 
						COUNT(*) as jml, 
						MAX(sf.id_upload) AS id_upload 
					FROM 
						$tblStokfull sf
					LEFT JOIN $tblUpload tu ON tu.id=sf.id_upload
					WHERE 
						tu.status='Open' 
						AND zone = '$Zone' 
						AND SN = '$Barcode' 
						$WhereLokasi1";
		$sqlCek = sqlsrv_query($con, $qryCekSN, [], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
		$ck = fetchOrDefault($sqlCek, array('jml' => 0, 'id_upload' => null), 'cek SN di stokfull', __LINE__);

		if ($Zone == "" && $Lokasi == "") {
			echo "<script>alert('Zone atau Lokasi belum dipilih');</script>";
		} elseif (is_numeric(trim($Barcode)) && $Barcode != "" && strlen($Barcode) == 13 && (substr($Barcode, 0, 2) == "15" || substr($Barcode, 0, 2) == "16" || substr($Barcode, 0, 2) == "17" || substr($Barcode, 0, 2) == "18" || substr($Barcode, 0, 2) == "19" || substr($Barcode, 0, 2) == "20" || substr($Barcode, 0, 2) == "21" || substr($Barcode, 0, 2) == "22" ||substr($Barcode, 0, 2) == "23" || substr($Barcode, 0, 2) == "24" || substr($Barcode, 0, 3) == "000" || substr($Barcode, 0, 2) == "00" ||substr($Barcode, 0, 2) == "80")) {
			if ($ck['jml'] > 0) {
				$qryUpdateStokOk = "UPDATE 
										$tblStokfull 
									SET
										status='ok',
										tgl_cek=GETDATE()
									WHERE 
										id_upload='$ck[id_upload]' 
										AND zone = '$Zone' 
										AND lokasi = '$Lokasi' 
										AND SN='$Barcode'";
				$sqlData = sqlsrv_query($con, $qryUpdateStokOk);

				$qryCntOkLokasi = "SELECT 
										COUNT(*) as jml 
									FROM 
										$tblStokfull 
									WHERE 
										status = 'ok' 
										AND zone = '$Zone' 
										AND lokasi = '$Lokasi'";
				$sqlCek1 = sqlsrv_query($con, $qryCntOkLokasi, [], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
				$ck1 = fetchOrDefault($sqlCek1, array('jml' => 0), 'hitung stok ok lokasi', __LINE__);

				$qryCntBelumLokasi = "SELECT 
										COUNT(*) as jml 
										FROM 
											$tblStokfull 
										WHERE 
											status = 'belum cek' 
											AND zone = '$Zone' 
											AND lokasi = '$Lokasi'";
				$sqlCek2 = sqlsrv_query($con, $qryCntBelumLokasi, [], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
				$ck2 = fetchOrDefault($sqlCek2, array('jml' => 0), 'hitung stok belum cek lokasi', __LINE__);
			} else {
				$sqlDB21 = "SELECT 
								WHSLOCATIONWAREHOUSEZONECODE, 
								WAREHOUSELOCATIONCODE, 
								CREATIONDATETIME,
								BASEPRIMARYQUANTITYUNIT
							FROM
								BALANCE b 
							WHERE 
								(b.ITEMTYPECODE='KFF' OR b.ITEMTYPECODE='FKF') 
								AND b.ELEMENTSCODE='$Barcode'";
				$stmt1   = db2_exec($conn1, $sqlDB21, array('cursor' => DB2_SCROLLABLE));
				$rowdb21 = db2_fetch_assoc($stmt1);
				$lokasiAsli = trim($rowdb21['WHSLOCATIONWAREHOUSEZONECODE']) . "-" . trim($rowdb21['WAREHOUSELOCATIONCODE']);
				$tglMasuk = substr($rowdb21['CREATIONDATETIME'], 0, 10);
				$KGnow = round($rowdb21['BASEPRIMARYQUANTITYUNIT'], 2);

				if ($lokasiAsli != "-") {
					echo "<script>alert('Data Roll ini dilokasi $lokasiAsli');</script>";

					$Where = " AND sf.zone='$Zone' AND sf.lokasi = '$Lokasi' ";
					$qryAmbilStok = "SELECT 
										sf.* 
									FROM 
										$tblStokfull sf
									LEFT JOIN $tblUpload tu ON tu.id=sf.id_upload
									WHERE 
										tu.status='Open' $Where ";
					$sql = sqlsrv_query($con, $qryAmbilStok, [], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
					$rowd = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC);

					$qryInsertLoss = "INSERT INTO $tblStokloss 
										(lokasi, lokasi_asli, KG, zone, SN, tgl_masuk, id_upload, tgl_cek)
										VALUES (?, ?, ?, ?, ?, ?, ?, GETDATE())";
					$sqlDataE = sqlsrv_query($con, $qryInsertLoss, [$Lokasi, $lokasiAsli, $KGnow, $Zone, $Barcode, $tglMasuk, $rowd['id_upload']]);
				} else {
					echo "<script>alert('SN tidak OK');</script>";
					
					$Where = "AND sf.zone='$Zone' $WhereLokasi ";
					$qryAmbilStok = "SELECT 
										sf.* 
									FROM 
										$tblStokfull sf
									LEFT JOIN $tblUpload tu ON tu.id=sf.id_upload
									WHERE 
										tu.status='Open' $Where ";
					$sql = sqlsrv_query($con, $qryAmbilStok, [], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
					$rowd = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC);

					$qryInsertLoss = "INSERT INTO $tblStokloss 
										(lokasi, lokasi_asli, KG, zone, SN, tgl_masuk, id_upload, tgl_cek)
										VALUES (?, ?, ?, ?, ?, ?, ?, GETDATE())";
					$sqlDataE = sqlsrv_query($con, $qryInsertLoss, [$Lokasi, $lokasiAsli, $KGnow, $Zone, $Barcode, $tglMasuk, $rowd['id_upload']]);
				}

				$qryCekLoss = "SELECT 
								COUNT(*) as jml, 
								MAX(sf.id_upload) AS id_upload 
								FROM 
									$tblStokfull sf
								LEFT JOIN $tblUpload tu ON tu.id=sf.id_upload
								WHERE 
									tu.status='Open' AND SN='$Barcode'";
				$sqlCek1 = sqlsrv_query($con, $qryCekLoss, [], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
				$ck1 = fetchOrDefault($sqlCek1, array('jml' => 0, 'id_upload' => null), 'cek SN di stokfull (insert loss)', __LINE__);

				if ($ck1['jml'] > 0) {
					$qryUpdateLossOk = "UPDATE 
											$tblStokfull 
										SET
											status='ok',
											zone='$Zone',
											lokasi='$Lokasi',
											tgl_cek=GETDATE()
										WHERE id_upload='$ck1[id_upload]' AND SN='$Barcode'";
					$sqlData1 = sqlsrv_query($con, $qryUpdateLossOk);
				}
			}
		} elseif ($Barcode == "") {
			// barcode masih kosong
		} else {
			echo "<script>alert('SN tidak ditemukan');</script>";
		}
	}
?>
<!-- Main content -->
<div class="container-fluid">
	<?php if (!empty($sqlErrors)) { ?>
		<div class="alert alert-danger">
			<strong>SQL Error:</strong>
			<ul style="margin-bottom:0;">
				<?php foreach ($sqlErrors as $errMsg) { ?>
					<li><?php echo htmlspecialchars($errMsg); ?></li>
				<?php } ?>
			</ul>
		</div>
	<?php } ?>
	<form role="form" method="post" enctype="multipart/form-data" name="form1">
		<div class="card card-default">
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
					<div class="input-group input-group-sm">
						<select class="form-control select2bs4" style="width: 80%;" name="zone">
							<option value="">Pilih</option>
							<?php $qryZoneOpt = " SELECT * FROM $tblZone order by nama ASC";
							$sqlZ = sqlsrv_query($con, $qryZoneOpt, [], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
							while ($sqlZ && ($rZ = sqlsrv_fetch_array($sqlZ, SQLSRV_FETCH_ASSOC))) {
							?>
								<option value="<?php echo $rZ['nama']; ?>" <?php if ($rZ['nama'] == $Zone) {
																				echo "SELECTED";
																			} ?>><?php echo $rZ['nama']; ?></option>
							<?php  } ?>
						</select>
						<span class="input-group-append">
							<button type="button" class="btn btn-warning btn-flat" data-toggle="modal" data-target="#DataZone"><i class="fa fa-plus"></i> </button>
						</span>
					</div>
				</div>
				<div class="form-group row">
					<label for="lokasi" class="col-md-1">Location</label>
					<div class="input-group input-group-sm">
						<select class="form-control select2bs4" style="width: 80%;" name="lokasi">
							<option value="">Pilih</option>
							<?php $qryLokasiOpt = " SELECT * FROM $tblLokasi WHERE zone='$Zone' order by nama ASC";
							$sqlL = sqlsrv_query($con, $qryLokasiOpt, [], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
							while ($sqlL && ($rL = sqlsrv_fetch_array($sqlL, SQLSRV_FETCH_ASSOC))) {
							?>
								<option value="<?php echo $rL['nama']; ?>" <?php if ($rL['nama'] == $Lokasi) {
																				echo "SELECTED";
																			} ?>><?php echo $rL['nama']; ?></option>
							<?php  } ?>
						</select>
						<span class="input-group-append">
							<button type="button" class="btn btn-warning btn-flat" data-toggle="modal" data-target="#DataLokasi"><i class="fa fa-plus"></i> </button>
						</span>
					</div>
				</div>
				<button class="btn btn-info" type="submit" value="Cari" name="cari">Cari Data</button>
			</div>

			<!-- /.card-body -->

		</div>
		<!--	</form>
		<form role="form" method="post" enctype="multipart/form-data" name="form2">-->
		<div class="card card-default">

			<!-- /.card-header -->
			<div class="card-body">
				<div class="form-group row">
					<label for="barcode" class="col-md-1">Barcode</label>
					<input type="text" class="form-control" name="barcode" placeholder="SN / Elements" id="barcode" on autofocus>
				</div>
				<button class="btn btn-primary" type="submit" name="cek" value="Cek">Check</button>

			</div>

			<!-- /.card-body -->

		</div>
	</form>
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Stock</h3>
		</div>
		<!-- /.card-header -->
		<div class="card-body">
			<strong>Stok OK Sesuai Tempat</strong> <small class='badge badge-success'> <?php echo $ck1['jml']; ?> roll </small><br>
			<strong>Stok belum Cek</strong> <small class='badge badge-danger'> <?php echo $ck2['jml']; ?> roll </small>
			<table id="example1" class="table table-sm table-bordered table-striped" style="font-size:13px;">
				<thead>
					<tr>
						<th style="text-align: center">SN</th>
						<th style="text-align: center">Kg</th>
						<th style="text-align: center">Status</th>
						<th style="text-align: center">Lokasi</th>
						<th style="text-align: center">NOW</th>
						<th style="text-align: center">Lot</th>
						<th style="text-align: center">Warna</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if (!empty($Zone) && !empty($Lokasi) && strlen($Lokasi) > 2) {
							if ($Lokasi == "ALL") {
								$Where = " AND sf.zone='$Zone' ";
							} else {
								$Where = " AND sf.zone='$Zone' AND sf.lokasi = '$Lokasi' ";
							}
						} else if (!empty($Zone) && !empty($Lokasi) && strlen($Lokasi) == 2) {
							$Where = " AND sf.zone='$Zone' AND sf.lokasi LIKE '$Lokasi%' ";
						} else {
							$Where = " AND sf.zone='$Zone' AND sf.lokasi = '$Lokasi' ";
						}
					if ($Shift != "") {
						$Shft = " AND a.shft='$Shift' ";
					} else {
						$Shft = " ";
					}
						$qryStokList = "SELECT sf.* FROM $tblStokfull sf
													LEFT JOIN $tblUpload tu ON tu.id=sf.id_upload  
													WHERE tu.status='Open' $Where";
						$sql = sqlsrv_query($con, $qryStokList);
					$no = 1;
					$c = 0;
					logSqlError($sql, 'query stokfull', __LINE__);
					while ($sql && ($rowd = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC))) {
						$sqlDB22 = " SELECT WHSLOCATIONWAREHOUSEZONECODE, WAREHOUSELOCATIONCODE FROM 
									BALANCE b WHERE (b.ITEMTYPECODE='KFF' OR b.ITEMTYPECODE='FKF') AND b.ELEMENTSCODE='$rowd[SN]' ";
						$stmt2   = db2_exec($conn1, $sqlDB22, array('cursor' => DB2_SCROLLABLE));
						$rowdb22 = db2_fetch_assoc($stmt2);
						$lokasiBalance = trim($rowdb22['WHSLOCATIONWAREHOUSEZONECODE']) . "-" . trim($rowdb22['WAREHOUSELOCATIONCODE']);
					?>
						<tr>
							<td style="text-align: center"><?php echo $rowd['SN']; ?></td>
							<td style="text-align: right"><?php echo $rowd['KG']; ?></td>
							<td style="text-align: center"><small class='badge <?php if ($rowd['status'] == "ok") {
																					echo "badge-success";
																				} else if ($rowd['status'] == "belum cek") {
																					echo "badge-danger";
																				} ?>'> <?php echo $rowd['status']; ?></small></td>
							<td style="text-align: center"><?php echo $rowd['zone'] . "-" . $rowd['lokasi']; ?></td>
							<td style="text-align: center"><?php echo $lokasiBalance; ?></td>
							<td style="text-align: center"><?php echo $rowd['lot']; ?></td>
							<td style="text-align: center"><?php echo $rowd['warna']; ?></td>
						</tr>
					<?php

						$no++;
					} ?>
				</tbody>

			</table>
		</div>
		<!-- /.card-body -->
	</div>
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">ReCheck Stock </h3>
		</div>
		<!-- /.card-header -->
		<div class="card-body">
			<table id="example3" class="table table-sm table-bordered table-striped" style="font-size:13px;">
				<thead>
					<tr>
						<th style="text-align: center">SN</th>
						<th style="text-align: center">KG</th>
						<th style="text-align: center">Lokasi Scan</th>
						<th style="text-align: center">Lokasi Asli(Data)</th>
						<th style="text-align: center">Tgl Masuk</th>
						<th style="text-align: center">Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if (!empty($Zone) && !empty($Lokasi) && strlen($Lokasi) > 2) {
							$Where = " AND zone='$Zone' AND lokasi = '$Lokasi' ";
						} else if (!empty($Zone) && !empty($Lokasi) && strlen($Lokasi) == 2) {
							$Where = " AND zone='$Zone' AND lokasi LIKE '%$Lokasi%' ";
						} else {
							$Where = " AND zone='$Zone' AND lokasi = '$Lokasi' ";
						}
						$qryStokLoss = "SELECT sl.*, count(SN) as jmlscn FROM $tblStokloss sl
		LEFT JOIN $tblUpload tu ON tu.id=sl.id_upload
		WHERE tu.`status`='Open' $Where  group by sl.SN";
						$sql1 = sqlsrv_query($con, $qryStokLoss);
					$no = 1;
					$c = 0;
					logSqlError($sql1, 'query stokloss', __LINE__);
					while ($sql1 && ($rowd1 = sqlsrv_fetch_array($sql1, SQLSRV_FETCH_ASSOC))) {
						if (strlen($rowd1['SN']) != "13") {
							$ketSN = "jumlah Karakter di SN tidak Sesuai";
						} else {
							$ketSN = "";
						}
						if ($rowd1['jmlscn'] > 1) {
							$ketSCN = "Jumlah Scan " . $rowd1['jmlscn'] . " kali";
						} else {
							$ketSCN = "";
						}
						if ($rowd1['tgl_masuk'] == "0000-00-00" or $rowd1['tgl_masuk'] == "" || $rowd1['tgl_masuk'] === null) {
							$tglmsk = "";
						} else if ($rowd1['tgl_masuk'] instanceof DateTime) {
							$tglmsk = $rowd1['tgl_masuk']->format('Y-m-d');
						} else {
							$tglmsk = $rowd1['tgl_masuk'];
						}
					?>
						<tr>
							<td style="text-align: center"><?php echo $rowd1['SN']; ?></td>
							<td style="text-align: center"><?php echo $rowd1['KG']; ?></td>
							<td style="text-align: center"><?php echo $rowd1['zone'] . "-" . $rowd1['lokasi']; ?></td>
							<td style="text-align: center"><?php echo $rowd1['lokasi_asli']; ?></td>
							<td style="text-align: center"><?php echo $tglmsk; ?></td>
							<td style="text-align: center"><small class='badge <?php if ($rowd1['status'] == "tidak ok") {
																					echo "badge-warning";
																				} ?>'><i class='fas fa-exclamation-triangle text-default blink_me'></i> <?php echo $rowd1['status']; ?></small> <?php echo $ketSN . ", " . $ketSCN; ?> </td>
						</tr>
					<?php

						$no++;
					} ?>
				</tbody>

			</table>
		</div>
		<!-- /.card-body -->
	</div>
</div><!-- /.container-fluid -->
<!-- /.content -->
<div class="modal fade" id="DataZone">
	<div class="modal-dialog">
		<form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Input Data Zone</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
					<span aria-hidden="true">&times;</span>
				</div>
				<div class="modal-body">
					<input type="hidden" id="id" name="id">
					<div class="form-group">
						<label for="zone1" class="col-md-3 control-label">Zone</label>
						<div class="col-md-12">
							<input type="text" class="form-control" id="zone1" name="zone1" maxlength="3" required>
							<span class="help-block with-errors"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<input type="submit" value="Save changes" name="simpan_zone" class="btn btn-primary">
				</div>
			</div>
		</form>
	</div>
</div>

<div class="modal fade" id="DataLokasi">
	<div class="modal-dialog">
		<form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Input Data Lokasi</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
					<span aria-hidden="true">&times;</span>
				</div>
				<div class="modal-body">
					<input type="hidden" id="id" name="id">
					<div class="form-group">
						<label for="zone" class="col-md-3 control-label">Zone</label>
						<div class="col-md-12">
							<select class="form-control select2bs4" name="zone2" required>
								<option value="">Pilih</option>
								<?php $qryZoneOptModal = " SELECT * FROM $tblZone order by nama ASC";
								$sqlZ = sqlsrv_query($con, $qryZoneOptModal, [], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
								while ($sqlZ && ($rZ = sqlsrv_fetch_array($sqlZ, SQLSRV_FETCH_ASSOC))) {
								?>
									<option value="<?php echo $rZ['nama']; ?>"><?php echo $rZ['nama']; ?></option>
								<?php  } ?>
							</select>
							<span class="help-block with-errors"></span>
						</div>
					</div>
					<div class="form-group">
						<label for="lokasi1" class="col-md-3 control-label">Lokasi</label>
						<div class="col-md-12">
							<input type="text" class="form-control" id="lokasi1" name="lokasi1" maxlength="10" required>
							<span class="help-block with-errors"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<input type="submit" value="Save changes" name="simpan_lokasi" class="btn btn-primary">
				</div>
			</div>
		</form>
	</div>
</div>
<?php
	if ($_POST['simpan_zone'] == "Save changes") {
		$zone1 = strtoupper($_POST['zone1']);
		$qryInsertZone = "INSERT INTO $tblZone (nama) VALUES (?)";
		$sqlData1 = sqlsrv_query(
			$con,
			$qryInsertZone,
			[$zone1]
		);
		if ($sqlData1 !== false) {
			echo "<script>window.location='CheckStock';</script>";
		}
	}
	if ($_POST['simpan_lokasi'] == "Save changes") {
		$zone2 = strtoupper($_POST['zone2']);
		$lokasi2 = strtoupper($_POST['lokasi1']);
		$qryInsertLokasi = "INSERT INTO $tblLokasi (nama, zone) VALUES (?, ?)";
		$sqlDataLokasi = sqlsrv_query(
			$con,
			$qryInsertLokasi,
			[$lokasi2, $zone2]
		);
		if ($sqlDataLokasi !== false) {
			echo "<script>window.location='CheckStock';</script>";
		}
	}
?>
<script>
	$(function() {
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
