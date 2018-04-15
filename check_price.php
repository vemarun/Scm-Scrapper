<?php 
include_once 'db_connect.php';
$c="select * from currency";
$result=mysqli_query($db,$c);
$currency=mysqli_fetch_assoc($result);
$ref_price=$currency['ref_price'];
$key_ref=$currency['key_ref'];
?>
<!DOCTYPE html>
<html>

<head>
	<title>TF2 Weapon Skin Trading | TF2skins.com</title>
	<style>
		input {
			resize: horizontal;
			width: 200px;
		}

		input:active {
			width: auto;
		}

		input:focus {
			min-width: 200px;
		}

		input,
		select,
		textarea {
			color: black;
		}

	</style>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="assets/main.js"></script>


</head>

<body>


	<div style="position:fixed; text-align:center;width:100%; z-index:999;background:linear-gradient(to bottom right, #eeeeee, #1b435d);">
		<div id="logo"><img src="assets/logo.png" height="80px;"></div>
		<form method="get" class="form-group">
			<label for="search"></label><br><input type="text" id="search" class="form-control" placeholder="Enter Item Name to check how much bot will pay (Currently only trading war paints)">
		</form>

	</div>

	<div class="list-item" style="padding-top:10em;padding-left:5em;">



	</div>
</body>

</html>
