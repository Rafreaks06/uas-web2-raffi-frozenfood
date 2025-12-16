    <!DOCTYPE html>
    <html>
    <head>
        <title><?= $title ?></title>
        <style>
            body { font-family: Arial, sans-serif; font-size: 12px; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th, td { border: 1px solid #000; padding: 8px; }
            th { background-color: #f2f2f2; }
            .text-center { text-align: center; }
            .text-right { text-align: right; }
        </style>
    </head>
    <body onload="window.print()">

        <h2 class="text-center">Laporan Penjualan Frozen Food</h2>
        <p class="text-center">Periode: <?= date('d M Y', strtotime($tgl_awal)) ?> s/d <?= date('d M Y', strtotime($tgl_akhir)) ?></p>
        <hr>

        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Tanggal</th>
                    <th width="20%">Nama Pembeli</th> <th width="10%">Jenis</th>
                    <th>Item Terjual</th>
                    <th width="15%">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1; 
                $grand_total = 0;
                if(empty($laporan)) {
                    echo '<tr><td colspan="6" class="text-center">Data tidak ditemukan</td></tr>';
                } else {
                    foreach($laporan as $row) : 
                        $grand_total += $row->total;
                ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($row->tanggal)) ?></td>
                    
                    <td><?= $row->nama_pembeli ?></td>
                    
                    <td class="text-center"><?= $row->jenis_order ?></td>
                    <td><?= $row->detail_barang ?></td>
                    <td class="text-right">Rp <?= number_format($row->total, 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; } ?>
                <tr>
                    <th colspan="5" class="text-center">Total Pendapatan</th>
                    <th class="text-right">Rp <?= number_format($grand_total, 0, ',', '.') ?></th>
                </tr>
            </tbody>
        </table>

    </body>
    </html>