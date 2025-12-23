
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
?>
<?php
	$Tgl		= isset($_GET['tgl']) ? $_GET['tgl'] : '';
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
   $sqlBB=mysqli_query($con,"
   select
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
	tbl_opname_detail_bb_11
where
	tgl_tutup = '$Tgl'
   ");
	while($rBB=mysqli_fetch_array($sqlBB)){
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
              