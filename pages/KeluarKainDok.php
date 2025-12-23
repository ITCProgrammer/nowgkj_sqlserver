<?php
$Awal = isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : '';
$Akhir = isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : '';
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
          <label for="tgl_awal" class="col-md-1">Tgl Awal</label>
          <div class="col-md-2">
            <div class="input-group date" id="datepicker1" data-target-input="nearest">
              <div class="input-group-prepend" data-target="#datepicker1" data-toggle="datetimepicker">
                <span class="input-group-text btn-info">
                  <i class="far fa-calendar-alt"></i>
                </span>
              </div>
              <input name="tgl_awal" value="<?php echo $Awal; ?>" type="text" class="form-control form-control-sm" id="" autocomplete="off" required>
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
              <input name="tgl_akhir" value="<?php echo $Akhir; ?>" type="text" class="form-control form-control-sm" id="" autocomplete="off" required>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <button class="btn btn-info" type="submit" value="Cari" name="cari">Cari Data</button>
      </div>
      <!-- /.card-body -->

    </div>
  </form>

  <!-- Card laporan pengiriman -->
  <div class="card card-pink">
    <div class="card-header">
      <h3 class="card-title">Data Laporan Harian Keluar Kain Jadi</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example11" class="table table-sm table-bordered table-striped table-display" style="font-size:13px;">
        <thead>
          <tr>
            <th style="text-align: center">TglKeluar</th>
            <th style="text-align: center">Tipe</th>
            <th style="text-align: center">Warna</th>
            <th style="text-align: center">Roll</th>
            <th style="text-align: center">Qty(KG)</th>
            <th style="text-align: center">Buyer</th>
            <th style="text-align: center">Customer</th>
            <th style="text-align: center">No PO</th>
            <th style="text-align: center">No Order</th>
            <th style="text-align: center">Jenis Kain</th>
            <th style="text-align: center">Lot</th>
            <th style="text-align: center">Lokasi</th>
            <th style="text-align: center">FOC</th>
          </tr>
        </thead>

        <tbody>
        <?php
$no = 1;
$c = 0;
$sqlDB21 = " SELECT TRANSACTIONDATE, ORDERCODE, ITEMTYPECODE,DECOSUBCODE01,
DECOSUBCODE02,DECOSUBCODE03,DECOSUBCODE04,DECOSUBCODE05,
DECOSUBCODE06,DECOSUBCODE07,DECOSUBCODE08, COUNT(BASEPRIMARYQUANTITY) AS ROL,
SUM(BASEPRIMARYQUANTITY) AS KGS,LOTCODE,PROJECTCODE,
LISTAGG(DISTINCT  TRIM(WHSLOCATIONWAREHOUSEZONECODE),',') AS ZN,
LISTAGG(DISTINCT TRIM(WAREHOUSELOCATIONCODE),',') AS LK,QUALITYREASONCODE FROM STOCKTRANSACTION
WHERE TRANSACTIONDATE BETWEEN '$Awal' AND '$Akhir' AND
TEMPLATECODE ='302' AND
(ITEMTYPECODE='FKF' OR ITEMTYPECODE='KFF') AND
LOGICALWAREHOUSECODE ='M031'AND 
WHSLOCATIONWAREHOUSEZONECODE = 'DOK'AND WAREHOUSELOCATIONCODE = 'DOK'
GROUP BY LOTCODE,TRANSACTIONDATE,ORDERCODE,ITEMTYPECODE,DECOSUBCODE01,
DECOSUBCODE02,DECOSUBCODE03,DECOSUBCODE04,DECOSUBCODE05,
DECOSUBCODE06,DECOSUBCODE07,DECOSUBCODE08,PROJECTCODE,
WHSLOCATIONWAREHOUSEZONECODE,WAREHOUSELOCATIONCODE,QUALITYREASONCODE ";
$stmt1 = db2_exec($conn1, $sqlDB21, array('cursor' => DB2_SCROLLABLE));
//}
while ($rowdb21 = db2_fetch_assoc($stmt1)) {

    $sqlDB22 = " SELECT SALESORDER.CODE, SALESORDER.EXTERNALREFERENCE, SALESORDER.ORDPRNCUSTOMERSUPPLIERCODE,
		ITXVIEWAKJ.LEGALNAME1, ITXVIEWAKJ.ORDERPARTNERBRANDCODE, ITXVIEWAKJ.LONGDESCRIPTION
		FROM DB2ADMIN.SALESORDER SALESORDER LEFT OUTER JOIN DB2ADMIN.ITXVIEWAKJ
       	ITXVIEWAKJ ON SALESORDER.CODE=ITXVIEWAKJ.CODE
		WHERE SALESORDER.CODE='$rowdb21[PROJECTCODE]' ";

    $stmt2 = db2_exec($conn1, $sqlDB22, array('cursor' => DB2_SCROLLABLE));
    $rowdb22 = db2_fetch_assoc($stmt2);
    if ($rowdb22['LEGALNAME1'] == "") {
        $langganan = "";
    } else {
        $langganan = $rowdb22['LEGALNAME1'];
    }
    if ($rowdb22['ORDERPARTNERBRANDCODE'] == "") {
        $buyer = "";
    } else {
        $buyer = $rowdb22['LONGDESCRIPTION'];
    }

    $sqlDB23 = " SELECT s.EXTERNALREFERENCE AS PO_HEADER ,s2.EXTERNALREFERENCE AS PO_LINE FROM ITXVIEWKK i
LEFT OUTER JOIN SALESORDER s ON i.PROJECTCODE =s.CODE
LEFT OUTER JOIN SALESORDERLINE s2 ON i.PROJECTCODE =s2.SALESORDERCODE AND i.ORDERLINE =s2.ORDERLINE
WHERE i.DEAMAND ='$rowdb21[LOTCODE]' ";
    $stmt3 = db2_exec($conn1, $sqlDB23, array('cursor' => DB2_SCROLLABLE));
    $rowdb23 = db2_fetch_assoc($stmt3);

    $sqlDB24 = " SELECT PRODUCT.SHORTDESCRIPTION FROM PRODUCT WHERE
		ITEMTYPECODE='$rowdb21[ITEMTYPECODE]' AND
		SUBCODE01='$rowdb21[DECOSUBCODE01]' AND
		SUBCODE02='$rowdb21[DECOSUBCODE02]' AND
		SUBCODE03='$rowdb21[DECOSUBCODE03]' AND
		SUBCODE04='$rowdb21[DECOSUBCODE04]' AND
		SUBCODE05='$rowdb21[DECOSUBCODE05]'
		";
    $stmt4 = db2_exec($conn1, $sqlDB24, array('cursor' => DB2_SCROLLABLE));
    $rowdb24 = db2_fetch_assoc($stmt4);

    $sqlDB25 = " SELECT ITXVIEWRESEPCOLOR.LONGDESCRIPTION FROM ITXVIEWRESEPCOLOR WHERE
		ITXVIEWRESEPCOLOR.NO_WARNA='$rowdb21[DECOSUBCODE05]' AND
		ITXVIEWRESEPCOLOR.ARTIKEL='$rowdb21[DECOSUBCODE03]' ";
    $stmt5 = db2_exec($conn1, $sqlDB25, array('cursor' => DB2_SCROLLABLE));
    $rowdb25 = db2_fetch_assoc($stmt5);

    $sqlDB26 = " SELECT DESIGN.SUBCODE01,
	   DESIGNCOMPONENT.VARIANTCODE,
       DESIGNCOMPONENT.SHORTDESCRIPTION
	   FROM DB2ADMIN.DESIGN DESIGN LEFT OUTER JOIN DB2ADMIN.DESIGNCOMPONENT
       DESIGNCOMPONENT ON DESIGN.NUMBERID=DESIGNCOMPONENT.DESIGNNUMBERID AND
       DESIGN.SUBCODE01=DESIGNCOMPONENT.DESIGNSUBCODE01
	   WHERE DESIGN.SUBCODE01='$rowdb21[DECOSUBCODE07]' AND
	   DESIGNCOMPONENT.VARIANTCODE='$rowdb21[DECOSUBCODE08]' ";

    $stmt6 = db2_exec($conn1, $sqlDB26, array('cursor' => DB2_SCROLLABLE));
    $rowdb26 = db2_fetch_assoc($stmt6);
    if (trim($rowdb21['ITEMTYPECODE']) == "FKF") {
        $pos = strpos($rowdb24['SHORTDESCRIPTION'], "-");
        $warna = substr($rowdb24['SHORTDESCRIPTION'], 0, $pos);
    } else if (trim($rowdb21['DECOSUBCODE07']) == "-" and trim($rowdb21['DECOSUBCODE08']) == "-") {
        $warna = $rowdb25['LONGDESCRIPTION'];
    } else if (trim($rowdb21['DECOSUBCODE07']) != "-" and trim($rowdb21['DECOSUBCODE08']) != "-") {
        $warna = $rowdb26['SHORTDESCRIPTION'];
    }
    $sqlDB27 = " SELECT PRODUCT.SHORTDESCRIPTION FROM PRODUCT WHERE
		ITEMTYPECODE='$rowdb21[ITEMTYPECODE]' AND
		SUBCODE01='$rowdb21[DECOSUBCODE01]' AND
		SUBCODE02='$rowdb21[DECOSUBCODE02]' AND
		SUBCODE03='$rowdb21[DECOSUBCODE03]' AND
		SUBCODE04='$rowdb21[DECOSUBCODE04]' AND
		SUBCODE05='$rowdb21[DECOSUBCODE05]' AND
		SUBCODE06='$rowdb21[DECOSUBCODE06]' AND
		SUBCODE07='$rowdb21[DECOSUBCODE07]' AND
		SUBCODE08='$rowdb21[DECOSUBCODE08]'
		";
    $stmt7 = db2_exec($conn1, $sqlDB27, array('cursor' => DB2_SCROLLABLE));
    $rowdb27 = db2_fetch_assoc($stmt7);
    ?>
            <tr>
              <td style="text-align: center"><?php echo substr($rowdb21['TRANSACTIONDATE'], 0, 10); ?></td>
              <td style="text-align: left"><?php if ($rowdb21['ITEMTYPECODE'] == "KFF") {
        echo "KAIN";
    } else {
        echo "KRAH";
    }?></td>
              <td style="text-align: left"><?php echo $warna; ?></td>
              <td style="text-align: center"><?php echo $rowdb21['ROL']; ?></td>
              <td style="text-align: right"><?php echo number_format(round($rowdb21['KGS'], 2), 2); ?></td>
              <td style="text-align: left"><?php echo $buyer; ?></td>
              <td style="text-align: left"><?php echo $langganan; ?></td>
              <td style="text-align: left"><?php if ($rowdb23['PO_HEADER'] != "") {
        echo $rowdb23['PO_HEADER'];
    } else {
        echo $rowdb23['PO_LINE'];
    }?></td>
              <td style="text-align: center"><?php echo $rowdb21['PROJECTCODE']; ?></td>
              <td style="text-align: left"><?php echo $rowdb27['SHORTDESCRIPTION']; ?></td>
              <td style="text-align: right"><span style="text-align: center"><?php echo $rowdb21['LOTCODE']; ?></span></td>
              <td style="text-align: center"><?php echo $rowdb21['LK']; ?></td>
              <td style="text-align: center"><?php if ($rowdb21['QUALITYREASONCODE'] == "FOC") {
        echo $rowdb21['QUALITYREASONCODE'];
    }?></td>
            </tr>
          <?php $no++;
}?>
        </tbody>

      </table>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- End of Card laporan pengiriman -->



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