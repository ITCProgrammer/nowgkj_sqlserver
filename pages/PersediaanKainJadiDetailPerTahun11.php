<?php
$Awal  = isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : '';
$Akhir = isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : '';
$sqlErrors = [];

$schema      = 'dbnow_gkj';
$tblOpname11 = "[$schema].[tbl_opname_detail_11]";

// Helpers
function logSqlError($stmt, $label = '', $line = null)
{
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
function fetchOrDefault($stmt, $default = [], $label = '', $line = null)
{
  if ($stmt === false) {
    logSqlError($stmt, $label, $line);
    return $default;
  }
  $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
  return $row ?: $default;
}
function formatSqlsrvDate($value, $format = 'Y-m-d')
{
  if ($value instanceof DateTime) {
    return $value->format($format);
  }
  return $value;
}

// Date filter
if (!empty($Awal) && !empty($Akhir)) {
  $where = " tgl_tutup BETWEEN '$Awal' and '$Akhir' ";
} else {
  $where = " tgl_tutup BETWEEN DATEADD(day,-30, CAST(GETDATE() AS date)) and CAST(GETDATE() AS date) ";
}
?>
<!-- Main content -->
<div class="container-fluid">
  <form role="form" method="post" enctype="multipart/form-data" name="form1">
    <div class="card card-purple">
      <div class="card-header">
        <h3 class="card-title">Filter Tgl Tutup</h3>

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
          <label for="tgl_awal" class="col-md-1">Tgl Awal</label>
          <div class="col-md-2">
            <div class="input-group date" id="datepicker1" data-target-input="nearest">
              <div class="input-group-prepend" data-target="#datepicker1" data-toggle="datetimepicker">
                <span class="input-group-text btn-info">
                  <i class="far fa-calendar-alt"></i>
                </span>
              </div>
              <input name="tgl_awal" value="<?php echo $Awal; ?>" type="text" class="form-control form-control-sm" id="" autocomplete="off" required>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="tgl_akhir" class="col-md-1">Tgl Akhir</label>
          <div class="col-md-2">
            <div class="input-group date" id="datepicker2" data-target-input="nearest">
              <div class="input-group-prepend" data-target="#datepicker2" data-toggle="datetimepicker">
                <span class="input-group-text btn-info">
                  <i class="far fa-calendar-alt"></i>
                </span>
              </div>
              <input name="tgl_akhir" value="<?php echo $Akhir; ?>" type="text" class="form-control form-control-sm" id="" autocomplete="off" required>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <button class="btn btn-info" type="submit" value="Cari" name="cari">Cari Data</button>
        <button class="btn btn-primary float-right" type="button" name="refresh" onclick="window.location.href='PersediaanKainJadiDetailPerTahun11'">Refresh</button>
      </div>
      <!-- /.card-body -->

    </div>
  </form>
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-info"></i> Info</h5>
    <li>Data Persediaan Kain hanya dari Zone W, X Lokasi W1, W3, X1, X2, X6 ,X7 (Balance di NOW)</li>
    <li>Download dari Jam 23:01 WIB</li>
  </div>
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
  </form>
  <div class="row">
    <div class="col-md-6">
      <div class="card card-pink">
        <div class="card-header">
          <h3 class="card-title">Stock Balance Tahun 2023 - Sekarang (NOW)</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example11" class="table table-sm table-bordered table-striped" style="font-size:14px;" width="100%">
            <thead>
              <tr>
                <th style="text-align: center">Tgl</th>
                <th style="text-align: center">Tahun</th>
                <th style="text-align: center">Rol</th>
                <th style="text-align: center">Weight</th>
                <th style="text-align: center">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              $c = 0;
              $sqlDB21 = "SELECT
                            SUBSTRING(orderno, 4, 2) as thn,
                            sum(weight) as berat,
                            count(rol) as roll,
                            tgl_tutup
                          from
                            $tblOpname11 tod
                          where
                            SUBSTRING(orderno, 4, 2) > 22
                            and LEN(LTRIM(RTRIM(orderno))) = 10 and $where
                          group by
                            tgl_tutup,SUBSTRING(orderno, 4, 2)
                          order by
                            tgl_tutup desc";
              $stmt1   = sqlsrv_query($con, $sqlDB21, [], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
              logSqlError($stmt1, 'list tahun > 22', __LINE__);
              while ($stmt1 && ($rowdb21 = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC))) {
                $tglTutup = formatSqlsrvDate($rowdb21['tgl_tutup']);
              ?>
                <tr>
                  <td style="text-align: center"><?php echo $tglTutup; ?></td>
                  <td style="text-align: center"><?php if ($rowdb21['thn'] != "") {
                                                    echo "20" . $rowdb21['thn'];
                                                  } else {
                                                    echo "~";
                                                  } ?></td>
                  <td style="text-align: center"><?php echo $rowdb21['roll']; ?></td>
                  <td style="text-align: right"><?php echo number_format(round($rowdb21['berat'], 2), 2); ?></td>
                  <td style="text-align: center">
                    <div class="btn-group"><a href="pages/cetak/PersediaanKainJadi2023Excel11.php?thn=<?php echo $rowdb21['thn']; ?>" target="_blank" class="btn btn-outline-info btn-xs disabled"><i class="fa fa-download"></i> Download</a>&nbsp;<a href="pages/cetak/PersediaanKainJadi2023DetailExcel11.php?tgl=<?php echo $tglTutup; ?>&thn=<?php echo $rowdb21['thn']; ?>" target="_blank" class="btn btn-outline-warning btn-xs"><i class="fa fa-download"></i> Detail</a></div>
                  </td>
                </tr>
              <?php $no++;
              } ?>
            </tbody>
            <tfoot>
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
          <table id="example12" class="table table-sm table-bordered table-striped" style="font-size:14px;" width="100%">
            <thead>
              <tr>
                <th style="text-align: center">Tgl</th>
                <th style="text-align: center">Tahun</th>
                <th style="text-align: center">Rol</th>
                <th style="text-align: center">Weight</th>
                <th style="text-align: center">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sqlDB2022 = "SELECT
                              SUBSTRING(orderno, 4, 2) as thn,
                              sum(weight) as berat,
                              count(rol) as roll,
                              tgl_tutup
                            from
                              $tblOpname11 tod
                            where
                              SUBSTRING(orderno, 4, 2) < '23'
                              and LEN(LTRIM(RTRIM(orderno))) = 10 and $where
                            group by
                              tgl_tutup,SUBSTRING(orderno, 4, 2)
                            order by
                              tgl_tutup desc";
              $stmt2022   = sqlsrv_query($con, $sqlDB2022, [], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
              logSqlError($stmt2022, 'list tahun <=22', __LINE__);
              while ($stmt2022 && ($rowdb2022 = sqlsrv_fetch_array($stmt2022, SQLSRV_FETCH_ASSOC))) {
                $tglTutup = formatSqlsrvDate($rowdb2022['tgl_tutup']);
              ?>
                <tr>
                  <td style="text-align: center"><?php echo $tglTutup; ?></td>
                  <td style="text-align: center">2022</td>
                  <td style="text-align: center"><?php echo $rowdb2022['roll']; ?></td>
                  <td style="text-align: right"><?php echo number_format(round($rowdb2022['berat'], 2), 2); ?></td>
                  <td style="text-align: center"><a href="pages/cetak/PersediaanKainJadi2022Excel11.php?thn=2022" target="_blank" class="btn btn-outline-info btn-xs disabled"> <i class="fa fa-download"></i> Download</a>&nbsp;<a href="pages/cetak/PersediaanKainJadi2022DetailExcel11.php?tgl=<?php echo $tglTutup; ?>" target="_blank" class="btn btn-outline-warning btn-xs"><i class="fa fa-download"></i> Detail</a></td>
                </tr>
              <?php
              } ?>
            </tbody>
            <tfoot>
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
          <table id="example13" class="table table-sm table-bordered table-striped" style="font-size:14px;" width="100%">
            <thead>
              <tr>
                <th style="text-align: center">Action</th>
                <th style="text-align: center">Rol</th>
                <th style="text-align: center">Weight</th>
                <th style="text-align: center">Tgl</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              $c = 0;
              $sqlDB21 = "SELECT
                          sum(weight) as berat,
                          count(rol) as roll,
                          tgl_tutup
                        from
                          $tblOpname11 tod
                        where
                          (LEN(LTRIM(RTRIM(orderno)))>10
                          or LTRIM(RTRIM(orderno))='') and $where
                        group by
                          tgl_tutup
                        order by
                          tgl_tutup desc";
              $stmt1   = sqlsrv_query($con, $sqlDB21, [], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
              logSqlError($stmt1, 'list PO sample/no project', __LINE__);
              while ($stmt1 && ($rowdb21 = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC))) {
                $tglTutup = formatSqlsrvDate($rowdb21['tgl_tutup']);
              ?>
                <tr>
                  <td style="text-align: center"><a href="pages/cetak/PersediaanKainJadiNoOrderExcel11.php" target="_blank" class="btn btn-outline-info btn-xs disabled"> <i class="fa fa-download"></i> Download</a>&nbsp;<a href="pages/cetak/PersediaanKainJadiNoOrderDetailExcel11.php?tgl=<?php echo $tglTutup; ?>" target="_blank" class="btn btn-outline-warning btn-xs" title="Detail"> <i class="fa fa-download"></i> Detail</a></td>
                  <td style="text-align: center"><?php echo $rowdb21['roll']; ?></td>
                  <td style="text-align: right"><?php echo number_format(round($rowdb21['berat'], 2), 2); ?></td>
                  <td style="text-align: center"><?php echo $tglTutup; ?></td>
                </tr>
              <?php $no++;
              } ?>
            </tbody>
            <tfoot>
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
          <table id="example14" class="table table-sm table-bordered table-striped" style="font-size:14px;" width="100%">
            <thead>
              <tr>
                <th style="text-align: center">Action</th>
                <th style="text-align: center">Rol</th>
                <th style="text-align: center">Weight</th>
                <th style="text-align: center">Tgl</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              $c = 0;
              $sqlDB21 = "SELECT
                          sum(weight) as berat,
                          count(rol) as roll,
                          tgl_tutup
                        from
                          $tblOpname11 tod
                        where $where	
                        group by
                          tgl_tutup
                        order by
                          tgl_tutup desc";
              $stmt1   = sqlsrv_query($con, $sqlDB21, [], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
              logSqlError($stmt1, 'list stok balance all', __LINE__);
              while ($stmt1 && ($rowdb21 = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC))) {
                $tglTutup = formatSqlsrvDate($rowdb21['tgl_tutup']);
              ?>
                <tr>
                  <td style="text-align: center">
                    <div class="btn-group"><a href="pages/cetak/PersediaanKainJadiFullExcel11.php?tgl=<?php echo $tglTutup; ?>" target="_blank" class="btn btn-outline-info btn-xs disabled"><i class="fa fa-download"></i> Download</a>&nbsp;<a href="pages/cetak/PersediaanKainJadiFullDetailExcel11.php?tgl=<?php echo $tglTutup; ?>" target="_blank" class="btn btn-outline-warning btn-xs"><i class="fa fa-download"></i> Detail</a></div>
                  </td>
                  <td style="text-align: center"><?php echo $rowdb21['roll']; ?></td>
                  <td style="text-align: right"><?php echo number_format(round($rowdb21['berat'], 2), 2); ?></td>
                  <td style="text-align: center"><?php echo $tglTutup; ?></td>
                </tr>
              <?php $no++;
              } ?>
            </tbody>
            <tfoot>
            </tfoot>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
    </div>
  </div>
</div><!-- /.container-fluid -->
<!-- /.content -->