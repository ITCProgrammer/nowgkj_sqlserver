<?php
$tglParam = isset($_GET['tgl']) ? $_GET['tgl'] : '';
$schema   = 'dbnow_gkj';
$sqlErrors = [];
$tblOpnameDetailBB = "[$schema].[tbl_opname_detail_bb_11]";

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
?>
<!-- Main content -->
<div class="container-fluid">
    <div class="card card-pink">
        <div class="card-header">
            <h3 class="card-title">Stock Tanggal <?php echo htmlspecialchars($tglParam); ?></h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-sm table-bordered table-striped" style="font-size:13px;">
                <thead>
                    <tr>
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
                        <th style="text-align: center">Lot</th>
                        <th style="text-align: center">Rol</th>
                        <th style="text-align: center">Weight</th>
                        <th style="text-align: center">Satuan</th>
                        <th style="text-align: center">Length</th>
                        <th style="text-align: center">Satuan</th>
                        <th style="text-align: center">ElementNo</th>
                        <th style="text-align: center">Zone</th>
                        <th style="text-align: center">Lokasi</th>
                        <th style="text-align: center">Lebar</th>
                        <th style="text-align: center">Gramasi</th>
                        <th style="text-align: center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no       = 1;
                    $totrol   = 0;
                    $totkg    = 0;
                    $sql      = "SELECT * FROM $tblOpnameDetailBB WHERE tgl_tutup = ? ORDER BY id ASC";
                    $stmtList = sqlsrv_query($con, $sql, [$tglParam], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
                    logSqlError($stmtList, 'list detail BB', __LINE__);
                    while ($stmtList && ($r = sqlsrv_fetch_array($stmtList, SQLSRV_FETCH_ASSOC))) {
                        ?>
                        <tr>
                            <td style="text-align: left"><?php echo $r['itm']; ?></td>
                            <td style="text-align: left"><?php echo $r['langganan']; ?></td>
                            <td style="text-align: left"><?php echo $r['buyer']; ?></td>
                            <td style="text-align: center"><?php echo $r['po']; ?></td>
                            <td style="text-align: center"><?php echo $r['orderno']; ?></td>
                            <td style="text-align: center"><?php echo $r['tipe']; ?></td>
                            <td style="text-align: center"><?php echo $r['no_item']; ?></td>
                            <td style="text-align: center"><?php echo $r['jns_kain']; ?></td>
                            <td style="text-align: center"><?php echo $r['no_warna']; ?></td>
                            <td style="text-align: center"><?php echo $r['warna']; ?></td>
                            <td style="text-align: center"><?php echo $r['lot']; ?></td>
                            <td style="text-align: center"><?php echo $r['rol']; ?></td>
                            <td style="text-align: right"><?php echo $r['weight']; ?></td>
                            <td style="text-align: center"><?php echo $r['satuan']; ?></td>
                            <td style="text-align: center"><?php echo $r['length']; ?></td>
                            <td style="text-align: center"><?php echo $r['satuan_len']; ?></td>
                            <td style="text-align: center"><?php echo $r['sn']; ?></td>
                            <td style="text-align: center"><?php echo $r['zone']; ?></td>
                            <td style="text-align: center"><?php echo $r['lokasi']; ?></td>
                            <td style="text-align: center"><?php echo $r['lebar']; ?></td>
                            <td style="text-align: center"><?php echo $r['gramasi']; ?></td>
                            <td style="text-align: center"><?php echo $r['sts_kain']; ?></td>
                        </tr>
                        <?php
                        $no++;
                        $totrol += $r['rol'];
                        $totkg  += $r['weight'];
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
                        <td style="text-align: right">&nbsp;</td>
                        <td style="text-align: right">&nbsp;</td>
                        <td style="text-align: right">&nbsp;</td>
                        <td style="text-align: right"><strong>TOTAL</strong></td>
                        <td style="text-align: right"><strong><?php echo $totrol; ?></strong></td>
                        <td style="text-align: right"><strong><?php echo number_format(round($totkg,3),3); ?></strong></td>
                        <td style="text-align: center"><strong>KGs</strong></td>
                        <td style="text-align: right">&nbsp;</td>
                        <td style="text-align: right">&nbsp;</td>
                        <td style="text-align: right">&nbsp;</td>
                        <td style="text-align: right">&nbsp;</td>
                        <td style="text-align: center">&nbsp;</td>
                        <td style="text-align: center">&nbsp;</td>
                        <td style="text-align: center">&nbsp;</td>
                        <td style="text-align: center">&nbsp;</td>
                    </tr>
                </tfoot>
            </table>
            <?php if (!empty($sqlErrors)) { ?>
                <div class="alert alert-danger" style="margin-top:10px;">
                    <strong>SQL Error:</strong>
                    <ul style="margin-bottom:0;">
                        <?php foreach ($sqlErrors as $errMsg) { ?>
                            <li><?php echo htmlspecialchars($errMsg); ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
        <!-- /.card-body -->
    </div>
</div><!-- /.container-fluid -->
<!-- /.content -->
<script>
	$(function () {
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
