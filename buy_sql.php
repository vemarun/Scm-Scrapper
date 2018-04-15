<html>

<head>
	<title>
		Edit csv file
	</title>

	<script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>

	<script>


	</script>
</head>

<body>
	<center>
		<form method="post">
			<input type="text" name="item_name" placeholder="Item name" size="40px"> Quality:
			<select name="quality">
				<option></option>
				<option>Strange&nbsp;</option>
				<option>Unusual&nbsp;</option>
				<option>Genuine&nbsp;</option>
			</select>Killstreak:<select name="killstreak">
			    <option></option>
				<option>Killstreak&nbsp;</option>
				<option>Specialized Killstreak&nbsp;</option>
				<option>Professional Killstreak&nbsp;</option></select><br><br>
			<input type="text" name="key" placeholder="value in key">
			<input type="text" name="ref" placeholder="value in refine">
			<input type="text" name="rec" placeholder="value in reclaimed">
			<input type="text" name="scrap" placeholder="value in scrap">
			<input type="text" name="bud" value="0" disabled>
			<select name="buysell">
			<option> buy<br></option>
			<option> sell<br></option></select><br><br>
			<input type="submit" name="sub">
		</form>
	</center>
</body>

</html>
