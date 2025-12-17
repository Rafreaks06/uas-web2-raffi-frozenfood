<div class="container-fluid">

    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('success'); ?>"></div>
    <div class="flash-data-error" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>

    <h3><?= $title ?></h3>
    <a href="<?= base_url('admin/produk/create') ?>" class="btn btn-danger mb-3">Tambah Produk</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Supplier</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produk as $i => $p): ?>
                <tr>
                    <td><?= $i+1 ?></td>
                    <td><?= $p->nama_produk ?></td>
                    <td><?= $p->nama_kategori ?? '-' ?></td>
                    <td><?= $p->nama_supplier ?? '-' ?></td>
                    <td><?= number_format($p->harga) ?></td>
                    <td><?= $p->stok ?></td>
                    <td>
                        <img src="<?= base_url('assets/uploads/produk/'.$p->gambar) ?>"
                            width="70"
                            style="cursor:pointer"
                            data-toggle="modal"
                            data-target="#imgModal"
                            onclick="showImage('<?= base_url('assets/uploads/produk/'.$p->gambar) ?>')"
                            onerror="this.src='https://via.placeholder.com/70'">
                    </td>

                    <td>
                        <a href="<?= base_url('admin/produk/edit/'.$p->id_produk) ?>" 
                           class="btn btn-sm btn-warning">Edit</a>

                        <a href="<?= base_url('admin/produk/delete/'.$p->id_produk) ?>" 
                           class="btn btn-sm btn-danger tombol-hapus">Hapus</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <div class="modal fade" id="imgModal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <img id="modalImage" src="" class="img-fluid rounded">
        </div>
      </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <script>
    // FUNGSI MODAL GAMBAR (Bawaan kamu)
    function showImage(src) {
        document.getElementById('modalImage').src = src;
    }

    // --- LOGIC SWEETALERT2 ---

    // A. Notifikasi Sukses/Gagal (Flashdata)
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
        e.preventDefault(); // Matikan aksi default link (biar gak langsung pindah halaman)
        
        const href = $(this).attr('href'); // Ambil link dari tombol yang diklik

        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data produk akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus Data!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user klik Ya, baru arahkan ke link hapus
                document.location.href = href;
            }
        });
    });
</script>