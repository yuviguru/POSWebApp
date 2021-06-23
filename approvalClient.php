<?php session_start();
  $CLT_CLIENT_ID=$_GET['CLT_CLIENT_ID'];

  $CLT_APPROVAL=$_GET['CLT_APPROVAL'];

  $APPROVAL=$_GET['APPROVAL'];

  include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';
   $sql_check_Approve = "SELECT * from client_master where CLT_CLIENT_ID REGEXP '^$CLT_CLIENT_ID'";
  $sql_Approve = $conn->query($sql_check_Approve);

  if($sql_Approve->num_rows > 0) {
    while ($sql_App = $sql_Approve->fetch_assoc()) {
      $Approval_Status=$sql_App["CLT_APPROVAL"];
      $CLT_DELETE_FLAG=$sql_App["CLT_DELETE_FLAG"];
    }
  }

  if(($CLT_APPROVAL=='PENDING') && ($APPROVAL=='APPROVE') && ($Approval_Status=='PENDING') && ($CLT_DELETE_FLAG=='NO')) {
    
    $sql_client_block = "UPDATE client_master set CLT_APPROVAL='YES' where CLT_CLIENT_ID REGEXP '^$CLT_CLIENT_ID'";
    $sql_block = $conn->query($sql_client_block);

    header('Location: viewClientDetails.php');

  }

  else if(($CLT_APPROVAL=='PENDING') && ($APPROVAL=='REJECT') && ($Approval_Status=='PENDING') && ($CLT_DELETE_FLAG=='NO')) {
    
    $sql_client_block = "UPDATE client_master set CLT_APPROVAL='NO' where CLT_CLIENT_ID REGEXP '^$CLT_CLIENT_ID'";
    $sql_block = $conn->query($sql_client_block);

    header('Location: viewClientDetails.php');

  }

   else if($Approval_Status=='YES') {
    
    echo"<script>alert('Already has been Approved by Another Admin!');
    window.top.location.href='viewClientDetails.php'</script>";

  }

  else if($Approval_Status=='NO') {
    
    echo"<script>alert('Already has been Rejected by Another Admin!');
    window.top.location.href='viewClientDetails.php'</script>";

  }
  
  $conn->close();
                         
?>