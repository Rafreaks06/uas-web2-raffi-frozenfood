<div class="container-fluid">

    <h3><?= $title ?></h3>

    <form action="<?= isset($row)
            ? base_url('admin/supplier/update/'.$row->id_supplier)
            : base_url('admin/supplier/store')
        ?>" method="POST">

        <div class="form-group">
            <label>Nama Supplier</label>
            <input type="text" name="nama_supplier" class="form-control" required
                   value="<?= isset($row) ? $row->nama_supplier : '' ?>">
        </div>

        <div class="form-group">
            <label>Telepon</label>
            <input type="text" name="no_hp" class="form-control" required
                   value="<?= isset($row) ? $row->no_hp : '' ?>">
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required><?= isset($row) ? $row->alamat : '' ?></textarea>
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="<?= base_url('admin/Supplier') ?>" class="btn btn-secondary">Batal</a>
    </form>

</div>
