<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="card mb-4 shadow-sm border-left-primary">
        <div class="card-body py-2">
            <form method="GET" action="">
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <label class="font-weight-bold m-0"><i class="fas fa-filter"></i> Filter Status:</label>
                    </div>
                    <div class="col-auto">
                        <select name="filter" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="">-- Tampilkan Semua --</option>
                            <option value="online" <?= isset($selected_filter) && $selected_filter == 'online' ? 'selected' : '' ?>>User Online</option>
                            <option value="offline" <?= isset($selected_filter) && $selected_filter == 'offline' ? 'selected' : '' ?>>Customer Offline</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        // Looping data gabungan dari Model
                        foreach ($customer as $row): 
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row->nama ?></td>
                            <td><?= $row->no_hp ?></td>
                            <td><?= $row->alamat ?></td>
                            <td>
                                <span class="badge badge-<?= $row->badge_color ?>">
                                    <?= $row->badge_label ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y', strtotime($row->tanggal)) ?></td>
                            <td>
                                <a href="<?= base_url('admin/customer/detail/' . $row->id . '/' . $row->tipe) ?>" 
                                   class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                        <?php if(empty($customer)): ?>
                            <tr>
                                <td colspan="7" class="text-center">Data tidak ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>