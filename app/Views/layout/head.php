<!DOCTYPE html>
<html amp >
<head>
<!-- Site made with Mobirise Website Builder v5.6.8, https://mobirise.com -->
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $title ?></title>
<link rel="icon" type="image/png" href="<?= base_url('favicon.png') ?>">
<link rel="apple-touch-icon" href="<?= base_url('favicon.png') ?>">
<link rel="shortcut icon" href="<?php echo $this->website->icon() ?>">

<!-- PWA Integration -->
<link rel="manifest" href="<?= base_url('manifest-siswa.json') ?>">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="<?= esc($this->website->namaweb()) ?>">
<link rel="apple-touch-icon" href="<?php echo $this->website->icon() ?>">
<meta name="theme-color" content="#00ac37">

<meta name="generator" content="<?php echo $this->website->namaweb() ?>">
<meta name="twitter:card" content="<?php echo strip_tags($description ?? '') ?>"/>
<meta name="twitter:image:src" content="<?= $this->website->icon() ?>">
<meta property="og:image" content="<?= $this->website->icon() ?>">
<meta property="og:title" content="<?= esc($title ?? $this->website->namaweb()) ?>">
<meta name="twitter:title" content="<?php echo strip_tags($title) ?>">
<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
<meta name="description" content="<?php echo strip_tags($description ?? '') ?>">
<meta name="amp-script-src" content="<?php echo strip_tags($description ?? '') ?>">
<!-- font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200..800&family=League+Spartan:wght@100..900&display=swap" rel="stylesheet">
<!-- Mobile Specific Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="theme-color" content="#ffffff">
<script async src="https://cdn.ampproject.org/v0.js"></script>
<!-- All CSS File-->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/template/assets/css/plugins.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/template/assets/css/style.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/template/assets/css/fonts/dm.css">
<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/template.css">
<!-- jQuery -->
<script src="<?php echo base_url() ?>assets/admin/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url() ?>assets/jquery-ui/jquery-ui.min.js"></script>
<link href="<?php echo base_url() ?>assets/jquery-ui/jquery-ui.min.css" rel="stylesheet">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- isi berita dll -->
 
<!-- SweetAlert2 -->
<script src="<?php echo base_url() ?>assets/admin/plugins/sweetalert2/sweetalert2.min.js"></script>
 <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- <?php echo $this->website->metatext() ?> -->
 <!-- SEO Meta -->
<meta name="keywords" content="<?php echo strip_tags($this->website->keywords()) ?>">
<meta name="description" content="<?php echo strip_tags($this->website->metatext()) ?>">
<style type="text/css" media="screen">
	body {
	  font-family: "Dosis", sans-serif !important;
	  font-optical-sizing: auto;
	  font-weight: <weight>;
	  font-style: normal;
	}
	.konten img {
		width:  auto;
		height: auto;
		max-width: 100%;
		border-radius: 10px;
	}
    /* Premium Google Button */
    .btn-google {
        background-color: #ffffff;
        color: #555555 !important;
        border: 1px solid #e1e1e1;
        border-radius: 50px;
        padding: 12px 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        width: 100%;
    }
    .btn-google:hover {
        background-color: #ffffff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transform: translateY(-2px);
        border-color: #4285F4;
    }
    .btn-google img {
        width: 20px;
        height: 20px;
        margin-right: 12px;
    }
    .btn-google i {
        margin-right: 12px;
        font-size: 18px;
        color: #EA4335;
    }
    /* Fix Global Background Image untuk semua Banner */
    .bg-image {
      background-size: cover !important;
      background-position: center !important;
      background-repeat: no-repeat !important;
    }
</style>
</head>

<body>