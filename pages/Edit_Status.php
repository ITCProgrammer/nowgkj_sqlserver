<?php
include("../koneksi.php");

$schema    = 'dbnow_gkj';
$tblUpload = "[$schema].[tbl_upload]";

if ($_POST) {
    $id  = isset($_POST['id']) ? $_POST['id'] : '';
    $sts = isset($_POST['sts']) ? $_POST['sts'] : '';

    if ($sts == "Closed") {
        $qryUpdate = "UPDATE $tblUpload SET status=?, tgl_closed=GETDATE() WHERE id=?";
    } else {
        $qryUpdate = "UPDATE $tblUpload SET status=?, tgl_closed=NULL WHERE id=?";
    }

    $stmt = sqlsrv_query($con, $qryUpdate, [$sts, $id]);
    if ($stmt === false) {
        $err = sqlsrv_errors();
        $msg = $err[0]['message'] ?? 'Unknown error';
        echo "<script>alert('Gagal update status: $msg'); window.location='DataUpload';</script>";
        exit;
    }

    echo "<script type=\"text/javascript\">
            window.location = \"DataUpload\"
      </script>";
}
?>
