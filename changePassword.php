<?php 
	ob_start();
	session_start();
	include_once("sessionControl.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="favicon.png" />
    <title>Aritmi Ürünler ve Firma Teklifleri Şifre Değiştir</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: grey;
        }

        .login-form {
            width: 340px;
            margin: 150px auto;
            font-size: 15px;
        }

        .login-form form {
            margin-bottom: 15px;
            background: #f7f7f7;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            padding: 30px;
        }

        .login-form h2 {
            margin: 0 0 15px;
        }

        .form-control,
        .btn {
            min-height: 38px;
            border-radius: 2px;
        }

        .btn {
            font-size: 15px;
            font-weight: bold;
        }
    </style>
</head>

<body>
	<?php 

	if (isset($_POST["changePassword"])) {
		include_once("changePasswordUtils.php");

		$username = $_SESSION["user"]["USERNAME"];
		$password = $_POST["password"];
		$name = $_POST["name"];
		changePassword($username, $password, $name);
		$_SESSION["user"]["NAME"] = $name;

		header("Location: index.php");
		die();
	}
	?>

	<div class="login-form">
		<form action="changePassword.php" method="post">
			<h2 class="text-center">Şifre Değiştir</h2>
			<div class="form-group">
				<input type="text" name="name" class="form-control" placeholder="İsim" required="required" value="<?php echo($_SESSION["user"]["NAME"]) ?>">
			</div>
			<div class="form-group">
				<input type="password" name="password" class="form-control" placeholder="Yeni Şifre" required="required">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-block" name="changePassword">Değiştir</button>
			</div>
		</form>
	</div>
</body>

</html>

<?php ob_flush(); ?>