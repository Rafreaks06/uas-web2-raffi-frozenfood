<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3><?= $title ?></h3>
        <a href="<?= base_url('admin/customer') ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    <?php if (!$row): ?>
        <div class="alert alert-danger">Data customer tidak ditemukan.</div>
        <?php return; ?>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-3 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-user"></i> Data Customer</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <tr>
                            <th width="35%">Nama Customer</th>
                            <td><?= htmlspecialchars($row->nama_customer) ?></td>
                        </tr>
                        <tr>
                            <th>No HP</th>
                            <td><?= htmlspecialchars($row->no_hp) ?></td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td><?= nl2br(htmlspecialchars($row->alamat)) ?></td>
                        </tr>
                        <tr>
                            <th>Terdaftar</th>
                            <td><?= date('d M Y', strtotime($row->created_at)) ?></td>
                        </tr>

                        <tr class="bg-light">
                            <td colspan="2" class="text-center font-weight-bold text-muted small">KONEKSI AKUN ONLINE</td>
                        </tr>
                        <tr>
                            <th>Status Akun</th>
                            <td>
                                <?php if(!empty($row->username)): ?>
                                    <span class="badge badge-success">Terhubung Online</span>
                                    <div class="small text-muted mt-1">ID User: <?= $row->id_user ?></div>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Hanya Offline</span>
                                    <small class="d-block text-muted">Belum ditautkan ke akun user</small>
                                <?php endif; ?>
                            </td>
                        </tr>
                        
                        <?php if(!empty($row->username)): ?>
                            <tr>
                                <th>Username</th>
                                <td class="text-primary font-weight-bold"><?= htmlspecialchars($row->username) ?></td>
                            </tr>
                            <tr>
                                <th>Nama Akun</th>
                                <td><?= htmlspecialchars($row->nama_akun_online) ?></td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0 font-weight-bold text-dark">Riwayat Transaksi (Online & Offline)</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%" class="text-center">No</th>
                                    <th width="15%">Tanggal</th>
                                    <th width="10%" class="text-center">Jenis</th>
                                    <th>Detail Barang</th>
                                    <th width="15%">Total</th>
                                    <th width="10%" class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($riwayat)): ?>
                                <?php $no = 1; foreach ($riwayat as $r): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        
                                        <td>
                                            <?= date('d/m/Y', strtotime($r['tanggal'])) ?><br>
                                            <small class="text-muted"><?= date('H:i', strtotime($r['tanggal'])) ?></small>
                                        </td>
                                        
                                        <td class="text-center">
                                            <?php if($r['jenis_order'] == 'Online'): ?>
                                                <span class="badge badge-primary">Online</span>
                                            <?php else: ?>
                                                <span class="badge badge-warning">Offline</span>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <small class="text-dark">
                                                <?= $r['items_string'] ?>
                                            </small>
                                        </td>

                                        <td class="font-weight-bold text-right">
                                            Rp <?= number_format($r['total'], 0, ',', '.') ?>
                                        </td>
                                        
                                        <td class="text-center">
                                            <?php if ($r['status'] == 'Success'): ?>
                                                <span class="badge badge-success">Selesai</span>
                                            <?php elseif ($r['status'] == 'Cancelled'): ?>
                                                <span class="badge badge-danger">Batal</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary"><?= $r['status'] ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        Customer ini belum memiliki riwayat transaksi.
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>