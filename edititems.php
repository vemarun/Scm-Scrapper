<?php
require_once 'lib/parsecsv.lib.php';
if(isset($_POST['sub'])){
$item_name=$_POST['item_name'];
$quality=$_POST['quality'];
$ks=$_POST['killstreak'];
$key=$_POST['key'];
$ref=$_POST['ref'];
$rec=$_POST['rec'];
$scr=$_POST['scrap'];
$buysell=$_POST['buysell'];
$entry=$quality.$ks.$item_name.', '.$scr.'.'.$rec.'.'.$ref.'.'.$key.'.0, '.$buysell.PHP_EOL;
$fp=fopen("bot/trade.csv","a+");
if($fp==FALSE){
	echo "Error in opening File";
	exit();
}
	fwrite( $fp, $entry);
	fclose($fp);
}
?>
	<html>

	<head>
		<title>
			Edit csv file
		</title>
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
		<div id="block">
			<?php
           $file=fopen("bot/trade.csv","r"); 
			while(! feof($file)){ 
				print_r(fgetcsv($file)); 
				echo "<br>"; 
			} 
			fclose($file);
	?>
		</div>
	</body>

	</html>
