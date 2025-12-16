<!DOCTYPE html>
<html lang="en">
<title><?= isset($title) ? htmlspecialchars($title) : 'Frozen Food'; ?></title>

<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>

    <link href="<?= base_url('assets/sbadmin/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/sbadmin/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

    <style>
        .bg-user {
            background: #0ea5e9 !important; /* warna biru seperti admin tapi versi user */
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
