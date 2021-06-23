<?php session_start();
  $MAT_COD_ID=$_GET['MAT_COD_ID'];

  $MAT_COD_APPROVAL=$_GET['MAT_COD_APPROVAL'];

  $APPROVAL=$_GET['APPROVAL'];

 include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';

   $sql_check_Approve = "SELECT * from material_code_master where MAT_COD_ID REGEXP '^$MAT_COD_ID'";
  $sql_Approve = $conn->query($sql_check_Approve);

  if($sql_Approve->num_rows > 0) {
    while ($sql_App = $sql_Approve->fetch_assoc()) {
      $Approval_Status=$sql_App["MAT_COD_APPROVAL"];
      $MAT_COD_DELETE_FLAG=$sql_App["DELETE_FLAG"];
    }
  }

  if(($MAT_COD_APPROVAL=='PENDING') && ($APPROVAL=='APPROVE') && ($Approval_Status=='PENDING') && ($MAT_COD_DELETE_FLAG=='NO')) {
    
    $sql_mat_cod_block = "UPDATE material_code_master set MAT_COD_APPROVAL='YES' where MAT_COD_ID REGEXP '^$MAT_COD_ID'";
    $sql_block = $conn->query($sql_mat_cod_block);

    header('Location: viewMaterialCodeDetails.php');

  }

  else if(($MAT_COD_APPROVAL=='PENDING') && ($APPROVAL=='REJECT') && ($Approval_Status=='PENDING') && ($MAT_COD_DELETE_FLAG=='NO')) {
    
    $sql_mat_cod_block = "UPDATE material_code_master set MAT_COD_APPROVAL='NO' where MAT_COD_ID REGEXP '^$MAT_COD_ID'";
    $sql_block = $conn->query($sql_mat_cod_block);

    header('Location: viewMaterialCodeDetails.php');

  }
else if($Approval_Status=='YES') {
    
    echo"<script>alert('Already has been Approved by Another Admin!');
    window.top.location.href='viewMaterialCodeDetails.php'</script>";

  }

  else if($Approval_Status=='NO') {
    
    echo"<script>alert('Already has been Rejected by Another Admin!');
    window.top.location.href='viewMaterialCodeDetails.php'</script>";

  } 
  
  $conn->close();
                         
?>