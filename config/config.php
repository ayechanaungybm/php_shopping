<?php

  // I think your apache is disabling the debugging errors.
  // Please add the 3 lines to display errors.
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  define('MYSQL_USER','root');
  define('MYSQL_PASSWORD','');
  define('MYSQL_HOST','localhost');
  define('MYSQL_DATABASE','aca_shoping');

  $options = array(
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
);

  $pdo=new PDO(
    'mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DATABASE,MYSQL_USER,MYSQL_PASSWORD,$options
  );

 ?>
