<div class="container-fluid mt-3">

    <h4>Buat Order Online</h4>
    <hr>

    <div class="card shadow p-4">

        <form action="<?= base_url('user/order-online/store'); ?>" method="POST" enctype="multipart/form-data">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Pilih Produk</label>
                        <select name="id_produk" class="form-control" id="produkSelect" required>
                            <option value="" data-stok="0" data-harga="0">-- Pilih Produk --</option>
                            <?php foreach($produk as $p): ?>
                                <option 
                                    value="<?= $p->id_produk ?>"
                                    data-img="<?= base_url('assets/Uploads/Produk/'.$p->gambar) ?>"
                                    data-harga="<?= $p->harga ?>"
                                    data-stok="<?= $p->stok ?>"
                                    <?= ($p->stok <= 0) ? 'disabled style="color:red;"' : '' ?>
                                >
                                    <?= $p->nama_produk ?> <?= ($p->stok <= 0) ? '(Habis)' : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="alert alert-info" id="infoProduk" style="display:none;">
                        Harga: <strong>Rp <span id="displayHarga">0</span></strong> | 
                        Sisa Stok: <strong><span id="displayStok">0</span></strong>
                    </div>

                    <div class="form-group mb-3" id="previewProduk" style="display:none;">
                        <img id="gambarProduk" src="" style="max-width:150px; border-radius:5px; border:1px solid #ddd;">
                    </div>

                    <div class="form-group mb-3">
                        <label>Jumlah Pesanan (Qty)</label>
                        <input type="number" name="qty" id="qtyInput" class="form-control" min="1" value="1" required disabled>
                        <small class="text-danger font-weight-bold" id="stokWarning" style="display:none;">
                            * Jumlah melebihi stok yang tersedia!
                        </small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card bg-light mb-3 text-center">
                        <div class="card-body">
                            <h5>Total Bayar:</h5>
                            <h2 class="text-success font-weight-bold">Rp <span id="grandTotal">0</span></h2>
                            <p class="mb-0 text-muted small">*Silakan transfer sesuai nominal ini</p>
                        </div>
                    </div>

                    <div class="form-group mb-3 text-center">
                        <label>Rekening Pembayaran</label><br>
                        <img src="<?= base_url('assets/Uploads/rekening/Rekening.png') ?>" 
                             alt="Rekening" 
                             style="max-width: 250px; cursor:pointer; border:1px solid #ccc; border-radius:4px;"
                             onclick="showPopup(this.src)">
                    </div>

                    <div class="form-group mb-3">
                        <label>Upload Bukti Bayar</label>
                        <input type="file" name="bukti_bayar" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success btn-block btn-lg" id="btnSubmit" disabled>
                        <i class="fas fa-paper-plane"></i> Kirim Order
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

<div id="imgPopup" onclick="this.style.display='none'"
     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
            background:rgba(0,0,0,0.8); justify-content:center; align-items:center; z-index:9999;">
    <img id="popupImage" src="" style="max-width:90%; max-height:90%; border:3px solid white; border-radius:10px;">
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const produkSelect = document.getElementById('produkSelect');
    const qtyInput     = document.getElementById('qtyInput');
    const grandTotal   = document.getElementById('grandTotal');
    const btnSubmit    = document.getElementById('btnSubmit');
    const stokWarning  = document.getElementById('stokWarning');
    const displayStok  = document.getElementById('displayStok');
    const displayHarga = document.getElementById('displayHarga');
    const infoProduk   = document.getElementById('infoProduk');
    const previewBox   = document.getElementById('previewProduk');
    const gambarProduk = document.getElementById('gambarProduk');
    const uploadInput  = document.querySelector('input[name="bukti_bayar"]');

    let harga = 0;
    let stok  = 0;

    // 1. SAAT PILIH PRODUK
    produkSelect.addEventListener('change', function() {
        let option = this.options[this.selectedIndex];
        harga = parseInt(option.getAttribute('data-harga')) || 0;
        stok  = parseInt(option.getAttribute('data-stok')) || 0;
        let img = option.getAttribute('data-img');

        if(harga > 0) {
            infoProduk.style.display = 'block';
            displayHarga.innerText   = new Intl.NumberFormat('id-ID').format(harga);
            displayStok.innerText    = stok;
            
            previewBox.style.display = 'block';
            gambarProduk.src         = img;

            qtyInput.disabled = false;
            qtyInput.max      = stok;
            qtyInput.value    = 1;
            
            hitung();
        } else {
            reset();
        }
    });

    // 2. SAAT UBAH QTY
    qtyInput.addEventListener('input', function() {
        hitung();
    });

    function hitung() {
        let qty = parseInt(qtyInput.value) || 0;

        // Validasi Stok
        if(qty > stok) {
            stokWarning.style.display = 'block';
            btnSubmit.disabled = true;
            grandTotal.innerText = '0 (Stok Kurang)';
        } else if(qty <= 0) {
            btnSubmit.disabled = true;
            grandTotal.innerText = '0';
        } else {
            stokWarning.style.display = 'none';
            btnSubmit.disabled = false;
            let total = harga * qty;
            grandTotal.innerText = new Intl.NumberFormat('id-ID').format(total);
        }
    }

    function reset() {
        infoProduk.style.display = 'none';
        previewBox.style.display = 'none';
        qtyInput.disabled = true;
        qtyInput.value = '';
        btnSubmit.disabled = true;
        grandTotal.innerText = '0';
        stokWarning.style.display = 'none';
    }

    function showPopup(src) {
        document.getElementById('popupImage').src = src;
        document.getElementById('imgPopup').style.display = 'flex';
    }

    // --- PERBAIKAN SYNTAX DI SINI ---
    uploadInput.addEventListener('change', function() {
        const file = this.files[0];
        const maxSize = 2 * 1024 * 1024; // 2MB dalam bytes

        if (file) {
            if (file.size > maxSize) {
                Swal.fire({
                    icon: 'warning',
                    title: 'File Terlalu Besar',
                    text: 'Maksimal ukuran file adalah 2MB. Silakan kompres atau pilih file lain.',
                });
                this.value = ''; 
            }
        }
    });
</script>