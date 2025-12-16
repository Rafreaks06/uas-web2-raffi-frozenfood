<div class="container-fluid mt-4">

    <h3>Profil Saya</h3>
    <hr>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <form action="<?= base_url('user/profile/update') ?>" method="POST">
                        
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" value="<?= $user->username ?>" readonly disabled>
                            <small class="text-muted">Username tidak dapat diubah.</small>
                        </div>

                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" value="<?= $user->nama_lengkap ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?= $user->email ?>">
                        </div>

                        <div class="form-group">
                            <label>No HP / WhatsApp</label>
                            <input type="number" name="no_hp" class="form-control" value="<?= $user->no_hp ?>" placeholder="Contoh: 0812...">
                        </div>

                        <div class="form-group">
                            <label>Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat pengiriman..."><?= $user->alamat ?></textarea>
                        </div>

                        <hr>
                        <p class="text-danger font-weight-bold">Ganti Password (Opsional)</p>
                        <div class="form-group">
                            <label>Password Baru</label>
                            <input type="password" name="password" class="form-control" placeholder="Biarkan kosong jika tidak ingin mengganti password">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>