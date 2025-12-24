<?php
    $LotOld = isset($_POST['lotOld']) ? $_POST['lotOld'] : '';
    $LotNew = isset($_POST['lotNew']) ? $_POST['lotNew'] : '';
    $Barcode = isset($_POST['barcode']) ? substr($_POST['barcode'], -13) : '';
    $ip = $_SERVER['REMOTE_ADDR'];
    $date = date('Y-m-d H:i:s');
    $sqlErrors = [];
    $schema = 'dbnow_gkj';
    $tblTempChangeLot = "[$schema].[tbl_temp_change_lot]";
    $tblChangeLot    = "[$schema].[tbl_change_lot]";

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
    $sqldb2 = "SELECT
                    DISTINCT *,TRIM(WHSLOCATIONWAREHOUSEZONECODE) || '-' || TRIM(WAREHOUSELOCATIONCODE) AS LOKASI
                FROM
                    (
                    SELECT DISTINCT
                        s2.USERPRIMARYQUANTITY AS QTY_PRIMARY,
                        s2.USERSECONDARYQUANTITY AS QTY_SECONDARY,
                        s2.USERPRIMARYUOMCODE AS UOM_PRIMARY,
                        s2.USERSECONDARYUOMCODE AS UOM_SECONDARY,
                        s2.LOTCODE AS OLD_LOT,
                        s.LOTCODE AS NEW_LOT,
                        s.ITEMELEMENTCODE,
                        s.DECOSUBCODE01,
                        s.DECOSUBCODE02,
                        s.DECOSUBCODE03,
                        s.DECOSUBCODE04,
                        s.DECOSUBCODE05,
                        s.DECOSUBCODE06,
                        s.DECOSUBCODE07,
                        s.DECOSUBCODE08,
                        s.PROJECTCODE,
                        s.ITEMTYPECODE,
                        s2.LOGICALWAREHOUSECODE,
                        s.LOGICALWAREHOUSECODE,
                        s.WHSLOCATIONWAREHOUSEZONECODE,
                        s.WAREHOUSELOCATIONCODE
                    FROM
                        STOCKTRANSACTION s
                    LEFT JOIN STOCKTRANSACTION s2 ON s.TRANSACTIONNUMBER = s2.TRANSACTIONNUMBER AND s.ITEMELEMENTCODE = s2.ITEMELEMENTCODE AND s2.TEMPLATECODE = '313'
                    WHERE
                        s.TEMPLATECODE = '314' 	
                    )
                WHERE
                    OLD_LOT = '$LotOld'
                    AND NEW_LOT = '$LotNew'";
    $tes =[];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($LotOld == "" or $LotNew == "") {
            echo "<script>alert('Lot Lama dan Lot Baru WAJIB isi');</script>";
        } else {
            if (isset($_POST['cek']) && $_POST['cek'] == "Cek") {
                $stmt2 = db2_exec($conn1, $sqldb2, array('cursor' => DB2_SCROLLABLE));
                while ($rowd4 = db2_fetch_assoc($stmt2)) {
                    $elements = TRIM($rowd4['ITEMELEMENTCODE']);
                    if ($elements == $Barcode) {
                        $hasil = 'T';
                    }else {
                        $hasil = 'F';
                    } 
                    $tes[] = $hasil;
                }
                if (in_array('T', $tes)) {
                    $cekel = sqlsrv_query($con, "SELECT * FROM $tblTempChangeLot WHERE [elements] = ?", [$Barcode], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
                    logSqlError($cekel, 'cek temp change lot', __LINE__);
                    $stEl = $cekel ? sqlsrv_num_rows($cekel) : 0;
                    $cekel2 = sqlsrv_query($con, "SELECT * FROM $tblChangeLot WHERE [elements] = ?", [$Barcode], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
                    logSqlError($cekel2, 'cek change lot', __LINE__);
                    $stEl2 = $cekel2 ? sqlsrv_num_rows($cekel2) : 0;
                    if ($stEl >= 1 || $stEl2 >= 1) {
                        echo "<script>alert('Elements $Barcode Sudah Pernah Scan');</script>";
                    } else {
                        $sqldetail = "SELECT DISTINCT *,TRIM(WHSLOCATIONWAREHOUSEZONECODE) || '-' || TRIM(WAREHOUSELOCATIONCODE) AS LOKASI
                                FROM (SELECT DISTINCT
                                    s2.USERPRIMARYQUANTITY AS QTY_PRIMARY,
                                    s2.USERSECONDARYQUANTITY AS QTY_SECONDARY,
                                    s2.USERPRIMARYUOMCODE AS UOM_PRIMARY,
                                    s2.USERSECONDARYUOMCODE AS UOM_SECONDARY,
                                    s2.LOTCODE AS OLD_LOT,
                                            s.LOTCODE AS NEW_LOT,
                                            s.ITEMELEMENTCODE,
                                            s.DECOSUBCODE01,
                                            s.DECOSUBCODE02,
                                            s.DECOSUBCODE03,
                                            s.DECOSUBCODE04,
                                            s.DECOSUBCODE05,
                                            s.DECOSUBCODE06,
                                            s.DECOSUBCODE07,
                                            s.DECOSUBCODE08,
                                            s.PROJECTCODE,
                                            s.ITEMTYPECODE,
                                                s2.LOGICALWAREHOUSECODE AS ORIGINAL_LOKASI,
                                                s.LOGICALWAREHOUSECODE AS DESTINATION_LOKASI,
                                                s.WHSLOCATIONWAREHOUSEZONECODE,
                                                s.WAREHOUSELOCATIONCODE
                                        FROM STOCKTRANSACTION s
                                        LEFT JOIN STOCKTRANSACTION s2 ON s.TRANSACTIONNUMBER = s2.TRANSACTIONNUMBER
                                        AND s.ITEMELEMENTCODE = s2.ITEMELEMENTCODE
                                        AND s2.TEMPLATECODE = '313'
                                        WHERE s.TEMPLATECODE = '314')
                                WHERE OLD_LOT = '$LotOld'
                                AND NEW_LOT = '$LotNew'
                                AND ITEMELEMENTCODE = '$Barcode'";
                        $st = db2_exec($conn1, $sqldetail, array('cursor' => DB2_SCROLLABLE));
                        $detail = db2_fetch_assoc($st);
                        if ($detail) {
                            $elements_scan = $detail['ITEMELEMENTCODE'];
                            $lotold_scan = $detail['OLD_LOT'];
                            $lotnew_scan = $detail['NEW_LOT'];
                            $qty_primary_scan = $detail['QTY_PRIMARY'];
                            $qty_secondary_scan = $detail['QTY_SECONDARY'];
                            $uom_primary_scan = $detail['UOM_PRIMARY'];
                            $uom_secondary_scan = $detail['UOM_SECONDARY'];
                            $lokasi = $detail['LOKASI'];
                            $sqlinsert = "INSERT INTO $tblTempChangeLot ([elements], lot_old, lot_new, ip, tanggal_scan, qty_primary, qty_secondary, uom_primary, uom_secondary, lokasi)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                            $stmtIns = sqlsrv_query($con, $sqlinsert, [
                            $elements_scan,
                            $lotold_scan,
                            $lotnew_scan,
                            $ip,
                            $date,
                            $qty_primary_scan,
                            $qty_secondary_scan,
                            $uom_primary_scan,
                            $uom_secondary_scan,
                            $lokasi
                            ]);
                            logSqlError($stmtIns, 'insert temp change lot', __LINE__);
                        }
                    }
                }else{
                    echo "<script>alert('Element yang di Scan bukan dari LOT ini!');</script>";
                }
            }
        }
        if (isset($_POST['delete']) && $_POST['delete'] == 'delete' && isset($_POST['id'])) {
            $id = $_POST['id'];  // Ambil ID dari form

            $deleteQuery = "DELETE FROM $tblTempChangeLot WHERE id = ?";
            $stmt = sqlsrv_query($con, $deleteQuery, [$id]);
            logSqlError($stmt, 'delete temp change lot', __LINE__);
            if ($stmt !== false) {
                echo "<script>alert('Berhasil Dihapus');</script>";
            } else {
                echo "<script>alert('Gagal menghapus data');</script>";
            }
        }
        
    }

    if (isset($_POST['simpan']) && $_POST['simpan'] == "simpan") {
        $sql_temp = "SELECT * FROM $tblTempChangeLot WHERE ip = '$ip' AND lot_old = '$LotOld' AND lot_new = '$LotNew'";
        $stmt1 = sqlsrv_query($con, $sql_temp, [], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
        logSqlError($stmt1, 'list temp change lot for save', __LINE__);

        while ($stmt1 && ($scan_row = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC))) {
            $status = "1";
            $stmt = sqlsrv_query(
            $con,
            "INSERT INTO $tblChangeLot ([elements], lot_old, lot_new, ip, tanggal_scan, [status], qty_primary, qty_secondary, uom_primary, uom_secondary, lokasi)
                                            VALUES (?,?,?,?,?,?,?,?,?,?,?)",
            [
                $scan_row['elements'], 
                $scan_row['lot_old'], 
                $scan_row['lot_new'],
                $scan_row['ip'], 
                $scan_row['tanggal_scan'], 
                $status, 
                $scan_row['qty_primary'], 
                $scan_row['qty_secondary'],
                $scan_row['uom_primary'], 
                $scan_row['uom_secondary'],
                $scan_row['lokasi']
            ]
            );
            logSqlError($stmt, 'insert change lot', __LINE__);

            $delete_stmt = sqlsrv_query($con, "DELETE FROM $tblTempChangeLot WHERE [elements] = ?", [$scan_row['elements']]);
            logSqlError($delete_stmt, 'delete temp after save', __LINE__);
        }
    }

?>

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
        <!-- Filter Data Card -->
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
            <div class="card-body">
                <div class="form-group row">
                    <label for="zone" class="col-md-1">Lot Old</label>
                    <input type="text" class="form-control" name="lotOld" placeholder="Lot Lama" id="lotOld" value="<?=$LotOld?>">
                </div>
                <div class="form-group row">
                    <label for="lokasi" class="col-md-1">Lot New</label>
                    <input type="text" class="form-control" name="lotNew" placeholder="Lot Baru" id="lotNew" value="<?=$LotNew?>">
                </div>
                <button class="btn btn-info" type="submit" value="Cari" name="cari">Cari Data</button>
            </div>
        </div>

        <div class="card card-default">
            <div class="card-body">
                <div class="form-group row">
                    <label for="barcode" class="col-md-1">Barcode</label>
                    <input type="text" class="form-control" name="barcode" placeholder="SN / Elements" id="barcode" on autofocus>
                </div>
                <button class="btn btn-primary" type="submit" name="cek" value="Cek">Check</button>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">List Scan Elements</h3>
            </div>
            <div class="card-body">
                <table class="table table-sm table-bordered table-striped" style="font-size:13px;">
                    <thead>
                        <tr>
                            <th style="text-align: center">Elements</th>
                            <th style="text-align: center">Lot Old</th>
                            <th style="text-align: center">Lot New</th>
                            <th style="text-align: center">Tanggal Scan</th>
                            <th style="text-align: center">Qty Primary</th>
                            <th style="text-align: center">Qty Secondary</th>
                            <th style="text-align: center">Lokasi</th>
                            <th style="text-align: center">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_qty_primary_scan = 0;
                        $total_qty_secondary_scan = 0;
                        $total_rol1 =0;
                        $sql_temp = "SELECT * FROM $tblTempChangeLot WHERE ip = '$ip' AND lot_old = '$LotOld' AND lot_new = '$LotNew'";
                        $stmt1 = sqlsrv_query($con, $sql_temp, [], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
                        logSqlError($stmt1, 'list temp (table render)', __LINE__);
                        while ($stmt1 && ($scan_row = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC))) {
                            ?>
                            <tr>
                                <td style="text-align: left"><?=$scan_row['elements'];?></td>
                                <td style="text-align: center"><?=$scan_row['lot_old'];?></td>
                                <td style="text-align: center"><?=$scan_row['lot_new'];?></td>
                                <td style="text-align: center"><?=$scan_row['tanggal_scan'];?></td>
                                <td style="text-align: center"><?=$scan_row['qty_primary'] . ' '. $scan_row['uom_primary'];?></td>
                                <td style="text-align: center"><?=$scan_row['qty_secondary']. ' '. $scan_row['uom_secondary'];?></td>
                                <td style="text-align: center"><?=$scan_row['lokasi'];?></td>
                                <td style="text-align: center">
                                        <input type="hidden" name="id" value="<?= $scan_row['id'];?>">
                                        <button class="btn btn-danger" type="submit" name="delete" value="delete">Hapus</button>
                                </td>


                            </tr>
                            <?php  
                            $total_qty_primary_scan += $scan_row['qty_primary'];
                            $total_qty_secondary_scan += $scan_row['qty_secondary'];
                            $total_rol1 ++;
                        }?>
                    </tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right">Total</td>
                        <td style="text-align: center"><?php echo $total_qty_primary_scan . ' ' . $uom_primary_scan?></td>
                        <td style="text-align: center"><?php echo $total_qty_secondary_scan . ' '. $uom_secondary_scan?></td>
                        <td style="text-align: center"><?php echo $total_rol1. ' Roll';?></td>
                        <td></td>
                    </tr>
                </table>
                <br>
                <!-- Save Button -->
                <button class="btn btn-success" type="submit" name="simpan" value="simpan">Simpan</button>
            </div>
        </div>

        <div class="card">
              <div class="card-header">
                <h3 class="card-title">List Elements Old</h3>
              </div>
              <div class="card-body">
                <table id="example2" class="table table-sm table-bordered table-striped" style="font-size:13px;">
                    <thead>
                    <tr>
                        <th style="text-align: center">Elements</th>
                        <th style="text-align: center">Lot Old</th>
                        <th style="text-align: center">Lot New</th>
                        <th style="text-align: center">Qty Primary</th>
                        <th style="text-align: center">Qty Secondary</th>
                        <th style="text-align: center">Lokasi</th>
                        <th style="text-align: center" colspan="2">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $total_qty_primary = 0;
                    $total_qty_secondary = 0;
                    $qty_sudah_scan_primary = 0;
                    $qty_sudah_scan_secondary = 0;
                    $total_rol =0;

                    $stmt = db2_exec($conn1, $sqldb2, array('cursor' => DB2_SCROLLABLE));
                    while ($stmt && ($rowd = db2_fetch_assoc($stmt))) {
                        $cek_status = sqlsrv_query($con, "SELECT * FROM $tblChangeLot WHERE [elements] = ?", [$rowd['ITEMELEMENTCODE']], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
                        logSqlError($cek_status, 'cek status change lot', __LINE__);
                        $status = $cek_status ? sqlsrv_num_rows($cek_status) : 0;
                    ?>
                    <tr>
                        <td style="text-align: left"><?php echo TRIM($rowd['ITEMELEMENTCODE']); ?></td>
                        <td style="text-align: center"><?php echo $rowd['OLD_LOT']; ?></td>
                        <td style="text-align: center"><?php echo $rowd['NEW_LOT']; ?></td>
                        <td style="text-align: center"><?php echo round($rowd['QTY_PRIMARY'], 3) . ' ' .$rowd['UOM_PRIMARY']; ?></td>
                        <td style="text-align: center"><?php echo round($rowd['QTY_SECONDARY'],3) . ' ' .$rowd['UOM_SECONDARY']; ?></td>
                        <td style="text-align: center"><?php echo $rowd['LOKASI']; ?></td>
                        <td style="text-align: center" colspan="2"><?php
                            if ($status >= '1') {
                                echo "<span class='badge badge-success blink large-text'>Sudah Scan</span>";
                                $qty_sudah_scan_primary += $rowd['QTY_PRIMARY'];
                                $qty_sudah_scan_secondary += $rowd['QTY_SECONDARY'];
                            } else {
                                echo "<span class='badge badge-danger blink large-text'>Belum Scan</span>";
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                        $uom_primary = $rowd['UOM_PRIMARY'];
                        $uom_secondary = $rowd['UOM_SECONDARY'];
                        $total_qty_primary += $rowd['QTY_PRIMARY'];
                        $total_qty_secondary += $rowd['QTY_SECONDARY'];
                        $total_rol++;
                    } ?>
                    </tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align: right">TOTAL</td>
                        <td style="text-align: center"><?php echo $total_qty_primary . ' ' . $uom_primary; ?></td>
                        <td style="text-align: center"><?php echo $total_qty_secondary . ' ' . $uom_secondary; ?></td>
                        <td style="text-align: center"><?php echo $total_rol . ' Roll';?></td>
                        <td style="text-align: center"><?php echo $qty_sudah_scan_primary . ' ' . $uom_primary; ?></td>
                        <td style="text-align: center"><?php echo $qty_sudah_scan_secondary . ' ' . $uom_secondary; ?></td>
                    </tr>
                </table>
              </div>
         </div>
    </form>
</div>


<script>
    document.getElementById("barcode").addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Mencegah form disubmit jika Enter ditekan
            document.querySelector("button[type='submit'][name='cek']").click(); // Menekan tombol Cek secara otomatis
        }
    });
</script>
