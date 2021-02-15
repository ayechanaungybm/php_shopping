<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require "../config/config.php";
require "../config/common.php";

$stmt=$pdo->prepare("DELETE FROM categories WHERE id=:id");
$result=$stmt->execute(
  array(':id'=>$_GET['id'])
);
if($result){
  header('location:category.php');
}
 ?>
