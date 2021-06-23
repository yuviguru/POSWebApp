<?php session_start();
  $camp_id=$_GET['camp_id'];

  $CAMP_APPROVAL=$_GET['CAMP_APPROVAL'];

  $APPROVAL=$_GET['APPROVAL'];

  include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
	
    include 'check_page_access.php';
    $sql_check_Approve = "SELECT * from campaign_master_final where CAMP_PKID REGEXP '^$camp_id'";
  $sql_Approve = $conn->query($sql_check_Approve);

  if($sql_Approve->num_rows > 0) {
    while ($sql_App = $sql_Approve->fetch_assoc()) {
      $Approval_Status=$sql_App["CAMP_APPROVAL"];
      $CAMP_DELETE_FLAG=$sql_App["CAMP_DELETE_FLAG"];
    }
  } 
  if(($CAMP_APPROVAL=='PENDING') && ($APPROVAL=='APPROVE') && ($Approval_Status=='PENDING') && ($CAMP_DELETE_FLAG=='NO')) {
    
    $sql_campaign_approval = "UPDATE campaign_master_final set CAMP_APPROVAL='YES' where CAMP_PKID REGEXP '^$camp_id'";
    $sql_approval = $conn->query($sql_campaign_approval);

    header('Location: viewCampaignDetails-Final.php');

  }

  else if(($CAMP_APPROVAL=='PENDING') && ($APPROVAL=='REJECT') && ($Approval_Status=='PENDING') && ($CAMP_DELETE_FLAG=='NO')) {
    
    $sql_campaign_approval = "UPDATE campaign_master_final set CAMP_APPROVAL='NO' where CAMP_PKID REGEXP '^$camp_id'";
    $sql_approval = $conn->query($sql_campaign_approval);

    header('Location: viewCampaignDetails-Final.php');

  }

 else if($Approval_Status=='YES') {
    
    echo"<script>alert('Already has been Approved by Another Admin!');
    window.top.location.href='viewCampaignDetails.php'</script>";

  }

  else if($Approval_Status=='NO') {
    
    echo"<script>alert('Already has been Rejected by Another Admin!');
    window.top.location.href='viewCampaignDetails.php'</script>";

  }
  
  $conn->close();
                         
?>