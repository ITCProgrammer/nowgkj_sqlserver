<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=LaporanTolakanKain.xls");
header("Pragma: no-cache");
header("Expires: 0");

include "../../koneksi.php";   // pastikan di sini ada $cond
// include juga koneksi DB2 kalau perlu: include "../../koneksi_db2.php";

ini_set("error_reporting", 1);

$Awal_ = isset($_GET['tgl1']) ? $_GET['tgl1'] : '';
$Akhir_ = isset($_GET['tgl2']) ? $_GET['tgl2'] : '';

?>

<?php
date_default_timezone_set('Asia/Jakarta');

$awalParam = $_GET['tgl1'] ?? '';
$akhirParam = $_GET['tgl2'] ?? '';

$awalDate = $awalParam ? new DateTime($awalParam) : null;
$akhirDate = $akhirParam ? new DateTime($akhirParam) : null;

// Format nama bulan Indonesia (huruf pertama besar)
function namaBulanIndo($bulan)
{
  $bulanIndo = [
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
  ];
  return $bulanIndo[(int) $bulan] ?? $bulan;
}

function tanggalIndo(DateTime $dt)
{
  $hari = $dt->format('d');
  $bulan = namaBulanIndo($dt->format('n'));
  $tahun = $dt->format('Y');
  return "$hari $bulan $tahun";
}

// Teks periode (kalau mau range, tinggal pakai yg bawah)
// $teksPeriode = ($awalDate && $akhirDate && $awalParam != $akhirParam)
//     ? tanggalIndo($awalDate)." s/d ".tanggalIndo($akhirDate)
//     : ($awalDate ? tanggalIndo($awalDate) : '');

$teksPeriode = $akhirDate ? tanggalIndo($akhirDate) : '';
?>

<table border="0" width="100%" style="margin-bottom: 20px;">
  <tr>
    <td colspan="16" style="text-align: center; vertical-align: middle; height: 80px;">
      <div style="font-size:21px; font-weight:bold;">
        LAPORAN TOLAKAN GUDANG KAIN JADI<br>
        <?php if ($teksPeriode): ?>
          PERIODE: <?= $teksPeriode; ?><br>
        <?php endif; ?>
        FW-19-GKJ-12/05
      </div>
    </td>
  </tr>
</table>

<br>
<table border="1" style="font-size:13px;">
  <thead>
    <tr>
      <th>No.</th>
      <th>Tanggal Bon</th>
      <th>Tanggal Masuk Mutasi</th>
      <th>No Bon</th>      
      <th>Langganan</th>
      <th>No PO</th>
      <th>No Order</th>
      <th>Jenis Kain</th>
      <th>Warna</th>
      <th>Roll</th>
      <th>Berat Netto</th>
      <th>Berat TG</th>
      <th>No LOT</th>
      <th>Ket</th>
      <th>Lokasi</th>
      <th>Kode</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    $totJml = 0;
    $totKg = 0;
    $totberatTG = 0;

    // --- cek dulu: parameter tanggal ada atau tidak ---
    if ($Awal_ != '' && $Akhir_ != '') {

      // jika kolom tgl_terima tipe DATETIME, lebih aman pakai 00:00:00 s/d 23:59:59
      $sql = "SELECT 
                tbp.tgl_terima as tgl_bon,
                tbp.nokk,
                CASE 
                  WHEN tbp.jns_permintaan = 'Bongkaran'      THEN 'BG'
                  WHEN tbp.jns_permintaan = 'Potong Pas Qty' THEN 'PPQ'
                  WHEN tbp.jns_permintaan = 'Potong Sample'  THEN 'PSP'
                  WHEN tbp.jns_permintaan = 'Potong Sisa'    THEN 'PSS'
                  ELSE tbp.jns_permintaan    	
                END AS kode_jns_permintaan,
                tbpd.tgl_mutasi,
                tbp.refno AS no_bon,
                tbp.langganan,
                tbp.no_po,
                tbp.no_order,
                tbp.jenis_kain,
                tbp.warna,
                CASE
                  WHEN tbp.jns_permintaan IN ('Bongkaran','Potong Pas Qty','Potong Sample','Potong Sisa')
                      AND tbpd.berat IS NULL
                    THEN CAST(0 AS DECIMAL(18,2))
                  WHEN tbp.jns_permintaan IN ('Bongkaran','Potong Pas Qty','Potong Sample','Potong Sisa')
                    THEN CAST(IFNULL(tbpd.berat_potong, 0) AS DECIMAL(18,2))
                  ELSE CAST(IFNULL(tbpd.berat, 0) AS DECIMAL(18,2))
                END AS berat_tg,
                tbp.no_lot,
                tbp.ket,
                tbpd.tempat
            FROM 
                tbl_bon_permintaan tbp 
            LEFT JOIN tbl_bon_permintaan_detail tbpd 
                ON tbpd.no_permintaan = tbp.no_permintaan 
            WHERE 
                tbp.tgl_terima  between '$Awal_ 23:00:00'
                AND  '$Akhir_ 23:00:00'
            ORDER BY tbp.id ASC";

      $sqlDB21 = mysqli_query($cond, $sql);

      if (!$sqlDB21) {
        // Kalau query salah / koneksi salah, akan kelihatan di Excel
        echo '<tr><td colspan="16" style="text-align:center;color:red;">
                Error query MySQL: ' . mysqli_error($cond) . '
            </td></tr>';
      } else {

        // Tambahan: cek apakah memang tidak ada data
        if (mysqli_num_rows($sqlDB21) == 0) {
          echo '<tr><td colspan="16" style="text-align:center;">
                    Data tidak ditemukan untuk range ' . $Awal_ . ' s/d ' . $Akhir_ . '
                  </td></tr>';
        } else {

          while ($rowdb21 = mysqli_fetch_array($sqlDB21)) {

            // kalau belum punya koneksi DB2 ($conn1), ini bisa di-skip/dibuat 0 dulu
            $sqld = "SELECT 
                                    COUNT(BALANCE.ELEMENTSCODE) AS JML_ROLL, 
                                    SUM(BALANCE.BASEPRIMARYQUANTITYUNIT) AS TBERAT
                                FROM 
                                    BALANCE BALANCE 
                                WHERE 
                                    BALANCE.LOTCODE ='{$rowdb21['nokk']}' 
                                    AND BALANCE.LOGICALWAREHOUSECODE ='M031' 
                                    AND NOT (BALANCE.WHSLOCATIONWAREHOUSEZONECODE='B1' 
                                        OR BALANCE.WHSLOCATIONWAREHOUSEZONECODE='TMP' 
                                        OR BALANCE.WHSLOCATIONWAREHOUSEZONECODE='DOK')";
            $stmt = db2_exec($conn1, $sqld, array('cursor' => DB2_SCROLLABLE));
            $rowd = db2_fetch_assoc($stmt);
            // kalau $conn1 belum ada, komentar 3 baris berikut dan pakai nilai 0
            // $stmt = db2_exec($conn1, $sqld, array('cursor' => DB2_SCROLLABLE));
            // $rowd = $stmt ? db2_fetch_assoc($stmt) : ['JML_ROLL' => 0, 'TBERAT' => 0];
    
            // sementara: kalau DB2 belum dipakai, biar tidak error:
            $rowd['JML_ROLL'] = isset($rowd['JML_ROLL']) ? $rowd['JML_ROLL'] : 0;
            $rowd['TBERAT'] = isset($rowd['TBERAT']) ? $rowd['TBERAT'] : 0;
            ?>
            <tr>
              <td><?php echo $no; ?></td>
              <td><?php echo substr($rowdb21['tgl_bon'], 0, 10); ?></td>
              <td><?php echo $rowdb21['tgl_mutasi']; ?></td>
              <td><?php echo $rowdb21['no_bon']; ?></td>              
              <td><?php echo $rowdb21['langganan']; ?></td>
              <td><?php echo $rowdb21['no_po']; ?></td>
              <td><?php echo $rowdb21['no_order']; ?></td>
              <td><?php echo $rowdb21['jenis_kain']; ?></td>
              <td><?php echo $rowdb21['warna']; ?></td>
              <td><?php echo $rowd['JML_ROLL']; ?></td>
              <td><?php echo number_format($rowd['TBERAT'], 2); ?></td>
              <td><?php echo $rowdb21['berat_tg']; ?></td>
              <td><?php echo $rowdb21['no_lot']; ?></td>
              <td><?php echo $rowdb21['ket']; ?></td>
              <td><?php echo $rowdb21['tempat']; ?></td>
              <td><?php echo $rowdb21['kode_jns_permintaan']; ?></td>
            </tr>
            <?php
            $no++;
            $totJml += $rowd['JML_ROLL'];
            $totKg += $rowd['TBERAT'];
            $totberatTG += $rowdb21['berat_tg'];
          }
        }
      }

    } else {
      // Kalau parameter kosong
      echo '<tr><td colspan="16" style="text-align:center;">
            Parameter tgl1 / tgl2 kosong.
          </td></tr>';
    }
    ?>
  </tbody>
  <tfoot>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><strong>Total</strong></td>
      <td><strong><?php echo $totJml; ?></strong></td>
      <td><strong><?php echo number_format(round($totKg, 2), 2); ?></strong></td>
      <td><strong><?php echo number_format(round($totberatTG, 2), 2); ?></strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>   
      <td>&nbsp;</td>   
    </tr>
  </tfoot>
</table>

<br><br>

    <table style="width: auto;" border="1">
        <tr>
            <td colspan="4"></td>
            <td colspan="3" style="text-align: center;">Dibuat Oleh :</td>
            <td colspan="3" style="text-align: center;">Diperiksa Oleh :</td>
            <td colspan="6" style="text-align: center;">Mengetahui :</td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center;">Nama</td>
            <td colspan="3" style="text-align: center;"></td>
            <td colspan="3" style="text-align: center;"></td>
            <td colspan="6" style="text-align: center;"></td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center;">Jabatan</td>
            <td colspan="3" style="text-align: center;"></td>
            <td colspan="3" style="text-align: center;"></td>
            <td colspan="6" style="text-align: center;"></td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center;">Tanggal</td>
            <td colspan="3" style="text-align: center;"></td>
            <td colspan="3" style="text-align: center;"></td>
            <td colspan="6" style="text-align: center;"></td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center;">Tanda Tangan</td>
            <td colspan="3" style="text-align: center;"><br><br><br><br></td>
            <td colspan="3" style="text-align: center;"></td>
            <td colspan="6" style="text-align: center;"></td>
        </tr>
    </table>