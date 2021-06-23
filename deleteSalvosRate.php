<?php session_start();
  $Rate_Id=$_GET['RAT_ID'];

  $Delete_Flag=$_GET['RAT_DELETE_FLAG'];

 include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';
  $sql_approve_block = "SELECT RAT_APPROVAL from rate_master where RAT_ID REGEXP '^$Rate_Id'";
  $sql_approve = $conn->query($sql_approve_block);
  $Approval_Status=$sql_approve->fetch_assoc()["RAT_APPROVAL"];
  
  if($Approval_Status=='EDITING') {
    
    echo"<script>alert('Currently being edited by another user !!!');window.top.location.href='viewSalvosRate.php'</script>";

  }
     else if($Delete_Flag=='NO') {
    
    $sql_client_block = "UPDATE rate_master set RAT_DELETE_FLAG='YES' where RAT_ID REGEXP '^$Rate_Id'";
    $sql_block = $conn->query($sql_client_block);

    header('Location: viewSalvosRate.php');

  }
  $conn->close();
                         
?>