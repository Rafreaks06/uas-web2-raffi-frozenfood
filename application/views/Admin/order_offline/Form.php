<div class="container-fluid">

    <h3><?= $title ?></h3>
    <form action="<?= base_url('admin/order-offline/store') ?>" method="POST">

        <h5>Data Customer</h5>
        <div class="form-group">
            <label>Nama Customer</label>
            <input type="text" name="nama_customer" class="form-control" required>
        </div>
        <hr>
        <h5>Detail Order</h5>

        <table class="table" id="produkTable">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody id="produkBody">
                <tr class="item-row">
                    <td>
                        <select name="produk[]" class="form-control produkSelect" required>
                            <option value="">-- Pilih Produk --</option>
                            <?php foreach ($produk as $p): ?>
                                <option value="<?= $p->id_produk ?>" data-harga="<?= $p->harga ?>">
                                    <?= $p->nama_produk ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="number" class="form-control qty" name="qty[]" value="1" min="1"></td>
                    <td><input type="text" class="form-control harga" readonly></td>
                    <td><input type="text" class="form-control subtotal" name="subtotal[]" readonly></td>
                    <td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>
                </tr>
            </tbody>
        </table>

        <button type="button" class="btn btn-info btn-sm" id="addRow">+ Tambah Baris</button>

        <div class="form-group mt-3">
            <label>Total</label>
            <input type="text" name="total" id="total" class="form-control" readonly>
        </div>

        <button class="btn btn-success">Simpan Transaksi</button>
        <a href="<?= base_url('admin/order-offline') ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    
const tbody = document.getElementById('produkBody');

function hitung() {
    let total = 0;

    tbody.querySelectorAll('.item-row').forEach(row => {
        const harga = parseInt(row.querySelector('.harga').value || 0, 10);
        const qty   = parseInt(row.querySelector('.qty').value   || 0, 10);
        const subtotal = harga * qty;

        row.querySelector('.subtotal').value = subtotal;
        total += subtotal;
    });

    document.getElementById('total').value = total;
}

// change produk => isi harga + hitung
document.addEventListener('change', function(e){
    if (e.target.classList.contains('produkSelect')) {
        const option = e.target.selectedOptions[0];
        const harga  = option ? option.dataset.harga || 0 : 0;
        const row    = e.target.closest('.item-row');

        row.querySelector('.harga').value = harga;
        hitung();
    }
});

// ubah qty => hitung ulang
document.addEventListener('input', function(e){
    if (e.target.classList.contains('qty')) {
        hitung();
    }
});

<?php if ($this->session->flashdata('error_stok')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Ups, Stok Kurang!',
            text: '<?= $this->session->flashdata('error_stok'); ?>',
            footer: 'Silakan kurangi jumlah qty atau update stok produk dulu.'
        });
    <?php endif; ?>

// tambah baris
document.getElementById('addRow').addEventListener('click', function () {
    const firstRow = tbody.querySelector('.item-row');
    const newRow   = firstRow.cloneNode(true);

    // reset nilai di baris baru
    newRow.querySelector('.produkSelect').value = '';
    newRow.querySelector('.harga').value        = '';
    newRow.querySelector('.qty').value          = 1;
    newRow.querySelector('.subtotal').value     = '';

    tbody.appendChild(newRow);
});

// hapus baris
document.addEventListener('click', function(e){
    if (e.target.classList.contains('removeRow')) {
        const rows = tbody.querySelectorAll('.item-row');
        if (rows.length > 1) {
            e.target.closest('.item-row').remove();
            hitung();
        }
    }
});
</script>
