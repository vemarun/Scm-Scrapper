<?php
set_time_limit(0);
include_once 'db_connect.php';
$q="select item_name, item_img from items";
$res=mysqli_query($db,$q);
while($r=mysqli_fetch_array($res)){
	$url=$r['item_img'];
	$img="images/".$r['item_name'].".png";
	file_put_contents($img, file_get_contents($url));
}
