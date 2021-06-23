<?php session_start();
  $MAT_PKID=$_GET['MAT_PKID'];

  $MAT_APPROVAL=$_GET['MAT_APPROVAL'];

  $APPROVAL=$_GET['APPROVAL'];

  include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';
 $sql_check_Approve = "SELECT * from material_master where MAT_PKID REGEXP '^$MAT_PKID'";
  $sql_Approve = $conn->query($sql_check_Approve);

  if($sql_Approve->num_rows > 0) {
    while ($sql_App = $sql_Approve->fetch_assoc()) {
      $Approval_Status=$sql_App["MAT_APPROVAL"];
      $MAT_DELETE_FLAG=$sql_App["DELETE_FLAG"];
    }
  }

  if(($MAT_APPROVAL=='PENDING') && ($APPROVAL=='APPROVE') && ($Approval_Status=='PENDING') && ($MAT_DELETE_FLAG=='NO')) {
    
    $sql_mat_cod_block = "UPDATE  material_master set MAT_APPROVAL='YES' where MAT_PKID REGEXP '^$MAT_PKID'";
    $sql_block = $conn->query($sql_mat_cod_block);

    header('Location: viewMaterialDetails.php');

  }

  else if(($MAT_APPROVAL=='PENDING') && ($APPROVAL=='REJECT') && ($Approval_Status=='PENDING') && ($MAT_DELETE_FLAG='NO')) {
    
    $sql_mat_cod_block = "UPDATE material_master set MAT_APPROVAL='NO' where MAT_PKID REGEXP '^$MAT_PKID'";
    $sql_block = $conn->query($sql_mat_cod_block);

    header('Location: viewMaterialDetails.php');

  }
  else if($Approval_Status=='YES') {
    
    echo"<script>alert('Already has been Approved by Another Admin!');
    window.top.location.href='viewMaterialDetails.php'</script>";

  }

  else if($Approval_Status=='NO') {
    
    echo"<script>alert('Already has been Rejected by Another Admin!');
    window.top.location.href='viewMaterialDetails.php'</script>";

  }
  
  $conn->close();
                         
?>