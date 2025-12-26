<?php
$schema = 'dbnow_gkj';
$sqlErrors = [];

$tblOpnameDetail   = "[$schema].[tbl_opname_detail_11]";
$tblOpnameDetailBS = "[$schema].[tbl_opname_detail_bs_11]";
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
function formatSqlsrvDate($value, $format = 'Y-m-d') {
    if ($value instanceof DateTime) {
        return $value->format($format);
    }
    return $value;
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

    <div class="card card-yellow">
        <div class="card-header">
            <h3 class="card-title">Stock Kain Jadi</h3>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-sm table-bordered table-striped" style="font-size:13px;">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align: center">ALL ZONA</th>
                        <th rowspan="2" style="text-align: center">ACTION</th>
                        <th colspan="2" style="text-align: center">ZONA W1 (Lantai 1)</th>
                        <th colspan="2" style="text-align: center">ZONA W3 (Lantai 3)</th>
                        <th colspan="2" style="text-align: center">ZONA X1 (Area PRT)</th>
                        <th colspan="2" style="text-align: center">ZONA X2 (Lantai 2)</th>
                        <th colspan="2" style="text-align: center">ZONA X6 (Trolly)</th>
                        <th colspan="2" style="text-align: center">ZONA X7 (Rak)</th>
                        <th rowspan="2" style="text-align: center">TGL</th>
                    </tr>
                    <tr>
                        <th style="text-align: center">ROLL</th>
                        <th style="text-align: center">WEIGHT</th>
                        <th style="text-align: center">ROLL</th>
                        <th style="text-align: center">WEIGHT</th>
                        <th style="text-align: center">ROLL</th>
                        <th style="text-align: center">WEIGHT</th>
                        <th style="text-align: center">ROLL</th>
                        <th style="text-align: center">WEIGHT</th>
                        <th style="text-align: center">ROLL</th>
                        <th style="text-align: center">WEIGHT</th>
                        <th style="text-align: center">ROLL</th>
                        <th style="text-align: center">WEIGHT</th>
                        <th style="text-align: center">ROLL</th>
                        <th style="text-align: center">WEIGHT</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sqlKain = "SELECT 
    tgl_tutup,
    SUM(CASE WHEN zone IN ('W1', 'W3', 'X1', 'X2', 'X6', 'X7') THEN weight ELSE 0 END) AS ALL_WEIGHT,
    SUM(CASE WHEN zone IN ('W1', 'W3', 'X1', 'X2', 'X6', 'X7') THEN 1 ELSE 0 END) AS ALL_ROLL,
    SUM(CASE WHEN zone = 'W1' THEN weight ELSE 0 END) AS W1_WEIGHT,
    SUM(CASE WHEN zone = 'W1' THEN 1 ELSE 0 END) AS W1_ROLL,
    SUM(CASE WHEN zone = 'W3' THEN weight ELSE 0 END) AS W3_WEIGHT,
    SUM(CASE WHEN zone = 'W3' THEN 1 ELSE 0 END) AS W3_ROLL,
    SUM(CASE WHEN zone = 'X1' THEN weight ELSE 0 END) AS X1_WEIGHT,
    SUM(CASE WHEN zone = 'X1' THEN 1 ELSE 0 END) AS X1_ROLL,
    SUM(CASE WHEN zone = 'X2' THEN weight ELSE 0 END) AS X2_WEIGHT,
    SUM(CASE WHEN zone = 'X2' THEN 1 ELSE 0 END) AS X2_ROLL,
    SUM(CASE WHEN zone = 'X6' THEN weight ELSE 0 END) AS X6_WEIGHT,
    SUM(CASE WHEN zone = 'X6' THEN 1 ELSE 0 END) AS X6_ROLL,
    SUM(CASE WHEN zone = 'X7' THEN weight ELSE 0 END) AS X7_WEIGHT,
    SUM(CASE WHEN zone = 'X7' THEN 1 ELSE 0 END) AS X7_ROLL
FROM 
    $tblOpnameDetail tod
WHERE 
    tgl_tutup >= DATEADD(day,-5,CAST(GETDATE() AS date))
GROUP BY 
    tgl_tutup
ORDER BY 
    tgl_tutup DESC";
                $stmtKain = sqlsrv_query($con, $sqlKain, [], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
                logSqlError($stmtKain, 'list stok kain jadi', __LINE__);
                while ($stmtKain && ($rowdb = sqlsrv_fetch_array($stmtKain, SQLSRV_FETCH_ASSOC))) {
                    $tglTutup = formatSqlsrvDate($rowdb['tgl_tutup']);
                    $tglParam = urlencode($tglTutup);
                    ?>
                    <tr>
                        <td style="text-align: center"><?php echo number_format($rowdb['ALL_ROLL']);?></td>
                        <td style="text-align: right"><?php echo number_format($rowdb['ALL_WEIGHT'],2);?></td>
                        <td style="text-align: center"><div class="btn-group"><a href="pages/cetak/PersediaanKainJadiFullExcel11.php?tgl=<?php echo $tglParam;?>" target="_blank" class="btn btn-outline-info btn-xs disabled"><i class="fa fa-download"></i> Download</a>&nbsp;<a href="pages/cetak/PersediaanKainJadiFullDetailExcel11.php?tgl=<?php echo $tglParam;?>" target="_blank" class="btn btn-outline-warning btn-xs"><i class="fa fa-download"></i> Detail</a></div></td>
                        <td style="text-align: center"><?php echo number_format($rowdb['W1_ROLL']);?></td>
                        <td style="text-align: right"><?php echo number_format($rowdb['W1_WEIGHT'],2);?></td>
                        <td style="text-align: center"><?php echo number_format($rowdb['W3_ROLL']);?></td>
                        <td style="text-align: right"><?php echo number_format($rowdb['W3_WEIGHT'],2);?></td>
                        <td style="text-align: center"><?php echo number_format($rowdb['X1_ROLL']);?></td>
                        <td style="text-align: right"><?php echo number_format($rowdb['X1_WEIGHT'],2);?></td>
                        <td style="text-align: center"><?php echo number_format($rowdb['X2_ROLL']);?></td>
                        <td style="text-align: right"><?php echo number_format($rowdb['X2_WEIGHT'],2);?></td>
                        <td style="text-align: center"><?php echo number_format($rowdb['X6_ROLL']);?></td>
                        <td style="text-align: right"><?php echo number_format($rowdb['X6_WEIGHT'],2);?></td>
                        <td style="text-align: center"><?php echo number_format($rowdb['X7_ROLL']);?></td>
                        <td style="text-align: right"><?php echo number_format($rowdb['X7_WEIGHT'],2);?></td>
                        <td style="text-align: center"><?php echo $tglTutup;?></td>
                    </tr>
                <?php } ?>
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
                        <td style="text-align: center">&nbsp;</td>
                        <td style="text-align: center">&nbsp;</td>
                        <td style="text-align: center">&nbsp;</td>
                        <td style="text-align: center">&nbsp;</td>
                        <td style="text-align: center">&nbsp;</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="card card-green">
        <div class="card-header">
            <h3 class="card-title">Stock Kain Jadi BS</h3>
        </div>
        <div class="card-body">
            <table id="example3" class="table table-sm table-bordered table-striped" style="font-size:13px;">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align: center">ALL ZONA</th>
                        <th rowspan="2" style="text-align: center">ACTION</th>
                        <th colspan="2" style="text-align: center">ZONA 01</th>
                        <th colspan="2" style="text-align: center">ZONA 03</th>
                        <th rowspan="2" style="text-align: center">TGL</th>
                    </tr>
                    <tr>
                        <th style="text-align: center">ROLL</th>
                        <th style="text-align: center">WEIGHT</th>
                        <th style="text-align: center">ROLL</th>
                        <th style="text-align: center">WEIGHT</th>
                        <th style="text-align: center">ROLL</th>
                        <th style="text-align: center">WEIGHT</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sqlBS = "SELECT 
    tgl_tutup,
    SUM(CASE WHEN zone IN ('01', '03') THEN weight ELSE 0 END) AS ALL_WEIGHT,
    SUM(CASE WHEN zone IN ('01', '03') THEN 1 ELSE 0 END) AS ALL_ROLL,
    SUM(CASE WHEN zone = '01' THEN weight ELSE 0 END) AS [01_WEIGHT],
    SUM(CASE WHEN zone = '01' THEN 1 ELSE 0 END) AS [01_ROLL],
    SUM(CASE WHEN zone = '03' THEN weight ELSE 0 END) AS [03_WEIGHT],
    SUM(CASE WHEN zone = '03' THEN 1 ELSE 0 END) AS [03_ROLL]
FROM 
    $tblOpnameDetailBS tod
WHERE 
    tgl_tutup >= DATEADD(day,-5,CAST(GETDATE() AS date))
GROUP BY 
    tgl_tutup
ORDER BY 
    tgl_tutup DESC";
                $stmtBS = sqlsrv_query($con, $sqlBS, [], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
                logSqlError($stmtBS, 'list stok kain jadi BS', __LINE__);
                while ($stmtBS && ($rowdb = sqlsrv_fetch_array($stmtBS, SQLSRV_FETCH_ASSOC))) {
                    $tglTutup = formatSqlsrvDate($rowdb['tgl_tutup']);
                    $tglParam = urlencode($tglTutup);
                    ?>
                    <tr>
                        <td style="text-align: center"><?php echo number_format($rowdb['ALL_ROLL']);?></td>
                        <td style="text-align: right"><?php echo number_format($rowdb['ALL_WEIGHT'],2);?></td>
                        <td style="text-align: center"><div class="btn-group"><a href="pages/cetak/PersediaanKainDetailBSExcel11.php.php?tgl=<?php echo $tglParam;?>" target="_blank" class="btn btn-outline-info btn-xs disabled"><i class="fa fa-download"></i> Download</a>&nbsp;<a href="pages/cetak/PersediaanKainJadiFullDetailBSExcel11.php?tgl=<?php echo $tglParam;?>" target="_blank" class="btn btn-outline-warning btn-xs"><i class="fa fa-download"></i> Detail</a></div></td>
                        <td style="text-align: center"><?php echo number_format($rowdb['01_ROLL']);?></td>
                        <td style="text-align: right"><?php echo number_format($rowdb['01_WEIGHT'],2);?></td>
                        <td style="text-align: center"><?php echo number_format($rowdb['03_ROLL']);?></td>
                        <td style="text-align: right"><?php echo number_format($rowdb['03_WEIGHT'],2);?></td>
                        <td style="text-align: center"><?php echo $tglTutup;?></td>
                    </tr>
                <?php } ?>
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
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="card card-pink">
        <div class="card-header">
            <h3 class="card-title">Stock Kain Jadi BB</h3>
        </div>
        <div class="card-body">
            <table id="example3" class="table table-sm table-bordered table-striped" style="font-size:13px;">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align: center">ALL ZONA</th>
                        <th rowspan="2" style="text-align: center">ACTION</th>
                        <th colspan="2" style="text-align: center">ZONA BS1</th>
                        <th colspan="2" style="text-align: center">ZONA BS2</th>
                        <th colspan="2" style="text-align: center">ZONA BS3</th>
                        <th colspan="2" style="text-align: center">ZONA JS1</th>
                        <th rowspan="2" style="text-align: center">TGL</th>
                    </tr>
                    <tr>
                        <th style="text-align: center">ROLL</th>
                        <th style="text-align: center">WEIGHT</th>
                        <th style="text-align: center">ROLL</th>
                        <th style="text-align: center">WEIGHT</th>
                        <th style="text-align: center">ROLL</th>
                        <th style="text-align: center">WEIGHT</th>
                        <th style="text-align: center">ROLL</th>
                        <th style="text-align: center">WEIGHT</th>
                        <th style="text-align: center">ROLL</th>
                        <th style="text-align: center">WEIGHT</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sqlBB = "SELECT 
    tgl_tutup,
    SUM(CASE WHEN zone IN ('BS1', 'BS2', 'BS3', 'JS1') THEN weight ELSE 0 END) AS ALL_WEIGHT,
    SUM(CASE WHEN zone IN ('BS1', 'BS2', 'BS3', 'JS1') THEN 1 ELSE 0 END) AS ALL_ROLL,
    SUM(CASE WHEN zone = 'BS1' THEN weight ELSE 0 END) AS BS1_WEIGHT,
    SUM(CASE WHEN zone = 'BS1' THEN 1 ELSE 0 END) AS BS1_ROLL,
    SUM(CASE WHEN zone = 'BS2' THEN weight ELSE 0 END) AS BS2_WEIGHT,
    SUM(CASE WHEN zone = 'BS2' THEN 1 ELSE 0 END) AS BS2_ROLL,
    SUM(CASE WHEN zone = 'BS3' THEN weight ELSE 0 END) AS BS3_WEIGHT,
    SUM(CASE WHEN zone = 'BS3' THEN 1 ELSE 0 END) AS BS3_ROLL,
    SUM(CASE WHEN zone = 'JS1' THEN weight ELSE 0 END) AS JS1_WEIGHT,
    SUM(CASE WHEN zone = 'JS1' THEN 1 ELSE 0 END) AS JS1_ROLL
FROM 
    $tblOpnameDetailBB tod
WHERE 
    tgl_tutup >= DATEADD(day,-5,CAST(GETDATE() AS date))
GROUP BY 
    tgl_tutup
ORDER BY 
    tgl_tutup DESC";
                $stmtBB = sqlsrv_query($con, $sqlBB, [], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
                logSqlError($stmtBB, 'list stok kain jadi BB', __LINE__);
                while ($stmtBB && ($rowdb = sqlsrv_fetch_array($stmtBB, SQLSRV_FETCH_ASSOC))) {
                    $tglTutup = formatSqlsrvDate($rowdb['tgl_tutup']);
                    $tglParam = urlencode($tglTutup);
                    ?>
                    <tr>
                        <td style="text-align: center"><?php echo number_format($rowdb['ALL_ROLL']);?></td>
                        <td style="text-align: right"><?php echo number_format($rowdb['ALL_WEIGHT'],2);?></td>
                        <td style="text-align: center"><div class="btn-group"><a href="pages/cetak/PersediaanKainDetailBBExcel11.php.php?tgl=<?php echo $tglParam;?>" target="_blank" class="btn btn-outline-info btn-xs disabled"><i class="fa fa-download"></i> Download</a>&nbsp;<a href="pages/cetak/PersediaanKainJadiFullDetailBBExcel11.php?tgl=<?php echo $tglParam;?>" target="_blank" class="btn btn-outline-warning btn-xs"><i class="fa fa-download"></i> Detail</a></div></td>
                        <td style="text-align: center"><?php echo number_format($rowdb['BS1_ROLL']);?></td>
                        <td style="text-align: right"><?php echo number_format($rowdb['BS1_WEIGHT'],2);?></td>
                        <td style="text-align: center"><?php echo number_format($rowdb['BS2_ROLL']);?></td>
                        <td style="text-align: right"><?php echo number_format($rowdb['BS2_WEIGHT'],2);?></td>
                        <td style="text-align: center"><?php echo number_format($rowdb['BS3_ROLL']);?></td>
                        <td style="text-align: right"><?php echo number_format($rowdb['BS3_WEIGHT'],2);?></td>
                        <td style="text-align: center"><?php echo number_format($rowdb['JS1_ROLL']);?></td>
                        <td style="text-align: right"><?php echo number_format($rowdb['JS1_WEIGHT'],2);?></td>
                        <td style="text-align: center"><?php echo $tglTutup;?></td>
                    </tr>
                <?php } ?>
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
                        <td style="text-align: center">&nbsp;</td>
                    </tr>
                </tfoot>
            </table>
        </div>
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
