<?php
$tgl = $_GET['tgl'];
mysqli_query($con, "DELETE FROM tbl_opname_bb_11 WHERE tgl_tutup='$tgl'");

echo "<script type=\"text/javascript\">
            window.location = \"TutupHarianBB\"
      </script>";
?>