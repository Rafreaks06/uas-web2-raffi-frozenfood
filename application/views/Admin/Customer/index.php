<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="card mb-4 shadow-sm border-left-primary">
        <div class="card-body py-3">
            <form method="GET" action="">
                <div class="form-row align-items-center">
                    
                    <div class="col-md-5 mb-2 mb-md-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-primary text-white border-primary">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                            <input type="text" id="keyword" name="keyword" class="form-control" 
                                   placeholder="Ketik Nama Customer..." autocomplete="off"
                                   value="<?= isset($keyword) ? $keyword : '' ?>">
                        </div>
                    </div>

                    <div class="col-md-3 mb-2 mb-md-0">
                        <select name="filter" id="filter_status" class="form-control" onchange="this.form.submit()">
                            <option value="">-- Semua Status --</option>
                            <option value="online" <?= isset($selected_filter) && $selected_filter == 'online' ? 'selected' : '' ?>>User Online</option>
                            <option value="offline" <?= isset($selected_filter) && $selected_filter == 'offline' ? 'selected' : '' ?>>Customer Offline</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <a href="<?= base_url('admin/customer') ?>" class="btn btn-secondary btn-block">
                            <i class="fas fa-sync"></i> Reset
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <?php 
        $is_offline = (isset($selected_filter) && $selected_filter == 'offline');
    ?>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>

                            <?php if (!$is_offline): ?>
                                <th>No HP</th>
                                <th>Alamat</th>
                            <?php endif; ?>

                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    
                    <tbody id="tabel-body">
                        <?php 
                            // Panggil file partial view yang baru dibuat
                            $data_view['customer']   = $customer;
                            $data_view['is_offline'] = $is_offline;
                            $this->load->view('admin/customer/table_rows', $data_view); 
                        ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        
        // Deteksi ketikan di kolom input #keyword
        $('#keyword').on('keyup', function(){
            
            var keyword = $(this).val();
            var filter  = $('#filter_status').val(); // Ambil status filter juga

            $.ajax({
                url: '<?= base_url("admin/customer/ajax_search") ?>',
                type: 'POST',
                data: {
                    keyword: keyword,
                    filter: filter
                },
                success: function(data){
                    // Ganti isi tbody dengan hasil pencarian
                    $('#tabel-body').html(data);
                },
                error: function(xhr, status, error){
                    console.error(error);
                }
            });
        });

    });
</script>