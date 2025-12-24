<?php
$stmt = sqlsrv_query(
    $con,
    "INSERT INTO tbl_upload_bs ([status]) VALUES (?)",
    ['Open']
);

if ($stmt === false) {
    $errors = sqlsrv_errors();
    $message = isset($errors[0]['message']) ? $errors[0]['message'] : 'Unknown error';
    echo "<script type=\"text/javascript\">
            alert(\"Gagal menambah data: {$message}\");
            window.location = \"DataUploadBS\"
          </script>";
    exit;
}

echo "<script type=\"text/javascript\">
            alert(\"Data Berhasil Ditambah\");
            window.location = \"DataUploadBS\"
            </script>";
?>
