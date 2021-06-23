<?php session_start();
  $ELE_PKID=$_GET['ELE_PKID'];

  $Delete_Flag=$_GET['ELE_DELETE_FLAG'];

  include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';
  $sql_approve_block = "SELECT ELE_APPROVAL from element_master where ELE_PKID REGEXP '^$ELE_PKID'";
  $sql_approve = $conn->query($sql_approve_block);
  $Approval_Status=$sql_approve->fetch_assoc()["ELE_APPROVAL"];

  if($Approval_Status=='EDITING') {
    
    echo"<script>alert('Currently being edited by another user !!!');window.top.location.href='viewElementsDetails.php'</script>";

  }
  else if($Delete_Flag=='NO') {
    
    $sql_element_block = "UPDATE element_master set ELE_DELETE_FLAG='YES' where ELE_PKID REGEXP '^$ELE_PKID'";
    $sql_block = $conn->query($sql_element_block);

    header('Location: viewElementsDetails.php');

  }
    
  
  $conn->close();
                         
?>