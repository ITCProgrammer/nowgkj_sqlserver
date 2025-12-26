<?php
$schema           = 'dbnow_gkj';
$tblOpnameDetail  = "[$schema].[tbl_opname_detail_11]";
$sqlErrors        = [];

$Tgl_6_Hari_Lalu = date('Y-m-d', strtotime('-6 day'));
$Tgl_5_Hari_Lalu = date('Y-m-d', strtotime('-5 day'));
$Tgl_4_Hari_Lalu = date('Y-m-d', strtotime('-4 day'));
$Tgl_3_Hari_Lalu = date('Y-m-d', strtotime('-3 day'));
$Tgl_2_Hari_Lalu = date('Y-m-d', strtotime('-2 day'));
$kemarin          = date('Y-m-d', strtotime('-1 day'));

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
    <div class="card card-pink">
        <div class="card-header">
            <h3 class="card-title">Stock Status Kain Jadi (X1, X2, W1, W3) Tahun 2023 Ke Atas</h3>
        </div>
        <div class="card-body">
            <table id="example17" class="table table-sm table-bordered table-striped" style="font-size:13px;" width="100%">
                <thead>
                    <tr>
                        <th style="text-align: center">&nbsp;</th>
                        <th colspan="2" style="text-align: center"><?php echo $Tgl_6_Hari_Lalu; ?></th>
                        <th colspan="2" style="text-align: center"><?php echo $Tgl_5_Hari_Lalu; ?></th>
                        <th colspan="2" style="text-align: center"><?php echo $Tgl_4_Hari_Lalu; ?></th>
                        <th colspan="2" style="text-align: center"><?php echo $Tgl_3_Hari_Lalu; ?></th>
                        <th colspan="2" style="text-align: center"><?php echo $Tgl_2_Hari_Lalu; ?></th>
                        <th colspan="2" style="text-align: center"><?php echo $kemarin; ?></th>
                    </tr>
                    <tr>
                        <th style="text-align: center">STATUS</th>
                        <th style="text-align: center">&nbsp;</th>
                        <th style="text-align: center">QTY(KGs)</th>
                        <th style="text-align: center">&nbsp;</th>
                        <th style="text-align: center">QTY(KGs)</th>
                        <th style="text-align: center">&nbsp;</th>
                        <th style="text-align: center">QTY(KGs)</th>
                        <th style="text-align: center">&nbsp;</th>
                        <th style="text-align: center">QTY(KGs)</th>
                        <th style="text-align: center">&nbsp;</th>
                        <th style="text-align: center">QTY(KGs)</th>
                        <th style="text-align: center">&nbsp;</th>
                        <th style="text-align: center">QTY(KGs)</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sqlStatus = "SELECT 
    sts_kain,
    SUM(CASE WHEN tgl_tutup = CAST(DATEADD(day,-6, CAST(GETDATE() AS date)) AS date) THEN berat ELSE 0 END) AS Tgl_6_Hari_Lalu,
    SUM(CASE WHEN tgl_tutup = CAST(DATEADD(day,-5, CAST(GETDATE() AS date)) AS date) THEN berat ELSE 0 END) AS Tgl_5_Hari_Lalu,
    SUM(CASE WHEN tgl_tutup = CAST(DATEADD(day,-4, CAST(GETDATE() AS date)) AS date) THEN berat ELSE 0 END) AS Tgl_4_Hari_Lalu,
    SUM(CASE WHEN tgl_tutup = CAST(DATEADD(day,-3, CAST(GETDATE() AS date)) AS date) THEN berat ELSE 0 END) AS Tgl_3_Hari_Lalu,
    SUM(CASE WHEN tgl_tutup = CAST(DATEADD(day,-2, CAST(GETDATE() AS date)) AS date) THEN berat ELSE 0 END) AS Tgl_2_Hari_Lalu,
    SUM(CASE WHEN tgl_tutup = CAST(DATEADD(day,-1, CAST(GETDATE() AS date)) AS date) THEN berat ELSE 0 END) AS Tgl_Kemarin
FROM (
    SELECT 
        tod.sts_kain, 
        tod.tgl_tutup, 
        SUM(tod.weight) AS berat
    FROM 
        $tblOpnameDetail tod
    WHERE 
        tod.tgl_tutup >= CAST(DATEADD(day,-6, CAST(GETDATE() AS date)) AS date)
        AND SUBSTRING(orderno, 4, 2) > '22'
        AND LEN(LTRIM(RTRIM(orderno))) = 10
    GROUP BY 
        tod.sts_kain, tod.tgl_tutup
) AS subquery
GROUP BY sts_kain
ORDER BY sts_kain ASC";
                $stmtStatus = sqlsrv_query($con, $sqlStatus, [], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
                logSqlError($stmtStatus, 'list status kain', __LINE__);
                $tot1 = $tot2 = $tot3 = $tot4 = $tot5 = $tot6 = 0;
                while($stmtStatus && ($rowdb2022 = sqlsrv_fetch_array($stmtStatus, SQLSRV_FETCH_ASSOC))){
                    $tgl6Param = urlencode($Tgl_6_Hari_Lalu);
                    $tgl5Param = urlencode($Tgl_5_Hari_Lalu);
                    $tgl4Param = urlencode($Tgl_4_Hari_Lalu);
                    $tgl3Param = urlencode($Tgl_3_Hari_Lalu);
                    $tgl2Param = urlencode($Tgl_2_Hari_Lalu);
                    $tgl1Param = urlencode($kemarin);
                ?>
                  <tr>
                  <td style="text-align: center"><?php echo $rowdb2022['sts_kain'];?></td>
                  <td style="text-align: center"><a href="pages/cetak/PersediaanKainJadiFullSTSExcel11.php?tgl=<?php echo $tgl6Param; ?>&sts=<?php echo urlencode($rowdb2022['sts_kain']);?>" target="_blank" class="btn btn-outline-info btn-xs"><i class="fa fa-download"></i> Download</a></td>
                  <td style="text-align: right"><?php echo number_format($rowdb2022['Tgl_6_Hari_Lalu'],2);?></td>
                  <td style="text-align: center"><a href="pages/cetak/PersediaanKainJadiFullSTSExcel11.php?tgl=<?php echo $tgl5Param; ?>&sts=<?php echo urlencode($rowdb2022['sts_kain']);?>" target="_blank" class="btn btn-outline-info btn-xs"><i class="fa fa-download"></i> Download</a></td>
                  <td style="text-align: right"><?php echo number_format($rowdb2022['Tgl_5_Hari_Lalu'],2);?></td>
                  <td style="text-align: center"><a href="pages/cetak/PersediaanKainJadiFullSTSExcel11.php?tgl=<?php echo $tgl4Param; ?>&sts=<?php echo urlencode($rowdb2022['sts_kain']);?>" target="_blank" class="btn btn-outline-info btn-xs"><i class="fa fa-download"></i> Download</a></td>
                  <td style="text-align: right"><?php echo number_format($rowdb2022['Tgl_4_Hari_Lalu'],2);?></td>
                  <td style="text-align: center"><a href="pages/cetak/PersediaanKainJadiFullSTSExcel11.php?tgl=<?php echo $tgl3Param; ?>&sts=<?php echo urlencode($rowdb2022['sts_kain']);?>" target="_blank" class="btn btn-outline-info btn-xs"><i class="fa fa-download"></i> Download</a></td>
                  <td style="text-align: right"><?php echo number_format($rowdb2022['Tgl_3_Hari_Lalu'],2);?></td>
                  <td style="text-align: center"><a href="pages/cetak/PersediaanKainJadiFullSTSExcel11.php?tgl=<?php echo $tgl2Param; ?>&sts=<?php echo urlencode($rowdb2022['sts_kain']);?>" target="_blank" class="btn btn-outline-info btn-xs"><i class="fa fa-download"></i> Download</a></td>
                  <td style="text-align: right"><?php echo number_format($rowdb2022['Tgl_2_Hari_Lalu'],2);?></td>
                  <td style="text-align: center"><a href="pages/cetak/PersediaanKainJadiFullSTSExcel11.php?tgl=<?php echo $tgl1Param; ?>&sts=<?php echo urlencode($rowdb2022['sts_kain']);?>" target="_blank" class="btn btn-outline-info btn-xs"><i class="fa fa-download"></i> Download</a></td>
                  <td style="text-align: right"><?php echo number_format($rowdb2022['Tgl_Kemarin'],2);?></td>
                  </tr>
                <?php
                    $tot6 += $rowdb2022['Tgl_6_Hari_Lalu'];
                    $tot5 += $rowdb2022['Tgl_5_Hari_Lalu'];
                    $tot4 += $rowdb2022['Tgl_4_Hari_Lalu'];
                    $tot3 += $rowdb2022['Tgl_3_Hari_Lalu'];
                    $tot2 += $rowdb2022['Tgl_2_Hari_Lalu'];
                    $tot1 += $rowdb2022['Tgl_Kemarin'];
                }
                ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th style="text-align: center">TOTAL</th>
                        <th style="text-align: center"><a href="pages/cetak/PersediaanKainJadiFullSTSALLExcel11.php?tgl=<?php echo urlencode($Tgl_6_Hari_Lalu); ?>" target="_blank" class="btn btn-outline-primary btn-xs"><i class="fa fa-download"></i> Download</a></th>
                        <th style="text-align: right"><strong><?php echo number_format($tot6,2); ?></strong></th>
                        <th style="text-align: center"><a href="pages/cetak/PersediaanKainJadiFullSTSALLExcel11.php?tgl=<?php echo urlencode($Tgl_5_Hari_Lalu); ?>" target="_blank" class="btn btn-outline-primary btn-xs"><i class="fa fa-download"></i> Download</a></th>
                        <th style="text-align: right"><strong><?php echo number_format($tot5,2); ?></strong></th>
                        <th style="text-align: center"><a href="pages/cetak/PersediaanKainJadiFullSTSALLExcel11.php?tgl=<?php echo urlencode($Tgl_4_Hari_Lalu); ?>" target="_blank" class="btn btn-outline-primary btn-xs"><i class="fa fa-download"></i> Download</a></th>
                        <th style="text-align: right"><strong><?php echo number_format($tot4,2); ?></strong></th>
                        <th style="text-align: center"><a href="pages/cetak/PersediaanKainJadiFullSTSALLExcel11.php?tgl=<?php echo urlencode($Tgl_3_Hari_Lalu); ?>" target="_blank" class="btn btn-outline-primary btn-xs"><i class="fa fa-download"></i> Download</a></th>
                        <th style="text-align: right"><strong><?php echo number_format($tot3,2); ?></strong></th>
                        <th style="text-align: center"><a href="pages/cetak/PersediaanKainJadiFullSTSALLExcel11.php?tgl=<?php echo urlencode($Tgl_2_Hari_Lalu); ?>" target="_blank" class="btn btn-outline-primary btn-xs"><i class="fa fa-download"></i> Download</a></th>
                        <th style="text-align: right"><strong><?php echo number_format($tot2,2); ?></strong></th>
                        <th style="text-align: center"><a href="pages/cetak/PersediaanKainJadiFullSTSALLExcel11.php?tgl=<?php echo urlencode($kemarin); ?>" target="_blank" class="btn btn-outline-primary btn-xs"><i class="fa fa-download"></i> Download</a></th>
                        <th style="text-align: right"><strong><?php echo number_format($tot1,2); ?></strong></th>
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
