<?php session_start();
  $BRD_ID=$_GET['BRD_ID'];

  $BRD_APPROVAL=$_GET['BRD_APPROVAL'];

  $APPROVAL=$_GET['APPROVAL'];

 include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';
 $sql_check_Approve = "SELECT * from brand_master where BRD_ID REGEXP '^$BRD_ID'";
  $sql_Approve = $conn->query($sql_check_Approve);

  if($sql_Approve->num_rows > 0) {
    while ($sql_App = $sql_Approve->fetch_assoc()) {
      $Approval_Status=$sql_App["BRD_APPROVAL"];
      $BRD_DELETE_FLAG=$sql_App["BRD_DELETE_FLAG"];
    }
  }
  if(($BRD_APPROVAL=='PENDING') && ($APPROVAL=='APPROVE') && ($Approval_Status=='PENDING') && ($BRD_DELETE_FLAG=='NO')) {
    
    $sql_brand_block = "UPDATE brand_master set BRD_APPROVAL='YES' where BRD_ID REGEXP '^$BRD_ID'";
    $sql_block = $conn->query($sql_brand_block);

    header('Location: viewBrandDetails.php');

  }

  else if(($BRD_APPROVAL=='PENDING') && ($APPROVAL=='REJECT') && ($Approval_Status=='PENDING') && ($BRD_DELETE_FLAG=='NO')) {
    
    $sql_brand_block = "UPDATE brand_master set BRD_APPROVAL='NO' where BRD_ID REGEXP '^$BRD_ID'";
    $sql_block = $conn->query($sql_brand_block);

    header('Location: viewBrandDetails.php');

  }

  else if($Approval_Status=='YES') {
    
    echo"<script>alert('Already has been Approved by Another Admin!');
    window.top.location.href='viewBrandDetails.php'</script>";

  }

  else if($Approval_Status=='NO') {
    
    echo"<script>alert('Already has been Rejected by Another Admin!');
    window.top.location.href='viewBrandDetails.php'</script>";

  }
  
  $conn->close();
                         
?>