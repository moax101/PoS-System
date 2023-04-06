<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {
	$menu_id = $_POST['menuId'];
	$menu_name	= $_POST['editMenuName']; 
	$price 	= $_POST['editPrice'];

				
	$sql = "UPDATE menu_list SET menu_name = '$menu_name', price = '$price' WHERE menu_id = $menu_id ";

	if($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = "Successfully Update";	
	} else {
		$valid['success'] = false;
		$valid['messages'] = "Error while updating product info";
	}

} // /$_POST
	 
$connect->close();

echo json_encode($valid);
 
