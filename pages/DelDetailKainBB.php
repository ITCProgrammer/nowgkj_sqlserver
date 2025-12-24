<?php
$tgl     = isset($_GET['tgl']) ? $_GET['tgl'] : '';
$schema  = 'dbnow_gkj';
$tblOpnameDetailBB = "[$schema].[tbl_opname_detail_bb_11]";
$sql    = "DELETE FROM $tblOpnameDetailBB WHERE tgl_tutup = ?";
$stmt   = sqlsrv_query($con, $sql, [$tgl]);
if ($stmt === false) {
    $err = sqlsrv_errors();
    $msg = !empty($err) ? $err[0]['message'] : 'Unknown error';
    echo "<script>alert('Gagal hapus: " . addslashes($msg) . "'); window.history.back();</script>";
    exit;
}
echo "<script type=\"text/javascript\">
            window.location = \"PersediaanKainJadiBBDetailPerHari\"
      </script>";
?>
