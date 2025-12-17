<div class="container-fluid mt-3">

    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('success'); ?>"></div>
    <div class="flash-data-error" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Detail Order Online</h4>
        <a href="<?= base_url('user/order-online') ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    
    <hr>

    <div class="card shadow p-4">

        <div class="row">
            <div class="col-md-6">
                <h5>Status: 
                    <?php 
                        $badge = 'secondary';
                        if($order->status == 'Success') $badge = 'success';
                        elseif($order->status == 'Pending') $badge = 'warning';
                        elseif($order->status == 'Cancelled') $badge = 'danger';
                    ?>
                    <span class="badge badge-<?= $badge ?>"><?= $order->status ?></span>
                </h5>
                <p><strong>Tanggal:</strong> <?= date('d F Y H:i', strtotime($order->created_at)) ?></p>
            </div>
            
            <div class="col-md-6 text-right">
                <?php if ($order->status == 'Pending'): ?>
                    <a href="<?= base_url('user/order-online/cancel/' . $order->id_order_online) ?>" 
                       class="btn btn-danger tombol-batal">
                        <i class="fas fa-times"></i> Batalkan Pesanan
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <hr>
        <p><strong>Bukti Bayar:</strong></p>
        <?php if (!empty($order->bukti_bayar)): ?>
            <img src="<?= base_url('assets/bukti/'.$order->bukti_bayar) ?>"
                 alt="Bukti Bayar"
                 class="img-thumbnail"
                 style="max-width:300px; cursor: pointer;"
                 onclick="Swal.fire({
                     imageUrl: '<?= base_url('assets/bukti/'.$order->bukti_bayar) ?>',
                     imageAlt: 'Bukti Bayar',
                     showConfirmButton: false
                 })">
                 <?php else: ?>
            <p class="text-muted">Belum ada bukti bayar.</p>
        <?php endif; ?>

        <hr>

        <h5>Produk Dibeli</h5>

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
                <?php foreach($items as $i): ?>
                <tr>
                    <td><?= $i->nama_produk ?></td>
                    <td><?= $i->qty ?></td>
                    <td>Rp <?= number_format($i->subtotal / $i->qty) ?></td>
                    <td>Rp <?= number_format($i->subtotal) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h4 class="text-right mt-3">
            Total: <strong>Rp <?= number_format($order->total) ?></strong>
        </h4>

    </div>

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

    // B. Konfirmasi Batalkan Pesanan
    $('.tombol-batal').on('click', function(e) {
        e.preventDefault(); // Tahan dulu link-nya
        
        const href = $(this).attr('href'); // Ambil link tujuan

        Swal.fire({
            title: 'Batalkan Pesanan?',
            text: "Apakah Anda yakin? Stok barang yang sudah dipesan akan dikembalikan ke sistem.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33', // Merah untuk tombol konfirmasi delete/cancel
            cancelButtonColor: '#3085d6', // Biru untuk batal
            confirmButtonText: 'Ya, Batalkan!',
            cancelButtonText: 'Tidak Jadi'
        }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href; // Lanjut ke link pembatalan
            }
        });
    });
</script>