<?php
mysqli_query($con, "INSERT INTO tbl_upload_bs (`status`) 
				VALUES ('Open')");
echo "<script type=\"text/javascript\">
            alert(\"Data Berhasil Ditambah\");
            window.location = \"DataUploadBS\"
            </script>";
?>