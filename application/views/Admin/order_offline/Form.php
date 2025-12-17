<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Tambah Transaksi Offline</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            
            <form action="<?= base_url('admin/order-offline/store') ?>" method="POST">
                
                <div class="mb-3">
                <label for="nama_customer" class="form-label">Nama Customer</label>
                <input type="text" 
                    class="form-control" 
                    id="customer_name" 
                    name="customer_name" 
                    placeholder="Contoh: Budi Santoso / Ibu Ani" 
                    required>
                <small class="text-muted">Masukkan nama pembeli untuk pesanan offline (Walk-in).</small>
                </div>

                <div class="form-group">
                    <label>Pilih Produk</label>
                    <select name="id_produk" id="id_produk" class="form-control" required>
                        <option value="" data-harga="0" data-stok="0">-- Pilih Produk --</option>
                        <?php foreach($produk as $p): ?>
                            <option value="<?= $p->id_produk ?>" 
                                    data-harga="<?= $p->harga ?>"
                                    data-stok="<?= $p->stok ?>"
                                    <?= ($p->stok <= 0) ? 'disabled style="background-color:#ffeeba;"' : '' ?>>
                                <?= $p->nama_produk ?> (Stok: <?= $p->stok ?>) <?= ($p->stok <= 0) ? '- HABIS' : '' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="alert alert-info" id="info_stok" style="display:none;">
                    Harga Satuan: <strong>Rp <span id="harga_display">0</span></strong> <br>
                    Sisa Stok Tersedia: <strong><span id="stok_display">0</span></strong>
                </div>

                <div class="form-group">
                    <label>Jumlah Beli (Qty)</label>
                    <input type="number" name="qty" id="qty" class="form-control" min="1" value="1" required disabled>
                    <small class="text-danger font-weight-bold" id="qty_warning" style="display:none;">
                        * Jumlah melebihi stok yang tersedia!
                    </small>
                </div>

                <div class="form-group">
                    <label>Total Harga</label>
                    <input type="text" id="total_display" class="form-control" value="Rp 0" readonly>
                </div>

                <button type="submit" id="btn_submit" class="btn btn-primary" disabled>Simpan Transaksi</button>
                <a href="<?= base_url('admin/order-offline') ?>" class="btn btn-secondary">Batal</a>

            </form>

        </div>
    </div>

</div>

<script>
    const produkSelect = document.getElementById('id_produk');
    const qtyInput     = document.getElementById('qty');
    const infoStok     = document.getElementById('info_stok');
    const stokDisplay  = document.getElementById('stok_display');
    const hargaDisplay = document.getElementById('harga_display');
    const totalDisplay = document.getElementById('total_display');
    const qtyWarning   = document.getElementById('qty_warning');
    const btnSubmit    = document.getElementById('btn_submit');

    let stokSaatIni = 0;
    let hargaSaatIni = 0;

    // SAAT PRODUK DIPILIH
    produkSelect.addEventListener('change', function() {
        // Ambil data dari atribut <option>
        const selectedOption = this.options[this.selectedIndex];
        stokSaatIni  = parseInt(selectedOption.getAttribute('data-stok')) || 0;
        hargaSaatIni = parseInt(selectedOption.getAttribute('data-harga')) || 0;

        if (hargaSaatIni > 0) {
            // Tampilkan Info
            infoStok.style.display = 'block';
            stokDisplay.innerText  = stokSaatIni;
            hargaDisplay.innerText = new Intl.NumberFormat('id-ID').format(hargaSaatIni);

            // Aktifkan Input Qty
            qtyInput.disabled = false;
            qtyInput.max = stokSaatIni; // Set max html attribute
            qtyInput.value = 1;
            
            hitungTotal();
        } else {
            resetForm();
        }
    });

    // SAAT QTY DIKETIK
    qtyInput.addEventListener('input', function() {
        hitungTotal();
    });

    function hitungTotal() {
        let qty = parseInt(qtyInput.value) || 0;

        // Validasi Stok
        if (qty > stokSaatIni) {
            qtyWarning.style.display = 'block';
            btnSubmit.disabled = true;
            totalDisplay.value = "Stok Tidak Cukup!";
        } else if (qty <= 0) {
            btnSubmit.disabled = true;
            totalDisplay.value = "Rp 0";
        } else {
            qtyWarning.style.display = 'none';
            btnSubmit.disabled = false;
            let total = hargaSaatIni * qty;
            totalDisplay.value = "Rp " + new Intl.NumberFormat('id-ID').format(total);
        }
    }

    function resetForm() {
        infoStok.style.display = 'none';
        qtyInput.disabled = true;
        qtyInput.value = '';
        btnSubmit.disabled = true;
        totalDisplay.value = "Rp 0";
    }
</script>