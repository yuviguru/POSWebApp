<?php session_start(); ?>
<!doctype html>
<html lang="en">

<?php include 'header.php'; ?>

<body>
  <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header" style="height:auto;">
  <?php include 'navigation.php';
    if((isset($_SESSION['USERID'])) && ($_SESSION['EDIT']=='Yes')) { ?>
    <?php 
    $Emp_id=$_GET['update-user-id'];
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
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    else
    {
      echo "<br><br><br><br><br>";
    include 'check_page_access.php';

      $sql_update_usr ="UPDATE user_master set EMP_ID='$Emp_id', USER_MENU_ACCESS=$menu_attach, USER_ACCESS_APPROVE='$user_rights[0]', USER_ACCESS_EDIT='$user_rights[1]', USER_ACCESS_CREATE='$user_rights[2]', USER_ACCESS_VIEW='$user_rights[3]', PASSWORD='$Usr_cpass',UPDATED_DATE='$Today' where EMP_ID='$Emp_id'";
      

      if (mysqli_query($conn, $sql_update_usr)) { ?>
        <div class="moz-margin" align="center" style="color: #A6192E;font-size: 20px;">
          <?php echo "User" ?> <font color="green"><?php echo $Emp_id ?></font> <?php echo "Details Updated successfully"; ?>
        </div><br><br><br>
      <?php } else {
          echo "Error: " . $sql_update_usr . "<br>" . mysqli_error($conn);
      }
    }
    ?>
    <div class="mdl-layout__content" style="margin:20px;overflow-x:scroll;">
    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp myTable" align="center">
      <thead>
        <tr>
          <th class="mdl-data-table__cell--numeric">User ID</th>
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
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Emp_id;      ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $user_rights[0]; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $user_rights[1]; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $user_rights[2]; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $user_rights[3]; ?></td>
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
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Usr_cpass;   ?></td>
        </tr>
      </tbody>
    </table>
     <br><br>
    </div>
    <br><br><br>
    <?php if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes')) { ?> 
      <div align="center">
        <a href="viewUserDetails.php">
          <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:20%">View All Details</button>
        </a> 
      </div>
     <?php } } else {
    echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
  } ?>
  </div>
</body>
</html>