<div class="container-fluid">

    <h3>Detail Order Offline</h3>

    <a href="<?= base_url('admin/order-offline') ?>" class="btn btn-secondary mb-3">
        Kembali
    </a>

    <div class="card mb-4">
        <div class="card-header">
            <strong>Informasi Customer</strong>
        </div>
        <div class="card-body">
            <p><strong>Nama Customer:</strong> <?= $order->nama_customer ?></p>
            <p><strong>Alamat:</strong> <?= $order->alamat ?: '-' ?></p>
            <p><strong>No HP:</strong> <?= $order->no_hp ?: '-' ?></p>
            <p><strong>Tanggal Order:</strong> <?= $order->created_at ?></p>
            <p><strong>Status:</strong> 
                <span class="badge badge-<?= $order->status == 'Success' ? 'success' : 'danger' ?>">
                    <?= $order->status ?>
                </span>
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <strong>Detail Produk</strong>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                    $grandTotal = 0;
                    foreach ($detail as $d): 
                        // PERBAIKAN: Ambil subtotal asli dari database, jangan hitung ulang
                        $subtotal_real = $d->subtotal;
                        $grandTotal += $subtotal_real;
                        
                        // Hitung harga satuan lama
                        $harga_lama = $subtotal_real / $d->qty;
                    ?>
                        <tr>
                            <td><?= $d->nama_produk ?></td>
                            <td><?= $d->qty ?></td>
                            <td><?= number_format($harga_lama) ?></td>
                            <td><?= number_format($subtotal_real) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>

            <h4 class="text-right mt-3">
                Total: <strong><?= number_format($grandTotal) ?></strong>
            </h4>

            <a href="<?= base_url('admin/order-offline/cetak/'.$order->id_order_offline) ?>" 
               class="btn btn-primary float-right mt-2">
                Cetak Struk
            </a>

        </div>
    </div>

</div>