<?php
include_once 'db_connect.php';

//getting currency prices from table  should be updated regularly via backpack.tf api
$c="select * from currency";
$result=mysqli_query($db,$c);
$currency=mysqli_fetch_assoc($result);
$ref_price=$currency['ref_price'];
$key_ref=$currency['key_ref'];



$q="select item_name,sale_price,item_img,item_link from items where item_name LIKE '%war paint%'";
$res=mysqli_query($db,$q);
while($row = mysqli_fetch_array($res)){
	
	/***************** converting to key,refine and scrap ******************/
	$sale_price=(($row['sale_price']));
	$total_ref=(($sale_price)/$ref_price);


$key=(int)(($total_ref)/$key_ref);           // value in key
$ref=(int)($total_ref-($key*$key_ref));      // rest value in ref 

$total_scrap=($total_ref-(($key*$key_ref)+$ref));    // rest value in scrap
$scr=(int)($total_scrap/.11);                     // Number of total scrap
$rec=(int)($scr/3);                               // Number of reclaimed metal
$scrap=((($scr*.11)-($rec*.33))/.11);    // Number of scrap
	
	/***************** Conversion Complete *******************************/
	
	
	//formatting price to fit in csv file
	
	$price=$scrap.'.'.$rec.'.'.$ref.'.'.$key.'.0';  //format scrap.reclaimed.ref.key.bud
	
	
	$query="insert into sell(item_name,price) values('".$row['item_name']."','".$price."')";
	$insert=mysqli_query($db,$query);
	
}
