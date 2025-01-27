<?php 

  $hostname = 'localhost';
  $username = 'root';
  $password = '';
  $db = 'you data base name';
  $conn = new mysqli($hostname,$username,$password,$db);

  if($conn->error){
    die("FAILED TO CONNECT WITH DATABSE");
  }

?>
