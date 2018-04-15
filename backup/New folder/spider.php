<?php
include_once 'db_connect.php';
include_once 'simple_html_dom.php';

set_time_limit(0);
$start = 0;
  $count = 1;
$json_string = "http://steamcommunity.com/market/search/render/?query=&start=$1&count=$2&search_descriptions=0&sort_column=quantity&sort_dir=asc&appid=440&category_440_Collection[]=any&category_440_Type[]=any";
  $maxresults = 4;//PHP_INT_MAX;

//start
while($count<$maxresults){
	$url = str_replace( "$1", $start, $json_string );
    $url = str_replace( "$2", $count, $url );
		
$json_data = file_get_contents($url, true);
$obj = json_decode($json_data);
$test=$obj->results_html;
print_r($obj);

  // $ch = curl_init();
  //  curl_setopt( $ch, CURLOPT_URL, $url );
  //  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
  //  $result = json_decode( curl_exec( $ch ), TRUE );
  //  curl_close( $ch );


///////////////////////Parsing Html/////////////////////////

$dom = new DOMDocument();

$dom->loadHTML($test);
$xpath = new DomXPath($dom);

//item_detail

$item_links=$xpath->query("//a[@id='resultlink_".$start."']");
//foreach($item_links as $item_link){
	$href=$item_links->getAttribute('href');
//}
print_r($href);
$item_name=$xpath->query("//span[@class='market_listing_item_name']")->item($start)->nodeValue;
	
print_r($item_name);

$item_color_class= $xpath->query("//[@class='market_listing_item_name']");
foreach($item_color_class as $item_colors){
$item_color=$item_colors->getAttribute('style');
}

//item_price
$normal_price = $xpath->query("//a[@id='resultlink_".$start."' > //span[@class='normal_price']")->item(0)->nodeValue;
$sale_price= $xpath->query("//span[@class='sale_price']")->item(0)->nodeValue;

//item_image
$images = $xpath->query("//img[@id='result_".$start."_image']");
foreach ($images as $image) {
$item_image=$image->getAttribute('src');
$img_color=$image->getAttribute('style');
	
}
	mysqli_query($db,"insert into items(item_name,normal_price,sale_price,item_link,item_img,img_color,item_color) values('".$item_name."','".$normal_price."','".$sale_price."','".$href."','".$item_image."','".$img_color."','".$item_color."')");	

	$count = $obj->pagesize;
    $start += $count;
    //$maxresults = $obj->total_count;
	//sleep(5);
}
