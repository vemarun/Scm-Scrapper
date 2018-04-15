<?php 
include_once 'db_connect.php';
$c="select * from currency";
$result=mysqli_query($db,$c);
$currency=mysqli_fetch_assoc($result);
$ref_price=$currency['ref_price'];
$key_ref=$currency['key_ref'];

        if(isset($_GET['s'])){            // filter as value entered in input text field

            $value=$_GET['s'];            //filtering `s` is name of form input element

            $q="select * from imported where item_name like '%".$value."%'";
            $res=mysqli_query($db,$q);


            while($row=mysqli_fetch_array($res)){


//converting price to human readable form

                $ex=explode('.', $row['price']);
                
                $number_ref=($ex[0]*.11+$ex[1]*.33+$ex[2]);
                
               $total_price= $ex[3].' Key '.$number_ref.' Refined Metal';
                
                if(strpos($row['item_name'],'Unusual') !== false){
                    $bgcolor='#8650AC';
                    $bordercolor='#3C352E';
                }
                else if(strpos($row['item_name'],'Strange') !== false){
                    $bgcolor='#CF6A32';
                }
                else{
                    $bgcolor='#f4f9f4';
                }
                ?>

<div style="position:relative;float:left; padding: 20px;margin:5px;border:.2px solid white; width:270px;height:270px;background-color:<?php echo $bgcolor?>;border-radius:25px;">


	<img src="<?php echo $row['item_img']; ?>"><br>
	<p>
		<?php echo $row['item_name'];?><br>
	</p>
	<div style="background-color:white;">
		<br>Bot will pay :<br>
		<b><?php echo $total_price; ?></b>
	</div>
	<a href="https://steamcommunity.com/tradeoffer/new/?partner=348723290&token=ydhmF_Sf" target="_blank"><button class="btn btn-info" style="margin:0 auto;">Trade </button></a>


</div>


<?php  } }?>
