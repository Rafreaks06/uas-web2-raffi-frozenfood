<div class="container-fluid">

    <h3><?= $title ?></h3>

    <a href="<?= base_url('admin/supplier/create') ?>" class="btn btn-primary mb-3">
        Tambah Supplier
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Supplier</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($supplier as $i => $row): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= $row->nama_supplier ?></td>
                <td><?= $row->no_hp ?></td>
                <td><?= $row->alamat ?></td>
                <td>
                    <a href="<?= base_url('admin/supplier/edit/'.$row->id_supplier) ?>"
                       class="btn btn-warning btn-sm">Edit</a>

                    <a onclick="return confirm('Hapus supplier ini?')"
                       href="<?= base_url('admin/supplier/delete/'.$row->id_supplier) ?>"
                       class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>

</div>
