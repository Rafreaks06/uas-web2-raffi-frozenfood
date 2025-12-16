<div class="container-fluid mt-3">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Detail Order Online</h4>
        <a href="<?= base_url('user/order-online') ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    
    <hr>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <div class="card shadow p-4">

        <div class="row">
            <div class="col-md-6">
                <h5>Status: 
                    <?php 
                        $badge = 'secondary';
                        if($order->status == 'Success') $badge = 'success';
                        elseif($order->status == 'Pending') $badge = 'warning';
                        elseif($order->status == 'Cancelled') $badge = 'danger';
                    ?>
                    <span class="badge badge-<?= $badge ?>"><?= $order->status ?></span>
                </h5>
                <p><strong>Tanggal:</strong> <?= date('d F Y H:i', strtotime($order->created_at)) ?></p>
            </div>
            
            <div class="col-md-6 text-right">
                <?php if ($order->status == 'Pending'): ?>
                    <a href="<?= base_url('user/order-online/cancel/' . $order->id_order_online) ?>" 
                       class="btn btn-danger"
                       onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini? Stok barang akan dikembalikan.')">
                        <i class="fas fa-times"></i> Batalkan Pesanan
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <hr>
        <p><strong>Bukti Bayar:</strong></p>
        <?php if (!empty($order->bukti_bayar)): ?>
            <img src="<?= base_url('assets/bukti/'.$order->bukti_bayar) ?>"
                 alt="Bukti Bayar"
                 style="max-width:300px; border:1px solid #ddd; border-radius:5px;">
        <?php else: ?>
            <p class="text-muted">Belum ada bukti bayar.</p>
        <?php endif; ?>

        <hr>

        <h5>Produk Dibeli</h5>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($items as $i): ?>
                <tr>
                    <td><?= $i->nama_produk ?></td>
                    <td><?= $i->qty ?></td>
                    <td>Rp <?= number_format($i->subtotal / $i->qty) ?></td>
                    <td>Rp <?= number_format($i->subtotal) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h4 class="text-right mt-3">
            Total: <strong>Rp <?= number_format($order->total) ?></strong>
        </h4>

    </div>

</div>