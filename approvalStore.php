<?php session_start();
  $Store_ID=$_GET['Store_ID'];
  $STR_APPROVAL=$_GET['STR_APPROVAL'];
  $APPROVAL=$_GET['APPROVAL'];

 include 'db-conn.php';
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';
 $sql_check_Approve = "SELECT * from store_master where STR_PKID REGEXP '^$Store_ID'";
  $sql_Approve = $conn->query($sql_check_Approve);

  if($sql_Approve->num_rows > 0) {
    while ($sql_App = $sql_Approve->fetch_assoc()) {
      $Approval_Status=$sql_App["STR_APPROVAL"];
      $STR_DELETE_FLAG=$sql_App["STR_DELETE_FLAG"];
    }
  }
  if(($STR_APPROVAL=='PENDING') && ($APPROVAL=='APPROVE') && ($Approval_Status=='PENDING') && ($STR_DELETE_FLAG=='NO')) {
    
    $sql_store_approval = "UPDATE store_master set STR_APPROVAL='YES' where STR_PKID REGEXP '^$Store_ID'";
    $sql_approval = $conn->query($sql_store_approval);

    header('Location: viewStoreDetails.php');

  }

  else if(($STR_APPROVAL=='PENDING') && ($APPROVAL=='REJECT') && ($Approval_Status=='PENDING') && ($STR_DELETE_FLAG=='NO')) {
    
    $sql_store_approval = "UPDATE store_master set STR_APPROVAL='NO' where STR_PKID REGEXP '^$Store_ID'";
    $sql_approval = $conn->query($sql_store_approval);

    header('Location: viewStoreDetails.php');

  }
   else if($Approval_Status=='YES') {
    
    echo"<script>alert('Already has been Approved by Another Admin!');
    window.top.location.href='viewStoreDetails.php'</script>";

  }

  else if($Approval_Status=='NO') {
    
    echo"<script>alert('Already has been Rejected by Another Admin!');
    window.top.location.href='viewStoreDetails.php'</script>";

  }  

  $conn->close();
                         
?>