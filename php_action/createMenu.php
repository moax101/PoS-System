<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$menuName 		= $_POST['menuName'];
    $price 			= $_POST['price'];

	$menu = "SELECT * FROM menu_list WHERE menu_name = '$menuName'";
	$result = $connect->query($menu);

	if($result->num_rows == 1){
		$valid['success'] = true;
		$valid['messages'] = "Menu Already Exist";	
	}	
	else{
		$sql = "INSERT INTO menu_list (menu_name, price) 
		VALUES ('$menuName', '$price')";

		if($connect->query($sql) === TRUE) {
			$valid['success'] = true;
			$valid['messages'] = "New Menu Successfully added";	
		} else {
			$valid['success'] = false;
			$valid['messages'] = "Error while adding the members";
		}
	}

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST