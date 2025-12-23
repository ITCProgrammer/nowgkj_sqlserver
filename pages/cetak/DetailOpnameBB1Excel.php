
<?php
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=DetailOpnameBB1 ".$_GET['tgl'].".xls"); //ganti nama sesuai keperluan
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
                    <th>Jns Kain</th>
                    <th>No Warna</th>
                    <th>Warna</th>
                    <th>Lot</th>
                    <th>Rol</th>
                    <th>Weight</th>
                    <th>Satuan</th>
                    <th>Length</th>
                    <th>Satuan</th>
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
	count(rol) as rol,
	sum(weight) as weight,
	satuan,
	sum(length) as length,
	satuan_len,
	zone,
	lokasi,
	lebar,
	gramasi,
	sts_kain
from
	tbl_opname_detail_bb_11
where
	tgl_tutup = '$Tgl'
group by
	orderno,
	no_warna,
	lot,
	zone,
	lokasi,
	sts_kain
order by
	id asc
   ");
	while($r=mysqli_fetch_array($sqlBB)){
?>				  
	  <tr>
      <td><?php echo $r['itm']; ?></td>
	   <td><?php echo $r['langganan']; ?></td>
      <td><?php echo $r['buyer']; ?></td>
      <td><?php echo $r['po']; ?></td>
      <td><?php echo $r['orderno']; ?></td>
      <td><?php echo $r['tipe']; ?></td>
      <td><?php echo $r['no_item']; ?></td>
      <td><?php echo $r['jns_kain']; ?></td>
      <td><?php echo $r['no_warna']; ?></td>
      <td><?php echo $r['warna']; ?></td>
      <td>'<?php echo $r['lot'];?></td>
      <td><?php echo $r['rol'];?></td>
      <td><?php echo $r['weight'];?></td>
      <td><?php echo $r['satuan'];?></td>
      <td><?php echo $r['length'];?></td>
      <td><?php echo $r['satuan_len'];?></td>
      <td><?php echo $r['zone'];?></td>
      <td><?php echo $r['lokasi'];?></td>
      <td><?php echo $r['lebar'];?></td>
      <td><?php echo $r['gramasi'];?></td>
      <td><?php echo $r['sts_kain'];?></td>
      </tr>				  
      <?php	$no++;
		$totrol=$totrol+$r['rol'];
		$totkg=$totkg+$r['weight'];
	   } ?>
      <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><strong>TOTAL</strong></td>
      <td><strong><?php echo $totrol; ?></strong></td>
      <td><strong><?php echo number_format(round($totkg,3),3); ?></strong></td>
      <td><strong>KGs</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>				                    
   </table>
              