<?php
include "../koneksi.php";
ini_set("error_reporting", 1);
define("TANGGAL_HARI_INI", date("Y-m-d"));
define("TANGGAL_KEMARIN", date("Y-m-d", strtotime("-1 day")));

$Awal  = TANGGAL_HARI_INI;
$Kemarin = TANGGAL_KEMARIN;
		//echo "<meta http-equiv='refresh' content='30; url=PersediaanKainJadiFullDetailAuto11.php?note=Berhasil'>";
?>
		<script type="text/javascript">
			// Mengarahkan ke URL pertama
			window.open("cetak/PersediaanKainJadi2022DetailExcelR11.php?tgl=<?php echo $Kemarin; ?>", "_blank");


			// Menunggu beberapa waktu sebelum mengarahkan ke URL kedua
			setTimeout(function() {
				window.open("cetak/PersediaanKainJadiNoOrderDetailExcelR11.php?tgl=<?php echo $Kemarin; ?>", "_blank");
			}, 5000);
			// Menunggu 5 detik (5000 milidetik) sebelum mengarahkan ke URL kedua

			// Menunggu beberapa waktu sebelum mengarahkan ke URL ketiga
			setTimeout(function() {
				window.open("cetak/PersediaanKainJadiFullDetailExcelR11.php?tgl=<?php echo $Kemarin; ?>", "_blank");
			}, 10000);
			// Menunggu 10 detik (10000 milidetik) sebelum mengarahkan ke URL ketiga

			// Menunggu beberapa waktu sebelum mengarahkan ke URL keempat
			setTimeout(function() {
				window.open("cetak/PersediaanKainJadi2023DetailExcelR11.php?tgl=<?php echo $Kemarin; ?>", "_blank");
			}, 15000);
			// Menunggu 15 detik (15000 milidetik) sebelum mengarahkan ke URL keempat

			// Menunggu beberapa waktu sebelum mengarahkan ke URL kelima
			setTimeout(function() {
				window.open("cetak/PersediaanKainJadi2024DetailExcelR11.php?tgl=<?php echo $Kemarin; ?>", "_blank");
			}, 20000);
			// Menunggu 20 detik (20000 milidetik) sebelum mengarahkan ke URL kelima
			
			// Menunggu beberapa waktu sebelum mengarahkan ke URL kelima
			setTimeout(function() {
				window.open("cetak/PersediaanKainJadi2025DetailExcelR11.php?tgl=<?php echo $Kemarin; ?>", "_blank");
			}, 25000);
			// Menunggu 25 detik (20000 milidetik) sebelum mengarahkan ke URL kelima
		</script>