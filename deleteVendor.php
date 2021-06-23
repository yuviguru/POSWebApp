<?php session_start();
  $VEN_PKID=$_GET['VEN_PKID'];

  $Delete_Flag=$_GET['DELETE_FLAG'];

 include 'db-conn.php';
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';

  $sql_approve_block = "SELECT VEN_APPROVAL from vendor_master where VEN_PKID REGEXP '^$VEN_PKID'";
  $sql_approve = $conn->query($sql_approve_block);

  $Approval_Status=$sql_approve->fetch_assoc()["VEN_APPROVAL"];
    

  if($Approval_Status=='EDITING') {
    echo"<script>alert('Currently being edited by another user !!!');window.top.location.href='viewVendorDetails.php'</script>";
  }
  
  else if($Delete_Flag=='NO') {
    
    $sql_client_block = "UPDATE vendor_master set DELETE_FLAG='YES' where VEN_PKID REGEXP '^$VEN_PKID'";
    $sql_block = $conn->query($sql_client_block);

    header('Location: viewVendorDetails.php');

  }

  
  $conn->close();
                         
?>