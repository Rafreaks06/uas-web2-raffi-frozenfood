<div class="container-fluid">

    <h3><?= $title ?></h3>

    <a href="<?= base_url('admin/order-offline/create') ?>" class="btn btn-primary mb-3">
        Tambah Order Offline
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Customer</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($order as $i => $o): ?>
                <tr>
                    <td><?= $i+1 ?></td>
                    <td><?= $o->nama_customer ?></td>
                    <td><?= number_format($o->total) ?></td>
                    <td><?= $o->status ?></td>
                    <td><?= $o->created_at ?></td>
                    <td>
                        <a href="<?= base_url('admin/order-offline/detail/'.$o->id_order_offline) ?>" class="btn btn-info btn-sm">Detail</a>
                        <a onclick="return confirm('Hapus?')" href="<?= base_url('admin/order-offline/delete/'.$o->id_order_offline) ?>" class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

</div>
