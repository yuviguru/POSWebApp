<?php session_start();
  $BRD_ID=$_GET['brandID'];

  $Delete_Flag=$_GET['Delete_Flag'];

  include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';

    $sql_approve_block = "SELECT BRD_APPROVAL from brand_master where BRD_ID REGEXP '^$BRD_ID'";
    $sql_approve = $conn->query($sql_approve_block);
    $Approval_Status=$sql_approve->fetch_assoc()["BRD_APPROVAL"];
    
    
    if($Approval_Status=='EDITING') {
    
      echo"<script>alert('Currently being edited by another user !!!');window.top.location.href='viewBrandDetails.php'</script>";

    }

    else if($Delete_Flag=='NO') {
    
      $sql_client_block = "UPDATE brand_master set BRD_DELETE_FLAG='YES' where BRD_ID REGEXP '^$BRD_ID'";
      $sql_block = $conn->query($sql_client_block);

      header('Location: viewBrandDetails.php');

    }
  
  
  $conn->close();
                         
?>