<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Laporan Penjualan (<?= date('d M Y', strtotime($tgl_awal)) ?> s/d <?= date('d M Y', strtotime($tgl_akhir)) ?>)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="15%">Tanggal</th>
                        <th width="20%">Nama Pembeli</th> <th width="10%" class="text-center">Jenis Order</th>
                        <th>Item Terjual</th>
                        <th width="15%" class="text-right">Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1; 
                    $grand_total = 0;
                    
                    if(empty($laporan)) : ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data transaksi pada periode ini.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach($laporan as $row) : 
                            $grand_total += $row->total;
                        ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td>
                                <?= date('d/m/Y', strtotime($row->tanggal)) ?><br>
                                <small class="text-muted"><?= date('H:i', strtotime($row->tanggal)) ?> WIB</small>
                            </td>
                            
                            <td><?= $row->nama_pembeli ?></td>
                            
                            <td class="text-center">
                                <?php if($row->jenis_order == 'Online') : ?>
                                    <span class="badge badge-info">Online</span>
                                <?php else : ?>
                                    <span class="badge badge-warning">Offline</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <small style="font-size: 13px;"><?= $row->detail_barang ?></small>
                            </td>

                            <td class="text-right">Rp <?= number_format($row->total, 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <tr class="bg-light font-weight-bold">
                            <td colspan="5" class="text-center">GRAND TOTAL PENDAPATAN</td>
                            <td class="text-right">Rp <?= number_format($grand_total, 0, ',', '.') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-3 no-print">
            <button onclick="window.print()" class="btn btn-secondary"><i class="fas fa-print"></i> Cetak Halaman</button>
            <a href="<?= base_url('admin/laporan') ?>" class="btn btn-danger">Kembali</a>
        </div>
    </div>
</div>