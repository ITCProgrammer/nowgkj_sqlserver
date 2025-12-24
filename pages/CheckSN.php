<?php
$Barcode   = substr($_POST['barcode'], -13);
$sqlErrors = [];

// Helpers (legacy MySQL for QC data)
function logSqlErrorLegacy($stmt, $label = '') {
    global $sqlErrors;
    if ($stmt) {
        return;
    }
    if ($stmt === false && function_exists('mysqli_error')) {
        $msg = $label !== '' ? $label . ': ' : '';
        $msg .= mysqli_error($GLOBALS['cond']);
        $sqlErrors[] = $msg;
        echo "<script>console.error('MySQL error: " . addslashes($msg) . "');</script>";
    }
}

// Check SN exist (MySQL QC DB)
$ck = ['jml' => 0];
if ($_POST['cek'] == "Cek" || $_POST['cari'] == "Cari") {
    $qryCek = "SELECT COUNT(*) as jml FROM tmp_detail_kite WHERE SN='$Barcode'";
    $sqlCek = mysqli_query($cond, $qryCek);
    logSqlErrorLegacy($sqlCek, 'cek SN legacy');
    $ck = $sqlCek ? mysqli_fetch_array($sqlCek) : ['jml' => 0];
    if ($ck['jml'] <= 0) {
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
            <div class="card-body">
                <div class="form-group row">
                    <label for="barcode" class="col-md-1">Barcode</label>
                    <input type="text" class="form-control" name="barcode" placeholder="SN / Elements" id="barcode" on autofocus>
                </div>
                <button class="btn btn-primary" type="submit" name="cek" value="Cek">Check</button>
            </div>
        </div>
    </form>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Detail SN Legacy</h3>
        </div>
        <div class="card-body">
            <table id="example3" class="table table-sm table-bordered table-striped" style="font-size:13px;">
                <thead>
                    <tr>
                        <th style="text-align: center">SN</th>
                        <th style="text-align: center">NoKK</th>
                        <th style="text-align: center">Langganan</th>
                        <th style="text-align: center">Order</th>
                        <th style="text-align: center">PO</th>
                        <th style="text-align: center">Item</th>
                        <th style="text-align: center">Warna</th>
                        <th style="text-align: center">No Warna</th>
                        <th style="text-align: center">Jenis Kain</th>
                        <th style="text-align: center">Style</th>
                        <th style="text-align: center">Kgs</th>
                        <th style="text-align: center">Panjang</th>
                        <th style="text-align: center">Satuan</th>
                        <th style="text-align: center">Lot</th>
                        <th style="text-align: center">Lokasi</th>
                        <th style="text-align: center">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $qryData = "SELECT * FROM tmp_detail_kite WHERE SN='$Barcode'";
                    $sql = mysqli_query($cond, $qryData);
                    logSqlErrorLegacy($sql, 'data SN legacy');
                    while ($sql && ($rowd = mysqli_fetch_array($sql))) {
                        $qryKite = "SELECT * FROM tbl_kite WHERE nokk='$rowd[nokkKite]'";
                        $sql1 = mysqli_query($cond, $qryKite);
                        logSqlErrorLegacy($sql1, 'detail kite legacy');
                        $rowd1 = $sql1 ? mysqli_fetch_array($sql1) : [];
                        if ($rowd['status'] == "0") {
                            $sts = "<small class='badge badge-info'>Mutasi QCF</small>";
                        } else if ($rowd['status'] == "1") {
                            $sts = "<small class='badge badge-success'>In GKJ</small>";
                        } else if ($rowd['status'] == "2") {
                            $sts = "<small class='badge badge-danger'>Out GKJ</small>";
                        } else {
                            $sts = "";
                        }
                    ?>
                        <tr>
                            <td style="text-align: center"><?php echo $rowd['SN']; ?></td>
                            <td style="text-align: left"><?php echo $rowd['nokkKite']; ?></td>
                            <td style="text-align: left"><?php echo isset($rowd1['pelanggan']) ? $rowd1['pelanggan'] : ''; ?></td>
                            <td style="text-align: center"><?php echo isset($rowd1['no_order']) ? $rowd1['no_order'] : ''; ?></td>
                            <td style="text-align: center"><?php echo isset($rowd1['no_po']) ? $rowd1['no_po'] : ''; ?></td>
                            <td style="text-align: center"><?php echo isset($rowd1['no_item']) ? $rowd1['no_item'] : ''; ?></td>
                            <td style="text-align: left"><?php echo isset($rowd1['warna']) ? $rowd1['warna'] : ''; ?></td>
                            <td style="text-align: center"><?php echo isset($rowd1['no_warna']) ? $rowd1['no_warna'] : ''; ?></td>
                            <td style="text-align: left"><?php echo isset($rowd1['jenis_kain']) ? $rowd1['jenis_kain'] : ''; ?></td>
                            <td style="text-align: center"><?php echo isset($rowd1['no_style']) ? $rowd1['no_style'] : ''; ?></td>
                            <td style="text-align: left"><?php echo $rowd['net_wight']; ?></td>
                            <td style="text-align: left"><?php echo $rowd['yard_']; ?></td>
                            <td style="text-align: center"><?php echo $rowd['satuan']; ?></td>
                            <td style="text-align: center"><?php echo isset($rowd1['no_lot']) ? $rowd1['no_lot'] : ''; ?></td>
                            <td style="text-align: center"><?php echo $rowd['lokasi']; ?></td>
                            <td style="text-align: center"><?php echo $sts; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
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
