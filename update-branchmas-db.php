<?php session_start(); ?>
<!doctype html>
<html lang="en">
  
  <?php include 'header.php';
    include 'db-conn.php';
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    ?>

  <body>
    <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header" style="height:auto">
    <?php include 'navigation.php';

    if((isset($_SESSION['USERID'])) && ($_SESSION['EDIT']=='Yes')) { 
      $Branch_id=$_GET['update-branch-id'];

    if(isset($_GET['branch-head'])) {
      $Branch_head='"'.$_GET['branch-head'].'"';
      $EMP_ID =$_GET['branch-head'];
      $sql_emp_details = "SELECT EMP_NAME FROM employee_master WHERE EMP_ID=$Branch_head";
      $sql_emp = $conn->query($sql_emp_details);
      $Branch_head_view = $sql_emp->fetch_assoc()['EMP_NAME']; 
    }
    else {
      $Branch_head = "NULL";
      $Branch_head_view="--------";
    }

    if($_GET['branch-effdate']!='') {
      $Branch_effdate_before=strtotime($_GET['branch-effdate']);
      $Branch_effdate_test=date('Y-m-d',$Branch_effdate_before);
      $Branch_effdate='"'.$Branch_effdate_test.'"';
      $Branch_effdate_view=date('d-m-Y',$Branch_effdate_before);
    } else {
      $Branch_effdate="NULL";
      $Branch_effdate_view="--------";
    }
    
    $Branch_city=$_GET['City2'];
    $Branch_mail=$_GET['branch-mail'];

    $Branch_add1_view=$_GET['branch-add1'];
    $Branch_add1=addslashes($Branch_add1_view);

    $Branch_add2_view=$_GET['branch-add2'];
    $Branch_add2=addslashes($Branch_add2_view);

    $Branch_pincode=$_GET['branch-pincode'];
    $Branch_state=$_GET['branch-state'];
    $Branch_phn_num=$_GET['branch-phn-num'];

    $Branch_CP=$_GET['branch-CP'];

    $Today=date("Y-m-d H:i:s");

   

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    else
    {
      echo "<br><br><br><br><br>";
    include 'check_page_access.php';
      $sql_update_branch ="UPDATE branch_master set BRN_PKID='$Branch_id', BRN_HEAD=$Branch_head, BRN_EF_DATE=$Branch_effdate, BRN_CITY='$Branch_city', BRN_EMAIL='$Branch_mail', BRN_ADD1='$Branch_add1', BRN_ADD2='$Branch_add2', BRN_PINCODE='$Branch_pincode',BRN_CONTACT_PERSON='$Branch_CP', BRN_STATE='$Branch_state', BRN_TELE_NO='$Branch_phn_num',UPDATED_DATE='$Today',BRN_APPROVAL='PENDING' where BRN_PKID='$Branch_id'";
    }
  
      if (mysqli_query($conn, $sql_update_branch)) { ?>
        <div class="moz-margin" align="center" style="color: #A6192E;font-size: 20px;">
          <?php echo "Branch" ?> <font color="green"><?php echo $Branch_id ?></font> <?php echo "Details Updated successfully"; ?>
        </div><br><br><br>
      <?php } else {
          echo "Error: " . $sql_update_branch . "<br>" . mysqli_error($conn);
      }
    ?>
    <div class="mdl-cell mdl-cell--12-col" align="center" style="overflow-x: scroll;">
      <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp myTable" align="center">
        <thead>
          <tr>
            <th class="mdl-data-table__cell--numeric">Branch ID</th>
            <th class="mdl-data-table__cell--numeric">Branch Head</th>
            <th class="mdl-data-table__cell--numeric">Efffective Date</th>
            <th class="mdl-data-table__cell--numeric">Address 1</th>
            <th class="mdl-data-table__cell--numeric">Address 2</th>
            <th class="mdl-data-table__cell--numeric">Pincode</th>
            <th class="mdl-data-table__cell--numeric">City</th>
            <th class="mdl-data-table__cell--numeric">State</th>
            <th class="mdl-data-table__cell--numeric">Contact Person</th>
            <th class="mdl-data-table__cell--numeric">Phone Number</th>
            <th class="mdl-data-table__cell--numeric">Mail</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $Branch_id;      ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $Branch_head_view; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $Branch_effdate_view; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $Branch_add1_view; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $Branch_add2_view; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $Branch_pincode; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $Branch_city;     ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $Branch_state;   ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $Branch_CP;        ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $Branch_phn_num; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $Branch_mail;    ?></td>
          </tr>
        </tbody>
      </table>
    </div><br>
    <?php if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes')) { ?> 
    <div align="center">
    <a href="viewBranchDetails.php">
      <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:20%">View All Details</button>
    </a>
    </div>
<?php  } } else {
   echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
  } 
?>
</div>
</body>
</html>