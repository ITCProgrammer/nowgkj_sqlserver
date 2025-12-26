<?php
$Awal	= isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : '';
?>

<!-- Main content -->
      <div class="container-fluid">		
		<div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Detail Data Persediaan Kain Jadi Perhari (Tutup Auto Jam 11:00 Malam)</h3>				 
          </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-sm table-bordered table-striped" style="font-size: 14px; text-align: center;">
                  <thead>
                  <tr>
                    <th valign="middle" style="text-align: center">No</th>
                    <th valign="middle" style="text-align: center">Detail</th>
                    <th valign="middle" style="text-align: center">Tgl Tutup</th>
                    <th valign="middle" style="text-align: center">Rol</th>
                    <th valign="middle" style="text-align: center">KG</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                      $no = 1;

                      $sql = "SELECT TOP (60)
                              CONVERT(date, tgl_tutup) AS tgl_tutup,
                              SUM(rol) AS rol,
                              SUM([weight]) AS kg,
                              CONVERT(date, GETDATE()) AS tgl
                          FROM dbnow_gkj.tbl_opname_detail_11
                          GROUP BY CONVERT(date, tgl_tutup)
                          ORDER BY tgl_tutup DESC
                      ";

                      $stmt = sqlsrv_query($con, $sql);
                      if ($stmt === false) {
                          die(print_r(sqlsrv_errors(), true));
                      }

                      while ($r = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                          $tgl_tutup = ($r['tgl_tutup'] instanceof DateTime) ? $r['tgl_tutup']->format('Y-m-d') : (string)$r['tgl_tutup'];
                      ?>
                        <tr>
                          <td style="text-align: center"><?php echo $no; ?></td>
                          <td style="text-align: center">
                            <div class="btn-group">
                              <a href="DetailOpnamed11-<?php echo $tgl_tutup; ?>" class="btn btn-info btn-xs" target="_blank">
                                <i class="fa fa-link"></i> Lihat Data
                              </a>
                              <a href="pages/cetak/DetailOpnamed11Excel.php?tgl=<?php echo $tgl_tutup; ?>" class="btn btn-success btn-xs" target="_blank">
                                <i class="fa fa-file"></i> Cetak Ke Excel
                              </a>
                            </div>
                          </td>
                          <td style="text-align: center"><?php echo $tgl_tutup; ?></td>
                          <td style="text-align: center"><?php echo (int)$r['rol']; ?></td>
                          <td style="text-align: right"><?php echo number_format((float)$r['kg'], 3, '.', ','); ?></td>
                        </tr>
                      <?php
                          $no++;
                      }
                      ?>
				  </tbody>
                  <tfoot>				
					</tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div> 
      </div><!-- /.container-fluid -->
    <!-- /.content -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>	
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

