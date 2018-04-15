<?php
include_once 'db_connect.php';
$row=440;


$total_ref=($row)/0.07;

//$total_ref=37.77;
$key=(int)(($total_ref)/36.66);
$ref=(int)($total_ref-($key*36.66));

$total_scrap=($total_ref-(($key*36.66)+$ref));
$scr=(int)($total_scrap/.11);
$rec=(int)($scr/3);
$scrap=((($scr*.11)-($rec*.33))/.11);





print_r($total_ref);
echo "<br>Total key:  ";
print_r($key);
echo "<br>Total ref:  ";
print_r($ref);
echo "<br>Total scrap:  ";
print_r($total_scrap);
echo "<br>Scr :  ";
print_r($scr);
echo "<br>scrap:  ";
print_r($scrap);
echo "<br>reclaimed:  ";
print_r($rec);

$price=$scr.'.'.$rec.'.'.$ref.'.'.$key.'.0';
echo "<br>price:  ";
print_r($price);

//$p="selectREPLACE(REPLACE('$ 2.5 USD','$',''),USD, '')";
//$q=mysqli_query($db,$p);
//echo $q;

$p=(93-((40*93)/100));
//echo "<br>";
	//echo $p;
echo "<br> Converting back to refine<br>";
//$price='0.2.3.5.0';
$ex=explode('.', $price);
$tot_ref=($ex[0]*.11+$ex[1]*.33+$ex[2]+$ex[3]*36.66);
print_r($tot_ref);


?>
