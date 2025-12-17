<div class="container-fluid">

    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('success'); ?>"></div>
    <div class="flash-data-error" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Order Online</h1>
        <a href="<?= base_url('admin/order-online') ?>" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Order Online</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">User / Pemesan</th>
                    <td><?= $order->nama_lengkap ?></td>
                </tr>
                
                <tr>
                    <th>No HP / WhatsApp</th>
                    <td>
                        <?php if(!empty($order->no_hp)): ?>
                            <?= $order->no_hp ?> 
                            <a href="https://wa.me/<?= '62'.ltrim($order->no_hp, '0') ?>" target="_blank" class="badge badge-success ml-2">
                                <i class="fab fa-whatsapp"></i> Chat WA
                            </a>
                        <?php else: ?>
                            <span class="text-danger">Tidak ada nomor HP</span>
                        <?php endif; ?>
                    </td>
                </tr>

                <tr>
                    <th>Alamat Pengiriman</th>
                    <td>
                        <?php if(!empty($order->alamat)): ?>
                            <?= $order->alamat ?>
                        <?php else: ?>
                            <span class="text-danger font-italic">Alamat belum diisi oleh user.</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>Total</th>
                    <td>Rp <?= number_format($order->total) ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <?php 
                            $badge = 'secondary';
                            if($order->status == 'Success') $badge = 'success';
                            if($order->status == 'Pending') $badge = 'warning';
                            if($order->status == 'Cancelled') $badge = 'danger';
                        ?>
                        <span class="badge badge-<?= $badge ?>"><?= $order->status ?></span>
                    </td>
                </tr>
                <tr>
                    <th>Bukti Pembayaran</th>
                    <td>
                        <?php if($order->bukti_bayar): ?>
                            <img src="<?= base_url('assets/bukti/'.$order->bukti_bayar) ?>" 
                                 style="max-width: 300px; border: 1px solid #ddd; padding: 5px; border-radius: 5px; cursor: pointer;"
                                 onclick="Swal.fire({
                                     imageUrl: '<?= base_url('assets/bukti/'.$order->bukti_bayar) ?>',
                                     imageAlt: 'Bukti Bayar',
                                     showConfirmButton: false,
                                     width: 600
                                 })">
                             <br><small class="text-muted">*Klik gambar untuk memperbesar</small>
                        <?php else: ?>
                            <span class="text-muted">Belum upload bukti bayar.</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Produk</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
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
                        <?php foreach($detail as $d): ?>
                        <tr>
                            <td><?= $d->nama_produk ?></td>
                            <td><?= $d->qty ?></td>
                            <td>Rp <?= number_format($d->harga) ?></td>
                            <td>Rp <?= number_format($d->subtotal) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <?php if($order->status == 'Pending'): ?>
    <div class="row mb-4">
        <div class="col-md-6">
            <a href="<?= base_url('admin/order-online/verifikasi/'.$order->id_order_online) ?>" 
               class="btn btn-success btn-block tombol-verifikasi">
               <i class="fas fa-check"></i> Verifikasi Lunas
            </a>
        </div>
        <div class="col-md-6">
            <a href="<?= base_url('admin/order-online/tolak/'.$order->id_order_online) ?>" 
               class="btn btn-danger btn-block tombol-tolak">
               <i class="fas fa-times"></i> Tolak Pesanan
            </a>
        </div>
    </div>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // A. Notifikasi Sukses/Gagal (Flashdata)
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

    // B. Konfirmasi Verifikasi (Tombol Hijau)
    $('.tombol-verifikasi').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');

        Swal.fire({
            title: 'Verifikasi Pembayaran?',
            text: "Pastikan uang sudah masuk mutasi rekening. Status order akan berubah menjadi Lunas/Success.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1cc88a', // Hijau (Success Bootstrap)
            cancelButtonColor: '#858796', // Abu-abu
            confirmButtonText: 'Ya, Verifikasi!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href;
            }
        });
    });

    // C. Konfirmasi Tolak (Tombol Merah)
    $('.tombol-tolak').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');

        Swal.fire({
            title: 'Tolak Pesanan?',
            text: "Pesanan ini akan dibatalkan dan stok produk akan dikembalikan ke sistem.",
            icon: 'warning', // Ikon Segitiga Kuning
            showCancelButton: true,
            confirmButtonColor: '#e74a3b', // Merah (Danger Bootstrap)
            cancelButtonColor: '#858796',
            confirmButtonText: 'Ya, Tolak Pesanan!',
            cancelButtonText: 'Tidak Jadi'
        }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href;
            }
        });
    });
</script>