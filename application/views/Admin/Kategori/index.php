<div class="container-fluid">
    <h3><?= $title ?></h3>

    <a href="<?= base_url('admin/kategori/create') ?>" class="btn btn-primary mb-3">
        Tambah Kategori
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>1</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php $no=1; foreach($kategori as $k): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $k->nama_kategori ?></td>
                <td>
                    <a href="<?= base_url('admin/kategori/edit/'.$k->id_kategori) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="<?= base_url('admin/kategori/delete/'.$k->id_kategori) ?>" class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
