<center>
	<form method="post">
		<input type="text" name="query" placeholder="Insert query to search steam market" size="40" width="40"><br>
		<select name="wear">
		<option></option>
		<option>Factory New</option>
		<option>Minimal Wear</option>
		<option>Field Tested</option>
		<option>Well Worn</option>
		<option>Battle Scarred</option></select>

		<input type="submit" name="sub">
	</form>
</center>


<?php
include_once 'db_connect.php';
include_once 'simple_html_dom.php';

$wear=$_POST['wear'];
$query=$_POST['query'].$wear;


$query=str_replace(" ","+",$query);

set_time_limit(0);
$start = 0;
$count = 100;
$json_string = "http://steamcommunity.com/market/search/render/?query=$query&start=$1&count=$2&search_descriptions=0&sort_column=quantity&sort_dir=asc&appid=440&category_440_Collection[]=any&category_440_Type[]=any";
$maxresults =PHP_INT_MAX;

//start
while($start<$maxresults){
	$url = str_replace( "$1", $start, $json_string );
    $url = str_replace( "$2", $count, $url );
		
$json_data = file_get_contents($url, true);
$obj = json_decode($json_data);
$test=$obj->results_html;
print_r($obj);
	
$maxresults =$obj->total_count;

$count = $maxresults;
$start += $count;
}

for($start=0;$start<=$count;$start++){
$dom = new DOMDocument();

$dom->loadHTML($test);
$xpath = new DomXPath($dom);

//item_detail

$item_links=$xpath->query("//a[@id='resultlink_".$start."']");

foreach($item_links as $item_link){
	$href=$item_link->getAttribute('href');
	//print_r($href);
	//echo "<br>";
}
	
//print_r($href);
$item_namess=$xpath->query("//a[@id='resultlink_".$start."']//span[@class='market_listing_item_name']");
foreach($item_namess as $item_names){
	$item_name=$item_names->nodeValue;
	//print_r($item_name);
	//echo "<br>";
}



$item_color_class= $xpath->query("//a[@id='resultlink_".$start."']//span[@class='market_listing_item_name']");
foreach($item_color_class as $item_colors){
$item_color=$item_colors->getAttribute('style');
	//print_r($item_color);
	//echo "<br>";
}

//item_price
$normal_pricess = $xpath->query("//a[@id='resultlink_".$start."']//span[@class='normal_price']");
$sale_pricess= $xpath->query("//a[@id='resultlink_".$start."']//span[@class='sale_price']");
	foreach($normal_pricess as $normal_prices){
		$normal_price=$normal_prices->nodeValue;
		//print_r($normal_price);
		//echo "<br>";
	}
	foreach($sale_pricess as $sale_prices){
		$sale_price=$sale_prices->nodeValue;
		//print_r($sale_price);
		//echo "<br>";
	}

//item_image 
$images = $xpath->query("//img[@id='result_".$start."_image']"); //->item(0)->nodeValue;
foreach ($images as $image) {
$item_image=$image->getAttribute('src');
$img_color=$image->getAttribute('style');
	//print_r($item_image);
	//echo "<br>";
	//print_r($img_color);
	//echo "<br><br><br>";
}
	mysqli_query($db,"insert into items(item_name,normal_price,sale_price,item_link,item_img,img_color,item_color) values('".$item_name."','".$normal_price."','".$sale_price."','".$href."','".$item_image."','".$img_color."','".$item_color."')");
}
