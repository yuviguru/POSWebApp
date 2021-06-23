<?php session_start();
  $Campaign_ID=$_GET['Campaign_ID'];

  $Delete_Flag=$_GET['Delete_Flag'];

 include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';

    $sql_approve_block = "SELECT CAMP_APPROVAL from campaign_master_final where CAMP_PKID REGEXP '^$Campaign_ID'";
    $sql_approve = $conn->query($sql_approve_block);
    $Approval_Status=$sql_approve->fetch_assoc()["CAMP_APPROVAL"];
    
    
    if($Approval_Status=='EDITING') {
    
      echo"<script>alert('Currently being edited by another user !!!');
      window.top.location.href='viewCampaignDetails-Final.php'</script>";

    }

    else if($Delete_Flag=='NO') {
    
      $sql_client_block = "UPDATE campaign_master_final set CAMP_DELETE_FLAG='YES' where CAMP_PKID REGEXP '^$Campaign_ID'";
      $sql_block = $conn->query($sql_client_block);

      header('Location: viewCampaignDetails-Final.php');

    }
  
  $conn->close();
                         
?>