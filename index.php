<?php ob_start(); session_start(); include_once("sessionControl.php"); ?>
<html>

<head>
	<title>Aritmi Ürünler ve Firma Teklifleri</title>
	<meta charset="utf-8">
	<link rel="icon" href="favicon.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>

<body>
	<?php

	if (isset($_GET["Status"]) && "EXIT" == $_GET["Status"]) {
		unset($_SESSION["user"]);
		header("Location: login.php");
		die();
	}

	if (isset($_GET["ProductId"])) {
		$_SESSION["ProductId"] = $_GET["ProductId"];
	}

	include_once('productUtils.php');
	saveProducts();
	
	if (isset($_GET["Status"])) {
		if("DELETE_PRODUCT" == $_GET["Status"]) {
			deleteProduct($_GET["ProductId"]);
		} else if ("DELETE_OFFER" == $_GET["Status"]) {
			include_once('offerUtils.php');
			deleteProductOffer($_GET["ProductOfferId"]);
		}
	}
	?>

	<a class="btn btn-link" style="font-weight: 700; float: right;" href="index.php?Status=EXIT" role="button"><?php echo($_SESSION["user"]["NAME"]); ?>, Çıkış Yap</a>
	<a class="btn btn-link" style="font-weight: 700; float: left;" href="changePassword.php" role="button"><?php echo($_SESSION["user"]["NAME"]); ?>, Şifre Değiştir</a>
	
	<div class="row mt-3"></div>
	<div class="container" style="max-width: 95% !important;">
		<h1 class="text-center">ARİTMİ ÜRÜNLER ve FİRMA TEKLİFLERİ</h1>
		<div class="row mt-3"></div>
		<div class="row">
			<div class="col-sm-3">
				<?php
				include('product.php');
				include_once('productUtils.php');
				if (isset($_POST['SearchProduct'])) {
					$productTableAsHtml = searchProducts();
				} else {
					$productTableAsHtml = getProductTableHtml();
				}
				echo ($productTableAsHtml);
				?>
			</div>
			<div class="col-sm-9">
				<div class="container">
					<h2 style="color: red; font-weight: 800;">
						<?php
						include_once("productUtils.php");
						if (isset($_SESSION['ProductId'])) {
							echo (getProductName($_SESSION['ProductId']));
						}
						?>
					</h2>
				</div>

				<?php
				include_once('offerUtils.php');
				saveProductOffer();
				if (isset($_SESSION['ProductId'])) {
					$offerTableAsHtml = getProductOfferTableHtml();
					echo ($offerTableAsHtml);
				}
				?>
				<div class="row mt-5"></div>

				<?php
				include('offer.php');
				?>
			</div>
		</div>
	</div>
</body>

</html>

<?php ob_flush(); ?>