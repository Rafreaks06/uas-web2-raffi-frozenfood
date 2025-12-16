<div class="container-fluid">
    <h3><?= $title ?></h3>

    <form action="<?= isset($row)
            ? base_url('admin/kategori/update/'.$row->id_kategori)
            : base_url('admin/kategori/store')
        ?>" method="POST">

        <div class="form-group">
            <label>Nama Kategori</label>
            <input type="text" name="nama_kategori" class="form-control" required
                value="<?= isset($row) ? $row->nama_kategori : '' ?>">
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="<?= base_url('admin/kategori') ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>
