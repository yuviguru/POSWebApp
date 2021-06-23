<?php session_start();
  $CAT_NAME=$_POST['CAT_NAME'];
  $CAT_MASTER=$_POST['CAT_MASTER'];
  include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

    $sql_insert_cat = "INSERT INTO categories(CAT_NAME, CAT_MASTER) VALUES('$CAT_NAME', '$CAT_MASTER')";
    if (mysqli_query($conn, $sql_insert_cat)) { 
      $sql_category = $conn->query("SELECT * FROM categories order by CAT_ID desc limit 1");
      $conn->close(); 
      $response['error'] = "false";
      while($sql_cat= $sql_category->fetch_assoc()){
      $response['id'] = $sql_cat['CAT_ID'];
      $response['name'] = $sql_cat['CAT_NAME'];
      }
      header('Content-type: application/json');
      echo json_encode($response);
      } else {
          $response['error'] = mysqli_error($conn);
          header('Content-type: application/json');
          echo json_encode($response);
      }                       
?>