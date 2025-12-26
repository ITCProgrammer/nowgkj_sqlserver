<?php
include "../koneksi.php";
ini_set("error_reporting", 1);
define("TANGGAL_HARI_INI", date("Y-m-d"));
define("TANGGAL_KEMARIN", date("Y-m-d", strtotime("-1 day")));

$Awal    = TANGGAL_HARI_INI;
$Kemarin = TANGGAL_KEMARIN;
$tgl     = isset($_GET['tgl']) && $_GET['tgl'] !== '' ? $_GET['tgl'] : $Kemarin;
$tglParam = urlencode($tgl);
?>
<script type="text/javascript">
    // urutan unduhan laporan manual (default: kemarin)
    const tgl = "<?php echo $tglParam; ?>";
    window.open("cetak/PersediaanKainJadi2022DetailExcelR11.php?tgl=" + tgl, "_blank");
    setTimeout(function() {
        window.open("cetak/PersediaanKainJadiNoOrderDetailExcelR11.php?tgl=" + tgl, "_blank");
    }, 5000);
    setTimeout(function() {
        window.open("cetak/PersediaanKainJadiFullDetailExcelR11.php?tgl=" + tgl, "_blank");
    }, 10000);
    setTimeout(function() {
        window.open("cetak/PersediaanKainJadi2023DetailExcelR11.php?tgl=" + tgl, "_blank");
    }, 15000);
    setTimeout(function() {
        window.open("cetak/PersediaanKainJadi2024DetailExcelR11.php?tgl=" + tgl, "_blank");
    }, 20000);
    setTimeout(function() {
        window.open("cetak/PersediaanKainJadi2025DetailExcelR11.php?tgl=" + tgl, "_blank");
    }, 25000);
</script>
