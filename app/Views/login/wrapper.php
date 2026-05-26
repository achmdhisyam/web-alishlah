<?php 
use App\Libraries\Website;
$this->website  = new Website();
?>
<!doctype html>
	<html lang="en">
	<head>
		<title><?php echo $title ?></title>
		<meta charset="utf-8">
		<link rel="icon" href="<?php echo $this->website->icon() ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/fontawesome-free/css/all.min.css">
		<!-- SweetAlert2 -->
	  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/login/css/style.css">
        <style>
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
        </style>
	</head>

	<body style="background-color: #66c2ff;">
		<section class="ftco-section">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-12 col-lg-10">
						<div class="wrap d-md-flex">
							<div class="text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last">
								<div class="text w-100">
									<p>
										<img src="<?php echo $this->website->icon() ?>" alt="<?php echo $site->namaweb ?>" class="img img-thumbnail rounded-circle" style="max-height: 100px; width: auto;">
									</p>
									<h2><?php echo $site->namaweb ?></h2>
									<p><?php echo $site->tagline ?></p>
									
								</div>
							</div>
							<div class="login-wrap p-4 p-lg-5">
								<div class="d-flex">
									<div class="w-100">
										<h3 class="mb-4"><?php echo $title ?></h3>
										<hr>
									</div>
									
								</div>

<?php 
if($content) {
	echo view($content);
}
 ?>

 
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="<?php echo base_url() ?>assets/login/js/jquery.min.js"></script>
	<script src="<?php echo base_url() ?>assets/login/js/popper.js"></script>
	<script src="<?php echo base_url() ?>assets/login/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url() ?>assets/login/js/main.js"></script>
	<!-- SweetAlert2 -->
	<script src="<?php echo base_url() ?>assets/admin/plugins/sweetalert2/sweetalert2.min.js"></script>
	<script>
	<?php if(isset($_GET['logout'])) { ?>
		Swal.fire({
		  icon: 'success',
		  heightAuto: false,
		  timer: 2000,
		  title: 'Sukses...',
		  text: 'Anda berhasil logout.',
		})
	<?php }if(Session()->getFlashdata('warning')) { ?>
	// Notifikasi
	Swal.fire({
	  icon: 'warning',
	  title: 'Oops...',
	  timer: 3000,
	  heightAuto: false,
	  text: '<?php echo Session()->getFlashdata('warning'); ?>',
	})
	<?php } ?>
	<?php if(Session()->getFlashdata('sukses')) { ?>
	// Notifikasi
	Swal.fire({
	  icon: 'success',
	  heightAuto: false,
	  timer: 2000,
	  title: 'Alhamdulillah...',
	  text: '<?php echo Session()->getFlashdata('sukses'); ?>',
	})
	<?php } ?>
	</script>
</body>
</html>