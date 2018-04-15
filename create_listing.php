<?php 
include_once 'db_connect.php';
$c="select * from currency";
$result=mysqli_query($db,$c);
$currency=mysqli_fetch_assoc($result);
$ref_price=$currency['ref_price'];
$key_ref=$currency['key_ref'];
?>



<html>

<head>
	<title>load more</title>
	<style>
		input {
			resize: horizontal;
			width: 200px;
		}

		input:active {
			width: auto;
		}

		input:focus {
			min-width: 200px;
		}

		input,
		select,
		textarea {
			color: black;
		}

	</style>
	<script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script>
		$(document).ready(function() {
			$('.loader').bind('ajaxStart', function() {
				$(this).show();
			}).bind('ajaxStop', function() {
				$(this).hide();
			});



			$(function() {
				$('.sub').click(function(e) {
					e.preventDefault();
					var item_name = $(this).parent().find('.item_name').val();
					var price = $(this).parent().find('.price').val();
					var sellprice = $(this).parent().find('.sellprice').val();
					console.log(item_name);
					$.ajax({
						type: 'POST',
						url: 'update_price.php',
						data: {
							item_name: item_name,
							price: price,
							sellprice: sellprice
						},
						success: function(data) {
							$('.status').html(data);
						}
					});

				});
				return false;

			});



			$(function() {
				$("#search").keyup(function(e) {
					e.preventDefault();

					var value = $("#search").val();

					$.ajax({
						type: 'GET',
						url: 'create_listing.php',
						data: 's=' + value,
						success: function(data) {
							$('.list-item').html(data);


						}

					});

				});
				return false;
			});

		});

	</script>

</head>

<body>


	<div style="position:fixed; text-align:center;width:100%; z-index:999;background-color:lightgrey;top:0px; color:black;">
		<form method="get">
			Filter : <input type="text" id="search">
		</form>
		<p class="status" style="color:green">
			Status here : Current Refine price:
			<?php echo $ref_price;?>$ || 1 key =
			<?php echo $key_ref;?> ref
		</p>
		<div class="loader" style="display:none">
			<img src="loader.gif">
		</div>
	</div>


	<div class="list-item" style="padding-top:5em">
		<?php
        if(isset($_GET['s'])){            // filter as value entered in input text field

            $value=$_GET['s'];            //filtering `s` is name of form input element

            $q="select * from imported where item_name like '%".$value."%'";
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
				<?php echo $row['id'];?><img src="<?php echo $row['item_img']; ?>"><br>
				<p>
					<?php echo $row['item_name'];?><br>
				</p>
				<form method="post">
					Name: <input type="text" value="<?php echo $row['item_name'];?>" class="item_name" name="item_name" readonly>
					<br> Buy :<input type="text" value="<?php echo $row['price'];?>" class="price" name="price">
					<br> Sell :<input type="text" value="<?php echo $sellprice['price'];?>" class="sellprice" name="sellprice"><br>

					<a href="<?php echo $row['item_link']; ?>" target="_blank">
                            Scm: <?php echo $row['sale_price'];?> </a>
					<br><input type="submit" class="sub" value="update">
				</form>
			</div>

			<?php  } } else {

		
$q="select * from imported";
$res=mysqli_query($db,$q);

if(mysqli_num_rows($res)>0){
while($row=mysqli_fetch_array($res)){
	
	//fetching item sellprice from `sell` table
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
			<form method="post">
				<div style="position:relative;float:left; padding: 20px;margin:5px;border:1px solid black; width:270px;height:270px;background-color:<?php echo $bgcolor?>;">
					<?php echo $row['id'];?><img src="<?php echo $row['item_img']; ?>"><br>
					<p>
						<?php echo $row['item_name'];?>
					</p>

					Name: <input type="text" value="<?php echo $row['item_name'];?>" class="item_name" name="item_name" readonly>
					<br> Buy : <input type="text" value="<?php echo $row['price'];?>" class="price" name="price">
					<br> Sell: <input type="text" value="<?php echo $sellprice['price'];?>" class="sellprice" name="sellprice">
					<br>
					<a href="<?php echo $row['item_link']; ?>" target="_blank">
						Scm: <?php echo $row['sale_price'];?> </a>
					<br>
					<input type="submit" value="Update" class="sub">
				</div>


				<?php  }?>

			</form>

			<?php  } }?>


	</div>
</body>

</html>
