<div class="container-fluid">

    <h3><?= $title ?></h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>User</th>
                <th>Total</th>
                <th>Status</th>
                <th>Bukti Bayar</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($orders as $i => $row): ?>
            <tr>
                <td><?= $i+1 ?></td>
                <td><?= $row->username ?></td>
                <td><?= number_format($row->total) ?></td>
                <td>
                    <span class="badge badge-info"><?= $row->status ?></span>
                </td>
                <td>
                    <?php if($row->bukti_bayar): ?>
                        <a href="<?= base_url('assets/bukti/'.$row->bukti_bayar) ?>" target="_blank">
                            Lihat   
                        </a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= base_url('admin/order-online/detail/'.$row->id_order_online) ?>" 
                       class="btn btn-sm btn-primary">
                        Detail
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
