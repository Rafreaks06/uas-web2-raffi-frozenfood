<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Penjualan_" . date('d-m-Y') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan Excel</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 5px; }
        th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>
<body>

    <center>
        <h3>Laporan Penjualan Frozen Food</h3>
        <p>Periode: <?= date('d M Y', strtotime($tgl_awal)) ?> s/d <?= date('d M Y', strtotime($tgl_akhir)) ?></p>
    </center>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="20%">Nama Pembeli</th> <th width="10%">Jenis</th>
                <th width="35%">Item Terjual</th>
                <th width="15%">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1; 
            $grand_total = 0;
            
            if(empty($laporan)) {
                echo '<tr><td colspan="6" class="text-center">Tidak ada data transaksi.</td></tr>';
            } else {
                foreach($laporan as $row) : 
                    $grand_total += $row->total;
            ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td class="text-center"><?= date('d/m/Y H:i', strtotime($row->tanggal)) ?></td>
                
                <td><?= $row->nama_pembeli ?></td>

                <td class="text-center"><?= $row->jenis_order ?></td>
                <td><?= $row->detail_barang ?></td>
                <td class="text-right">Rp <?= number_format($row->total, 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; } ?>

            <tr>
                <td colspan="5" class="text-center" style="font-weight:bold; background-color:#eee;">GRAND TOTAL</td>
                <td class="text-right" style="font-weight:bold; background-color:#eee;">
                    Rp <?= number_format($grand_total, 0, ',', '.') ?>
                </td>
            </tr>
        </tbody>
    </table>

</body>
</html>