<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="card mb-4 shadow-sm border-left-info">
        <div class="card-body py-2">
            <form method="GET" action="">
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <label class="font-weight-bold m-0"><i class="fas fa-filter"></i> Filter Status:</label>
                    </div>
                    <div class="col-auto">
                        <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="">-- Semua Pesanan --</option>
                            <option value="Pending"   <?= (isset($selected_status) && $selected_status == 'Pending') ? 'selected' : '' ?>>Pending (Menunggu)</option>
                            <option value="Success"   <?= (isset($selected_status) && $selected_status == 'Success') ? 'selected' : '' ?>>Success (Selesai)</option>
                            <option value="Cancelled" <?= (isset($selected_status) && $selected_status == 'Cancelled') ? 'selected' : '' ?>>Cancelled (Dibatalkan)</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi Masuk</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>User</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Bukti Bayar</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        foreach ($orders as $o): 
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $o->nama_lengkap ?></td>
                            <td>Rp <?= number_format($o->total) ?></td>
                            <td class="text-center">
                                <?php 
                                    $badge = 'secondary';
                                    if($o->status == 'Success') $badge = 'success';
                                    if($o->status == 'Pending') $badge = 'warning';
                                    if($o->status == 'Cancelled') $badge = 'danger';
                                ?>
                                <span class="badge badge-<?= $badge ?>"><?= $o->status ?></span>
                            </td>
                            <td class="text-center">
                                <?php if($o->bukti_bayar): ?>
                                    <a href="<?= base_url('assets/bukti/'.$o->bukti_bayar) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-image"></i> Lihat
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted small">Belum upload</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/order-online/detail/'.$o->id_order_online) ?>" class="btn btn-info btn-sm btn-block">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                        <?php if(empty($orders)): ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data pesanan untuk status ini.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>