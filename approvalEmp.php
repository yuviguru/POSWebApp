<?php session_start();
  $EMP_ID=$_GET['EMP_ID'];

  $EMP_APPROVAL=$_GET['EMP_APPROVAL'];

  $APPROVAL=$_GET['APPROVAL'];

  include 'db-conn.php';
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';
   $sql_check_Approve = "SELECT * from employee_master where EMP_ID REGEXP '^$EMP_ID'";
  $sql_Approve = $conn->query($sql_check_Approve);

  if($sql_Approve->num_rows > 0) {
    while ($sql_App = $sql_Approve->fetch_assoc()) {
      $Approval_Status=$sql_App["EMP_APPROVAL"];
      $EMP_DELETE_FLAG=$sql_App["EMP_DELETE_FLAG"];
    }
  }

  if(($EMP_APPROVAL=='PENDING') && ($APPROVAL=='APPROVE') && ($Approval_Status=='PENDING') && ($EMP_DELETE_FLAG=='NO')) {
    
    $sql_emp_block = "UPDATE employee_master set EMP_APPROVAL='YES' where EMP_ID REGEXP '^$EMP_ID'";
    $sql_block = $conn->query($sql_emp_block);

    header('Location: viewEmpdetails.php');

  }

  else if(($EMP_APPROVAL=='PENDING') && ($APPROVAL=='REJECT') && ($Approval_Status=='PENDING') && ($EMP_DELETE_FLAG=='NO')) {
    
    $sql_emp_block = "UPDATE employee_master set EMP_APPROVAL='NO' where EMP_ID REGEXP '^$EMP_ID'";
    $sql_block = $conn->query($sql_emp_block);

    header('Location: viewEmpdetails.php');

  }
  else if($Approval_Status=='YES') {
    
    echo"<script>alert('Already has been Approved by Another Admin!');
    window.top.location.href='viewEmpdetails.php'</script>";

  }

  else if($Approval_Status=='NO') {
    
    echo"<script>alert('Already has been Rejected by Another Admin!');
    window.top.location.href='viewEmpdetails.php'</script>";

  }
  
  $conn->close();
                         
?>