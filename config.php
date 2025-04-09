<?php
  
  $host = "localhost";
  $username = "root"; // Your MySQL username
  $password = ""; // Your MySQL password
  $dbname = "lms_db";
  
  $conn = mysqli_connect($host, $username, $password, $dbname);
  
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }
  ?>
  