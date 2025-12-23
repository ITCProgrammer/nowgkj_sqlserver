<?php
$Thn2			= isset($_POST['thn']) ? $_POST['thn'] : '';
$Bln2			= isset($_POST['bln']) ? $_POST['bln'] : '';
$Dept			= isset($_POST['dept']) ? $_POST['dept'] : '';
$Bulan			= $Thn2."-".$Bln2;
if($Thn2!="" and $Bln2!=""){
$d				= cal_days_in_month(CAL_GREGORIAN,$Bln2,$Thn2);
$Lalu 		= $Bln2-1;	
	if($Lalu=="0"){
	if(strlen($Lalu)==1){$bl0="0".$Lalu;}else{$bl0=$Lalu;}	
	$BlnLalu="12";	
	$Thn=$Thn2-1;
	$TBln=$Thn."-".$BlnLalu;	
	}else{
	if(strlen($Lalu)==1){$bl0="0".$Lalu;}else{$bl0=$Lalu;}	
	$BlnLalu=$bl0;
	$TBln=$Thn2."-".$BlnLalu;	
	}	
	
}
?>
<!-- Main content -->
      <div class="container-fluid">
		<form role="form" method="post" enctype="multipart/form-data" name="form1">  
		<div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Filter Data Gudang Kain Jadi</h3>

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
			<div class="col-sm-1">
                	<select name="thn" class="form-control form-control-sm  select2"> 
                	<option value="">Pilih Tahun</option>
        <?php
                $thn_skr = date('Y');
                for ($x = $thn_skr; $x >= 2022; $x--) {
                ?>
        <option value="<?php echo $x ?>" <?php if($Thn2!=""){if($Thn2==$x){echo "SELECTED";}}else{if($x==$thn_skr){echo "SELECTED";}} ?>><?php echo $x ?></option>
        <?php
                }
   ?>
                	</select>
                	</div>
		       	<div class="col-sm-2">
                	<select name="bln" class="form-control form-control-sm  select2"> 
                	<option value="">Pilih Bulan</option>
					<option value="01" <?php if($Bln2=="01"){ echo "SELECTED";}?>>Januari</option>
					<option value="02" <?php if($Bln2=="02"){ echo "SELECTED";}?>>Febuari</option>
					<option value="03" <?php if($Bln2=="03"){ echo "SELECTED";}?>>Maret</option>
					<option value="04" <?php if($Bln2=="04"){ echo "SELECTED";}?>>April</option>
					<option value="05" <?php if($Bln2=="05"){ echo "SELECTED";}?>>Mei</option>
					<option value="06" <?php if($Bln2=="06"){ echo "SELECTED";}?>>Juni</option>
					<option value="07" <?php if($Bln2=="07"){ echo "SELECTED";}?>>Juli</option>
					<option value="08" <?php if($Bln2=="08"){ echo "SELECTED";}?>>Agustus</option>
					<option value="09" <?php if($Bln2=="09"){ echo "SELECTED";}?>>September</option>
					<option value="10" <?php if($Bln2=="10"){ echo "SELECTED";}?>>Oktober</option>
					<option value="11" <?php if($Bln2=="11"){ echo "SELECTED";}?>>November</option>
					<option value="12" <?php if($Bln2=="12"){ echo "SELECTED";}?>>Desember</option>	
                	</select>
                	</div>		
				 <!-- /.input group -->
			
              	  
          </div>
			  
				 
			 
          </div>		  
		  <div class="card-footer"> 
			  <button class="btn btn-info" type="submit">Cari Data</button>
		  </div>	
		  <!-- /.card-body -->          
        </div>  
		
		<div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Detail Laporan Harian Masuk Kain Jadi</h3>				  
          </div>
              <!-- /.card-header -->
              <div class="card-body">
			<?php	  
	$sql = mysqli_query($con," SELECT tgl_tutup,sum(rol) as rol,sum(weight) as kg FROM tbl_opname 
	WHERE DATE_FORMAT(tgl_tutup,'%Y-%m')='$TBln' GROUP BY tgl_tutup ORDER BY tgl_tutup DESC LIMIT 1 ");		  
    $r = mysqli_fetch_array($sql);
	?>			<strong>Sisa Stok Bulan Lalu Kain I : <?php echo number_format(round($r['kg'],3),3); ?> Kain II : 00.00 Total: <?php $total=$r['kg']+00.00; echo number_format(round($total,3),3);?></strong><br>
                <table id="example16" width="100%" class="table table-sm table-bordered table-striped" style="font-size: 11px; text-align: center;">
                  <thead>
                  <tr>
                    <th width="6%" rowspan="2" valign="middle" style="text-align: center">Tgl</th>
                    <th width="13%" rowspan="2" valign="middle" style="text-align: center">Kain dari Packing</th>
                    <th width="13%" rowspan="2" valign="middle" style="text-align: center">Retur Masuk</th>
                    <th colspan="5" valign="middle" style="text-align: center">Keluar</th>
                    <th width="8%" rowspan="2" valign="middle" style="text-align: center">Sisa</th>
                    <th width="8%" rowspan="2" valign="middle" style="text-align: center">Status</th>
                    <th width="8%" rowspan="2" valign="middle" style="text-align: center">Selisih</th>
                    </tr>
                  <tr>
                    <th width="16%" valign="middle" style="text-align: center">Pengiriman</th>
                    <th width="13%" valign="middle" style="text-align: center">Pass Qty</th>
                    <th width="13%" valign="middle" style="text-align: center">Potong Sample</th>
                    <th width="13%" valign="middle" style="text-align: center">Bongkaran</th>
                    <th width="13%" valign="middle" style="text-align: center">Bongkaran Retur</th>
                    </tr>
                  </thead>
                  <tbody>
<?php for ($i = 1; $i <= $d; $i++){ 
	$sqlMasuk = mysqli_query($con," SELECT tgl_tutup,sum(qty) as rol,sum(berat) as kg FROM tblmasukkain 
	WHERE tgl_tutup='$Thn2-$Bln2-$i' and jns_trans='packing' GROUP BY tgl_tutup ");	
	$rMasuk = mysqli_fetch_array($sqlMasuk);
	$sqlReturMasuk = mysqli_query($con," SELECT tgl_tutup,sum(qty) as rol,sum(berat) as kg FROM tblmasukkain 
	WHERE tgl_tutup='$Thn2-$Bln2-$i' and jns_trans='retur' GROUP BY tgl_tutup ");	
	$rReturMasuk = mysqli_fetch_array($sqlReturMasuk);
	$sqlPengiriman = mysqli_query($con," SELECT tgl_tutup,sum(qty) as rol,sum(berat) as kg FROM tblkeluarkain 
	WHERE tgl_tutup='$Thn2-$Bln2-$i' AND jns_trans='pengiriman' GROUP BY tgl_tutup");		  
    $rPengiriman = mysqli_fetch_array($sqlPengiriman);
	$sqlPassQTY = mysqli_query($con," SELECT tgl_tutup,sum(qty) as rol,sum(berat) as kg FROM tblkeluarkain 
	WHERE tgl_tutup='$Thn2-$Bln2-$i' AND jns_trans='pass qty' GROUP BY tgl_tutup");		  
    $rPassQTY = mysqli_fetch_array($sqlPassQTY);
	$sqlSample = mysqli_query($con," SELECT tgl_tutup,sum(qty) as rol,sum(berat) as kg FROM tblkeluarkain 
	WHERE tgl_tutup='$Thn2-$Bln2-$i' AND jns_trans='potong sample' GROUP BY tgl_tutup");		  
    $rSample = mysqli_fetch_array($sqlSample);
	$sqlBongkaran = mysqli_query($con," SELECT tgl_tutup,sum(qty) as rol,sum(berat) as kg FROM tblkeluarkain 
	WHERE tgl_tutup='$Thn2-$Bln2-$i' AND jns_trans='bongkaran' GROUP BY tgl_tutup");		  
    $rBongkaran = mysqli_fetch_array($sqlBongkaran);
	$sqlBongkaranRetur = mysqli_query($con," SELECT tgl_tutup,sum(qty) as rol,sum(berat) as kg FROM tblkeluarkain 
	WHERE tgl_tutup='$Thn2-$Bln2-$i' AND jns_trans='bongkaran retur' GROUP BY tgl_tutup");		  
    $rBongkaranRetur = mysqli_fetch_array($sqlBongkaranRetur);
	if($i=="1"){
	$sisa+=$total+((round($rMasuk['kg'],3)+round($rReturMasuk['kg'],3))-(round($rPengiriman['kg'],3)+round($rPassQTY['kg'],3)+round($rSample['kg'],3)+round($rBongkaran['kg'],3)+round($rBongkaranRetur['kg'],3)));	
	}else{
	$sisa+=((round($rMasuk['kg'],3)+round($rReturMasuk['kg'],3))-(round($rPengiriman['kg'],3)+round($rPassQTY['kg'],3)+round($rSample['kg'],3)+round($rBongkaran['kg'],3)+round($rBongkaranRetur['kg'],3)));
	}
	$sqlOP = mysqli_query($con," SELECT tgl_tutup,sum(rol) as rol,sum(weight) as kg,DATE_FORMAT(now(),'%Y-%m-%d') as tgl 
FROM tbl_opname WHERE tgl_tutup='$Thn2-$Bln2-$i' GROUP BY tgl_tutup");		  
    $rOP = mysqli_fetch_array($sqlOP);
	
	if(round($sisa)==round($sisa-$rOP['kg'])){
		$sts="<small class='badge badge-info'> OK</small>";
	}else if(round($sisa-$rOP['kg'])==0){
		$sts="<small class='badge badge-success'> OK</small>";
	}else{
		$sts="<small class='badge badge-warning'><i class='fas fa-exclamation-triangle text-white blink_me'></i> Tidak OK</small>";
	}
	
					  ?>
	  <tr>
	  <td><?php echo $i; ?></td>
	  <td align="right"><?php echo number_format(round($rMasuk['kg'],2),2); ?></td>
	  <td align="right"><?php echo number_format(round($rReturMasuk['kg'],2),2); ?></td>
	  <td align="right"><?php echo number_format(round($rPengiriman['kg'],2),2); ?></td>
      <td align="right"><?php echo number_format(round($rPassQTY['kg'],2),2); ?></td>
      <td align="right"><?php echo number_format(round($rSample['kg'],2),2); ?></td>
      <td align="right"><?php echo number_format(round($rBongkaran['kg'],2),2); ?></td>
      <td align="right"><?php echo number_format(round($rBongkaranRetur['kg'],2),2); ?></td>
      <td align="right"><strong><?php echo number_format(round($sisa,3),3); ?></strong></td>
      <td align="right"><strong><?php echo $sts; ?></strong></td>
      <td align="right"><strong><?php echo number_format(round($sisa,3)-round($rOP['kg'],3),3); ?></strong></td>
      </tr>
	  				  
	<?php 
	 $no++; 
	$tM+=round($rMasuk['kg'],3);
	$tRM+=round($rReturMasuk['kg'],3);
	$tP+=round($rPengiriman['kg'],3);
	$tPQ+=round($rPassQTY['kg'],3);
	$tSP+=round($rSample['kg'],3);
	$tB+=round($rBongkaran['kg'],3);
	$tBR+=round($rBongkaranRetur['kg'],3);
	} 
	$tS=($total+$tM+$tRM)-($tP+$tPQ+$tS+$tB+$tBR);
					  ?>
				  </tbody>
                  <tfoot>
	 <tr>
	   <td><strong>Total</strong></td>
	    <td align="right"><strong><?php echo number_format(round($tM,2),2); ?></strong></td>
	    <td align="right"><strong><?php echo number_format(round($tRM,2),2); ?></strong></td>
	    <td align="right"><strong><?php echo number_format(round($tP,2),2); ?></strong></td>
	    <td align="right"><strong><?php echo number_format(round($tPQ,2),2); ?></strong></td>
	    <td align="right"><strong><?php echo number_format(round($tSP,2),2); ?></strong></td>
	    <td align="right"><strong><?php echo number_format(round($tB,2),2); ?></strong></td>
	    <td align="right"><strong><?php echo number_format(round($tBR,2),2); ?></strong></td>
	    <td align="right"><strong><?php echo number_format(round($tS,3),3); ?></strong></td>
	    <td align="right">&nbsp;</td>
	    <td align="right">&nbsp;</td>
	    </tr>				
					</tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div> 
	</form>		
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