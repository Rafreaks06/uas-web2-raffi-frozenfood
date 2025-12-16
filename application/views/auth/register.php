<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register - Frozen Food</title>

    <link href="<?= base_url('assets/sbadmin/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/sbadmin/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            width: 100%;
        }
    </style>
</head>

<body class="bg-gradient-danger">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Buat Akun Baru!</h1>
                                    </div>

                                    <?php if ($this->session->flashdata('error')): ?>
                                        <div class="alert alert-danger text-center">
                                            <?= $this->session->flashdata('error') ?>
                                        </div>
                                    <?php endif; ?>

                                    <form class="user" action="<?= base_url('auth/register_process') ?>" method="POST">

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" 
                                                name="nama_lengkap" placeholder="Nama Lengkap" required>
                                        </div>

                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" 
                                                name="email" placeholder="Alamat Email" required>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" 
                                                name="username" placeholder="Username" required>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="password" class="form-control form-control-user"
                                                    name="password" placeholder="Password" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="password" class="form-control form-control-user"
                                                    name="password_confirm" placeholder="Ulangi Password" required>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Daftar Akun
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="<?= base_url('auth/login') ?>">Sudah punya akun? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/sbadmin/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= base_url('assets/sbadmin/js/sb-admin-2.min.js'); ?>"></script>

</body>
</html>