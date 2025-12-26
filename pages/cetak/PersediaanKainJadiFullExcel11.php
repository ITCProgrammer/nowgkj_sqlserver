<?php
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=persediaankainjadiFull11.xls"); //ganti nama sesuai keperluan
	header("Pragma: no-cache");
	header("Expires: 0");
	// disini script laporan anda
?>
<?php
	include "../../koneksi.php";
	ini_set("error_reporting", 1);
    $schema = 'dbnow_gkj';
    $tblOpnameDetail = "[$schema].[tbl_opname_detail_11]";
    $sqlErrors = [];
    function logSqlError($stmt, $label = ''){
        global $sqlErrors;
        if ($stmt !== false) { return; }
        $err = sqlsrv_errors();
        if (!empty($err)) {
            $msg = ($label !== '' ? $label . ': ' : '') . $err[0]['message'];
            $sqlErrors[] = $msg;
        }
    }
    function fmtDate($val, $format = 'Y-m-d') {
        if ($val instanceof DateTime) {
            return $val->format($format);
        }
        return $val;
    }
    $tgl = isset($_GET['tgl']) ? $_GET['tgl'] : '';
?>
<table>                  
                  <tr>
                    <th>Tgl Mutasi</th>
                    <th>Tgl Update</th>
                    <th>Item</th>
                    <th>Langganan</th>
                    <th>Buyer</th>
                    <th>PO</th>
                    <th>Order</th>
                    <th>Tipe</th>
                    <th>Tgl Delivery</th>
                    <th>Delivery Actual</th>
                    <th>No Item</th>
                    <th>Jns Kain</th>
                    <th>No Warna</th>
                    <th>Warna</th>
                    <th>Rol</th>
                    <th>Lot</th>
                    <th>Weight</th>
                    <th>Satuan</th>
                    <th>Length</th>
                    <th>Satuan</th>
                    <th>Zone</th>
                    <th>Lokasi</th>
                    <th>Lebar</th>
                    <th>Gramasi</th>
                    <th>Grouping</th>
                    <th>Hue</th>
                    <th>Status</th>
                    </tr>                  
				  <?php
   $no=1;
   $c=0;
	$sqlDB21 = " select *
from
	$tblOpnameDetail tod
where tgl_tutup = ?
";
	$stmt1   = sqlsrv_query($con,$sqlDB21, [$tgl], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
    logSqlError($stmt1, 'FullExcel11 tgl');
    while($stmt1 && ($rowdb21 = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC))){
        $tglMutasi   = fmtDate($rowdb21['tgl_mutasi']);
        $tglUpdate   = fmtDate($rowdb21['tgl_update']);
        $tglDelivery = fmtDate($rowdb21['tgl_delivery']);
        $tglDeliveryActual = fmtDate($rowdb21['tgl_delivery_actual']);
	?>
	  <tr>
	  <td><?php if($tglMutasi!="0000-00-00"){echo $tglMutasi;}else{} ?></td>
	  <td><?php echo $tglUpdate; ?></td>
	  <td><?php echo $rowdb21['itm']; ?></td>
      <td><?php echo $rowdb21['langganan']; ?></td>
      <td><?php echo $rowdb21['buyer']; ?></td>
      <td><?php echo $rowdb21['po']; ?></td>
      <td><?php echo $rowdb21['orderno']; ?></td>
      <td><?php echo $rowdb21['tipe']; ?></td>
      <td><?php echo $tglDelivery; ?></td>
      <td><?php echo $tglDeliveryActual; ?></td>
      <td><?php echo $rowdb21['no_item']; ?></td>
      <td><?php echo $rowdb21['jns_kain']; ?></td>
      <td><?php echo $rowdb21['no_warna']; ?></td>
      <td><?php echo $rowdb21['warna']; ?></td>
      <td><?php echo $rowdb21['rol']; ?></td>
      <td>'<?php echo $rowdb21['lot'];?></td>
      <td><?php echo number_format(round($rowdb21['weight'],2),2);?></td>
      <td><?php echo $rowdb21['satuan'];?></td>
      <td><?php echo number_format(round($rowdb21['lenght'],2),2);?></td>
      <td><?php echo $rowdb21['satuan_len'];?></td>
      <td><?php echo $rowdb21['zone'];?></td>
      <td><?php echo $rowdb21['lokasi'];?></td>
      <td><?php echo round($rowdb27['lebar']);?></td>
      <td><?php echo round($rowdb27['gramasi']);?></td>
      <td><?php echo $rowdb28['grouping1']; ?></td>
      <td><?php echo $rowdb28['hue1']; ?></td>
      <td><?php echo $rowdb21['sts_kain']; ?></td>
      </tr>				  
<?php	$no++;
		$totrol=$totrol+$rowdb21['rol'];
		$totkg=$totkg+$rowdb21['weight'];
		if(trim($rowdb21['satuan_len'])=="yd"){$tyd=$rowdb21['lenght'];}else{$tyd=0;}
		$totyd=$totyd+$tyd;
		if(trim($rowdb21['satuan_len'])=="m"){$tmtr=$rowdb21['lenght'];}else{$tmtr=0;}
		$totmtr=$totmtr+$tmtr;
	
	
	} ?>				  
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
					<td>TOTAL</td>
                    <td><?php echo $totrol; ?></td>  
                    <td></td>                    
                    <td><?php echo number_format(round($totkg,2),2); ?></td>
                    <td>KGs</td>
                    <td><?php echo number_format(round($totyd,2),2); ?></td>
                    <td>YDs</td>
                    <td><?php echo number_format(round($totmtr,2),2); ?></td>
                    <td>MTRs</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>  
                    </tr>  
                </table>
<?php if (!empty($sqlErrors)) { ?>
    <p><strong>SQL Error:</strong></p>
    <ul>
        <?php foreach ($sqlErrors as $errMsg) { ?>
            <li><?php echo htmlspecialchars($errMsg); ?></li>
        <?php } ?>
    </ul>
<?php } ?>
