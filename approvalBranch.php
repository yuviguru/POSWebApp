<?php session_start();
  $BRN_ID=$_GET['BRN_ID'];

  $BRN_APPROVAL=$_GET['BRN_APPROVAL'];

  $APPROVAL=$_GET['APPROVAL'];

  include 'db-conn.php';
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  
    include 'check_page_access.php';
   $sql_check_Approve = "SELECT * from branch_master where BRN_PKID REGEXP '^$BRN_ID'";
  $sql_Approve = $conn->query($sql_check_Approve);

  if($sql_Approve->num_rows > 0) {
    while ($sql_App = $sql_Approve->fetch_assoc()) {
      $Approval_Status=$sql_App["BRN_APPROVAL"];
      $BRN_DELETE_FLAG=$sql_App["BRN_DELETE_FLAG"];
    }
  }

  if(($BRN_APPROVAL=='PENDING') && ($APPROVAL=='APPROVE') && ($Approval_Status=='PENDING') && ($BRN_DELETE_FLAG=='NO')) {
    
    $sql_branch_block = "UPDATE branch_master set BRN_APPROVAL='YES' where BRN_PKID REGEXP '^$BRN_ID'";
    $sql_block = $conn->query($sql_branch_block);

    header('Location: viewBranchDetails.php');

  }

  else if(($BRN_APPROVAL=='PENDING') && ($APPROVAL=='REJECT') && ($Approval_Status=='PENDING') && ($BRN_DELETE_FLAG=='NO')) {
    
    $sql_branch_block = "UPDATE branch_master set BRN_APPROVAL='NO' where BRN_PKID REGEXP '^$BRN_ID'";
    $sql_block = $conn->query($sql_branch_block);

    header('Location: viewBranchDetails.php');

  }

  else if($Approval_Status=='YES') {
    
    echo"<script>alert('Already has been Approved by Another Admin!');
    window.top.location.href='viewBranchDetails.php'</script>";

  }

  else if($Approval_Status=='NO') {
    
    echo"<script>alert('Already has been Rejected by Another Admin!');
    window.top.location.href='viewBranchDetails.php'</script>";

  }
  
  
  $conn->close();
                         
?>