<?php session_start();
  $ELE_PKID=$_GET['ELE_PKID'];

  $ELE_APPROVAL=$_GET['ELE_APPROVAL'];

  $APPROVAL=$_GET['APPROVAL'];

 include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  include 'check_page_access.php';
   $sql_check_Approve = "SELECT * from element_master where ELE_PKID REGEXP '^$ELE_PKID'";
  $sql_Approve = $conn->query($sql_check_Approve);

  if($sql_Approve->num_rows > 0) {
    while ($sql_App = $sql_Approve->fetch_assoc()) {
      $Approval_Status=$sql_App["ELE_APPROVAL"];
      $ELE_DELETE_FLAG=$sql_App["ELE_DELETE_FLAG"];
    }
  }

  if(($ELE_APPROVAL=='PENDING') && ($APPROVAL=='APPROVE') && ($Approval_Status=='PENDING') && ($ELE_DELETE_FLAG='NO')) {
    
    $sql_ele_block = "UPDATE element_master set ELE_APPROVAL='YES' where ELE_PKID REGEXP '^$ELE_PKID'";
    $sql_block = $conn->query($sql_ele_block);

    header('Location: viewElementsDetails.php');

  }

  else if(($ELE_APPROVAL=='PENDING') && ($APPROVAL=='REJECT') && ($Approval_Status=='PENDING') && ($ELE_DELETE_FLAG='NO')) {
    
    $sql_ele_block = "UPDATE element_master set ELE_APPROVAL='NO' where ELE_PKID REGEXP '^$ELE_PKID'";
    $sql_block = $conn->query($sql_ele_block);

    header('Location: viewElementsDetails.php');

  }
 else if($Approval_Status=='YES') {
    
    echo"<script>alert('Already has been Approved by Another Admin!');
    window.top.location.href='viewElementsDetails.php'</script>";

  }

  else if($Approval_Status=='NO') {
    
    echo"<script>alert('Already has been Rejected by Another Admin!');
    window.top.location.href='viewElementsDetails.php'</script>";

  }
  
  
  $conn->close();
                         
?>