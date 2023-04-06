<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$menuId = $_POST['menuId'];

if($menuId) { 

 $sql = "DELETE FROM menu_list WHERE menu_id = {$menuId}";

 if($connect->query($sql) === TRUE) {
 	$valid['success'] = true;
	$valid['messages'] = "Successfully Removed";		
 } else {
 	$valid['success'] = false;
 	$valid['messages'] = "Error while remove the brand";
 }
 
 $connect->close();

 echo json_encode($valid);
 
} // /if $_POST