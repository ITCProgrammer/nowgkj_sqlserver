<?PHP
ini_set("error_reporting", 1);
session_start();
include "../../koneksi.php";
$ip_num = $_SERVER['REMOTE_ADDR'];
$os= $_SERVER['HTTP_USER_AGENT'];
$qry = mysqli_query($con,"SELECT * FROM tbl_keterangan  where link_kj = '".$_POST['pk']."'");
$ck= mysqli_num_rows($qry);
if($ck>0){
mysqli_query($con,"UPDATE tbl_keterangan SET `keterangan` = '$_POST[value]' where link_kj = '".$_POST['pk']."'");
}else{
mysqli_query($con,"INSERT into tbl_keterangan SET
	`link_kj` = '".$_POST['pk']."',
	`keterangan` = '$_POST[value]'");	
}
echo json_encode('success');
