<div class="container-fluid mt-3">

    <h4>Buat Order Online</h4>
    <hr>

    <div class="card shadow p-4">

        <form action="<?= base_url('user/order-online/store'); ?>" 
              method="POST" 
              enctype="multipart/form-data">

            <!-- PILIH PRODUK -->
            <div class="form-group mb-3">
                <label>Pilih Produk</label>
                <select name="id_produk" class="form-control" id="produkSelect" required>
                    <option value="">-- Pilih Produk --</option>
                    <?php foreach($produk as $p): ?>
                        <option 
                            value="<?= $p->id_produk ?>"
                            data-img="<?= base_url('assets/Uploads/Produk/'.$p->gambar) ?>"
                            data-harga="<?= $p->harga ?>"
                        >
                            <?= $p->nama_produk ?> - Rp <?= number_format($p->harga) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- GAMBAR PRODUK -->
            <div class="form-group mb-3" id="previewProduk" style="display:none;">
                <label>Preview Produk</label><br>

                <img id="gambarProduk" src="" 
                     alt="Gambar Produk" 
                     style="max-width:250px; border:1px solid #ccc; border-radius:5px; cursor:pointer;">
            </div>

            <!-- JUMLAH -->
            <div class="form-group mb-3">
                <label>Jumlah</label>
                <input type="number" name="qty" class="form-control" min="1" required>
            </div>

            <!-- GAMBAR REKENING -->
            <div class="form-group mb-3">
                <label>Rekening Pembayaran</label><br>

                <img src="<?= base_url('assets/Uploads/rekening/Rekening.png') ?>" 
                     alt="Rekening Pembayaran"
                     style="max-width:300px; border:1px solid #ddd; border-radius:5px; cursor:pointer;"
                     onclick="showPopup(this.src)">

                <p class="mt-2 mb-0">
                    Silakan transfer ke rekening di atas, lalu upload bukti pembayarannya.
                </p>
            </div>

            <!-- UPLOAD BUKTI -->
            <div class="form-group mb-3">
                <label>Upload Bukti Bayar</label>
                <input type="file" name="bukti_bayar" class="form-control" required>
            </div>

            <button class="btn btn-success">Kirim Order</button>

        </form>

    </div>

</div>

<!-- POPUP GAMBAR -->
<div id="imgPopup" 
     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
            background:rgba(0,0,0,0.8); justify-content:center; align-items:center; z-index:9999;">

    <img id="popupImage" src="" style="max-width:90%; max-height:90%; border:3px solid white; border-radius:10px;">
</div>

<!-- SCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('produkSelect').addEventListener('change', function() {
    let img = this.options[this.selectedIndex].getAttribute('data-img');

    if (img) {
        document.getElementById('previewProduk').style.display = 'block';
        document.getElementById('gambarProduk').src = img;
    } else {
        document.getElementById('previewProduk').style.display = 'none';
    }
});

// Cek apakah ada flashdata error_stok dari Controller
    <?php if ($this->session->flashdata('error_stok')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Stok Habis / Kurang',
            text: '<?= $this->session->flashdata('error_stok'); ?>',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Oke, Saya Ganti Jumlahnya'
        });
    <?php endif; ?>

    // Cek error upload
    <?php if ($this->session->flashdata('error_upload')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal Upload',
            text: '<?= strip_tags($this->session->flashdata('error_upload')); ?>'
        });
    <?php endif; ?>

// Klik gambar produk → buka popup
document.getElementById('gambarProduk').addEventListener('click', function() {
    showPopup(this.src);
});

// Fungsi popup
function showPopup(src) {
    document.getElementById('popupImage').src = src;
    document.getElementById('imgPopup').style.display = 'flex';
}

// Klik luar gambar → close popup
document.getElementById('imgPopup').addEventListener('click', function(e) {
    if (e.target.id === 'imgPopup') {
        this.style.display = 'none';
    }
});
</script>
