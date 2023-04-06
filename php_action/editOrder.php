<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	
	$orderId = $_POST['orderId'];

  $orderDate 						= date('Y-m-d', strtotime($_POST['orderDate']));
  $custName 						= $_POST['custName'];
  $totalAmountValue 			    = (int)$_POST['totalAmount'];
  $discount			  				= (int)$_POST['discount'];
  $paid 				  			= (int)$_POST['paid'];
  $dueValue 			  			= (int)$_POST['dueValue'];

	
    $totalPaid = $discount + $paid;
    $totalChange = $totalPaid - $totalAmountValue;

    $totalNumber = 1;

	if($totalChange >= 0){

		$sql2 = "DELETE FROM item_list WHERE order_id = {$orderId}";
		$connect->query($sql2);

		$sql = "UPDATE order_list SET order_date = '$orderDate', customer_name = '$custName', total_amount = '$totalAmountValue', discount = '$discount', paid_amount = '$paid', change_amount = '$dueValue' WHERE order_id = {$orderId}";	
		
	$order_id;
	$orderStatus = false;
	if($connect->query($sql) === true) {
		$order_id = $connect->insert_id;
		$valid['order_id'] = $order_id;	

		$orderStatus = true;
	}

		
	// echo $_POST['productName'];
	$orderItemStatus = false;

	
		for($x = 0; $x < count($_POST['menuName']); $x++) {
				$orderItemSql = "INSERT INTO item_list (order_id, menu_id , menu_price, quantity, total) 
				VALUES ('$orderId', '".$_POST['menuName'][$x]."', '".$_POST['priceValue'][$x]."', '".$_POST['quantity'][$x]."', '".$_POST['totalValue'][$x]."')";

				$connect->query($orderItemSql);		

				if($x == count($_POST['menuName'])) {
					$orderItemStatus = true;
				}			
		} // /for quantity

	$valid['success'] = true;
	$valid['messages'] = "Successfully Added";
	}else 
	{
		$valid['success'] = false;
		$valid['messages'] = "Paid Amount is not Enough";		
	}	
	$connect->close();

	echo json_encode($valid); 		

 
} // /if $_POST
// echo json_encode($valid);