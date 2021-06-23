<?php session_start();
  $BRN_PKID=$_GET['BRN_PKID'];

  $Delete_Flag=$_GET['Delete_Flag'];

  include 'db-conn.php';
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';

    $sql_approve_block = "SELECT BRN_APPROVAL from branch_master where BRN_PKID REGEXP '^$BRN_PKID'";
    $sql_approve = $conn->query($sql_approve_block);
    $Approval_Status=$sql_approve->fetch_assoc()["BRN_APPROVAL"];
    
    
    if($Approval_Status=='EDITING') {
    
      echo"<script>alert('Currently being edited by another user !!!');window.top.location.href='viewBranchDetails.php'</script>";

    }

    else if($Delete_Flag=='NO') {
    
      $sql_client_block = "UPDATE branch_master set BRN_DELETE_FLAG='YES' where BRN_PKID REGEXP '^$BRN_PKID'";
      $sql_block = $conn->query($sql_client_block);

      header('Location: viewBranchDetails.php');

    }
  
  $conn->close();
                         
?>