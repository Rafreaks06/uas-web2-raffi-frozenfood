<div class="container-fluid">

    <h3><?= $title ?></h3>

    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card shadow p-3 bg-primary text-white">
                <h5>Total Produk</h5>
                <h3><?= $total_produk ?></h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow p-3 bg-success text-white">
                <h5>Total Supplier</h5>
                <h3><?= $total_supplier ?></h3>
            </div>
        </div>

                <div class="col-md-3">
            <div class="card shadow p-3" style="background-color:#17a2b8; color:white;">
                <h5>Total Customer</h5>
                <h3><?= $total_customer ?></h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow p-3 bg-warning text-white">
                <h5>Order Offline</h5>
                <h3><?= $order_offline ?></h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow p-3 bg-info text-white">
                <h5>Order Online</h5>
                <h3><?= $order_online ?></h3>
            </div>
        </div>
    </div>

    <div class="row mt-4">

        <!-- Pie Chart -->
        <div class="col-md-4">
            <div class="card shadow p-3">
                <h5 class="text-center">Perbandingan Order</h5>
                <canvas id="pieChart"></canvas>
            </div>
        </div>

        <!-- Bar Chart -->
        <div class="col-md-8">
            <div class="card shadow p-3">
                <h5 class="text-center">Order Per Bulan (Offline & Online)</h5>
                <canvas id="barChart"></canvas>
            </div>
        </div>

    </div>

</div>

<!-- Chart.js -->
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
