<div class="container-fluid">

    <h3><?= $title ?></h3>

    <div class="row mt-4">
        
        <div class="col-md-4 col-xl-2 mb-3">
            <div class="card shadow p-3 bg-primary text-white h-100">
                <h6 class="text-uppercase" style="font-size: 0.8rem;">Total Produk</h6>
                <h3><?= $total_produk ?></h3>
            </div>
        </div>

        <div class="col-md-4 col-xl-2 mb-3">
            <div class="card shadow p-3 bg-success text-white h-100">
                <h6 class="text-uppercase" style="font-size: 0.8rem;">Total Supplier</h6>
                <h3><?= $total_supplier ?></h3>
            </div>
        </div>

        <div class="col-md-4 col-xl-2 mb-3">
            <div class="card shadow p-3 text-white h-100" style="background-color:#17a2b8;">
                <h6 class="text-uppercase" style="font-size: 0.8rem;">Total Customer</h6>
                <h3><?= $total_customer ?></h3>
            </div>
        </div>

        <div class="col-md-4 col-xl-2 mb-3">
            <div class="card shadow p-3 bg-warning text-white h-100">
                <h6 class="text-uppercase" style="font-size: 0.8rem;">Order Offline</h6>
                <h3><?= $order_offline ?></h3>
            </div>
        </div>

        <div class="col-md-4 col-xl-2 mb-3">
            <div class="card shadow p-3 bg-info text-white h-100">
                <h6 class="text-uppercase" style="font-size: 0.8rem;">Order Online</h6>
                <h3><?= $order_online ?></h3>
            </div>
        </div>

        <div class="col-md-4 col-xl-2 mb-3">
            <div class="card shadow p-3 bg-danger text-white h-100">
                <h6 class="text-uppercase" style="font-size: 0.8rem;">Stok Menipis</h6>
                <h3><?= isset($jml_menipis) ? $jml_menipis : 0 ?> Item</h3>
                
                <?php if(isset($jml_menipis) && $jml_menipis > 0): ?>
                <button class="btn btn-sm btn-light text-danger mt-2 font-weight-bold" 
                        data-toggle="modal" data-target="#modalStok">
                    Lihat <i class="fas fa-arrow-right"></i>
                </button>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <div class="row mt-4">

        <div class="col-md-4">
            <div class="card shadow p-3">
                <h5 class="text-center">Perbandingan Order</h5>
                <canvas id="pieChart"></canvas>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow p-3">
                <h5 class="text-center">Order Per Bulan (Offline & Online)</h5>
                <canvas id="barChart"></canvas>
            </div>
        </div>

    </div>

</div>

<div class="modal fade" id="modalStok" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">⚠️ Daftar Barang Stok Menipis</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php if(isset($stok_menipis) && !empty($stok_menipis)): ?>
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th class="text-center">Sisa Stok</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($stok_menipis as $sm): ?>
                <tr>
                    <td><?= $sm->nama_produk ?></td>
                    <td class="text-center font-weight-bold text-danger">
                        <?= $sm->stok ?>
                    </td>
                    <td class="text-right">
                        <a href="<?= base_url('admin/produk/edit/'.$sm->id_produk) ?>" class="btn btn-sm btn-primary">
                            Restock
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p class="text-center text-success font-weight-bold">Aman! Tidak ada stok yang menipis.</p>
        <?php endif; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Data PHP ke JS
    const offline = <?= json_encode($chart_offline) ?>;
    const online  = <?= json_encode($chart_online) ?>;

    // PIE CHART
    new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: {
            labels: ['Offline', 'Online'],
            datasets: [{
                data: [<?= $order_offline ?>, <?= $order_online ?>],
                backgroundColor: ['#ffc107', '#17a2b8']
            }]
        }
    });

    // BAR CHART
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [
                {
                    label: 'Order Offline',
                    data: offline,
                    backgroundColor: '#ffc107'
                },
                {
                    label: 'Order Online',
                    data: online,
                    backgroundColor: '#17a2b8'
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>