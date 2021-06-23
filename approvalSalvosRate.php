<?php session_start();
  $RAT_ID=$_GET['RAT_ID'];

  $RAT_APPROVAL=$_GET['RAT_APPROVAL'];

  $APPROVAL=$_GET['APPROVAL'];

  include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';
   $sql_check_Approve = "SELECT * from rate_master where RAT_ID REGEXP '^$RAT_ID'";
  $sql_Approve = $conn->query($sql_check_Approve);

  if($sql_Approve->num_rows > 0) {
    while ($sql_App = $sql_Approve->fetch_assoc()) {
      $Approval_Status=$sql_App["RAT_APPROVAL"];
      $RAT_DELETE_FLAG=$sql_App["RAT_DELETE_FLAG"];
    }
  }

  if(($RAT_APPROVAL=='PENDING') && ($APPROVAL=='APPROVE') && ($Approval_Status=='PENDING') && ($RAT_DELETE_FLAG=='NO')) {
    
    $sql_rat_block = "UPDATE rate_master set RAT_APPROVAL='YES' where RAT_ID REGEXP '^$RAT_ID'";
    $sql_block = $conn->query($sql_rat_block);

    header('Location: viewSalvosRate.php');

  }

  else if(($RAT_APPROVAL=='PENDING') && ($APPROVAL=='REJECT')&& ($Approval_Status=='PENDING') && ($RAT_DELETE_FLAG=='NO')) {
    
    $sql_rat_block = "UPDATE rate_master set RAT_APPROVAL='NO' where RAT_ID REGEXP '^$RAT_ID'";
    $sql_block = $conn->query($sql_rat_block);

    header('Location: viewSalvosRate.php');

  }
  else if($Approval_Status=='YES') {
    
    echo"<script>alert('Already has been Approved by Another Admin!');
    window.top.location.href='viewSalvosRate.php'</script>";

  }

  else if($Approval_Status=='NO') {
    
    echo"<script>alert('Already has been Rejected by Another Admin!');
    window.top.location.href='viewSalvosRate.php'</script>";

  }  

  
  $conn->close();
                         
?>