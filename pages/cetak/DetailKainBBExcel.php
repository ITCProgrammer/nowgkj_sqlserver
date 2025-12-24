
<?php
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=DetailKainBB".$_GET['tgl'].".xls"); //ganti nama sesuai keperluan
	header("Pragma: no-cache");
	header("Expires: 0");
	// disini script laporan anda
?>
<?php
	include "../../koneksi.php";
	ini_set("error_reporting", 1);
    $schema = 'dbnow_gkj';
    $tblOpnameDetailBB = "[$schema].[tbl_opname_detail_bb_11]";
	$Tgl		= isset($_GET['tgl']) ? $_GET['tgl'] : '';

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
?>

          <table border="1">
                  <tr>
                    <th>Item</th>
                    <th>Langganan</th>
                    <th>Buyer</th>
                    <th>PO</th>
                    <th>Order</th>
                    <th>Tipe</th>
                    <th>No Item</th>
                    <th>Jenis Kain</th>
                    <th>No Warna</th>
                    <th>Warna</th>
                    <th>Lot</th>
                    <th>Rol</th>
                    <th>Weight</th>
                    <th>Length</th>
                    <th>ElementNo</th>
                    <th>Zone</th>
                    <th>Lokasi</th>
					<th>Lebar</th>
                    <th>Gramasi</th>  
                    <th>Status</th>
			  </tr>
<?php				  
			  
   $no=1;   
   $c=0;
   $sqlBB = "select
	itm,
	langganan,
	buyer,
	po,
	orderno,
	tipe,
	no_item,
	jns_kain,
	no_warna,
	warna,
	lot,
	zone,
	lokasi,
	lebar,
	gramasi,
	sts_kain,
	sn,
	rol,
	weight as kg,
	length
from
	$tblOpnameDetailBB
where
	tgl_tutup = ?";
    $stmtBB = sqlsrv_query($con, $sqlBB, [$Tgl], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
    logSqlError($stmtBB, 'DetailKainBBExcel');
	while($stmtBB && ($rBB=sqlsrv_fetch_array($stmtBB, SQLSRV_FETCH_ASSOC))){
?>				  
	  <tr>
      <td><?php echo $rBB['itm']; ?></td>
      <td><?php echo $rBB['langganan']; ?></td>
      <td><?php echo $rBB['buyer']; ?></td>
      <td><?php echo $rBB['po']; ?></td>
      <td><?php echo $rBB['orderno']; ?></td>
      <td><?php echo $rBB['tipe']; ?></td>
      <td><?php echo $rBB['no_item']; ?></td>
      <td><?php echo $rBB['jns_kain']; ?></td>
      <td><?php echo $rBB['no_warna']; ?></td>
      <td><?php echo $rBB['warna']; ?></td>
      <td>'<?php echo $rBB['lot']; ?></td>
      <td><?php echo $rBB['rol']; ?></td>
      <td><?php echo $rBB['kg']; ?></td>
      <td><?php echo $rBB['length'];?></td>
      <td>'<?php echo $rBB['sn']; ?></td>
      <td><?php echo $rBB['zone']; ?></td>
      <td><?php echo $rBB['lokasi']; ?></td>
	  <td><?php echo $rBB['lebar']; ?></td>
      <td><?php echo $rBB['gramasi']; ?></td> 	  
      <td><?php echo $rBB['sts_kain']; ?></td>
      </tr>				  
<?php	$no++;
		
	} 
					  ?>				                    
                </table>
<?php if (!empty($sqlErrors)) { ?>
    <p><strong>SQL Error:</strong></p>
    <ul>
        <?php foreach ($sqlErrors as $errMsg) { ?>
            <li><?php echo htmlspecialchars($errMsg); ?></li>
        <?php } ?>
    </ul>
<?php } ?>
