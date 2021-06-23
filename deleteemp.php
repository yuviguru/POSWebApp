<?php session_start();
  $EMP_ID=$_GET['empID'];

  $Delete_Flag=$_GET['Delete_Flag'];

  include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';
  $sql_approve_block = "SELECT EMP_APPROVAL from employee_master where EMP_ID REGEXP '^$EMP_ID'";
  $sql_approve = $conn->query($sql_approve_block);
  $Approval_Status=$sql_approve->fetch_assoc()["EMP_APPROVAL"];
  
  if($Approval_Status=='EDITING') {
    
    echo"<script>alert('Currently being edited by another user !!!');window.top.location.href='viewEmpDetails.php'</script>";

  }
  else if($Delete_Flag=='NO') {
    
    $sql_emp_block = "UPDATE employee_master set EMP_DELETE_FLAG='YES' where EMP_ID REGEXP '^$EMP_ID'";
    $sql_block = $conn->query($sql_emp_block);

    header('Location: viewEmpDetails.php');

  }
    
  
  $conn->close();
                         
?>