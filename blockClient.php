<?php session_start();
  $Client_ID=$_GET['Client_ID'];

  $Client_Active=$_GET['Client_Active'];

 include 'db-conn.php';
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  if($Client_Active=='YES') {

    $sql_client_block = "UPDATE client_master set Client_Active='NO' where Client_ID REGEXP '^$Client_ID'";
    $sql_block = $conn->query($sql_client_block);

    header('Location: viewClientDetails.php');

  }

  if($Client_Active=='NO') {
    
    $sql_client_block = "UPDATE client_master set Client_Active='YES' where Client_ID REGEXP '^$Client_ID'";
    $sql_block = $conn->query($sql_client_block);

    header('Location: viewClientDetails.php');

  } 
  
  $conn->close();
                         
?>