<?php session_start();
  $usrID=$_GET['usrID'];

  $Delete_Flag=$_GET['Delete_Flag'];

  include 'db-conn.php';
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';

  if($Delete_Flag=='NO') {
    
    $sql_client_block = "UPDATE user_master set Delete_Flag='YES' where EMP_ID REGEXP '^$usrID'";
    $sql_block = $conn->query($sql_client_block);
     $sql1 ="UPDATE employee_master set EMP_USER_STATUS='NO' WHERE EMP_ID='$Emp_id'";
     $sql_block2 = $conn->query($sql1);
    header('Location: viewUserDetails.php');

  }
   else if($Approval_Status=='EDITING') {
    
    echo"<script>alert('Can't Delete at a Moment!Editing By another user');
    window.top.location.href='viewUserDetails.php'</script>";

  }
  
  $conn->close();
                         
?>