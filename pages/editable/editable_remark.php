<?PHP
ini_set("error_reporting", 1);
session_start();
include "../../koneksi.php";
$ip_num = $_SERVER['REMOTE_ADDR'];
$os= $_SERVER['HTTP_USER_AGENT'];
//$tgl	= substr($_POST['pk'],0,6);
//$project= substr($_POST['pk'],6,20);
//mysqli_query($con,"UPDATE tbl_salesorder SET `bruto` = '$_POST[value]' where projectcode = '$project' and tgl_buat_po='$tgl' ");
mysqli_query($con,"UPDATE tbl_salesorder SET `remark` = '$_POST[value]' where projectcode = '".$_POST['pk']."'");
mysqli_query($con,"INSERT into tbl_log SET
	`what` = 'Edit Data Sales Order',
	`what_do` = 'Edit Data Sales Order Remark $_POST[value]',
	`project` = '$_POST[pk]',
	`do_by` = '$_SESSION[userMKT]',
	`do_at` = '$time',
	`ip` = '$ip_num',
	`os` = '$os',
	`foto` = '$_SESSION[fotoMKT]',
	`remark`='$_SESSION[jabatanMKT]'");
echo json_encode('success');
