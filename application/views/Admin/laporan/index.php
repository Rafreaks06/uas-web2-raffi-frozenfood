<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <?= $this->session->flashdata('pesan'); ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/laporan/cetak') ?>" method="post">
            <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tanggal Awal</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" name="tgl_awal" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tanggal Akhir</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" name="tgl_akhir" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <button type="submit" name="submit" value="web" class="btn btn-info">
                            <i class="fas fa-eye"></i> Lihat di Web
                        </button>

                        <button type="submit" name="submit" value="print" class="btn btn-primary" formtarget="_blank">
                            <i class="fas fa-print"></i> Cetak / PDF
                        </button>
                        
                        <button type="submit" name="submit" value="excel" class="btn btn-success">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>