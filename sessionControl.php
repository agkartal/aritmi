<?php
ob_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"] == null) {
	header("Location: login.php");
	die();
}
ob_flush();
?>