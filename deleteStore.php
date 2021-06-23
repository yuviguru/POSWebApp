<?php session_start();
  $Store_ID=$_GET['Store_ID'];

  $Delete_Flag=$_GET['Delete_Flag'];

  include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';
    $sql_approve_block = "SELECT STR_APPROVAL from store_master where STR_PKID REGEXP '^$Store_ID'";
    $sql_approve = $conn->query($sql_approve_block);
    $Approval_Status=$sql_approve->fetch_assoc()["STR_APPROVAL"];

  if($Approval_Status=='EDITING') {
    
    echo"<script>alert('Currently being edited by another user !!!');window.top.location.href='viewStoreDetails.php'</script>";

  }
  
    else if($Delete_Flag=='NO') {
    
    $sql_client_block = "UPDATE store_master set STR_DELETE_FLAG='YES' where STR_PKID REGEXP '^$Store_ID'";
    $sql_block = $conn->query($sql_client_block);

    header('Location: viewStoreDetails.php');

  }
  
  
  $conn->close();
                         
?>