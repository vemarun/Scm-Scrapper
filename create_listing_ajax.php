<?php 
include_once 'db_connect.php';
$c="select * from currency";
$result=mysqli_query($db,$c);
$currency=mysqli_fetch_assoc($result);
$ref_price=$currency['ref_price'];
$key_ref=$currency['key_ref'];

        if(isset($_GET['s'])){            // filter as value entered in input text field

            $value=$_GET['s'];            //filtering `s` is name of form input element

            $q="select * from imported where item_name like '%".$value."%' limit 100";
            $res=mysqli_query($db,$q);


            while($row=mysqli_fetch_array($res)){

                //fetch sell price from sell table

                $query="select price from sell where item_name='".$row['item_name']."'";
                $sell=mysqli_query($db,$query);
                $sellprice=mysqli_fetch_array($sell);

//checking whether buyprice 'price' <  'sellprice'

                $ex=explode('.', $row['price']);
                $ex2=explode('.', $sellprice['price']);
                $buy_price=($ex[0]*.11+$ex[1]*.33+$ex[2]+$ex[3]*$key_ref);
                $sell_price=($ex2[0]*.11+$ex2[1]*.33+$ex2[2]+$ex2[3]*$key_ref);

                if($sell_price <= $buy_price ){
                    $bgcolor='red';
                }
                else if(strpos($row['item_name'],'Unusual') !== false){
                    $bgcolor='#8650AC';
                    $bordercolor='#3C352E';
                }
                else if(strpos($row['item_name'],'Strange') !== false){
                    $bgcolor='#CF6A32';
                }
                else{
                    $bgcolor='white';
                }
                ?>

<div style="position:relative;float:left; padding: 20px;margin:5px;border:1px solid black; width:270px;height:270px;background-color:<?php echo $bgcolor?>;">
	<img src="<?php echo $row['item_img']; ?>"><br>
	<p>
		<?php echo $row['item_name'];?><br>
	</p>
	<form method="post">
		Name: <input type="text" value="<?php echo $row['item_name'];?>" class="item_name" readonly>
		<br> Buy :<input type="text" value="<?php echo $row['price'];?>" class="price">
		<br> Sell :<input type="text" value="<?php echo $sellprice['price'];?>" class="sellprice"><br>

		<a href="<?php echo $row['item_link']; ?>" target="_blank">
                            Scm: <?php echo $row['sale_price'];?> </a>
		<br><input type="submit" class="sub" value="update" name="sub">
	</form>
</div>

<?php  } } ?>
