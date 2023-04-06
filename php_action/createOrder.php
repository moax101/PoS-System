<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array(), 'order_id' => '');
// print_r($valid);
if($_POST) {

	$orderDate  		  = date('Y-m-d', strtotime($_POST['orderDate']));	
    $custName  			  = $_POST['custName'];	
    $totalAmountValue     = (int)$_POST['totalAmountValue'];
    $discount			  = (int)$_POST['discount'];
    $paid 				  = (int)$_POST['paid'];
    $dueValue 			  = (int)$_POST['dueValue'];

    $totalPaid = $discount + $paid;
    $totalChange = $totalPaid - $totalAmountValue;
    
    $totalNumber = 1;

	$orderNum = "SELECT * FROM total_order WHERE order_date = '$orderDate'";
	$result = $connect->query($orderNum);

	if($totalChange >= 0){

		$sql = "INSERT INTO order_list (order_date, customer_name, total_amount, discount, paid_amount, change_amount) VALUES ('$orderDate', '$custName', '$totalAmountValue', '$discount' ,'$paid', '$dueValue')";	

		if($result->num_rows == 1){
			$sql2 = "UPDATE total_order SET total_number = total_number + '$totalNumber', total_amount = total_amount + '$totalAmountValue' Where order_date = '$orderDate' ";
			$connect->query($sql2);
		}
		else{
			$sql2 = "INSERT INTO total_order (order_date, total_amount, total_number) VALUES ('$orderDate', '$totalAmountValue','$totalNumber')";
			$connect->query($sql2);				
		}


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
				VALUES ('$order_id', '".$_POST['menuName'][$x]."', '".$_POST['priceValue'][$x]."', '".$_POST['quantity'][$x]."', '".$_POST['totalValue'][$x]."')";

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
}