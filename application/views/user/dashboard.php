<div class="container-fluid mt-4">

    <!-- Welcome -->
    <!-- <div class="alert alert-info shadow-sm">
        Selamat datang, <?= $nama ?>!
    </div> -->

    <div class="row">

        <!-- Belanja Produk -->
        <div class="col-lg-6 col-md-6 mb-4">
            <div class="card shadow border-0" style="background:#3d64ff; color:white; border-radius:10px;">
                <div class="card-body">
                    <h5 class="font-weight-bold">Belanja Produk</h5>
                    <small>Klik untuk melihat produk</small>

                    <a href="<?= base_url('user/produk'); ?>" 
                       class="btn btn-light mt-3 btn-block font-weight-bold" 
                       style="border-radius:6px;">
                       Lihat Produk
                    </a>
                </div>
            </div>
        </div>

        <!-- Riwayat Pesanan -->
        <div class="col-lg-6 col-md-6 mb-4">
            <div class="card shadow border-0" style="background:#17c37b; color:white; border-radius:10px;">
                <div class="card-body">
                    <h5 class="font-weight-bold">Riwayat Pesanan</h5>
                    <small>Lihat pesanan kamu</small>

                    <a href="<?= base_url('user/order'); ?>" 
                       class="btn btn-light mt-3 btn-block font-weight-bold" 
                       style="border-radius:6px;">
                       Lihat Pesanan
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>
