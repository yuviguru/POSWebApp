<?php session_start();
  $VEN_PKID=$_GET['VEN_PKID'];

  $VEN_APPROVAL=$_GET['VEN_APPROVAL'];

  $APPROVAL=$_GET['APPROVAL'];

  include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';
  $sql_check_Approve = "SELECT * from vendor_master where VEN_PKID REGEXP '^$VEN_PKID'";
  $sql_Approve = $conn->query($sql_check_Approve);

  if($sql_Approve->num_rows > 0) {
    while ($sql_App = $sql_Approve->fetch_assoc()) {
      $Approval_Status=$sql_App["VEN_APPROVAL"];
      $VEN_DELETE_FLAG=$sql_App["DELETE_FLAG"];
    }
  }

  if(($VEN_APPROVAL=='PENDING') && ($APPROVAL=='APPROVE') && ($Approval_Status=='PENDING') && ($VEN_DELETE_FLAG=='NO')) {
    
    $sql_vendor_block = "UPDATE vendor_master set VEN_APPROVAL='YES' where VEN_PKID REGEXP '^$VEN_PKID'";
    $sql_block = $conn->query($sql_vendor_block);

    header('Location: viewVendorDetails.php');

  }

  else if(($VEN_APPROVAL=='PENDING') && ($APPROVAL=='REJECT') && ($Approval_Status=='PENDING') && ($VEN_DELETE_FLAG=='NO')) {
    
    $sql_vendor_block = "UPDATE vendor_master set VEN_APPROVAL='NO' where VEN_PKID REGEXP '^$VEN_PKID'";
    $sql_block = $conn->query($sql_vendor_block);

    header('Location: viewVendorDetails.php');

  }
  else if($Approval_Status=='YES') {
    
    echo"<script>alert('Already has been Approved by Another Admin!');
    window.top.location.href='viewVendorDetails.php'</script>";

  }

  else if($Approval_Status=='NO') {
    
    echo"<script>alert('Already has been Rejected by Another Admin!');
    window.top.location.href='viewVendorDetails.php'</script>";

  }  
  $conn->close();
                         
?>