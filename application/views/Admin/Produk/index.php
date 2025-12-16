<div class="container-fluid">

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

                        <a onclick="return confirm('Yakin?')" 
                           href="<?= base_url('admin/produk/delete/'.$p->id_produk) ?>" 
                           class="btn btn-sm btn-danger">Hapus</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <!-- Modal View Gambar -->
<div class="modal fade" id="imgModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <img id="modalImage" src="" class="img-fluid rounded">
    </div>
  </div>
</div>

<script>
function showImage(src) {
    document.getElementById('modalImage').src = src;
}
</script>


</div>
