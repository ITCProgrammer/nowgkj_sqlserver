<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=DetailOpnameBB1 " . ($_GET['tgl'] ?? '') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

include "../../koneksi.php"; // pastikan ini koneksi SQL Server ($con) pakai sqlsrv
ini_set("error_reporting", 1);

$Tgl = isset($_GET['tgl']) ? $_GET['tgl'] : '';
?>

<table border="1">
   <tr>
      <th>Item</th>
      <th>Langganan</th>
      <th>Buyer</th>
      <th>PO</th>
      <th>Order</th>
      <th>Tipe</th>
      <th>No Item</th>
      <th>Jns Kain</th>
      <th>No Warna</th>
      <th>Warna</th>
      <th>Lot</th>
      <th>Rol</th>
      <th>Weight</th>
      <th>Satuan</th>
      <th>Length</th>
      <th>Satuan</th>
      <th>Zone</th>
      <th>Lokasi</th>
      <th>Lebar</th>
      <th>Gramasi</th>
      <th>Status</th>
   </tr>

   <?php
   $no = 1;
   $totrol = 0;
   $totkg = 0.0;

   $sql = "
    SELECT
        itm,
        langganan,
        buyer,
        po,
        orderno,
        tipe,
        no_item,
        jns_kain,
        no_warna,
        warna,
        lot,
        COUNT(rol) AS rol,
        SUM([weight]) AS [weight],
        satuan,
        SUM([length]) AS [length],
        satuan_len,
        zone,
        lokasi,
        lebar,
        gramasi,
        sts_kain
    FROM dbnow_gkj.tbl_opname_detail_bb_11
    WHERE CONVERT(date, tgl_tutup) = CONVERT(date, ?)
    GROUP BY
        itm, langganan, buyer, po, orderno, tipe, no_item, jns_kain,
        no_warna, warna, lot, satuan, satuan_len, zone, lokasi, lebar, gramasi, sts_kain
    ORDER BY
        MIN(id) ASC
";

   $stmt = sqlsrv_query($con, $sql, [$Tgl]);
   if ($stmt === false) {
      die(print_r(sqlsrv_errors(), true));
   }

   while ($r = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
      $totrol += (int) $r['rol'];
      $totkg += (float) $r['weight'];
      ?>
      <tr>
         <td><?php echo $r['itm']; ?></td>
         <td><?php echo $r['langganan']; ?></td>
         <td><?php echo $r['buyer']; ?></td>
         <td><?php echo $r['po']; ?></td>
         <td><?php echo $r['orderno']; ?></td>
         <td><?php echo $r['tipe']; ?></td>
         <td><?php echo $r['no_item']; ?></td>
         <td><?php echo $r['jns_kain']; ?></td>
         <td><?php echo $r['no_warna']; ?></td>
         <td><?php echo $r['warna']; ?></td>
         <td><?php echo $r['lot']; ?></td>
         <td><?php echo (int) $r['rol']; ?></td>
         <td><?php echo number_format((float) $r['weight'], 3, '.', ','); ?></td>
         <td><?php echo $r['satuan']; ?></td>
         <td><?php echo number_format((float) $r['length'], 2, '.', ','); ?></td>
         <td><?php echo $r['satuan_len']; ?></td>
         <td><?php echo $r['zone']; ?></td>
         <td><?php echo $r['lokasi']; ?></td>
         <td><?php echo $r['lebar']; ?></td>
         <td><?php echo $r['gramasi']; ?></td>
         <td><?php echo $r['sts_kain']; ?></td>
      </tr>
      <?php
      $no++;
   }
   ?>

   <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><strong>TOTAL</strong></td>
      <td><strong><?php echo $totrol; ?></strong></td>
      <td><strong><?php echo number_format(round($totkg, 3), 3, '.', ','); ?></strong></td>
      <td><strong>KGs</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
   </tr>
</table>