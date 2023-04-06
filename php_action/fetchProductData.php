<?php 	

require_once 'core.php';

$sql = "SELECT * FROM menu_list";
$result = $connect->query($sql);

$data = $result->fetch_all();

$connect->close();

echo json_encode($data);