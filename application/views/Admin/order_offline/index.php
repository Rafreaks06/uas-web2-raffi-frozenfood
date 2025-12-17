<div class="container-fluid">

    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('success'); ?>"></div>
    <div class="flash-data-error" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>

    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="card mb-4 shadow-sm border-left-success">
        <div class="card-body py-3">
            <form method="GET" action="">
                <div class="form-row align-items-end">
                    
                    <div class="col-md-3 mb-2 mb-md-0">
                        <label class="small font-weight-bold">Tanggal Awal</label>
                        <input type="date" name="tgl_awal" class="form-control" 
                               value="<?= isset($tgl_awal) ? $tgl_awal : '' ?>">
                    </div>

                    <div class="col-md-3 mb-2 mb-md-0">
                        <label class="small font-weight-bold">Tanggal Akhir</label>
                        <input type="date" name="tgl_akhir" class="form-control" 
                               value="<?= isset($tgl_akhir) ? $tgl_akhir : '' ?>">
                    </div>

                    <div class="col-md-3 mb-2 mb-md-0">
                        <label class="small font-weight-bold">Cari Nama / ID</label>
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control" 
                                   placeholder="Ketikan sesuatu..." 
                                   value="<?= isset($keyword) ? $keyword : '' ?>">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="<?= base_url('admin/order-offline') ?>" class="btn btn-secondary btn-block mt-2">
                            <i class="fas fa-sync"></i> Reset
                        </a>
                    </div>

                </div>
            </form>
            
            <hr>
            
            <div class="text-right">
                <a href="<?= base_url('admin/order-offline/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Transaksi Baru
                </a>
            </div>

        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Customer</th>
                            <th>Tanggal</th>
                            <th>Total Belanja</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        if(!empty($orders)):
                            foreach ($orders as $o): 
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $o->nama_customer ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($o->created_at)) ?></td>
                            <td>Rp <?= number_format($o->total) ?></td>
                            <td>
                                <a href="<?= base_url('admin/order-offline/detail/'.$o->id_order_offline) ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                
                                <a href="<?= base_url('admin/order-offline/delete/'.$o->id_order_offline) ?>" 
                                   class="btn btn-danger btn-sm tombol-hapus">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center">Data tidak ditemukan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // A. Notifikasi Sukses/Gagal (Saat Halaman Reload)
    const flashData = $('.flash-data').data('flashdata');
    const flashDataError = $('.flash-data-error').data('flashdata');

    if (flashData) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: flashData
        });
    }

    if (flashDataError) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: flashDataError
        });
    }

    // B. Konfirmasi Hapus
    $('.tombol-hapus').on('click', function(e) {
        e.preventDefault(); 
        const href = $(this).attr('href');

        Swal.fire({
            title: 'Hapus Transaksi?',
            text: "Data transaksi ini akan dihapus permanen dan stok tidak kembali otomatis (kecuali diatur di sistem).",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href;
            }
        });
    });
</script>