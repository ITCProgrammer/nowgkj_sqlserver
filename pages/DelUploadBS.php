<?php
$idUp = $_GET['id'];
mysqli_query($con, "DELETE FROM tbl_stokfull_bs WHERE id_upload='$idUp'");
mysqli_query($con, "DELETE FROM tbl_upload_bs WHERE id='$idUp'");

echo "<script type=\"text/javascript\">
            window.location = \"DataUploadBS\"
      </script>";
?>