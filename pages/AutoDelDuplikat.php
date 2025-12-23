<?php
// autodelduplikat.php

require_once "./../koneksi.php"; 

// Ambil tanggal dari GET, kalau kosong pakai kemarin (yesterday)
$tgl = isset($_GET['tgl']) ? $_GET['tgl'] : date("Y-m-d", strtotime("-1 day"));

// Query ambil id untuk dihapus
$sql = "
    SELECT MIN(id) AS id 
    FROM tbl_opname_detail_11 
    WHERE tgl_tutup = ? 
    GROUP BY SN 
    HAVING COUNT(SN) > 1
";

$stmt = $con->prepare($sql);
$stmt->bind_param("s", $tgl);
$stmt->execute();
$result = $stmt->get_result();

$idsToDelete = [];
while ($row = $result->fetch_assoc()) {
    $idsToDelete[] = $row['id'];
}
$stmt->close();

$deleted = 0;

if (!empty($idsToDelete)) {
    $idList = implode(",", $idsToDelete);
    $deleteSql = "DELETE FROM tbl_opname_detail_11 WHERE id IN ($idList)";
    if ($con->query($deleteSql)) {
        $deleted = $con->affected_rows;
    }
}

$con->close();

echo "Tanggal diproses: $tgl<br>";
echo "Selesai. Total data dihapus: " . $deleted;
?>