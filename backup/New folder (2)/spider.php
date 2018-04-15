<?php
include_once 'db_connect.php';
include_once 'simple_html_dom.php';

set_time_limit(0);
$start = 0;
$count = 2;
$json_string = "http://steamcommunity.com/market/search/render/?query=&start=$1&count=$2&search_descriptions=0&sort_column=quantity&sort_dir=asc&appid=440&category_440_Collection[]=any&category_440_Type[]=any";
  $maxresults = 5 ;//PHP_INT_MAX;

//start
while($start<$maxresults){
	$url = str_replace( "$1", $start, $json_string );
    $url = str_replace( "$2", $count, $url );
		
$json_data = file_get_contents($url, true);
$obj = json_decode($json_data);
//$test=$obj->results_html;
print_r($obj);
	
 

///////////////////////Parsing Html/////////////////////////

$test=str_get_html($obj->results_html);
$item_link=$test->find("a[id=resultlink_$start]",$start)->href;
//var_dump($item_link);
$item_name=$test->find("a[id=resultlink_$start] > .market_listing_item_name",$start)  -> plaintext;
//var_dump($item_name);
$item_color=$test->find("a[id=resultlink_$start] > .market_listing_item_name",$start)  -> style;
//var_dump($item_color);
$normal_price=$test->find("a[id=resultlink_$start] > .normal_price", $start)  -> plaintext;
$sale_price=$test->find("a[id=resultlink_$start] > .sale_price", $start)  -> plaintext;
var_dump($normal_price);
var_dump($sale_price);
$item_image=$test->find("img[id=result_".$start."_image]",$start)->src;
//var_dump($item_image);
$img_color=$test->find("img[id=result_".$start."_image]",$start)->style;
//var_dump($img_color);
/**$dom = new DOMDocument();

$dom->loadHTML($test);
$xpath = new DomXPath($dom);

//item_detail

$item_links=$xpath->query("//a[@id='resultlink_".$start."']");
print_r($item_links);
foreach($item_links as $item_link){
//	$href=$item_links->getAttribute('href');
}
//print_r($href);
$item_name=$xpath->query("//span[@class='market_listing_item_name']")->item(0)->nodeValue;
	
print_r($item_name);


/**$item_color_class= $xpath->query("//[@class='market_listing_item_name']");
foreach($item_color_class as $item_colors){
$item_color=$item_colors->getAttribute('style');
}

//item_price
$normal_price = $xpath->query("//span[@class='normal_price']")->item(0)->nodeValue;
$sale_price= $xpath->query("//span[@class='sale_price']")->item(0)->nodeValue;

//item_image
$images = $xpath->query("//img[@id='result_".$start."_image']")->item(0)->nodeValue;
foreach ($images as $image) {
$item_image=$image->getAttribute('src');
$img_color=$image->getAttribute('style');
	
}**/
	mysqli_query($db,"insert into items(item_name,normal_price,sale_price,item_link,item_img,img_color,item_color) values('".$item_name."','".$normal_price."','".$sale_price."','".$item_link."','".$item_image."','".$img_color."','".$item_color."')");	


	  // $maxresults =$obj->total_count;

	$count = $obj->pagesize;
    $start += 1;
}
