<?php
/**
 * Created by PhpStorm.
 * User: verma
 * Date: 2/2/2018
 * Time: 3:17 AM
 */
include_once 'db_connect.php';

    $item_name= $_POST['item_name'];
    $price= $_POST['price'];
    $sellprice=$_POST['sellprice'];

$buy_status='';
$sell_status='';

    $update="update imported set price='".$price."' where item_name='".$item_name."'"; //update imported table
    $update2="update buy set price='".$price."' where item_name='".$item_name."'"; //update imported 
    if((mysqli_query($db,$update)) && (mysqli_query($db,$update2))){
	$buy_status="Buy price updated";
	} 
else{
	 $buy_status= die(mysqli_error($db));
}

    $query="update sell set price='".$sellprice."' where item_name='".$item_name."'";  //update sell table
    if(mysqli_query($db,$query)){
		$sell_status="Sell price updated ";
	}  else{
		$sell_status= die(mysqli_error($db));
	}
    
 print_r($_POST);

	echo $buy_status;
	
	echo $sell_status; ?>
