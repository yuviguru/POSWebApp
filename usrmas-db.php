<?php session_start(); ?>
<!doctype html>
<html lang="en">

  <?php include 'header.php'; ?>

  <body>
  <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header" style="height:auto">
    <?php 
      include 'navigation.php'; 
     if((isset($_SESSION['USERID'])) && ($_SESSION['CREATE']=='Yes')) { ?> 

    <?php 
    $user_type = $_GET['usertype'];
    $id=$_GET['user-id'];
    $user_emp_name=$_GET['user_emp_name'];
    $Usr_cpass=$_GET['user-cpass'];
    $user_rights=$_GET['user_rights'];
    if(isset($_GET['menu'])){
    $menu=$_GET['menu'];
    $menu_attach =  "'".implode(",",$menu)."'";
    }else{
      $menu_attach = "NULL";
    }
    $Today=date("Y-m-d H:i:s");
    
    ?>

    <?php
   include 'db-conn.php';
    // Create connectionid
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    else
    {
		
    include 'check_page_access.php';
      echo "<br><br><br><br><br>";

      if($user_type == "Employee"){
        $table_name = "employee_master";
        $uid         = "EMP_ID";
        $flag       = "EMP_USER_STATUS";
      } else {
        $table_name = "client_master";
        $uid         = "CLT_CLIENT_ID";
        $flag       = "CLT_USER_STATUS";
      }
      $sql = "INSERT INTO user_master($uid, USER_TYPE, USER_MENU_ACCESS, USER_ACCESS_APPROVE, USER_ACCESS_EDIT, USER_ACCESS_CREATE, USER_ACCESS_VIEW, PASSWORD,CREATED_DATE) VALUES ('$id','$user_type',$menu_attach,'$user_rights[0]','$user_rights[1]','$user_rights[2]','$user_rights[3]','$Usr_cpass','$Today')";
      $sql1 ="UPDATE $table_name set $flag='YES' WHERE $uid='$id'";

      if (mysqli_query($conn, $sql)) { 
        if (mysqli_query($conn, $sql1)) { 
        ?>
        <div class="moz-margin" align="center" style="color: #A6192E;font-size: 20px;">
          <?php echo "User" ?> <font color="green"><?php echo $id ?></font> <?php echo "Created successfully"; ?>
        </div><br><br><br>
    <div class="mdl-layout__content" style="margin:20px;overflow-x:scroll;">
      <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp myTable" align="center">
      <thead>
        <tr>
          <th class="mdl-data-table__cell--numeric">User ID</th>
          <th class="mdl-data-table__cell--numeric">User Name</th>
          <th class="mdl-data-table__cell--numeric">Approve</th>
          <th class="mdl-data-table__cell--numeric">Edit</th>
          <th class="mdl-data-table__cell--numeric">Create</th>
          <th class="mdl-data-table__cell--numeric">View</th>
          <th class="mdl-data-table__cell--numeric">Access Menus</th>
          <th class="mdl-data-table__cell--numeric">Password</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $id ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $user_emp_name; ?></td>
          <td class="mdl-data-table__cell--numeric"><?php echo $user_rights[0]; ?></td>
          <td class="mdl-data-table__cell--numeric"><?php echo $user_rights[1]; ?></td>
          <td class="mdl-data-table__cell--numeric"><?php echo $user_rights[2]; ?></td>
          <td class="mdl-data-table__cell--numeric"><?php echo $user_rights[3]; ?></td>
          <td class="mdl-data-table__cell--numeric"><?php
          if(isset($_GET['menu'])){ 
           $prefix = $menunames ='';
          foreach($menu as $menuid){
            $sql_menu = $conn->query("SELECT * FROM menu_master WHERE MENU_ID='$menuid'");
            $menu_det = $sql_menu->fetch_assoc();
            $menunames .= $prefix.$menu_det['MENU_NAME'];
            $prefix = ', ';
          }
          echo $menunames; 
          } else {
            echo "-------"; 
          }?></td>
          <td class="mdl-data-table__cell--numeric"><?php echo $Usr_cpass;   ?></td>
        </tr>
      </tbody>
    </table>
  </div>
    <br>  
    <br>
    <br>
    <div align="center">
        <a href="viewUserDetails.php">
          <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:20%">View All Details</button>
        </a> 
      </div>
      <?php } else {
          echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
      } } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
    }
    ?>
    
</div>
<?php } else {
    echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
  } 
  ?>
  </body>
  </html>