<?php session_start();
 include 'header.php';

  $ACT_PKID=$_GET['ACT_PKID'];

  $Delete_Flag=$_GET['Delete_Flag'];


  include 'db-conn.php';
 
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';
    $sql_approve_block = "SELECT ACT_APPROVAL from activity_master where ACT_PKID REGEXP '^$ACT_PKID'";
    $sql_approve = $conn->query($sql_approve_block);
    $Approval_Status=$sql_approve->fetch_assoc()["ACT_APPROVAL"];
    
    if($Approval_Status=='EDITING') {
        
        echo"<script>alert('Currently being edited by another user !!!');window.top.location.href='viewActivityDetails.php'</script>";

      }
      else if($Delete_Flag=='NO') {
        
        $sql_client_block = "UPDATE activity_master set ACT_DELETE_FLAG='YES' where ACT_PKID REGEXP '^$ACT_PKID'";
        $sql_block = $conn->query($sql_client_block);

        header('Location: viewActivityDetails.php');

      }
  
  $conn->close();
                         
?>