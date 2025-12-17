<div class="container-fluid">

    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('success'); ?>"></div>
    <div class="flash-data-error" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>

    <h3><?= $title ?></h3>

    <a href="<?= base_url('admin/kategori/create') ?>" class="btn btn-primary mb-3">
        Tambah Kategori
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 50px;">No</th>
                <th>Nama Kategori</th>
                <th style="width: 200px;">Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php $no=1; foreach($kategori as $k): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $k->nama_kategori ?></td>
                <td>
                    <a href="<?= base_url('admin/kategori/edit/'.$k->id_kategori) ?>" class="btn btn-warning btn-sm">Edit</a>
                    
                    <a href="<?= base_url('admin/kategori/delete/'.$k->id_kategori) ?>" 
                       class="btn btn-danger btn-sm tombol-hapus">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // A. Notifikasi Sukses & Gagal (Menerima pesan dari Controller)
    const flashData = $('.flash-data').data('flashdata');
    const flashDataError = $('.flash-data-error').data('flashdata');

    // Jika Sukses (Data terhapus)
    if (flashData) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: flashData
        });
    }

    // Jika Gagal (Karena masih ada produk)
    if (flashDataError) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal Menghapus!',
            text: flashDataError,
            footer: '<a href="<?= base_url("admin/produk") ?>">Cek Data Produk Disini</a>'
        });
    }

    // B. Konfirmasi Sebelum Hapus
    $('.tombol-hapus').on('click', function(e) {
        e.preventDefault(); 
        const href = $(this).attr('href');

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data kategori ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href;
            }
        });
    });
</script>