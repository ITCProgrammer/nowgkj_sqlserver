<?php
// URL tujuan
$url = "http://online.indotaichen.com/laporan/ppc_pengiriman.php";

// Menampilkan pesan peringatan sebelum dialihkan
echo "<html>";
echo "<head>";
echo "<title>Peringatan - Halaman Sedang Dialihkan</title>";
echo "<script type='text/javascript'>
    var countdown = 10;
    function startCountdown() {
        var countdownElement = document.getElementById(\"countdown\");
        var interval = setInterval(function() {
            countdown--;
            countdownElement.textContent = countdown;
            if (countdown <= 0) {
                clearInterval(interval);
                window.location.href = \"$url\";
            }
        }, 1000);
    }
</script>";
echo "</head>";
echo "<body onload='startCountdown()'>";
echo "<br><br><br><br><br><br><br><br><br><center><h1>Peringatan: Anda sedang dialihkan ke halaman baru.</h1>";
echo "<p>Anda akan dialihkan dalam <span id='countdown'>10</span> detik...</p>";
echo "<p>Jika Anda tidak dialihkan, klik tautan berikut: <a href='$url'>$url</a></p></center>";
echo "</body>";
echo "</html>";
?>
