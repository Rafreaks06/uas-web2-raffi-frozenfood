<!DOCTYPE html>
<html>
<head>
    <title>Cetak Struk - Raffi Frozen Food</title>
    <style>
        body { font-family: monospace; font-size: 12px; }
        .container { width: 300px; margin: 0 auto; } /* Lebar struk */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .line { border-bottom: 1px dashed #000; margin: 5px 0; }
        table { width: 100%; font-size: 12px; }
    </style>
</head>
<body onload="window.print()"> 
    <div class="container">
        <div class="text-center">
            <h3>RAFFI FROZEN FOOD</h3>
            <p>Jln. Raya No. 123, Kota Tangerang<br>
            WA: 0812-2365-6546</p>
        </div>

        <div class="line"></div>

        <table>
            <tr>
                <td>Tgl: <?= date('d/m/Y H:i', strtotime($order->created_at)) ?></td>
            </tr>
            <tr>
                <td>Cust: <?= $order->nama_customer ?></td>
            </tr>
        </table>

        <div class="line"></div>

        <table>
            <?php foreach($detail as $d): ?>
            <tr>
                <td colspan="2"><?= $d->nama_produk ?></td>
            </tr>
            <tr>
                <td><?= $d->qty ?> x <?= number_format($d->subtotal / $d->qty, 0, ',', '.') ?></td>
                <td class="text-right"><?= number_format($d->subtotal, 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <div class="line"></div>

        <table>
            <tr>
                <td><strong>TOTAL</strong></td>
                <td class="text-right"><strong>Rp <?= number_format($order->total, 0, ',', '.') ?></strong></td>
            </tr>
        </table>

        <div class="line"></div>
        <div class="text-center">
            <p>Terima Kasih<br>Selamat Belanja Kembali</p>
        </div>
    </div>

</body>
</html>