 <div class="container-fluid mt-4">

    <h3>Katalog Produk Frozen Food</h3>
    <hr>

    <div class="row">
        <?php foreach($produk as $p): ?>
        
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card shadow h-100">
                
                <img src="<?= base_url('assets/Uploads/Produk/'.$p->gambar) ?>" 
                     class="card-img-top" 
                     alt="<?= $p->nama_produk ?>"
                     style="height: 200px; object-fit: cover;">
                
                <div class="card-body">
                    <h5 class="card-title" style="font-size: 16px; font-weight: bold;">
                        <?= $p->nama_produk ?>
                    </h5>
                    
                    <p class="card-text text-success font-weight-bold">
                        Rp <?= number_format($p->harga, 0, ',', '.') ?>
                    </p>
                    
                    <p class="card-text text-muted" style="font-size: 12px;">
                        Stok: <?= $p->stok ?> | Kategori: <?= $p->nama_kategori ?? '-' ?>
                    </p>

                    <a href="<?= base_url('user/order-online/create') ?>" class="btn btn-primary btn-block btn-sm">
                        <i class="fas fa-shopping-cart"></i> Pesan Sekarang
                    </a>
                </div>

            </div>
        </div>

        <?php endforeach; ?>
    </div>

    <?php if(empty($produk)): ?>
        <div class="alert alert-warning text-center">
            Belum ada produk yang tersedia saat ini.
        </div>
    <?php endif; ?>

</div>