<!-- Main content -->
      <div class="container-fluid">		
		  <div class="card card-pink">
              <div class="card-header">
                <h3 class="card-title">Stock Tanggal <?php echo $_GET['tgl']; ?></h3>
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
                    <th style="text-align: center">Zone</th>
                    <th style="text-align: center">Lokasi</th>
                    <th style="text-align: center">Lebar</th>
                    <th style="text-align: center">Gramasi</th>
                    <th style="text-align: center">Status</th>
                  </tr>
                  </thead>
                  <tbody>
				 <tbody>
<?php
          $no = 1;
          $totrol = 0;
          $totkg = 0.0;

          $tgl = $_GET['tgl'] ?? '';

          $sql = "SELECT
        itm, langganan, buyer, po, orderno, tipe, no_item, jns_kain, no_warna, warna, lot,
        SUM(rol) AS rol,
        SUM([weight]) AS [weight],
        satuan,
        SUM([length]) AS [length],
        satuan_len,
        [zone],
        lokasi,
        lebar,
        gramasi,
        sts_kain
    FROM dbnow_gkj.tbl_opname_detail_11
    WHERE CONVERT(date, tgl_tutup) = CONVERT(date, ?)
    GROUP BY
        itm, langganan, buyer, po, orderno, tipe, no_item, jns_kain, no_warna, warna, lot,
        satuan, satuan_len, [zone], lokasi, lebar, gramasi, sts_kain
";

          $stmt = sqlsrv_query($con, $sql, [$tgl]);
          if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
          }

          while ($r = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
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
              <td style="text-align: center"><?php echo (float) $r['rol']; ?></td>
              <td style="text-align: right"><?php echo number_format((float) $r['weight'], 3, '.', ','); ?></td>
              <td style="text-align: center"><?php echo $r['satuan']; ?></td>
              <td style="text-align: center"><?php echo number_format((float) $r['length'], 2, '.', ','); ?></td>
              <td style="text-align: center"><?php echo $r['satuan_len']; ?></td>
              <td style="text-align: center"><?php echo $r['zone']; ?></td>
              <td style="text-align: center"><?php echo $r['lokasi']; ?></td>
              <td style="text-align: center"><?php echo $r['lebar']; ?></td>
              <td style="text-align: center"><?php echo $r['gramasi']; ?></td>
              <td style="text-align: center"><?php echo $r['sts_kain']; ?></td>
            </tr>
            <?php
            $no++;
            $totrol += (float) $r['rol'];
            $totkg += (float) $r['weight'];
          }
          ?>
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
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    </tr>
                  </tfoot>                  
                </table>
              </div>
              <!-- /.card-body -->
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