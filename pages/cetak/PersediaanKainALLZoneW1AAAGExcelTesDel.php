<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=persediaanBalanceZoneW1AA_AG.xls");//ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");
//disini script laporan anda
?>
<?php
include "../../koneksi.php";
ini_set("error_reporting", 1);
?>
<table id="" class="">
                  <thead>
                  <tr>
                    <th>TGLMasuk</th>
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
                    <th>Delivery</th>
                    <th>Element</th>
                    <th>Lot</th>
                    <th>Weight</th>
                    <th>Satuan</th>
                    <th>Grade</th>
                    <th>Length</th>
                    <th>Satuan</th>
                    <th>Zone</th>
                    <th>Lokasi</th>
					<th>Lebar</th>
                    <th>Gramasi</th>  
                    <th>Status</th>
                    <th>Ket</th>
                    </tr>
                  </thead>
                  <tbody>
				  <?php
					  
   $no=1;   
   $c=0;
	//if($Zone=="" and $Lokasi==""){
	//	echo"<script>alert('Zone atau Lokasi belum dipilih');</script>";
	//}else{
	$sqlDB21 = " SELECT * FROM 
	BALANCE b WHERE (b.ITEMTYPECODE='KFF' OR b.ITEMTYPECODE='FKF') AND b.LOGICALWAREHOUSECODE='M031' AND WHSLOCATIONWAREHOUSEZONECODE LIKE 'W1%' AND 
	(WAREHOUSELOCATIONCODE LIKE 'AA%' OR
	WAREHOUSELOCATIONCODE LIKE 'AB%' OR 
	WAREHOUSELOCATIONCODE LIKE 'AC%' OR
	WAREHOUSELOCATIONCODE LIKE 'AD%' OR
	WAREHOUSELOCATIONCODE LIKE 'AE%' OR
	WAREHOUSELOCATIONCODE LIKE 'AF%' OR
	WAREHOUSELOCATIONCODE LIKE 'AG%') ";
	$stmt1   = db2_exec($conn1,$sqlDB21, array('cursor'=>DB2_SCROLLABLE));
	//}				  
    while($rowdb21 = db2_fetch_assoc($stmt1)){
	$itemNo=trim($rowdb21['DECOSUBCODE02'])."".trim($rowdb21['DECOSUBCODE03']);	
	
?>
	  <tr>
      <td><?php if($rowdb29['TRANSACTIONDATE']!=""){echo substr($rowdb29['TRANSACTIONDATE'],0,10);}else{echo substr($rowdb21['CREATIONDATETIME'],0,10);} ?></td>
      <td><?php echo $item; ?></td>
      <td><?php if($langganan!=""){echo $langganan;}else{ echo $cust; } ?></td>
      <td><?php if($buyer!=""){echo $buyer;}else{echo $byr;} ?></td>
      <td><?php if($PO!=""){echo $PO;}else{ echo $rQC['no_po']; } ?></td>
      <td><?php if(trim($rowdb21['PROJECTCODE'])!=""){echo $rowdb21['PROJECTCODE'];}else{ echo $rQC['no_order']; } ?></td>
      <td><?php echo $jns; ?></td>
      <td><?php echo $itemNo; ?></td>
      <td><?php echo $jskain; ?></td>
      <td><?php echo $rowdb21['DECOSUBCODE05']; ?></td>
      <td><?php echo $rowdb23['LONGDESCRIPTION']; ?></td>
      <td><?php echo $rowdb22['DELIVERYDATE'];?></td>
      <td>'<?php echo $rowdb21['ELEMENTSCODE'];?></td>
      <td>'<?php echo $rowdb21['LOTCODE'];?></td>
      <td><?php echo number_format(round($rowdb21['BASEPRIMARYQUANTITYUNIT'],2),2);?></td>
      <td><?php echo $rowdb21['BASEPRIMARYUNITCODE'];?></td>
      <td><?php echo $grade;?></td>
      <td><?php echo number_format(round($rowdb21['BASESECONDARYQUANTITYUNIT'],2),2);?></td>
      <td><?php echo $rowdb21['BASESECONDARYUNITCODE'];?></td>
      <td><?php echo $rowdb21['WHSLOCATIONWAREHOUSEZONECODE'];?></td>
      <td><?php echo $rowdb21['WAREHOUSELOCATIONCODE'];?></td>
	  <td><?php echo round($rowdb27['VALUEDECIMAL']);?></td>
      <td><?php echo round($rowdb28['VALUEDECIMAL']);?></td> 	  
      <td><?php echo $sts; ?></td>
      <td><?php echo $ket; ?></td>
      </tr>				  
<?php	$no++;
		$totkg=$totkg+$rowdb21['BASEPRIMARYQUANTITYUNIT'];
		if(trim($rowdb21['BASESECONDARYUNITCODE'])=="yd"){$tyd=$rowdb21['BASESECONDARYQUANTITYUNIT'];}else{$tyd=0;}
		$totyd=$totyd+$tyd;
		if(trim($rowdb21['BASESECONDARYUNITCODE'])=="m"){$tmtr=$rowdb21['BASESECONDARYQUANTITYUNIT'];}else{$tmtr=0;}
		$totmtr=$totmtr+$tmtr;
	} ?>
				  </tbody>
				<tfoot>
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
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><strong>TOTAL</strong></td>
                    <td><strong><?php echo $no-1; ?> Roll</strong></td>
                    <td><strong><?php echo number_format(round($totkg,2),2); ?></strong></td>
                    <td><strong>KGs</strong></td>
                    <td>&nbsp;</td>
                    <td><strong><?php echo number_format(round($totyd,2),2); ?></strong></td>
                    <td><strong>YDs</strong></td>
                    <td><strong><?php echo number_format(round($totmtr,2),2); ?></strong></td>
                    <td><strong>MTRs</strong></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>  
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    </tr>
                  </tfoot>                  
                </table>