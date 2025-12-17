<div class="container-fluid">

    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('success'); ?>"></div>
    <div class="flash-data-error" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>

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

                    <a href="<?= base_url('admin/supplier/delete/'.$row->id_supplier) ?>"
                       class="btn btn-danger btn-sm tombol-hapus">Hapus</a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // A. Notifikasi Sukses/Gagal (Saat Halaman Reload)
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

    // B. Konfirmasi Hapus
    $('.tombol-hapus').on('click', function(e) {
        e.preventDefault(); // Mencegah link langsung jalan
        
        const href = $(this).attr('href'); // Ambil alamat link delete

        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data supplier ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus Data!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user klik Ya, arahkan ke link delete
                document.location.href = href;
            }
        });
    });
</script>