<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Customer & User</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="example1">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($customer as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row->nama) ?></td>
                        <td><?= $row->no_hp ?></td>
                        <td>
                            <small><?= substr($row->alamat, 0, 50) ?></small>
                        </td>
                        <td class="text-center">
                            <?php if($row->tipe == 'Online'): ?>
                                <span class="badge badge-primary">User Online</span>
                            <?php else: ?>
                                <span class="badge badge-success">Customer Offline</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date('d/m/Y', strtotime($row->created_at)) ?></td>
                        <td>
                            <a href="<?= base_url('admin/customer/detail/'.$row->id_primary.'/'.$row->tipe) ?>" 
                               class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>