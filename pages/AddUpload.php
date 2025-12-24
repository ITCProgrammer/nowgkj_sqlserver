<?php
$schema = 'dbnow_gkj';
$tblUpload = "[$schema].[tbl_upload]";

$stmt = sqlsrv_query(
    $con,
    "INSERT INTO $tblUpload ([status]) VALUES (?)",
    ['Open']
);

if ($stmt === false) {
    $errors = sqlsrv_errors();
    $message = isset($errors[0]['message']) ? $errors[0]['message'] : 'Unknown error';
    echo "<script type=\"text/javascript\">
            alert(\"Gagal menambah data: {$message}\");
            window.location = \"DataUpload\"
          </script>";
    exit;
}

echo "<script type=\"text/javascript\">
            alert(\"Data Berhasil Ditambah\");
            window.location = \"DataUpload\"
            </script>";
?>
