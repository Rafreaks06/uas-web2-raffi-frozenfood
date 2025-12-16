<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Data</h1>
        <a href="<?= base_url('admin/customer') ?>" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="row">

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 border-bottom-primary">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Profil</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img class="img-profile rounded-circle" src="<?= base_url('assets/sbadmin/images/undraw_profile.svg') ?>" style="width: 100px;">
                    </div>
                    
                    <table class="table table-borderless">
                        <tr>
                            <th width="35%">Nama</th>
                            <td>: <strong><?= $row->nama_customer ?></strong></td>
                        </tr>
                        <tr>
                            <th>Tipe</th>
                            <td>: 
                                <?php if(isset($row->tipe) && $row->tipe == 'Online'): ?>
                                    <span class="badge badge-primary">User Online</span>
                                <?php else: ?>
                                    <span class="badge badge-success">Customer Offline</span>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <?php if(isset($row->tipe) && $row->tipe == 'Online'): ?>
                            <tr>
                                <th>No HP</th>
                                <td>: <?= $row->no_hp ?></td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>: <?= $row->alamat ?></td>
                            </tr>
                        <?php endif; ?>

                        <tr>
                            <th>Terdaftar</th>
                            <td>: <?= date('d M Y', strtotime($row->created_at)) ?></td>
                        </tr>

                        <?php if(!empty($row->username)): ?>
                        <tr>
                            <td colspan="2"><hr></td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td>: <?= $row->username ?></td>
                        </tr>
                        <?php endif; ?>
                    </table>

                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Transaksi</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Detail Barang</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($riwayat as $r): ?>
                                <tr>
                                    <td><?= date('d/m/Y H:i', strtotime($r['tanggal'])) ?></td>
                                    <td class="text-center">
                                        <?php if($r['jenis_order'] == 'Online'): ?>
                                            <span class="badge badge-primary">Online</span>
                                        <?php else: ?>
                                            <span class="badge badge-warning">Offline</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="small"><?= $r['items_string'] ?></td>
                                    <td>Rp <?= number_format($r['total']) ?></td>
                                    <td class="text-center">
                                        <?php 
                                            $badge = 'secondary';
                                            if($r['status'] == 'Success') $badge = 'success';
                                            if($r['status'] == 'Pending') $badge = 'warning';
                                            if($r['status'] == 'Cancelled') $badge = 'danger';
                                        ?>
                                        <span class="badge badge-<?= $badge ?>"><?= $r['status'] ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>

                                <?php if(empty($riwayat)): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada riwayat transaksi.</td>
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