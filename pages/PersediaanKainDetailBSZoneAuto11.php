<?php
include "../koneksi.php";
ini_set("error_reporting", 1);

$schema = 'dbnow_gkj';
$tblOpnameBS = "[$schema].[tbl_opname_detail_bs_11]";
$sqlErrors = [];
function logSqlError($stmt, $label = '', $line = null)
{
	global $sqlErrors;
	if ($stmt !== false) {
		return;
	}
	$err = sqlsrv_errors();
	if (!empty($err)) {
		$msg = $label !== '' ? $label . ': ' : '';
		if ($line !== null) {
			$msg = "[line $line] " . $msg;
		}
		$msg .= $err[0]['message'];
		$sqlErrors[] = $msg;
		echo "<script>console.error('SQLSRV error: " . addslashes($msg) . "');</script>";
	}
}

define("TANGGAL_HARI_INI", date("Y-m-d"));
$Awal = TANGGAL_HARI_INI;
$cektglSql = "SELECT
	CAST(GETDATE() AS date) as tgl,
	COUNT(tgl_tutup) as ck ,
	DATEPART(HOUR, GETDATE()) as jam,
	FORMAT(GETDATE(), 'HH:mm') as jam1,
	tgl_tutup 
FROM
	$tblOpnameBS
WHERE
	tgl_tutup = ?";
$stmtCek = sqlsrv_query($con, $cektglSql, [$Awal], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
logSqlError($stmtCek, 'cek tgl_tutup', __LINE__);
$dcek = $stmtCek ? sqlsrv_fetch_array($stmtCek, SQLSRV_FETCH_ASSOC) : null;
if ($dcek && $dcek['ck'] > 0) {
	echo "<script>";
	echo "alert('Stok Tgl " . $dcek['tgl_tutup'] . " Ini Sudah Pernah ditutup')";
	echo "</script>";
} else if ($_GET['note'] != "" or $_GET['note'] == "Berhasil") {
	echo "Tutup Transaksi Berhasil";
} else {
	$sqlDB21 = " 
	SELECT
	b.LOTCODE,
	b.PROJECTCODE,
	b.BASEPRIMARYUNITCODE,
	b.WHSLOCATIONWAREHOUSEZONECODE,
	b.WAREHOUSELOCATIONCODE,
	b.ITEMTYPECODE,
	b.DECOSUBCODE01,
	b.DECOSUBCODE02,
	b.DECOSUBCODE03,
	b.DECOSUBCODE04,
	b.DECOSUBCODE05,
	b.DECOSUBCODE06,
	b.DECOSUBCODE07,
	b.DECOSUBCODE08,
	b.ELEMENTSCODE,
	b.BASEPRIMARYQUANTITYUNIT,
	b.BASESECONDARYUNITCODE,
	b.BASESECONDARYQUANTITYUNIT,
	u.LONGDESCRIPTION AS KATEGORI	
FROM 
	BALANCE b
	LEFT JOIN USERGENERICGROUP u ON u.CODE = b.DECOSUBCODE02 AND  u.USERGENERICGROUPTYPECODE = 'S07' 	
WHERE
	(b.ITEMTYPECODE = 'KFF'
		OR b.ITEMTYPECODE = 'FKF')
	AND b.LOGICALWAREHOUSECODE = 'M631'
	AND (
		b.WHSLOCATIONWAREHOUSEZONECODE = '01'
		OR 
		b.WHSLOCATIONWAREHOUSEZONECODE = '03'		
		)	
	";
	$stmt1   = db2_exec($conn1, $sqlDB21, array('cursor' => DB2_SCROLLABLE));
	while ($rowdb21 = db2_fetch_assoc($stmt1)) {
		$itemNo = trim($rowdb21['DECOSUBCODE02']) . "" . trim($rowdb21['DECOSUBCODE03']);
		$sqlDB22 = " SELECT SALESORDER.CODE, SALESORDER.EXTERNALREFERENCE, SALESORDER.ORDPRNCUSTOMERSUPPLIERCODE,
		ITXVIEWAKJ.LEGALNAME1, ITXVIEWAKJ.ORDERPARTNERBRANDCODE, ITXVIEWAKJ.LONGDESCRIPTION
		FROM DB2ADMIN.SALESORDER SALESORDER LEFT OUTER JOIN DB2ADMIN.ITXVIEWAKJ 
       	ITXVIEWAKJ ON SALESORDER.CODE=ITXVIEWAKJ.CODE
		WHERE SALESORDER.CODE='$rowdb21[PROJECTCODE]' ";
		$stmt2   = db2_exec($conn1, $sqlDB22, array('cursor' => DB2_SCROLLABLE));
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

		$sqlDB23 = " SELECT USERGENERICGROUP.CODE,USERGENERICGROUP.LONGDESCRIPTION 
		FROM DB2ADMIN.USERGENERICGROUP USERGENERICGROUP WHERE USERGENERICGROUP.CODE='$rowdb21[DECOSUBCODE05]' ";
		$stmt3   = db2_exec($conn1, $sqlDB23, array('cursor' => DB2_SCROLLABLE));
		$rowdb23 = db2_fetch_assoc($stmt3);
		if ($rowdb21['QUALITYLEVELCODE'] == 1) {
			$grade = "A";
		} else if ($rowdb21['QUALITYLEVELCODE'] == 2) {
			$grade = "B";
		} else if ($rowdb21['QUALITYLEVELCODE'] == 3) {
			$grade = "C";
		}
		$sqlDB24 = "SELECT 
			ST.QUALITYREASONCODE,
			ST.ITEMELEMENTCODE,
			ST.PROJECTCODE,
			QR.LONGDESCRIPTION,
			ST.CREATIONDATETIME,
			ST.TRANSACTIONDATE,
			ST.TRANSACTIONTIME
		FROM DB2ADMIN.STOCKTRANSACTION ST
		LEFT JOIN DB2ADMIN.QUALITYREASON QR
			ON ST.QUALITYREASONCODE = QR.CODE
		WHERE ST.ITEMELEMENTCODE = '$rowdb21[ELEMENTSCODE]'
		ORDER BY ST.CREATIONDATETIME DESC
		FETCH FIRST 1 ROWS ONLY";
		$stmt4   = db2_exec($conn1, $sqlDB24, array('cursor' => DB2_SCROLLABLE));
		$rowdb24 = db2_fetch_assoc($stmt4);
		if ($rowdb24['QUALITYREASONCODE'] != "" and $rowdb24['QUALITYREASONCODE'] != "100") {
			$sts = $rowdb24['LONGDESCRIPTION'];
		} else if ((substr(trim($rowdb24['PROJECTCODE']), 0, 3) == "OPN" or substr(trim($rowdb24['PROJECTCODE']), 0, 3) == "STO") and $rowdb24['QUALITYREASONCODE'] == "100") {
			$sts = "Booking";
		} else if (substr(trim($rowdb24['PROJECTCODE']), 0, 3) == "OPN" or substr(trim($rowdb24['PROJECTCODE']), 0, 3) == "STO") {
			$sts = "Booking";
		} else if (substr(trim($rowdb24['PROJECTCODE']), 0, 3) == "RPE" and $rowdb24['QUALITYREASONCODE'] == "100") {
			$sts = "Ganti Kain";
		} else if (substr(trim($rowdb24['PROJECTCODE']), 0, 3) == "RPE") {
			$sts = "Ganti Kain";
		} else {
			$sts = "Tunggu Kirim";
		}

		$sqlDB25 = " SELECT ORDERITEMORDERPARTNERLINK.ORDPRNCUSTOMERSUPPLIERCODE,
       ORDERITEMORDERPARTNERLINK.LONGDESCRIPTION 
	   FROM DB2ADMIN.ORDERITEMORDERPARTNERLINK ORDERITEMORDERPARTNERLINK WHERE
       ORDERITEMORDERPARTNERLINK.ITEMTYPEAFICODE='$rowdb21[ITEMTYPECODE]' AND
	   ORDERITEMORDERPARTNERLINK.ORDPRNCUSTOMERSUPPLIERCODE='$rowdb22[ORDPRNCUSTOMERSUPPLIERCODE]' AND
	   ORDERITEMORDERPARTNERLINK.SUBCODE01='$rowdb21[DECOSUBCODE01]' AND
       ORDERITEMORDERPARTNERLINK.SUBCODE02='$rowdb21[DECOSUBCODE02]' AND
       ORDERITEMORDERPARTNERLINK.SUBCODE03='$rowdb21[DECOSUBCODE03]' AND
	   ORDERITEMORDERPARTNERLINK.SUBCODE04='$rowdb21[DECOSUBCODE04]' AND
       ORDERITEMORDERPARTNERLINK.SUBCODE05='$rowdb21[DECOSUBCODE05]' AND
	   ORDERITEMORDERPARTNERLINK.SUBCODE06='$rowdb21[DECOSUBCODE06]' AND
       ORDERITEMORDERPARTNERLINK.SUBCODE07='$rowdb21[DECOSUBCODE07]' AND
	   ORDERITEMORDERPARTNERLINK.SUBCODE08='$rowdb21[DECOSUBCODE08]'";
		$stmt5   = db2_exec($conn1, $sqlDB25, array('cursor' => DB2_SCROLLABLE));
		$rowdb25 = db2_fetch_assoc($stmt5);
		if ($rowdb25['LONGDESCRIPTION'] != "") {
			$item = $rowdb25['LONGDESCRIPTION'];
		} else {
			$item = trim($rowdb21['DECOSUBCODE02']) . "" . trim($rowdb21['DECOSUBCODE03']);
		}

		if ($stmt2['EXTERNALREFERENCE'] != "") {
			$PO = $stmt2['EXTERNALREFERENCE'];
		} else {
			$PO = $rowdb26['EXTERNALREFERENCE'];
		}
		$sqlDB27 = " SELECT ADSTORAGE.NAMENAME,ADSTORAGE.VALUEDECIMAL 
	   FROM DB2ADMIN.ADSTORAGE ADSTORAGE RIGHT OUTER JOIN DB2ADMIN.PRODUCT PRODUCT 
       ON ADSTORAGE.UNIQUEID=PRODUCT.ABSUNIQUEID WHERE
       PRODUCT.ITEMTYPECODE='$rowdb21[ITEMTYPECODE]' AND	
	   PRODUCT.SUBCODE01='$rowdb21[DECOSUBCODE01]' AND
       PRODUCT.SUBCODE02='$rowdb21[DECOSUBCODE02]' AND
       PRODUCT.SUBCODE03='$rowdb21[DECOSUBCODE03]' AND
	   PRODUCT.SUBCODE04='$rowdb21[DECOSUBCODE04]' AND
       PRODUCT.SUBCODE05='$rowdb21[DECOSUBCODE05]' AND
	   PRODUCT.SUBCODE06='$rowdb21[DECOSUBCODE06]' AND
       PRODUCT.SUBCODE07='$rowdb21[DECOSUBCODE07]' AND
	   PRODUCT.SUBCODE08='$rowdb21[DECOSUBCODE08]' AND 
	   ADSTORAGE.NAMENAME='Width' ";
		$stmt7   = db2_exec($conn1, $sqlDB27, array('cursor' => DB2_SCROLLABLE));
		$rowdb27 = db2_fetch_assoc($stmt7);
		$sqlDB28 = " SELECT ADSTORAGE.NAMENAME,ADSTORAGE.VALUEDECIMAL 
	   FROM DB2ADMIN.ADSTORAGE ADSTORAGE RIGHT OUTER JOIN DB2ADMIN.PRODUCT PRODUCT 
       ON ADSTORAGE.UNIQUEID=PRODUCT.ABSUNIQUEID WHERE
       PRODUCT.ITEMTYPECODE='$rowdb21[ITEMTYPECODE]' AND	
	   PRODUCT.SUBCODE01='$rowdb21[DECOSUBCODE01]' AND
       PRODUCT.SUBCODE02='$rowdb21[DECOSUBCODE02]' AND
       PRODUCT.SUBCODE03='$rowdb21[DECOSUBCODE03]' AND
	   PRODUCT.SUBCODE04='$rowdb21[DECOSUBCODE04]' AND
       PRODUCT.SUBCODE05='$rowdb21[DECOSUBCODE05]' AND
	   PRODUCT.SUBCODE06='$rowdb21[DECOSUBCODE06]' AND
       PRODUCT.SUBCODE07='$rowdb21[DECOSUBCODE07]' AND
	   PRODUCT.SUBCODE08='$rowdb21[DECOSUBCODE08]' AND 
	   ADSTORAGE.NAMENAME='GSM' ";
		$stmt8   = db2_exec($conn1, $sqlDB28, array('cursor' => DB2_SCROLLABLE));
		$rowdb28 = db2_fetch_assoc($stmt8);

		$sqlDB30 = "SELECT PRODUCT.LONGDESCRIPTION FROM PRODUCT WHERE
       PRODUCT.ITEMTYPECODE='$rowdb21[ITEMTYPECODE]' AND	
	   PRODUCT.SUBCODE01='$rowdb21[DECOSUBCODE01]' AND
       PRODUCT.SUBCODE02='$rowdb21[DECOSUBCODE02]' AND
       PRODUCT.SUBCODE03='$rowdb21[DECOSUBCODE03]' AND
	   PRODUCT.SUBCODE04='$rowdb21[DECOSUBCODE04]' AND
       PRODUCT.SUBCODE05='$rowdb21[DECOSUBCODE05]' AND
	   PRODUCT.SUBCODE06='$rowdb21[DECOSUBCODE06]' AND
       PRODUCT.SUBCODE07='$rowdb21[DECOSUBCODE07]' AND
	   PRODUCT.SUBCODE08='$rowdb21[DECOSUBCODE08]' ";
		$stmt10   = db2_exec($conn1, $sqlDB30, array('cursor' => DB2_SCROLLABLE));
		$rowdb30 = db2_fetch_assoc($stmt10);

		$sqlDB31 = "SELECT WARNA FROM (SELECT
    ITEMTYPECODE,
    SUBCODE01,
    SUBCODE02,
    SUBCODE03,
    SUBCODE04,
    SUBCODE05,
    SUBCODE06,
    SUBCODE07,
    SUBCODE08,
    SUBCODE09,
    SUBCODE10,
    CASE
        WHEN WARNA = 'NULL' THEN WARNA_FKF
        ELSE WARNA
    END AS WARNA,
    WARNA_DASAR
FROM
    (
    SELECT
        PRODUCT.ITEMTYPECODE AS ITEMTYPECODE,
        PRODUCT.SUBCODE01 AS SUBCODE01,
        PRODUCT.SUBCODE02 AS SUBCODE02,
        PRODUCT.SUBCODE03 AS SUBCODE03,
        PRODUCT.SUBCODE04 AS SUBCODE04,
        PRODUCT.SUBCODE05 AS SUBCODE05,
        PRODUCT.SUBCODE06 AS SUBCODE06,
        PRODUCT.SUBCODE07 AS SUBCODE07,
        PRODUCT.SUBCODE08 AS SUBCODE08,
        PRODUCT.SUBCODE09 AS SUBCODE09,
        PRODUCT.SUBCODE10 AS SUBCODE10,
        CASE
            WHEN PRODUCT.ITEMTYPECODE = 'KFF'
            AND PRODUCT.SUBCODE07 = '-' THEN A.LONGDESCRIPTION
            WHEN PRODUCT.ITEMTYPECODE = 'KFF'
            AND PRODUCT.SUBCODE07 <> '-'
            OR PRODUCT.SUBCODE07 <> '' THEN B.COLOR_PRT
            ELSE 'NULL'
        END AS WARNA,
        CASE
            WHEN PRODUCT.ITEMTYPECODE = 'FKF'
            AND LOCATE('-', PRODUCT.LONGDESCRIPTION) = 0 THEN PRODUCT.LONGDESCRIPTION
            WHEN PRODUCT.ITEMTYPECODE = 'FKF'
            AND LOCATE('-', PRODUCT.LONGDESCRIPTION) > 0 THEN SUBSTR(PRODUCT.LONGDESCRIPTION , 1, LOCATE('-', PRODUCT.LONGDESCRIPTION)-1)
            ELSE 'NULL'
        END AS WARNA_FKF,
        WARNA_DASAR
    FROM
        PRODUCT PRODUCT
    LEFT JOIN(
        SELECT
            CAST(SUBSTR(RECIPE.SUBCODE01, 1, LOCATE('/', RECIPE.SUBCODE01)-1) AS CHARACTER(10)) AS ARTIKEL,
            CAST(SUBSTR(RECIPE.SUBCODE01, LOCATE('/', RECIPE.SUBCODE01)+ 1, 7) AS CHARACTER(10)) AS NO_WARNA,
            SUBSTR(SUBSTR(RECIPE.SUBCODE01, LOCATE('/', RECIPE.SUBCODE01)+ 1), LOCATE('/', SUBSTR(RECIPE.SUBCODE01, LOCATE('/', RECIPE.SUBCODE01)+ 1))+ 1) AS CELUP,
            RECIPE.LONGDESCRIPTION,
            RECIPE.SHORTDESCRIPTION,
            RECIPE.SEARCHDESCRIPTION,
            RECIPE.NUMBERID,
            PRODUCT.SUBCODE03,
            PRODUCT.SUBCODE05,
            PRODUCT.LONGDESCRIPTION AS PRODUCT_LONG
        FROM
            RECIPE RECIPE
        LEFT JOIN PRODUCT PRODUCT ON
            SUBSTR(RECIPE.SUBCODE01, 1, LOCATE('/', RECIPE.SUBCODE01)-1) = PRODUCT.SUBCODE03
            AND SUBSTR(RECIPE.SUBCODE01, LOCATE('/', RECIPE.SUBCODE01)+ 1, 7) = PRODUCT.SUBCODE05
        WHERE
            RECIPE.ITEMTYPECODE = 'RFD'
            AND LOCATE('/', RECIPE.SUBCODE01) > 0
            AND RECIPE.SUFFIXCODE = '001'
            --            AND NOT RECIPE.SEARCHDESCRIPTION LIKE '%DELETE%' AND NOT RECIPE.SEARCHDESCRIPTION LIKE '%delete%'
            ) A ON
        PRODUCT.SUBCODE03 = A.SUBCODE03
        AND PRODUCT.SUBCODE05 = A.SUBCODE05
    LEFT JOIN(
        SELECT
            DESIGN.SUBCODE01,
            DESIGNCOMPONENT.VARIANTCODE,
            DESIGNCOMPONENT.LONGDESCRIPTION AS COLOR_PRT,
            DESIGNCOMPONENT.SHORTDESCRIPTION AS WARNA_DASAR
        FROM
            DESIGN DESIGN
        LEFT JOIN DESIGNCOMPONENT DESIGNCOMPONENT ON
            DESIGN.NUMBERID = DESIGNCOMPONENT.DESIGNNUMBERID
            AND DESIGN.SUBCODE01 = DESIGNCOMPONENT.DESIGNSUBCODE01) B ON
        PRODUCT.SUBCODE07 = B.SUBCODE01
        AND PRODUCT.SUBCODE08 = B.VARIANTCODE
    WHERE
        (PRODUCT.ITEMTYPECODE = 'KFF'
            OR PRODUCT.ITEMTYPECODE = 'FKF')
    GROUP BY
        PRODUCT.ITEMTYPECODE,
        PRODUCT.SUBCODE01,
        PRODUCT.SUBCODE02,
        PRODUCT.SUBCODE03,
        PRODUCT.SUBCODE04,
        PRODUCT.SUBCODE05,
        PRODUCT.SUBCODE06,
        PRODUCT.SUBCODE07,
        PRODUCT.SUBCODE08,
        PRODUCT.SUBCODE09,
        PRODUCT.SUBCODE10,
         PRODUCT.LONGDESCRIPTION,
        A.LONGDESCRIPTION,
        B.COLOR_PRT,
        WARNA_DASAR,
        PRODUCT.SHORTDESCRIPTION)) ITXVIEWCOLOR WHERE
       ITXVIEWCOLOR.ITEMTYPECODE='$rowdb21[ITEMTYPECODE]' AND	
	   ITXVIEWCOLOR.SUBCODE01='$rowdb21[DECOSUBCODE01]' AND
       ITXVIEWCOLOR.SUBCODE02='$rowdb21[DECOSUBCODE02]' AND
       ITXVIEWCOLOR.SUBCODE03='$rowdb21[DECOSUBCODE03]' AND
	   ITXVIEWCOLOR.SUBCODE04='$rowdb21[DECOSUBCODE04]' AND
       ITXVIEWCOLOR.SUBCODE05='$rowdb21[DECOSUBCODE05]' AND
	   ITXVIEWCOLOR.SUBCODE06='$rowdb21[DECOSUBCODE06]' AND
       ITXVIEWCOLOR.SUBCODE07='$rowdb21[DECOSUBCODE07]' AND
	   ITXVIEWCOLOR.SUBCODE08='$rowdb21[DECOSUBCODE08]' ";
		$stmt11   = db2_exec($conn1, $sqlDB31, array('cursor' => DB2_SCROLLABLE));
		$rowdb31 = db2_fetch_assoc($stmt11);

		if ($rowdb21['ITEMTYPECODE'] == "KFF") {
			$jns = "KAIN";
		} else if ($rowdb21['ITEMTYPECODE'] == "FKF") {
			$jns = "KRAH";
		}
		$sqlQC = mysqli_query($cond, "SELECT k.pelanggan,k.no_po,k.no_order,k.jenis_kain  FROM db_qc.tmp_detail_kite tmp
inner join db_qc.tbl_kite k on k.id=tmp.id_kite 
WHERE SN='$rowdb21[ELEMENTSCODE]' ");
		$rQC = mysqli_fetch_array($sqlQC);
		$pos = strpos($rQC['pelanggan'], "/");
		$cust = substr($rQC['pelanggan'], 0, $pos);
		$byr = substr($rQC['pelanggan'], $pos + 1, 300);


		if ($langganan != "") {
			$langganan1 = $langganan;
		} else {
			$langganan1 = $cust;
		}
		if ($buyer != "") {
			$buyer1 = $buyer;
		} else {
			$buyer1 = $byr;
		}
		if ($PO != "") {
			$PO1 = $PO;
		} else {
			$PO1 = $rQC['no_po'];
		}
		if (trim($rowdb21['PROJECTCODE']) != "") {
			$project = $rowdb21['PROJECTCODE'];
		} else {
			$project = $rQC['no_order'];
		}
		if (trim($rowdb26['ITEMDESCRIPTION']) != "") {
			$jeniskain = $rowdb26['ITEMDESCRIPTION'];
		} else if ($rQC['jenis_kain'] != "") {
			$jeniskain = $rQC['jenis_kain'];
		} else {
			$jeniskain = $rowdb30['LONGDESCRIPTION'];
		}
		if ($rowdb31['WARNA'] != "") {
			$warna = $rowdb31['WARNA'];
		} else {
			$warna = $rowdb23['LONGDESCRIPTION'];
		}
		$berat = number_format(round($rowdb21['BASEPRIMARYQUANTITYUNIT'], 2), 2);
		$pjng = number_format(round($rowdb21['BASESECONDARYQUANTITYUNIT'], 2), 2);


		$insertSql = "INSERT INTO $tblOpnameBS (
        itm, langganan, buyer, po, orderno, tipe, no_item, jns_kain, no_warna, warna, rol, lot, weight, satuan, length, satuan_len, zone, lokasi, lebar, gramasi, sts_kain, sn, tgl_update, tgl_tutup, kategori, tgl_buat
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE()
    )";
		$params = [
			$item,
			str_replace("'", "''", $langganan1),
			str_replace("'", "''", $buyer1),
			str_replace("'", "''", $PO1),
			$project,
			$jns,
			$itemNo,
			str_replace("'", "''", $jeniskain),
			$rowdb21['DECOSUBCODE05'],
			str_replace("'", "''", $warna),
			1,
			$rowdb21['LOTCODE'],
			round($berat, 2),
			$rowdb21['BASEPRIMARYUNITCODE'],
			round($pjng, 2),
			$rowdb21['BASESECONDARYUNITCODE'],
			$rowdb21['WHSLOCATIONWAREHOUSEZONECODE'],
			$rowdb21['WAREHOUSELOCATIONCODE'],
			round($rowdb27['VALUEDECIMAL']),
			round($rowdb28['VALUEDECIMAL']),
			$sts,
			$rowdb21['ELEMENTSCODE'],
			$rowdb24['TRANSACTIONDATE'] . " " . $rowdb24['TRANSACTIONTIME'],
			$Awal,
			$rowdb21['KATEGORI']
		];
		$simpan = sqlsrv_query($con, $insertSql, $params);
		logSqlError($simpan, 'insert opname detail bs', __LINE__);
	}
	if ($simpan) {
		//echo "<meta http-equiv='refresh' content='30; url=PersediaanKainDetailBBZoneAuto11.php?note=Berhasil'>";

?>
		<script type="text/javascript">
			// Mengarahkan ke URL pertama
			window.open("cetak/PersediaanKainDetailBSExcel11.php?tgl=<?php echo $Awal; ?>", "_blank");
		</script>
<?php
	}
} ?>