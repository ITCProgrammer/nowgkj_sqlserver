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
              <input name="tgl_awal" value="<?php echo $Awal; ?>" type="text" class="form-control form-control-sm" id=""
                autocomplete="off" required>
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
              <input name="tgl_akhir" value="<?php echo $Akhir; ?>" type="text" class="form-control form-control-sm"
                id="" autocomplete="off" required>
            </div>
          </div>
        </div>
        <button class="btn btn-info" type="submit" value="Cari" name="cari">Cari Data</button>

      </div>

      <!-- /.card-body -->

    </div>
  </form>
  <div class="card-pink">
    <div class="card-header">
      <h3 class="card-title">Data Laporan Harian Pengiriman</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example1" class="table table-sm table-bordered table-striped" style="font-size:13px;">
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
          $sqlDB21 = "SELECT
                        SALESDOCUMENT.GOODSISSUEDATE,
                        ITXVIEWLAPKIRIMPPC.PROVISIONALCODE,
                        ITXVIEWLAPKIRIMPPC.DEFINITIVEDOCUMENTDATE,
                        ITXVIEWLAPKIRIMPPC.ORDERPARTNERBRANDCODE,
                        ITXVIEWLAPKIRIMPPC.PO_NUMBER,
                        ITXVIEWLAPKIRIMPPC.PROJECTCODE,
                          ITXVIEWLAPKIRIMPPC.DLVSALORDERLINESALESORDERCODE,
                        ITXVIEWLAPKIRIMPPC.DLVSALESORDERLINEORDERLINE,
                        ITXVIEWLAPKIRIMPPC.ORDPRNCUSTOMERSUPPLIERCODE,
                        ITXVIEWLAPKIRIMPPC.ITEMDESCRIPTION,
                          ITXVIEWLAPKIRIMPPC.CODE,
                          ITXVIEWLAPKIRIMPPC.PAYMENTMETHODCODE,
                        SALESDOCUMENT.PROVISIONALCODE AS NOSJ
                      FROM
                        DB2ADMIN.ITXVIEWLAPKIRIMPPC ITXVIEWLAPKIRIMPPC
                      LEFT OUTER JOIN 
                            DB2ADMIN.SALESDOCUMENT SALESDOCUMENT ON
                        ITXVIEWLAPKIRIMPPC.PROVISIONALCODE = SALESDOCUMENT.PROVISIONALCODE
                      WHERE
                        SALESDOCUMENT.GOODSISSUEDATE BETWEEN '$Awal' AND '$Akhir'
                        AND SALESDOCUMENT.PROGRESSSTATUS = '2'
                        AND NOT ITXVIEWLAPKIRIMPPC.CODE IS NULL
                        AND NOT SALESDOCUMENT.PROVISIONALCODE LIKE 'PCA%'
                      GROUP BY
                        SALESDOCUMENT.GOODSISSUEDATE,
                        ITXVIEWLAPKIRIMPPC.PROVISIONALCODE,
                        ITXVIEWLAPKIRIMPPC.DEFINITIVEDOCUMENTDATE,
                        ITXVIEWLAPKIRIMPPC.ORDERPARTNERBRANDCODE,
                        ITXVIEWLAPKIRIMPPC.PO_NUMBER,
                        ITXVIEWLAPKIRIMPPC.PROJECTCODE,
                          ITXVIEWLAPKIRIMPPC.DLVSALORDERLINESALESORDERCODE,
                        ITXVIEWLAPKIRIMPPC.DLVSALESORDERLINEORDERLINE,
                        ITXVIEWLAPKIRIMPPC.ORDPRNCUSTOMERSUPPLIERCODE,
                        ITXVIEWLAPKIRIMPPC.ITEMDESCRIPTION,
                          ITXVIEWLAPKIRIMPPC.CODE,
                          ITXVIEWLAPKIRIMPPC.PAYMENTMETHODCODE,
                        SALESDOCUMENT.PROVISIONALCODE";
          $stmt1 = db2_exec($conn1, $sqlDB21, array('cursor' => DB2_SCROLLABLE));
          //}				  
          while ($rowdb21 = db2_fetch_assoc($stmt1)) {
            if ($rowdb21['PROJECTCODE'] != "") {
              $project = $rowdb21['PROJECTCODE'];
            } else {
              $project = $rowdb21['DLVSALORDERLINESALESORDERCODE'];
            }
            if ($rowdb21['PAYMENTMETHODCODE'] == "FOC") {
              $foc = $rowdb21['PAYMENTMETHODCODE'];;
            } else {
              $foc = "";
            }
            $sqlDB22 = "SELECT
                          SALESORDERLINE.ORDERLINE,
                          SALESORDERLINE.EXTERNALREFERENCE AS NOPO,
                          SALESORDER.CODE,
                          SALESORDER.EXTERNALREFERENCE,
                          SALESORDER.ORDPRNCUSTOMERSUPPLIERCODE,
                            ITXVIEWAKJ.LEGALNAME1,
                          ITXVIEWAKJ.ORDERPARTNERBRANDCODE,
                          ITXVIEWAKJ.LONGDESCRIPTION
                        FROM
                          DB2ADMIN.SALESORDER SALESORDER
                        LEFT OUTER JOIN DB2ADMIN.ITXVIEWAKJ 
                                ITXVIEWAKJ ON
                          SALESORDER.CODE = ITXVIEWAKJ.CODE
                        LEFT OUTER JOIN DB2ADMIN.SALESORDERLINE ON
                          SALESORDER.CODE = SALESORDERLINE.SALESORDERCODE
                        WHERE
                          SALESORDER.CODE = '$project'
                          AND SALESORDERLINE.ORDERLINE = '" . $rowdb21[' DLVSALESORDERLINEORDERLINE'] . "'";
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
            if ($rowdb22['EXTERNALREFERENCE'] != "") {
              $PONO = $rowdb22['EXTERNALREFERENCE'];
            } else {
              $PONO = $rowdb22['NOPO'];
            }

            $sqlDB23 = "SELECT
                          COUNT(BASEPRIMARYQUANTITY) AS ROL,
                          SUM(BASEPRIMARYQUANTITY) AS KG,
                          LISTAGG(DISTINCT TRIM(LOTCODE), ', ') AS LOTCODE,
                          LISTAGG(DISTINCT TRIM(WHSLOCATIONWAREHOUSEZONECODE),', ') AS ZN,
                          LISTAGG(DISTINCT TRIM(WAREHOUSELOCATIONCODE), ', ') AS LK,
                          ITEMTYPECODE,
                          DECOSUBCODE01,
                          DECOSUBCODE02,
                          DECOSUBCODE03,
                          DECOSUBCODE04,
                          DECOSUBCODE05,
                          DECOSUBCODE06,
                          DECOSUBCODE07,
                          DECOSUBCODE08
                        FROM
                          ITXVIEW_ALLOCATION_SURATJALAN_PPC
                        WHERE
                          ITXVIEW_ALLOCATION_SURATJALAN_PPC.CODE = '$rowdb21[CODE]'
                        GROUP BY
                          ITEMTYPECODE,
                          DECOSUBCODE01,
                          DECOSUBCODE02,
                          DECOSUBCODE03,
                          DECOSUBCODE04,
                          DECOSUBCODE05,
                          DECOSUBCODE06,
                          DECOSUBCODE07,
                          DECOSUBCODE08";
            $stmt3 = db2_exec($conn1, $sqlDB23, array('cursor' => DB2_SCROLLABLE));
            $rowdb23 = db2_fetch_assoc($stmt3);
            $itemCode = $rowdb23['ITEMTYPECODE'] . " " . $rowdb23['DECOSUBCODE01'] . "" . $rowdb23['DECOSUBCODE02'] . "" . $rowdb23['DECOSUBCODE03'] . "" . $rowdb23['DECOSUBCODE04'] . "" . $rowdb23['DECOSUBCODE05'] . "" . $rowdb23['DECOSUBCODE06'] . "" . $rowdb23['DECOSUBCODE07'] . "" . $rowdb23['DECOSUBCODE08'];
            $sqlDB24 = "SELECT
                          PRODUCT.SHORTDESCRIPTION
                        FROM
                          PRODUCT
                        WHERE
                          ITEMTYPECODE='$rowdb23[ITEMTYPECODE]' AND
                          SUBCODE01='$rowdb23[DECOSUBCODE01]' AND
                          SUBCODE02='$rowdb23[DECOSUBCODE02]' AND
                          SUBCODE03='$rowdb23[DECOSUBCODE03]' AND
                          SUBCODE04='$rowdb23[DECOSUBCODE04]' AND
                          SUBCODE05='$rowdb23[DECOSUBCODE05]'";
            $stmt4 = db2_exec($conn1, $sqlDB24, array('cursor' => DB2_SCROLLABLE));
            $rowdb24 = db2_fetch_assoc($stmt4);

            /*$sqlDB25 = " SELECT ITXVIEWRESEPCOLOR.LONGDESCRIPTION FROM ITXVIEWRESEPCOLOR WHERE
               ITXVIEWRESEPCOLOR.NO_WARNA='".trim($rowdb23['DECOSUBCODE05'])."' AND
               ITXVIEWRESEPCOLOR.ARTIKEL='".trim($rowdb23['DECOSUBCODE03'])."' ";*/
            $sqlDB25 = "SELECT
                          i.WARNA
                        FROM
                          ITXVIEWCOLOR i
                        LEFT OUTER JOIN PRODUCT p ON
                          i.ITEMTYPECODE = p.ITEMTYPECODE
                          AND i.SUBCODE01 = p.SUBCODE01
                          AND i.SUBCODE02 = p.SUBCODE02
                          AND i.SUBCODE03 = p.SUBCODE03
                          AND i.SUBCODE04 = p.SUBCODE04
                          AND i.SUBCODE05 = p.SUBCODE05
                          AND i.SUBCODE06 = p.SUBCODE06
                          AND i.SUBCODE07 = p.SUBCODE07
                          AND i.SUBCODE08 = p.SUBCODE08
                        WHERE 
                            i.SUBCODE01 = '" . trim($rowdb23[' DECOSUBCODE01']) . "'
                          AND i.SUBCODE02 = '" . trim($rowdb23[' DECOSUBCODE02']) . "'
                          AND i.SUBCODE03 = '" . trim($rowdb23[' DECOSUBCODE03']) . "'
                          AND i.SUBCODE04 = '" . trim($rowdb23[' DECOSUBCODE04']) . "'
                          AND	i.SUBCODE05 = '" . trim($rowdb23[' DECOSUBCODE05']) . "'
                          AND	i.SUBCODE06 = '" . trim($rowdb23[' DECOSUBCODE06']) . "'
                          AND	i.SUBCODE07 = '" . trim($rowdb23[' DECOSUBCODE07']) . "'
                          AND	i.SUBCODE08 = '" . trim($rowdb23[' DECOSUBCODE08']) . "'";
            $stmt5 = db2_exec($conn1, $sqlDB25, array('cursor' => DB2_SCROLLABLE));
            $rowdb25 = db2_fetch_assoc($stmt5);

            $sqlDB26 = "SELECT
                          DESIGN.SUBCODE01,
                          DESIGNCOMPONENT.VARIANTCODE,
                          DESIGNCOMPONENT.SHORTDESCRIPTION
                        FROM
                          DB2ADMIN.DESIGN DESIGN
                        LEFT OUTER JOIN DB2ADMIN.DESIGNCOMPONENT DESIGNCOMPONENT ON DESIGN.NUMBERID = DESIGNCOMPONENT.DESIGNNUMBERID
                          AND DESIGN.SUBCODE01 = DESIGNCOMPONENT.DESIGNSUBCODE01
                        WHERE
                          DESIGN.SUBCODE01 = '$rowdb23[DECOSUBCODE07]'
                          AND DESIGNCOMPONENT.VARIANTCODE = '$rowdb23[DECOSUBCODE08]'";
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

            $sqlDB27 = "SELECT
                          LISTAGG(DISTINCT TRIM(QUALITYREASON), ', ') AS QUALITYREASON
                        FROM
                          ITXVIEW_SUBDETAIL_EXIM2
                        WHERE
                          CODE = '$rowdb21[CODE]'
                          AND QUALITYREASON = 'FOC'";
            $stmt7 = db2_exec($conn1, $sqlDB27, array('cursor' => DB2_SCROLLABLE));
            $rowdb27 = db2_fetch_assoc($stmt7);

          ?>
            <tr>
              <td style="text-align: center">
                <?php echo $no; ?>
              </td>
              <td style="text-align: center">
                <?php echo substr($rowdb21['GOODSISSUEDATE'], 0, 10); ?>
              </td>
              <td style="text-align: left">
                <?php echo $buyer; ?>
              </td>
              <td style="text-align: left">
                <?php echo $langganan; ?>
              </td>
              <td style="text-align: left">
                <?php echo $PONO; ?>
              </td>
              <td style="text-align: center">
                <?php echo $project; ?>
              </td>
              <td style="text-align: left">
                <?php echo $rowdb21['ITEMDESCRIPTION']; ?>
              </td>
              <td style="text-align: left">
                <?php echo $rowdb23['DECOSUBCODE05']; ?>
              </td>
              <td style="text-align: left">
                <?php echo $warna; ?>
              </td>
              <td style="text-align: right"><span style="text-align: center">
                  <?php echo $rowdb23['LOTCODE']; ?>
                </span></td>
              <td style="text-align: center">
                <?php echo $rowdb23['ROL']; ?>
              </td>
              <td style="text-align: right">
                <?php echo round($rowdb23['KG'], 2); ?>
              </td>
              <td style="text-align: center">
                <?php echo $rowdb23['LK']; ?>
              </td>
              <td style="text-align: center">
                <?php echo $rowdb21['NOSJ']; ?>
              </td>
              <td style="text-align: center">
                <?php echo $rowdb27['QUALITYREASON']; ?>
              </td>
            </tr>
          <?php $no++;
          } ?>
        </tbody>

      </table>
    </div>
    <!-- /.card-body -->
  </div>
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