<div class="container-fluid mt-4">
    <h3 class="mb-4">Katalog Produk Frozen Food</h3>

    <div class="row">
        <?php foreach($produk as $p): ?>
        <div class="col-md-3 mb-4">
            <div class="card shadow h-100">
                
                <img src="<?= base_url('assets/Uploads/Produk/'.$p->gambar) ?>" class="card-img-top" alt="<?= $p->nama_produk ?>" style="height: 200px; object-fit: cover;">
                
                <div class="card-body">
                    <h5 class="card-title"><?= $p->nama_produk ?></h5>
                    <p class="card-text text-primary font-weight-bold">Rp <?= number_format($p->harga, 0, ',', '.') ?></p>
                    
                    <p class="card-text">
                        <?php if($p->stok > 0): ?>
                            <span class="badge badge-success">Stok: <?= $p->stok ?></span>
                        <?php else: ?>
                            <span class="badge badge-danger">Stok Habis</span>
                        <?php endif; ?>
                        <br>
                        <small class="text-muted">Kategori: <?= $p->nama_kategori ?? 'Umum' ?></small>
                    </p>

                    <?php if($p->stok > 0): ?>
                        <a href="<?= base_url('user/order-online/create') ?>" class="btn btn-primary btn-block">
                            <i class="fas fa-shopping-cart"></i> Pesan Sekarang
                        </a>
                    <?php else: ?>
                        <button class="btn btn-secondary btn-block" disabled>
                            <i class="fas fa-ban"></i> Stok Habis
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>