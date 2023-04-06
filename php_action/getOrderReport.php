<?php 

require_once 'core.php';

if($_POST) {

	$startDate = $_POST['startDate'];
	$date = DateTime::createFromFormat('m/d/Y',$startDate);
	$start_date = $date->format("Y-m-d");


	$endDate = $_POST['endDate'];
	$format = DateTime::createFromFormat('m/d/Y',$endDate);
	$end_date = $format->format("Y-m-d");

	
	$sql = "SELECT *, sum(total_amount) s, COUNT(*) c FROM order_list WHERE order_date >= '$start_date' AND order_date <= '$end_date' GROUP BY order_date HAVING c >= 1 ORDER BY order_date ASC";
	// $sql2 ="SELECT COUNT(*) FROM item_list JOIN order_list ON (item_list.order_id=order_list.order_id) WHERE order_list.order_date >= '$start_date' AND order_list.order_date <= '$end_date' ";
	$query = $connect->query($sql);
	// $query2 = $connect->query($sql2);
	// $rowcount=mysqli_num_rows($query2);

	$table = '
	<table border="1" cellspacing="2" cellpadding="2" style="width:100%;">
		<tr>
			<th colspan="1">Order Date</th>
			<th colspan="1">Total Amount</th>
			<th colspan="1">Total Number</th>			
		</tr>

		<tr>';
		$totalAmount = 0;
		while ($result = $query->fetch_assoc()) {
			$table .= '<tr>
				<td colspan="1" ><center>'.$result['order_date'].'</center></td>
				<td colspan="1" ><center>'.$result['s'].'</center></td>
				<td colspan="1" ><center>'.$result['c'].'</center></td>				
			</tr>';	
			$totalAmount = $totalAmount + $result['s'];
		}
		$table .= '
		</tr>
	</table>
	
	<br>
	<br>
	
	<table border="1" cellspacing="2" cellpadding="2" style="width:100%;">	
		<tr>
			<td colspan="2"><center>Overall Total Amount</center></td>
			<td colspan="1"><center>'.$totalAmount.'</center></td>
		</tr>
	</table>
	';	

	echo $table;

}

?>