<?php
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=persediaankainjadiFullDetail11.xls"); //ganti nama sesuai keperluan
	header("Pragma: no-cache");
	header("Expires: 0");
	// disini script laporan anda
?>
<?php
	include "../../koneksi.php";
	ini_set("error_reporting", 1);
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
                    <th>Kategori</th>
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
                    <th>ElementsCode</th>
                    <th>Status</th>
                    </tr>
				  <?php	
   $no=1;   
   $c=0;
	$sqlDB21 = " select *
from
	tbl_opname_detail_11 tod
where tgl_tutup ='$_GET[tgl]' ";
	$stmt1   = mysqli_query($con,$sqlDB21);
    while($rowdb21 = mysqli_fetch_array($stmt1)){		
	?>
	  <tr>
	    <td><?php if($rowdb21['tgl_mutasi']!="0000-00-00"){echo $rowdb21['tgl_mutasi'];}else{} ?></td>
	    <td><?php echo $rowdb21['tgl_update']; ?></td>
	    <td><?php echo $rowdb21['itm']; ?></td>
	    <td><?php echo $rowdb21['langganan']; ?></td>
	    <td><?php echo $rowdb21['buyer']; ?></td>
	    <td><?php echo $rowdb21['po']; ?></td>
	    <td><?php echo $rowdb21['orderno']; ?></td>
	    <td><?php echo $rowdb21['tipe']; ?></td>
	    <td><?php echo $rowdb21['tgl_delivery']; ?></td>
	    <td><?php echo $rowdb21['tgl_delivery_actual']; ?></td>
	    <td><?php echo $rowdb21['no_item']; ?></td>
	    <td><?php echo $rowdb21['kategori']; ?></td>
	    <td><?php echo $rowdb21['jns_kain']; ?></td>
	    <td><?php echo $rowdb21['no_warna']; ?></td>
	    <td><?php echo $rowdb21['warna']; ?></td>
	    <td><?php echo $rowdb21['rol']; ?></td>
	    <td>'<?php echo $rowdb21['lot'];?></td>
	    <td><?php echo number_format(round($rowdb21['weight'],2),2);?></td>
	    <td><?php echo $rowdb21['satuan'];?></td>
	    <td><?php echo number_format(round($rowdb21['length'],2),2);?></td>
	    <td><?php echo $rowdb21['satuan_len'];?></td>
	    <td><?php echo $rowdb21['zone'];?></td>
	    <td><?php echo $rowdb21['lokasi'];?></td>
	    <td><?php echo round($rowdb21['lebar']);?></td>
	    <td><?php echo round($rowdb21['gramasi']);?></td>
	    <td><?php echo $rowdb21['grouping1']; ?></td>
	    <td><?php echo $rowdb21['hue1']; ?></td>
	  <td>'<?php echo $rowdb21['sn'];?></td>
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
                    <td></td>  
                    </tr> 
                </table>