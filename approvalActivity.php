<?php session_start();
  $ACT_PKID=$_GET['ACT_PKID'];

  $ACT_APPROVAL=$_GET['ACT_APPROVAL'];

  $APPROVAL=$_GET['APPROVAL'];

  include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';
  $sql_check_Approve = "SELECT * from activity_master where ACT_PKID REGEXP '^$ACT_PKID'";
  $sql_Approve = $conn->query($sql_check_Approve);

  if($sql_Approve->num_rows > 0) {
    while ($sql_App = $sql_Approve->fetch_assoc()) {
      $Approval_Status=$sql_App["ACT_APPROVAL"];
      $ACT_DELETE_FLAG=$sql_App["ACT_DELETE_FLAG"];
    }
  }

  if(($ACT_APPROVAL=='PENDING') && ($APPROVAL=='APPROVE') && ($Approval_Status=='PENDING') && ($ACT_DELETE_FLAG=='NO')) {
    
    $sql_client_block = "UPDATE activity_master set ACT_APPROVAL='YES' where ACT_PKID REGEXP '^$ACT_PKID'";
    $sql_block = $conn->query($sql_client_block);

    header('Location: viewActivityDetails.php');

  }

  else if(($ACT_APPROVAL=='PENDING') && ($APPROVAL=='REJECT') && ($Approval_Status=='PENDING') && ($ACT_DELETE_FLAG=='NO')) {
    
    $sql_client_block = "UPDATE activity_master set ACT_APPROVAL='NO' where ACT_PKID REGEXP '^$ACT_PKID'";
    $sql_block = $conn->query($sql_client_block);

    header('Location: viewActivityDetails.php');

  }

  else if($Approval_Status=='YES') {
    
    echo"<script>alert('This Activity Already has been Approved by Another Admin!');
    window.top.location.href='viewActivityDetails.php'</script>";

  }

  else if($Approval_Status=='NO') {
    
    echo"<script>alert('This Activity Already has been Rejected by Another Admin!');
    window.top.location.href='viewActivityDetails.php'</script>";

  }
  
  $conn->close();
                         
?>