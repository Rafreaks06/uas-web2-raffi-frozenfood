<div class="container-fluid mt-3">
    <h4>Riwayat Pesanan Online</h4>
    <a href="<?= base_url('user/order-online/create') ?>" class="btn btn-primary mb-3">Buat Order</a>

    <div class="card shadow p-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Order</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($orders as $o): ?>
                <tr>
                    <td><?= $o->id_order_online ?></td>
                    <td><?= $o->created_at ?></td>
                    <td>Rp <?= number_format($o->total, 0, ',', '.') ?></td>
                    <td><?= $o->status ?></td>
                    <td><a href="<?= base_url('user/order_online/detail/'.$o->id_order_online) ?>">Detail</a>
                </td>

                </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>
</div>
