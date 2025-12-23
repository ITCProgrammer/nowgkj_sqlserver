<?php
$LotCode	= isset($_POST['lotcode']) ? $_POST['lotcode'] : '';
?>
<!-- Main content -->
<div class="container-fluid">
  <form role="form" method="post" enctype="multipart/form-data" name="form1">
    <div class="card card-purple">
      <div class="card-header">
        <h3 class="card-title">Filter Data</h3>

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
               <label for="tgl_awal" class="col-md-1">LotCode</label>
               <div class="col-md-2">  
                 <input name="lotcode" value="<?php echo $LotCode;?>" type="text" class="form-control form-control-sm">
			   </div>	
            </div>        
      </div>
      <div class="card-footer">
        <button class="btn btn-info" type="submit" value="Cari" name="cari">Cari Data</button>
      </div>
      <!-- /.card-body -->

    </div>
  </form>

  <!-- Card laporan harian pengiriman -->

  <div class="card card-pink">
              <div class="card-header">
                <h3 class="card-title">Data Laporan Harian Pengiriman</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
          <table id="example11" class="table table-sm table-bordered table-striped" style="font-size:13px;">
                  <thead>
                  <tr>
                    <th style="text-align: center">No.</th>
                    <th style="text-align: center">Tanggal</th>
                    <th style="text-align: center">Buyer</th>
                    <th style="text-align: center">Customer</th>
                    <th style="text-align: center">No PO</th>
                    <th style="text-align: center">NoOrder</th>
                    <th style="text-align: center">Jenis Kain</th>
                    <th style="text-align: center">NoWarna</th>
                    <th style="text-align: center">Warna</th>
                    <th style="text-align: center">Lot</th>
                    <th style="text-align: center">Roll</th>
                    <th style="text-align: center">Berat</th>
                    <th style="text-align: center">Lokasi</th>
                    <th style="text-align: center">No SJ</th>
                    <th style="text-align: center">FOC</th>
                    </tr>
                  </thead>
                  <tbody>
				  <?php
$no = 1;
$c = 0;
$sqlDB21 = " SELECT SALESDOCUMENT.GOODSISSUEDATE, ITXVIEWLAPKIRIMPPC.PROVISIONALCODE,
       ITXVIEWLAPKIRIMPPC.DEFINITIVEDOCUMENTDATE,ITXVIEWLAPKIRIMPPC.ORDERPARTNERBRANDCODE,
       ITXVIEWLAPKIRIMPPC.PO_NUMBER,ITXVIEWLAPKIRIMPPC.PROJECTCODE,
	   ITXVIEWLAPKIRIMPPC.DLVSALORDERLINESALESORDERCODE,ITXVIEWLAPKIRIMPPC.DLVSALESORDERLINEORDERLINE,
       ITXVIEWLAPKIRIMPPC.ORDPRNCUSTOMERSUPPLIERCODE,
       ITXVIEWLAPKIRIMPPC.ITEMDESCRIPTION,
	   ITXVIEWLAPKIRIMPPC.CODE,
	   ITXVIEWLAPKIRIMPPC.PAYMENTMETHODCODE,
       SALESDOCUMENT.PROVISIONALCODE AS NOSJ
	   FROM DB2ADMIN.ITXVIEWLAPKIRIMPPC ITXVIEWLAPKIRIMPPC LEFT OUTER JOIN
       DB2ADMIN.SALESDOCUMENT SALESDOCUMENT ON
       ITXVIEWLAPKIRIMPPC.PROVISIONALCODE=SALESDOCUMENT.PROVISIONALCODE
	   WHERE SALESDOCUMENT.GOODSISSUEDATE BETWEEN '$Awal' AND '$Akhir' AND SALESDOCUMENT.PROGRESSSTATUS='2'
	   AND NOT ITXVIEWLAPKIRIMPPC.CODE IS NULL AND NOT SALESDOCUMENT.PROVISIONALCODE LIKE 'PCA%'";
$stmt1 = db2_exec($conn1, $sqlDB21, array('cursor' => DB2_SCROLLABLE));
//}
while ($rowdb21 = db2_fetch_assoc($stmt1)) {
    if ($rowdb21['PROJECTCODE'] != "") {$project = $rowdb21['PROJECTCODE'];} else { $project = $rowdb21['DLVSALORDERLINESALESORDERCODE'];}
    if ($rowdb21['PAYMENTMETHODCODE'] == "FOC") {
        $foc = $rowdb21['PAYMENTMETHODCODE'];
    } else { $foc = "";}
    $sqlDB22 = "SELECT SALESORDERLINE.ORDERLINE, SALESORDERLINE.EXTERNALREFERENCE AS NOPO, SALESORDER.CODE, SALESORDER.EXTERNALREFERENCE, SALESORDER.ORDPRNCUSTOMERSUPPLIERCODE,
		ITXVIEWAKJ.LEGALNAME1, ITXVIEWAKJ.ORDERPARTNERBRANDCODE, ITXVIEWAKJ.LONGDESCRIPTION
		FROM DB2ADMIN.SALESORDER SALESORDER LEFT OUTER JOIN DB2ADMIN.ITXVIEWAKJ
       	ITXVIEWAKJ ON SALESORDER.CODE=ITXVIEWAKJ.CODE
       	LEFT OUTER JOIN DB2ADMIN.SALESORDERLINE ON SALESORDER.CODE=SALESORDERLINE.SALESORDERCODE
		WHERE SALESORDER.CODE='$project' AND SALESORDERLINE.ORDERLINE='" . $rowdb21['DLVSALESORDERLINEORDERLINE'] . "'";
    $stmt2 = db2_exec($conn1, $sqlDB22, array('cursor' => DB2_SCROLLABLE));
    $rowdb22 = db2_fetch_assoc($stmt2);
    if ($rowdb22['LEGALNAME1'] == "") {$langganan = "";} else { $langganan = $rowdb22['LEGALNAME1'];}
    if ($rowdb22['ORDERPARTNERBRANDCODE'] == "") {$buyer = "";} else { $buyer = $rowdb22['LONGDESCRIPTION'];}
    if ($rowdb22['EXTERNALREFERENCE'] != "") {$PONO = $rowdb22['EXTERNALREFERENCE'];} else { $PONO = $rowdb22['NOPO'];}

    $sqlDB23 = " SELECT COUNT(BASEPRIMARYQUANTITY) AS ROL,SUM(BASEPRIMARYQUANTITY) AS KG,
	LISTAGG(DISTINCT  TRIM(LOTCODE),', ') AS LOTCODE,LISTAGG(DISTINCT  TRIM(WHSLOCATIONWAREHOUSEZONECODE),', ') AS ZN, LISTAGG(DISTINCT TRIM(WAREHOUSELOCATIONCODE),', ') AS LK,
	ITEMTYPECODE, DECOSUBCODE01, DECOSUBCODE02, DECOSUBCODE03, DECOSUBCODE04, DECOSUBCODE05, DECOSUBCODE06, DECOSUBCODE07, DECOSUBCODE08
	FROM ITXVIEW_ALLOCATION_SURATJALAN_PPC
		 WHERE ITXVIEW_ALLOCATION_SURATJALAN_PPC.CODE='$rowdb21[CODE]'
	GROUP BY ITEMTYPECODE, DECOSUBCODE01, DECOSUBCODE02, DECOSUBCODE03, DECOSUBCODE04, DECOSUBCODE05, DECOSUBCODE06, DECOSUBCODE07, DECOSUBCODE08";
    $stmt3 = db2_exec($conn1, $sqlDB23, array('cursor' => DB2_SCROLLABLE));
    $rowdb23 = db2_fetch_assoc($stmt3);
    $itemCode = $rowdb23['ITEMTYPECODE'] . " " . $rowdb23['DECOSUBCODE01'] . "" . $rowdb23['DECOSUBCODE02'] . "" . $rowdb23['DECOSUBCODE03'] . "" . $rowdb23['DECOSUBCODE04'] . "" . $rowdb23['DECOSUBCODE05'] . "" . $rowdb23['DECOSUBCODE06'] . "" . $rowdb23['DECOSUBCODE07'] . "" . $rowdb23['DECOSUBCODE08'];
    $sqlDB24 = " SELECT PRODUCT.SHORTDESCRIPTION FROM PRODUCT WHERE
		ITEMTYPECODE='$rowdb23[ITEMTYPECODE]' AND
		SUBCODE01='$rowdb23[DECOSUBCODE01]' AND
		SUBCODE02='$rowdb23[DECOSUBCODE02]' AND
		SUBCODE03='$rowdb23[DECOSUBCODE03]' AND
		SUBCODE04='$rowdb23[DECOSUBCODE04]' AND
		SUBCODE05='$rowdb23[DECOSUBCODE05]'
		";
    $stmt4 = db2_exec($conn1, $sqlDB24, array('cursor' => DB2_SCROLLABLE));
    $rowdb24 = db2_fetch_assoc($stmt4);

    /*$sqlDB25 = " SELECT ITXVIEWRESEPCOLOR.LONGDESCRIPTION FROM ITXVIEWRESEPCOLOR WHERE
    ITXVIEWRESEPCOLOR.NO_WARNA='".trim($rowdb23['DECOSUBCODE05'])."' AND
    ITXVIEWRESEPCOLOR.ARTIKEL='".trim($rowdb23['DECOSUBCODE03'])."' ";*/
    $sqlDB25 = "SELECT i.WARNA FROM ITXVIEWCOLOR i
LEFT OUTER JOIN PRODUCT p ON
i.ITEMTYPECODE =p.ITEMTYPECODE AND
i.SUBCODE01 = p.SUBCODE01 AND
i.SUBCODE02 = p.SUBCODE02 AND
i.SUBCODE03 = p.SUBCODE03 AND
i.SUBCODE04 = p.SUBCODE04 AND
i.SUBCODE05 = p.SUBCODE05 AND
i.SUBCODE06 = p.SUBCODE06 AND
i.SUBCODE07 = p.SUBCODE07 AND
i.SUBCODE08 = p.SUBCODE08
WHERE
		i.SUBCODE01='" . trim($rowdb23['DECOSUBCODE01']) . "' AND
		i.SUBCODE02='" . trim($rowdb23['DECOSUBCODE02']) . "' AND
		i.SUBCODE03='" . trim($rowdb23['DECOSUBCODE03']) . "' AND
		i.SUBCODE04='" . trim($rowdb23['DECOSUBCODE04']) . "' AND
		i.SUBCODE05='" . trim($rowdb23['DECOSUBCODE05']) . "' AND
		i.SUBCODE06='" . trim($rowdb23['DECOSUBCODE06']) . "' AND
		i.SUBCODE07='" . trim($rowdb23['DECOSUBCODE07']) . "' AND
		i.SUBCODE08 ='" . trim($rowdb23['DECOSUBCODE08']) . "'";
    $stmt5 = db2_exec($conn1, $sqlDB25, array('cursor' => DB2_SCROLLABLE));
    $rowdb25 = db2_fetch_assoc($stmt5);

    $sqlDB26 = " SELECT DESIGN.SUBCODE01,
	   DESIGNCOMPONENT.VARIANTCODE,
       DESIGNCOMPONENT.SHORTDESCRIPTION
	   FROM DB2ADMIN.DESIGN DESIGN LEFT OUTER JOIN DB2ADMIN.DESIGNCOMPONENT
       DESIGNCOMPONENT ON DESIGN.NUMBERID=DESIGNCOMPONENT.DESIGNNUMBERID AND
       DESIGN.SUBCODE01=DESIGNCOMPONENT.DESIGNSUBCODE01
	   WHERE DESIGN.SUBCODE01='$rowdb23[DECOSUBCODE07]' AND
	   DESIGNCOMPONENT.VARIANTCODE='$rowdb23[DECOSUBCODE08]' ";
    $stmt6 = db2_exec($conn1, $sqlDB26, array('cursor' => DB2_SCROLLABLE));
    $rowdb26 = db2_fetch_assoc($stmt6);
    if (trim($rowdb23['ITEMTYPECODE']) == "FKF") {
        $pos = strpos($rowdb24['SHORTDESCRIPTION'], "-");
        $warna = substr($rowdb24['SHORTDESCRIPTION'], 0, $pos);
    } else if (trim($rowdb23['DECOSUBCODE07']) == "-" and trim($rowdb23['DECOSUBCODE08']) == "-") {
        $warna = $rowdb25['WARNA'];
    } else if (trim($rowdb23['DECOSUBCODE07']) != "-" and trim($rowdb23['DECOSUBCODE08']) != "-") {
        $warna = $rowdb26['SHORTDESCRIPTION'];
    }
    ?>
	  <tr>
	    <td style="text-align: center"><?php echo $no; ?></td>
      <td style="text-align: center"><?php echo substr($rowdb21['GOODSISSUEDATE'], 0, 10); ?></td>
      <td style="text-align: left"><?php echo $buyer; ?></td>
      <td style="text-align: left"><?php echo $langganan; ?></td>
      <td style="text-align: left"><?php echo $PONO; ?></td>
      <td style="text-align: center"><?php echo $project; ?></td>
      <td style="text-align: left"><?php echo $rowdb21['ITEMDESCRIPTION']; ?></td>
      <td style="text-align: left"><?php echo $rowdb23['DECOSUBCODE05']; ?></td>
      <td style="text-align: left"><?php echo $warna; ?></td>
      <td style="text-align: right"><span style="text-align: center"><?php echo $rowdb23['LOTCODE']; ?></span></td>
      <td style="text-align: center"><?php echo $rowdb23['ROL']; ?></td>
      <td style="text-align: right"><?php echo round($rowdb23['KG'], 2); ?></td>
      <td style="text-align: center"><?php echo $rowdb23['LK']; ?></td>
      <td style="text-align: center"><?php echo $rowdb21['NOSJ']; ?></td>
      <td style="text-align: center"><?php echo $foc; ?></td>
      </tr>
<?php	$no++;}?>
				  </tbody>

                </table>
              </div>
              <!-- /.card-body -->
        </div>

  <!-- End of Card laporan harian pengiriman -->

  <!-- Card Bongkaran -->
  <div class="card card-danger">
    <div class="card-header">
      <h3 class="card-title">Data Laporan Harian Bongkaran Kain</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example12" class="table table-sm table-bordered table-striped table-display" style="font-size:13px;">
        <thead>
          <tr>
            <th style="text-align: center">No.</th>
            <th style="text-align: center">Tanggal</th>
            <th style="text-align: center">Prod. Order</th>
            <th style="text-align: center">Lot</th>
            <th style="text-align: center">Kode</th>
            <th style="text-align: center">Elements</th>
            <th style="text-align: center">Qty</th>
            <th style="text-align: center">Kg</th>
            <th style="text-align: center">Project</th>
            <th style="text-align: center">UserID</th>
          </tr>
        </thead>
        <tbody>
          <?php
$no_bongkaran = 1;
$c = 0;
$sqlDB21_bongkaran = "SELECT
                        s.CREATIONUSER,
                        s.TRANSACTIONDATE,
                        s.ORDERCODE,
                        s.DECOSUBCODE02,
                        s.DECOSUBCODE03,
                        s.DECOSUBCODE04,
                        s.DECOSUBCODE05,
                        s.DECOSUBCODE06,
                        s.DECOSUBCODE07,
                        s.DECOSUBCODE08,
                        s.LOTCODE,
                        SUM(s.BASEPRIMARYQUANTITY) AS KG,
                        s.ITEMELEMENTCODE,
                        COUNT(s.ITEMELEMENTCODE) AS JML,
                        s.PROJECTCODE
                      FROM STOCKTRANSACTION s
                      WHERE s.ITEMTYPECODE='KFF' AND s.LOGICALWAREHOUSECODE ='M031'
                        AND s.TEMPLATECODE = '120' AND s.LOTCODE='$LotCode'
                      GROUP BY
                        s.TRANSACTIONDATE,
                        s.ORDERCODE,
                        s.DECOSUBCODE02,
                        s.DECOSUBCODE03,
                        s.DECOSUBCODE04,
                        s.DECOSUBCODE05,
                        s.DECOSUBCODE06,
                        s.DECOSUBCODE07,
                        s.DECOSUBCODE08,
                        s.LOTCODE,
                        s.CREATIONUSER,
                        s.PROJECTCODE,
                        s.ITEMELEMENTCODE ";
$stmt1_bongkaran = db2_exec($conn1, $sqlDB21_bongkaran, array('cursor' => DB2_SCROLLABLE));
//}
while ($rowdb21_bongkaran = db2_fetch_assoc($stmt1_bongkaran)) {
    $kdbenang_bongkaran = trim($rowdb21_bongkaran['DECOSUBCODE01']) . " " .
    trim($rowdb21_bongkaran['DECOSUBCODE02']) . " " .
    trim($rowdb21_bongkaran['DECOSUBCODE03']) . " " .
    trim($rowdb21_bongkaran['DECOSUBCODE04']) . " " .
    trim($rowdb21_bongkaran['DECOSUBCODE05']) . " " .
    trim($rowdb21_bongkaran['DECOSUBCODE06']) . " " .
    trim($rowdb21_bongkaran['DECOSUBCODE07']) . " " .
    trim($rowdb21_bongkaran['DECOSUBCODE08']);
    ?>
            <tr>
              <td style="text-align: center"><?php echo $no_bongkaran; ?></td>
              <td style="text-align: center"><?php echo substr($rowdb21_bongkaran['TRANSACTIONDATE'], 0, 10); ?></td>
              <td style="text-align: center"><?php echo $rowdb21_bongkaran['ORDERCODE']; ?></td>
              <td style="text-align: center"><?php echo $rowdb21_bongkaran['LOTCODE']; ?></td>
              <td style="text-align: left"><?php echo $kdbenang_bongkaran; ?></td>
              <td style="text-align: center"><?php echo $rowdb21_bongkaran['ITEMELEMENTCODE']; ?></td>
              <td style="text-align: center"><?php echo $rowdb21_bongkaran['JML']; ?></td>
              <td style="text-align: right"><?php echo $rowdb21_bongkaran['KG']; ?></td>
              <td style="text-align: center"><?php echo $rowdb21_bongkaran['PROJECTCODE']; ?></td>
              <td style="text-align: center"><?php echo $rowdb21_bongkaran['CREATIONUSER']; ?></td>
            </tr>
          <?php $no_bongkaran++;
    $totJml_bongkaran += $rowdb21_bongkaran['JML'];
    $totKg_bongkaran += $rowdb21_bongkaran['KG'];
}?>
        </tbody>
        <tfoot>
          <tr>
            <td style="text-align: center">&nbsp;</td>
            <td style="text-align: center">&nbsp;</td>
            <td style="text-align: center">&nbsp;</td>
            <td style="text-align: center">&nbsp;</td>
            <td style="text-align: left">&nbsp;</td>
            <td style="text-align: right"><strong>Total</strong></td>
            <td style="text-align: center"><strong><?php echo $totJml_bongkaran; ?></strong></td>
            <td style="text-align: right"><strong><?php echo number_format(round($totKg_bongkaran, 5), 5); ?></strong></td>
            <td style="text-align: left">&nbsp;</td>
            <td style="text-align: center">&nbsp;</td>
          </tr>
        </tfoot>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- End of Card Bongkaran -->

  <!-- Card Pass Qty -->
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Data Laporan Harian Pass Qty</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example13" class="table table-sm table-bordered table-striped table-display" style="font-size:13px;">
        <thead>
          <tr>
            <th style="text-align: center">No.</th>
            <th style="text-align: center">Tanggal</th>
            <th style="text-align: center">Lot</th>
            <th style="text-align: center">Kode</th>
            <th style="text-align: center">SN</th>
            <th style="text-align: center">Qty</th>
            <th style="text-align: center">KG</th>
            <th style="text-align: center">Yard</th>
            <th style="text-align: center">Ket</th>
            <th style="text-align: center">Userid</th>
          </tr>
        </thead>
        <tbody>
          <?php
$no_pass_qty = 1;
$c = 0;

$sqlDB21_pass_qty = " SELECT
                        s.CREATIONUSER,
                        s.TRANSACTIONDATE,
                        s.DECOSUBCODE02,
                        s.DECOSUBCODE03,
                        s.DECOSUBCODE04,
                        s.DECOSUBCODE05,
                        s.DECOSUBCODE06,
                        s.DECOSUBCODE07,
                        s.DECOSUBCODE08,
                        s.LOTCODE,
                        SUM(s.BASEPRIMARYQUANTITY) AS KG,
                        SUM(s.BASESECONDARYQUANTITY) AS YARD,
                        s.ITEMELEMENTCODE,
                        COUNT(s.ITEMELEMENTCODE) AS JML,
                        a.VALUESTRING AS PTG,
                        a1.VALUESTRING as NOTE,
                        s.PROJECTCODE
                      FROM STOCKTRANSACTION s
                      LEFT OUTER JOIN ADSTORAGE a ON a.UNIQUEID = s.ABSUNIQUEID AND a.NAMENAME = 'StatusPotongS'
                      LEFT OUTER JOIN ADSTORAGE a1 ON a1.UNIQUEID = s.ABSUNIQUEID AND a1.NAMENAME = 'NotePotongS'
                      WHERE s.ITEMTYPECODE='KFF' AND s.LOGICALWAREHOUSECODE ='M031'
                        AND a.VALUESTRING ='2' AND s.TEMPLATECODE = '098'
                        AND s.LOTCODE = '$LotCode'
                      GROUP BY
                        s.TRANSACTIONDATE,
                        s.DECOSUBCODE02,
                        s.DECOSUBCODE03,
                        s.DECOSUBCODE04,
                        s.DECOSUBCODE05,
                        s.DECOSUBCODE06,
                        s.DECOSUBCODE07,
                        s.DECOSUBCODE08,
                        s.LOTCODE,
                        s.CREATIONUSER,
                        a.VALUESTRING,
                        s.PROJECTCODE,
                        a1.VALUESTRING,
                        s.ITEMELEMENTCODE ";

$stmt1_pass_qty = db2_exec($conn1, $sqlDB21_pass_qty, array('cursor' => DB2_SCROLLABLE));
//}
while ($rowdb21_pass_qty = db2_fetch_assoc($stmt1_pass_qty)) {
    $kdbenang_pass_qty = trim($rowdb21_pass_qty['DECOSUBCODE01']) . " " .
    trim($rowdb21_pass_qty['DECOSUBCODE02']) . " " .
    trim($rowdb21_pass_qty['DECOSUBCODE03']) . " " .
    trim($rowdb21_pass_qty['DECOSUBCODE04']) . " " .
    trim($rowdb21_pass_qty['DECOSUBCODE05']) . " " .
    trim($rowdb21_pass_qty['DECOSUBCODE06']) . " " .
    trim($rowdb21_pass_qty['DECOSUBCODE07']) . " " .
    trim($rowdb21_pass_qty['DECOSUBCODE08']);
    ?>
            <tr>
              <td style="text-align: center"><?php echo $no_pass_qty; ?></td>
              <td style="text-align: center"><?php echo substr($rowdb21_pass_qty['TRANSACTIONDATE'], 0, 10); ?></td>
              <td style="text-align: center"><?php echo $rowdb21_pass_qty['LOTCODE']; ?></td>
              <td style="text-align: left"><?php echo $kdbenang_pass_qty; ?></td>
              <td style="text-align: center"><?php echo $rowdb21_pass_qty['ITEMELEMENTCODE']; ?></td>
              <td style="text-align: center"><?php echo $rowdb21_pass_qty['JML']; ?></td>
              <td style="text-align: right"><?php echo $rowdb21_pass_qty['KG']; ?></td>
              <td style="text-align: right"><?php echo $rowdb21_pass_qty['YARD']; ?></td>
              <td style="text-align: left"><?php echo $rowdb21_pass_qty['NOTE']; ?></td>
              <td style="text-align: center"><?php echo $rowdb21_pass_qty['CREATIONUSER']; ?></td>
            </tr>

          <?php $no_pass_qty++;
    $totJml_pass_qty += $rowdb21_pass_qty['JML'];
    $totKg_pass_qty += $rowdb21_pass_qty['KG'];
    $totYard_pass_qty += $rowdb21_pass_qty['YARD'];
}?>
        </tbody>
        <tfoot>
          <tr>
            <td style="text-align: center">&nbsp;</td>
            <td style="text-align: center">&nbsp;</td>
            <td style="text-align: center">&nbsp;</td>
            <td style="text-align: center">&nbsp;</td>
            <td style="text-align: center"><strong>Total</strong></td>
            <td style="text-align: center"><strong><?php echo $totJml_pass_qty; ?></strong></td>
            <td style="text-align: right"><strong><?php echo number_format(round($totKg_pass_qty, 5), 5); ?></strong></td>
            <td style="text-align: left"><strong><?php echo number_format(round($totYard_pass_qty, 5), 5); ?></strong></td>
            <td style="text-align: left">&nbsp;</td>
            <td style="text-align: center">&nbsp;</td>
          </tr>
        </tfoot>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- End of Card Pass Qty -->

  <!-- Card Potong Sample -->
  <div class="card card-success">
    <div class="card-header">
      <h3 class="card-title">Data Laporan Harian Potong Sample</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example14" class="table table-sm table-bordered table-striped table-display" style="font-size:13px;">
        <thead>
          <tr>
            <th style="text-align: center">No.</th>
            <th style="text-align: center">Tanggal</th>
            <th style="text-align: center">Lot</th>
            <th style="text-align: center">Kode</th>
            <th style="text-align: center">SN</th>
            <th style="text-align: center">Qty</th>
            <th style="text-align: center">KG</th>
            <th style="text-align: center">Yard</th>
            <th style="text-align: center">Ket</th>
            <th style="text-align: center">Userid</th>
          </tr>
        </thead>
        <tbody>
          <?php
$no_sample = 1;
$c = 0;

$sqlDB21_sample = " SELECT
                      s.CREATIONUSER,
                      s.TRANSACTIONDATE,
                      s.DECOSUBCODE02,
                      s.DECOSUBCODE03,
                      s.DECOSUBCODE04,
                      s.DECOSUBCODE05,
                      s.DECOSUBCODE06,
                      s.DECOSUBCODE07,
                      s.DECOSUBCODE08,
                      s.LOTCODE,
                      SUM(s.BASEPRIMARYQUANTITY) AS KG,
                      SUM(s.BASESECONDARYQUANTITY) AS YARD,
                      s.ITEMELEMENTCODE,
                      COUNT(s.ITEMELEMENTCODE) AS JML,
                      a.VALUESTRING AS PTG,
                      a1.VALUESTRING as NOTE,
                      s.PROJECTCODE
                    FROM STOCKTRANSACTION s
                    LEFT OUTER JOIN ADSTORAGE a ON a.UNIQUEID = s.ABSUNIQUEID AND a.NAMENAME = 'StatusPotongS'
                    LEFT OUTER JOIN ADSTORAGE a1 ON a1.UNIQUEID = s.ABSUNIQUEID AND a1.NAMENAME = 'NotePotongS'
                    WHERE s.ITEMTYPECODE='KFF' AND s.LOGICALWAREHOUSECODE ='M031' AND a.VALUESTRING ='1'
                      AND (s.TEMPLATECODE = '098' OR s.TEMPLATECODE = '342') AND s.LOTCODE = '$LotCode'
                    GROUP BY
                      s.TRANSACTIONDATE,
                      s.DECOSUBCODE02,
                      s.DECOSUBCODE03,
                      s.DECOSUBCODE04,
                      s.DECOSUBCODE05,
                      s.DECOSUBCODE06,
                      s.DECOSUBCODE07,
                      s.DECOSUBCODE08,
                      s.LOTCODE,
                      s.CREATIONUSER,
                      a.VALUESTRING,
                      s.PROJECTCODE,
                      a1.VALUESTRING,
                      s.ITEMELEMENTCODE ";

$stmt1_sample = db2_exec($conn1, $sqlDB21_sample, array('cursor' => DB2_SCROLLABLE));
//}
while ($rowdb21_sample = db2_fetch_assoc($stmt1_sample)) {
    $kdbenang_sample = trim($rowdb21_sample['DECOSUBCODE01']) . " " .
    trim($rowdb21_sample['DECOSUBCODE02']) . " " .
    trim($rowdb21_sample['DECOSUBCODE03']) . " " .
    trim($rowdb21_sample['DECOSUBCODE04']) . " " .
    trim($rowdb21_sample['DECOSUBCODE05']) . " " .
    trim($rowdb21_sample['DECOSUBCODE06']) . " " .
    trim($rowdb21_sample['DECOSUBCODE07']) . " " .
    trim($rowdb21_sample['DECOSUBCODE08']);
    ?>
            <tr>
              <td style="text-align: center"><?php echo $no_sample; ?></td>
              <td style="text-align: center"><?php echo substr($rowdb21_sample['TRANSACTIONDATE'], 0, 10); ?></td>
              <td style="text-align: center"><?php echo $rowdb21_sample['LOTCODE']; ?></td>
              <td style="text-align: left"><?php echo $kdbenang; ?></td>
              <td style="text-align: center"><?php echo $rowdb21_sample['ITEMELEMENTCODE']; ?></td>
              <td style="text-align: center"><?php echo $rowdb21_sample['JML']; ?></td>
              <td style="text-align: right"><?php echo $rowdb21_sample['KG']; ?></td>
              <td style="text-align: right"><?php echo $rowdb21_sample['YARD']; ?></td>
              <td style="text-align: left"><?php echo $rowdb21_sample['NOTE']; ?></td>
              <td style="text-align: center"><?php echo $rowdb21_sample['CREATIONUSER']; ?></td>
            </tr>

          <?php $no_sample++;
    $totJml_sample += $rowdb21_sample['JML'];
    $totKg_sample += $rowdb21_sample['KG'];
    $totYard_sample += $rowdb21_sample['YARD'];
}?>
        </tbody>
        <tfoot>
          <tr>
            <td style="text-align: center">&nbsp;</td>
            <td style="text-align: center">&nbsp;</td>
            <td style="text-align: center">&nbsp;</td>
            <td style="text-align: center">&nbsp;</td>
            <td style="text-align: center"><strong>Total</strong></td>
            <td style="text-align: center"><strong><?php echo $totJml_sample; ?></strong></td>
            <td style="text-align: right"><strong><?php echo number_format(round($totKg_sample, 5), 5); ?></strong></td>
            <td style="text-align: right"><strong><?php echo number_format(round($totYard_sample, 5), 5); ?></strong></td>
            <td style="text-align: left">&nbsp;</td>
            <td style="text-align: center">&nbsp;</td>
          </tr>
        </tfoot>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- End of Card Potong Sample -->


</div><!-- /.container-fluid -->
<!-- /.content -->
<script>
  $(function() {
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