<?php 	

require_once 'core.php';

$orderId = $_POST['orderId'];

$sql = "SELECT order_date, total_amount, discount, paid_amount, change_amount FROM order_list WHERE order_id = $orderId";

$orderResult = $connect->query($sql);
$orderData = $orderResult->fetch_array();
$orderDate = $orderData[0];
$total_amount = $orderData[1];
$discount = $orderData[2]; 
$paid_amount = $orderData[3];
$change_amount = $orderData[4];


$orderItemSql = "SELECT * FROM item_list
	INNER JOIN menu_list ON item_list.menu_id = menu_list.menu_id 
 WHERE item_list.order_id = $orderId";
$orderItemResult = $connect->query($orderItemSql);

 $table = '
 <table border="1" cellspacing="0" cellpadding="20" width="100%">
	<thead>
		<tr >
			<th colspan="5">

			<center>
				Order Date : '.$orderDate.'
				<h1>Order Slip</h1>
			</center>		
			</th>
				
		</tr>		
	</thead>
</table>
<table border="0" width="100%;" cellpadding="5" style="border:1px solid black;border-top-style:1px solid black;border-bottom-style:1px solid black;">

	<tbody>
		<tr>
			<th>Item No.</th>
			<th>Menu Name</th>
			<th>Price</th>
			<th>Quantity</th>
			<th>Total Amount</th>
		</tr>';

		$x = 1;
		while($row = $orderItemResult->fetch_array()) {			
						
			$table .= '<tr>
				<th>'.$x.'</th>
				<th>'.$row[6].'</th>
				<th>'.$row[7].'</th>
				<th>'.$row[3].'</th>
				<th>'.$row[4].'</th>
			</tr>
			';
		$x++;
		} // /while

		$table .= '<tr>
			<th></th>
		</tr>

		<tr>
			<th></th>
		</tr>

		<tr>
			<th>Total Amount</th>
			<th>'.$total_amount.'</th>			
		</tr>	

		<tr>
			<th>Paid Amount</th>
			<th>'.$discount.'</th>			
		</tr>

		<tr>
			<th>Due Amount</th>
			<th>'.$paid_amount.'</th>			
		</tr>

		<tr>
			<th>Total Amount</th>
			<th>'.$change_amount.'</th>			
		</tr>

	</tbody>
</table>
 ';


$connect->close();

echo $table;