<?php
$Awal	= isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : '';
$Akhir	= isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : '';
?>
<!-- Main content -->
      <div class="container-fluid">
		<form role="form" method="post" enctype="multipart/form-data" name="form1">  
		<div class="card card-purple">
          <div class="card-header">
            <h3 class="card-title">Filter Data Jam 23:00</h3>

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
                    <input name="tgl_awal" value="<?php echo $Awal;?>" type="text" class="form-control form-control-sm" id=""  autocomplete="off" required>
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
                    <input name="tgl_akhir" value="<?php echo $Akhir;?>" type="text" class="form-control form-control-sm" id=""  autocomplete="off" required>
                 </div>
			   </div>	
            </div> 
			  <button class="btn btn-info" type="submit" value="Cari" name="cari">Cari Data</button>
        <div class="btn-group float-right">  
        <a href="pages/cetak/LaporanTolakanExcel.php?tgl1=<?php echo $Awal; ?>&tgl2=<?php echo $Akhir;?>"
          class="btn btn-warning" target="_blank">Excel Tolakan Kain</a>
        </div>
          </div>
		  
		  <!-- /.card-body -->
          
        </div> 
	</form>
		  <div class="card card-pink">
              <div class="card-header">
                <h3 class="card-title">Data Laporan Tolakan</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
          <table id="example1" class="table table-sm table-bordered table-striped" style="font-size:13px;">
                  <thead>
                  <tr>
                    <th style="text-align: center">No.</th>
                    <th style="text-align: center">Tanggal Bon</th>
                    <th style="text-align: center">Tanggal Masuk Mutasi</th>
                    <th style="text-align: center">No Bon</th>                    
                    <th style="text-align: center">Langganan</th>
                    <th style="text-align: center">No PO</th>
                    <th style="text-align: center">No Order</th>
                    <th style="text-align: center">Jenis Kain</th>
                    <th style="text-align: center">Warna</th>
                    <th style="text-align: center">Roll</th>
                    <th style="text-align: center">Berat Netto</th>
                    <th style="text-align: center">Berat TG</th>
                    <th style="text-align: center">No LOT</th>                    
                    <th style="text-align: center">Ket</th>
                    <th style="text-align: center">Lokasi</th>
                    <th style="text-align: center">Kode</th>
                    </tr>
                  </thead>
                  <tbody>
          <?php
            $no = 1;
            $c = 0;

            $totJml = 0;
            $totKg = 0;
            $totberatTG = 0;

            // Hanya jalankan query kalau tanggal sudah diisi
            if ($Awal != '' && $Akhir != '') {

              $sql = "SELECT 
                            tbp.tgl_terima as tgl_bon,
                            tbp.nokk,
                            case 
                              when tbp.jns_permintaan = 'Bongkaran' then 'BG'
                              when tbp.jns_permintaan = 'Potong Pas Qty' then 'PPQ'
                              when tbp.jns_permintaan = 'Potong Sample' then 'PSP'
                              when tbp.jns_permintaan = 'Potong Sisa' then 'PSS'
                              else 
                              tbp.jns_permintaan    	
                            end as kode_jns_permintaan,
                            tbpd.tgl_mutasi,
                            tbp.refno as no_bon,
                            tbp.langganan,
                            tbp.no_po,
                            tbp.no_order,
                            tbp.jenis_kain,
                            tbp.warna,
                            CASE
                              WHEN tbp.jns_permintaan IN ('Bongkaran','Potong Pas Qty','Potong Sample','Potong Sisa')
                                  AND tbpd.berat IS NULL
                                THEN CAST(0 AS DECIMAL(18,2))
                              WHEN tbp.jns_permintaan IN ('Bongkaran','Potong Pas Qty','Potong Sample','Potong Sisa')
                                THEN CAST(IFNULL(tbpd.berat_potong, 0) AS DECIMAL(18,2))
                              ELSE CAST(IFNULL(tbpd.berat, 0) AS DECIMAL(18,2))
                            END AS berat_tg,
                            tbp.no_lot,
                            tbp.ket,
                            tbpd.tempat
                        FROM 
                            tbl_bon_permintaan tbp 
                        LEFT JOIN tbl_bon_permintaan_detail tbpd 
                            ON tbpd.no_permintaan = tbp.no_permintaan 
                        WHERE 
                            tbp.tgl_terima BETWEEN '$Awal 23:00:00' AND '$Akhir 23:00:00'
                        order by tbp.id ASC";

              $sqlDB21 = mysqli_query($cond, $sql);

              // Cek kalau query gagal
              if (!$sqlDB21) {
                echo '<tr><td colspan="16" style="text-align:center;color:red;">
                            Error query: ' . mysqli_error($cond) . '
                          </td></tr>';
              } else {

                while ($rowdb21 = mysqli_fetch_array($sqlDB21)) {
                  // Query ke DB2 (kalau perlu pakai no_lot atau nokk, sesuaikan kolom yang ada)
                  $sqld = "SELECT 
                                    COUNT(BALANCE.ELEMENTSCODE) AS JML_ROLL, 
                                    SUM(BALANCE.BASEPRIMARYQUANTITYUNIT) AS TBERAT
                                FROM 
                                    BALANCE BALANCE 
                                WHERE 
                                    BALANCE.LOTCODE ='{$rowdb21['nokk']}' 
                                    AND BALANCE.LOGICALWAREHOUSECODE ='M031' 
                                    AND NOT (BALANCE.WHSLOCATIONWAREHOUSEZONECODE='B1' 
                                        OR BALANCE.WHSLOCATIONWAREHOUSEZONECODE='TMP' 
                                        OR BALANCE.WHSLOCATIONWAREHOUSEZONECODE='DOK')";
                  $stmt = db2_exec($conn1, $sqld, array('cursor' => DB2_SCROLLABLE));
                  $rowd = db2_fetch_assoc($stmt);
                  ?>
                  <tr>
                    <td style="text-align: center"><?php echo $no; ?></td>
                    <td style="text-align: center"><?php echo substr($rowdb21['tgl_bon'], 0, 10); ?></td>
                    <td style="text-align: center"><?php echo $rowdb21['tgl_mutasi']; ?></td>
                    <td style="text-align: center"><?php echo $rowdb21['no_bon']; ?></td>                    
                    <td style="text-align: center"><?php echo $rowdb21['langganan']; ?></td>
                    <td style="text-align: center"><?php echo $rowdb21['no_po']; ?></td>
                    <td style="text-align: center"><?php echo $rowdb21['no_order']; ?></td>
                    <td style="text-align: center"><?php echo $rowdb21['jenis_kain']; ?></td>
                    <td style="text-align: center"><?php echo $rowdb21['warna']; ?></td>
                    <td style="text-align: center"><?php echo $rowd['JML_ROLL']; ?></td>
                    <td style="text-align: right"><?php echo  number_format($rowd['TBERAT'], 2) ?? '0' ; ?></td>
                    <td style="text-align: right"><?php echo $rowdb21['berat_tg']; ?></td>
                    <td style="text-align: center"><?php echo $rowdb21['no_lot']; ?></td>                    
                    <td style="text-align: left"><?php echo $rowdb21['ket']; ?></td>                    
                    <td style="text-align: center"><?php echo $rowdb21['tempat']; ?></td>
                    <td style="text-align: center"><?php echo $rowdb21['kode_jns_permintaan']; ?></td>
                  </tr>
                  <?php
                  $no++;
                  $totJml += $rowd['JML_ROLL'];
                  $totKg += $rowd['TBERAT'];
                  $totberatTG += $rowdb21['berat_tg'];
                }
              }
            } else {
              // Kalau belum pilih tanggal, kasih info
              echo '<tr><td colspan="16" style="text-align:center;">
                        Silakan pilih Tgl Awal dan Tgl Akhir, lalu klik Cari Data.
                      </td></tr>';
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
	    <td style="text-align: center">&nbsp;</td>
	    <td style="text-align: center"><strong>Total</strong></td>
	    <td style="text-align: center"><strong><?php echo $totJml; ?></strong></td>
	    <td style="text-align: right"><strong><?php echo number_format(round($totKg,2),2); ?></strong></td>
	    <td style="text-align: right"><strong><?php echo number_format(round($totberatTG, 2), 2); ?></strong></td>
	    <td style="text-align: left">&nbsp;</td>
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