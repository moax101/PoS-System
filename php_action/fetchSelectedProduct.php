<?php   

require_once 'core.php';

$menuId = $_POST['menuId'];

$sql = "SELECT * FROM menu_list WHERE menu_id = $menuId";
$result = $connect->query($sql);

if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);