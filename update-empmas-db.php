<?php session_start(); ?>
<!doctype html>
<html lang="en">

  <?php include 'header.php'; ?>

  <body>
  <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header" style="height:auto">
    <?php include 'navigation.php';
    if((isset($_SESSION['USERID'])) && ($_SESSION['EDIT']=='Yes')) { ?>

    <?php 
    $Emp_ID=$_GET['edit-emp-id'];
    $Emp_name=$_GET['emp-name'];
    $Emp_dept=$_GET['emp-dept'];
    $Emp_desig=$_GET['emp-desig'];
    $Emp_ctrl_branch=$_GET['emp-cb'];
    $Emp_qual=$_GET['emp-qual'];
    $Emp_DOJ=$_GET['emp-DOJ'];

    $Emp_add1_view=$_GET['emp-add1'];
    $Emp_add1=addslashes($Emp_add1_view);

    $Emp_add2_view=$_GET['emp-add2'];
    $Emp_add2=addslashes($Emp_add2_view);

    $Emp_city=$_GET['City2'];
    $Emp_pincode=$_GET['emp-pincode'];
    $Emp_state=$_GET['emp-state'];
    $Emp_off_mail=$_GET['emp-off-mail'];
    $Emp_pers_mail=$_GET['emp-pers-mail'];
    $Emp_off_mob=$_GET['emp-off-mob'];
    $Emp_pers_mob=$_GET['emp-pers-mob'];

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
      	 $sql_update_emp ="UPDATE employee_master set EMP_ID='$Emp_ID', EMP_NAME='$Emp_name', EMP_DEPARTMENT='$Emp_dept', EMP_DESIGNATION='$Emp_desig', EMP_CON_BRANCH='$Emp_ctrl_branch',EMP_QULIFICATION='$Emp_qual', EMP_DOJ='$Emp_DOJ', EMP_ADD1='$Emp_add1', EMP_ADD2='$Emp_add2', CITY='$Emp_city', PINCODE='$Emp_pincode', STATE='$Emp_state', E_MAIL_OFFICIAL='$Emp_off_mail', E_MAIL_PERSONAL='$Emp_pers_mail', MOBILE_OFFICIAL='$Emp_off_mob', MOBILE_PERSONAL='$Emp_pers_mob',UPDATED_DATE='$Today',EMP_APPROVAL='PENDING' where EMP_ID='$Emp_ID'";
        
        $sql_CB_name_query=$conn->query("SELECT BRN_CITY FROM branch_master WHERE BRN_PKID='$Emp_ctrl_branch'");
        $Emp_ctrl_branch_name = $sql_CB_name_query->fetch_assoc()['BRN_CITY'];

      if (mysqli_query($conn, $sql_update_emp)) { ?>
        <div class="moz-margin" align="center" style="color: #A6192E;font-size: 20px;">
        <?php echo "Employee" ?> <font color="green"><?php echo $Emp_ID." (".$Emp_name.") " ?></font> <?php echo "Details Updated successfully"; ?><br>
        </div><br><br><br>
      <?php } else {
          echo "Error: " . $sql_update_emp . "<br>" . mysqli_error($conn);
      }
    }
    ?>
    <div class="mdl-layout__content" style="margin:20px;overflow-x:scroll;">
    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp myTable" align="center" >
      <thead>
        <tr>
          <th class="mdl-data-table__cell--numeric">Employee ID</th>
          <th class="mdl-data-table__cell--numeric">Employee Name</th>
          <th class="mdl-data-table__cell--numeric">Department</th>
          <th class="mdl-data-table__cell--numeric">Designation</th>
          <th class="mdl-data-table__cell--numeric">Controlling Branch</th>
          <th class="mdl-data-table__cell--numeric">Qualification</th>
          <th class="mdl-data-table__cell--numeric">Date Of Joining</th>
          <th class="mdl-data-table__cell--numeric">Address 1</th>
          <th class="mdl-data-table__cell--numeric">Address 2</th>
          <th class="mdl-data-table__cell--numeric">City</th>
          <th class="mdl-data-table__cell--numeric">State</th>
          <th class="mdl-data-table__cell--numeric">Pincode</th>
          <th class="mdl-data-table__cell--numeric">E-Mail(O)</th>
          <th class="mdl-data-table__cell--numeric">E-Mail(P)</th>
          <th class="mdl-data-table__cell--numeric">Mobile(O)</th>
          <th class="mdl-data-table__cell--numeric">Mobile(P)</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Emp_ID; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Emp_name; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Emp_dept; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Emp_desig; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Emp_ctrl_branch_name; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Emp_qual; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Emp_DOJ; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Emp_add1_view; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Emp_add2_view; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Emp_city; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Emp_state; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Emp_pincode; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Emp_off_mail; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Emp_pers_mail; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Emp_off_mob; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Emp_pers_mob; ?></td>
        </tr>
      </tbody>
    </table>
  </div> 
  <br><br><br>
  <?php if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes')) { ?> 
  <div align="center">
    <a href="viewEmpdetails.php">
      <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:20%">View All Details</button>
    </a> 
  </div>

    <?php } } else {
    echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
  } ?>
</div>
</body>
</html>