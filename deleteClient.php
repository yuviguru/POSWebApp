<?php session_start();
  $Client_ID=$_GET['Client_ID'];

  $Delete_Flag=$_GET['Delete_Flag'];

 include 'db-conn.php';
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';
    $sql_approve_block = "SELECT CLT_APPROVAL from client_master where CLT_CLIENT_ID REGEXP '^$Client_ID'";
    $sql_approve = $conn->query($sql_approve_block);
    $Approval_Status=$sql_approve->fetch_assoc()["CLT_APPROVAL"];    
    if($Approval_Status=='EDITING') {
      echo"<script>alert('Currently being edited by another user !!!');
      window.top.location.href='viewClientDetails.php'</script>";
    }
    else if($Delete_Flag=='NO') {
      
      $sql_client_block = "UPDATE client_master set CLT_DELETE_FLAG='YES' where CLT_CLIENT_ID REGEXP '^$Client_ID'";
      $sql_block = $conn->query($sql_client_block);

      header('Location: viewClientDetails.php');
    }
    $conn->close();     
?>