<?php session_start();

  $PKID=$_GET['PKID'];
  $Approval_Status=$_GET['Approval_Status'];
  $Table_Name=$_GET['Table_Name'];
  $Col_Name=$_GET['Col_Name'];
  $Col_Name2=$_GET['Col_Name2'];

  include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  if($Approval_Status=='PENDING') {
    $sql_client_block = "UPDATE $Table_Name set $Col_Name2='PENDING' where $Col_Name='$PKID'";
    if (mysqli_query($conn, $sql_client_block)) 
    { 
    } else {
        echo "Error: " . $sql_client_block . "<br>" . mysqli_error($conn);
    }
  }

  else if($Approval_Status=='NO') {
    $sql_client_block = "UPDATE $Table_Name set $Col_Name2='PENDING' where $Col_Name='$PKID'";
    if (mysqli_query($conn, $sql_client_block)) 
    { 
    } else {
        echo "Error: " . $sql_client_block . "<br>" . mysqli_error($conn);
    }
  }

  else if($Approval_Status=='YES') {
    $sql_client_block = "UPDATE $Table_Name set $Col_Name2='YES' where $Col_Name='$PKID'";
    if (mysqli_query($conn, $sql_client_block)) 
    { 
    } else {
        echo "Error: " . $sql_client_block . "<br>" . mysqli_error($conn);
    }
  }

  $conn->close();
                         
?>