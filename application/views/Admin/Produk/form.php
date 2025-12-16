<div class="container-fluid">

    <h3><?= $title ?></h3>

    <form action="<?= isset($row) 
        ? base_url('admin/produk/update/'.$row->id_produk)
        : base_url('admin/produk/store')
    ?>" method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" class="form-control" name="nama_produk" required
                   value="<?= isset($row) ? $row->nama_produk : '' ?>">
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <select name="id_kategori" class="form-control">
                <option value="">-- Pilih Kategori --</option>
                <?php foreach ($kategori as $k): ?>
                    <option value="<?= $k->id_kategori ?>" 
                        <?= (isset($row) && $row->id_kategori == $k->id_kategori) ? 'selected' : '' ?>>
                        <?= $k->nama_kategori ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Atau Tambah Kategori Baru</label>
            <input type="text" name="kategori_baru" class="form-control" placeholder="Masukkan kategori baru">
        </div>

        <div class="form-group">
            <label>Harga</label>
            <input type="number" class="form-control" name="harga" required
                   value="<?= isset($row) ? $row->harga : '' ?>">
        </div>

        <div class="form-group">
            <label>Stok</label>
            <input type="number" class="form-control" name="stok" required
                   value="<?= isset($row) ? $row->stok : '' ?>">
        </div>

        <div class="form-group">
            <label>Supplier</label>
            <select name="id_supplier" class="form-control">
                <option value="">-- Pilih Supplier --</option>
                <?php foreach ($supplier as $s): ?>
                    <option value="<?= $s->id_supplier ?>"
                        <?= (isset($row) && $row->id_supplier == $s->id_supplier) ? 'selected' : '' ?>>
                        <?= $s->nama_supplier ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Atau Tambah Supplier Baru</label>
            <input type="text" name="supplier_baru" class="form-control" placeholder="Masukkan nama supplier baru">
        </div>

        <div class="form-group">
            <label>Gambar Produk</label>
            <input type="file" class="form-control" name="gambar">
            
            <?php if(isset($row) && $row->gambar): ?>
                <div class="mt-2">
                    <p>Gambar saat ini:</p>
                    <img src="<?= base_url('assets/uploads/produk/'.$row->gambar) ?>" width="100">
                    <input type="hidden" name="gambar_lama" value="<?= $row->gambar ?>">
                    <p class="text-muted small">Upload gambar baru untuk mengganti</p>
                </div>
            <?php endif; ?>
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="<?= base_url('admin/produk') ?>" class="btn btn-secondary">Batal</a>
    </form>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const supplierBaru = document.querySelector('input[name="supplier_baru"]');
        const dropdownSupplier = document.querySelector('select[name="id_supplier"]');
        const kategoriBaru = document.querySelector('input[name="kategori_baru"]');
        const dropdownKategori = document.querySelector('select[name="id_kategori"]');

        kategoriBaru.addEventListener('input', function() {
            if (kategoriBaru.value.trim() !== "") {
                dropdownKategori.value = "";
                dropdownKategori.setAttribute("disabled", "disabled");
            } else {
                dropdownKategori.removeAttribute("disabled");
            }
        });

        supplierBaru.addEventListener('input', function() {
            if (supplierBaru.value.trim() !== "") {
                dropdownSupplier.value = "";
                dropdownSupplier.setAttribute("disabled", "disabled");
            } else {
                dropdownSupplier.removeAttribute("disabled");
            }
        });
    });
    </script>

</div>