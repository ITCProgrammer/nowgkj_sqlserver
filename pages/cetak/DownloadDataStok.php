<?php
		$Awal="2024-03-26";
		//echo "<meta http-equiv='refresh' content='0; url=cetak/PersediaanKainJadiFullDetailExcelR11.php?tgl=$Awal'>";
//		echo "<meta http-equiv='refresh' content='5; url=cetak/PersediaanKainJadi2022DetailExcelR11.php?tgl=$Awal'>";
//		echo "<meta http-equiv='refresh' content='10; url=cetak/PersediaanKainJadiNoOrderDetailExcelR11.php?tgl=$Awal'>";
		//echo "<meta http-equiv='refresh' content='15; url=cetak/StatusResepRekapExcel11.php?tgl=$Awal'>";
        //echo "<meta http-equiv='refresh' content='20; url=PersediaanKainJadiFullDetailAuto11.php?note=Berhasil'>";	
if($Awal!=""){
?>
<script type="text/javascript">
    // Mengarahkan ke URL pertama
	window.open("cetak/PersediaanKainJadi2022DetailExcelR11.php?tgl=<?php echo $Awal; ?>", "_blank");


    // Menunggu beberapa waktu sebelum mengarahkan ke URL kedua
    setTimeout(function(){
        window.open("cetak/PersediaanKainJadiNoOrderDetailExcelR11.php?tgl=<?php echo $Awal; ?>", "_blank");
    }, 5000); 
	// Menunggu 5 detik (5000 milidetik) sebelum mengarahkan ke URL kedua
	
	// Menunggu beberapa waktu sebelum mengarahkan ke URL ketiga
    setTimeout(function(){
        window.open("cetak/PersediaanKainJadiFullDetailExcelR11.php?tgl=<?php echo $Awal; ?>", "_blank");
    }, 10000); 
	// Menunggu 10 detik (10000 milidetik) sebelum mengarahkan ke URL ketiga
	
	// Menunggu beberapa waktu sebelum mengarahkan ke URL keempat
    setTimeout(function(){
        window.open("cetak/PersediaanKainJadi2023DetailExcelR11.php?tgl=<?php echo $Awal; ?>", "_blank");
    }, 15000); 
	// Menunggu 15 detik (15000 milidetik) sebelum mengarahkan ke URL keempat
	
	// Menunggu beberapa waktu sebelum mengarahkan ke URL kelima
    setTimeout(function(){
        window.open("cetak/PersediaanKainJadi2024DetailExcelR11.php?tgl=<?php echo $Awal; ?>", "_blank");
    }, 20000); 
	// Menunggu 20 detik (20000 milidetik) sebelum mengarahkan ke URL kelima
</script>
<?php } ?>