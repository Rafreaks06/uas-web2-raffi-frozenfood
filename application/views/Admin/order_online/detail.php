<div class="container-fluid">

    <h3><?= $title ?></h3>

    <h5>Data Order Online</h5>
    <table class="table table-bordered">
        <tr><th>User</th><td><?= $order->username ?></td></tr>
        <tr><th>Total</th><td><?= number_format($order->total) ?></td></tr>
        <tr><th>Status</th><td><?= $order->status ?></td></tr>
        <tr>
            <th>Bukti Pembayaran</th>
            <td>
                <?php if ($order->bukti_bayar): ?>
                    <img src="<?= base_url('assets/bukti/'.$order->bukti_bayar) ?>" width="200">
                <?php else: ?>
                    <i>Tidak ada</i>
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <h5>Detail Produk</h5>
    <table class="table table-bordered">
        <tr>
            <th>Produk</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Subtotal</th>
        </tr>

        <?php foreach ($detail as $d): ?>
        <tr>
            <td><?= $d->nama_produk ?></td>
            <td><?= $d->qty ?></td>
            <td><?= number_format($d->subtotal / $d->qty) ?></td>
            <td><?= number_format($d->subtotal) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <br>

    <?php if ($order->status == 'Pending'): ?>
        <a href="<?= base_url('admin/order-online/verifikasi/'.$order->id_order_online) ?>" 
           class="btn btn-success">Verifikasi Pembayaran</a>

        <a href="<?= base_url('admin/order-online/tolak/'.$order->id_order_online) ?>" 
           class="btn btn-danger">Tolak</a>
    <?php endif; ?>

    <a href="<?= base_url('admin/order-online') ?>" class="btn btn-secondary">Kembali</a>

</div>