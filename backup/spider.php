<?php
include_once 'db_connect.php';
set_time_limit(0);

		$json_string = "http://steamcommunity.com/market/search/render/?query=&start=0&count=1000&search_descriptions=0&sort_column=quantity&sort_dir=asc&appid=440&category_440_Collection[]=any&category_440_Type[]=any";
$json_data = file_get_contents($json_string, true);
$obj = json_decode($json_data);
$test=$obj->results_html;


///////////////////////Parsing Html/////////////////////////

$dom = new DOMDocument();

$dom->loadHTML($test);
$images = $dom->getElementsByTagName('img');
foreach ($images as $image) {
$href=$image->getAttribute('src');
	

	mysqli_query($db,"insert into list(img) values('".$href."')");	
}
