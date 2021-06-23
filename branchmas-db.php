<?php session_start(); ?>
<!doctype html>
<html lang="en">

  <?php include 'header.php'; ?>

  <body>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header" style="height:auto">
    <?php include 'navigation.php'; 
     include 'db-conn.php';

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    if(isset($_SESSION['USERID']) && $_SESSION['CREATE']=='Yes') {
        $Branch_city=$_GET['City2'];
        $Branch_mail=$_GET['branch-mail'];
        $Branch_pincode=$_GET['branch-pincode'];
        $Branch_add1_view=$_GET['branch-add1'];
        $Branch_add1=addslashes($Branch_add1_view);
         if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }
    include 'check_page_access.php';
        $sql_branch_dup_check = $conn->query("SELECT * FROM branch_master WHERE (BRN_CITY='$Branch_city' AND BRN_PINCODE='$Branch_pincode') OR BRN_EMAIL='$Branch_mail'");
      if(($sql_branch_dup_check->num_rows > 0) && (!isset($_GET['rec-confirm']))){
        ?><br><br><br> 
      <div class="moz-margin" align="center">
        <h3 style="color:red;font-size:20px;">The Branch City or E-mail You have entered is already exist in the Database.<br>Do You want to continue?</h3>
        <a href="<?php echo basename($_SERVER['REQUEST_URI']).'&rec-confirm=Yes'?>"><button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:10%">Yes</button></a>
        <a href="branch-master.php"><button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:10%">No</button></a>
      </div><br> 
  <div class="mdl-cell mdl-cell--12-col" align="center" style="overflow-x: scroll;">
    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp myTable" align="center">
      <thead>
        <tr>
          <th class="mdl-data-table__cell--numeric">Branch ID</th>
          <th class="mdl-data-table__cell--numeric">Head</th>
          <th class="mdl-data-table__cell--numeric">Efffective Date</th>
          <th class="mdl-data-table__cell--numeric">Address 1</th>
          <th class="mdl-data-table__cell--numeric">Address 2</th>
          <th class="mdl-data-table__cell--numeric">City</th>
          <th class="mdl-data-table__cell--numeric">State</th>
          <th class="mdl-data-table__cell--numeric">Pincode</th>
          <th class="mdl-data-table__cell--numeric">Phone Number</th>
          <th class="mdl-data-table__cell--numeric">Contact Person</th>
          <th class="mdl-data-table__cell--numeric">Mail</th>
        </tr>
      </thead>
      <tbody>
      <?php while ($sql_branch_dup = $sql_branch_dup_check->fetch_assoc()) { ?>
        <tr>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_branch_dup['BRN_PKID'];?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_branch_dup['BRN_HEAD'];?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_branch_dup['BRN_EF_DATE'];?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_branch_dup['BRN_ADD1'];?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_branch_dup['BRN_ADD2'];?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_branch_dup['BRN_CITY'];?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_branch_dup['BRN_STATE'];?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_branch_dup['BRN_PINCODE'];?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_branch_dup['BRN_TELE_NO'];?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_branch_dup['BRN_CONTACT_PERSON'];?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_branch_dup['BRN_EMAIL'];?></td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
    </div>
    <br><br><br>
    <?php
      }
    else{
    $Branch_id=$_GET['branch-id'];
    $Branch_id_old=$_GET['old-branch-id'];

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

    ?>

    <?php
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    else
    {
      echo "<br><br><br><br><br>";
      
      $sql = "INSERT INTO branch_master(BRN_PKID, BRN_CITY, BRN_EMAIL, BRN_ADD1, BRN_ADD2, BRN_PINCODE, BRN_STATE, BRN_TELE_NO, BRN_CONTACT_PERSON, CREATED_DATE) VALUES ('$Branch_id','$Branch_city','$Branch_mail','$Branch_add1','$Branch_add2','$Branch_pincode','$Branch_state','$Branch_phn_num','$Branch_CP','$Today')";
      $sql1 = "UPDATE settings set Branch_Master='$Branch_id' where Branch_Master='$Branch_id_old'";

      if (mysqli_query($conn, $sql)) { ?>
        <div class="moz-margin" align="center" style="color: #A6192E;font-size: 20px;">
          <?php echo "Branch" ?> <font color="green"><?php echo $Branch_id ?></font> <?php echo "Created successfully"; ?>
        </div><br><br><br>
      <?php
        if (mysqli_query($conn, $sql1)) { ?>
      <div class="mdl-cell mdl-cell--12-col" align="center" style="overflow-x: scroll;">
        <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp myTable" align="center">
      <thead>
        <tr>
          <th class="mdl-data-table__cell--numeric">Branch ID</th>
          <th class="mdl-data-table__cell--numeric">Address 1</th>
          <th class="mdl-data-table__cell--numeric">Address 2</th>
          <th class="mdl-data-table__cell--numeric">State</th>
          <th class="mdl-data-table__cell--numeric">City</th>
          <th class="mdl-data-table__cell--numeric">Pincode</th>
          <th class="mdl-data-table__cell--numeric">Phone Number</th>
          <th class="mdl-data-table__cell--numeric">Contact Person</th>
          <th class="mdl-data-table__cell--numeric">Mail</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Branch_id;        ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Branch_add1_view; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Branch_add2_view; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Branch_state;     ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Branch_city;      ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Branch_pincode;   ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Branch_phn_num;   ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Branch_CP;        ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Branch_mail;      ?></td>
        </tr>
      </tbody>
    </table>
    </div>
    <br><br><br>

    <?php }
       } else {
          echo '<div align="center"><h3 style="color:red;">ERROR: Try Again</h3><br><a href="branch-master.php"><button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:10%">Create New</button></a></div><br>';
      }
      
    }
  }
  } 
  else {
      echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
    }
    ?>
    <div align="center">
    <a href="viewBranchDetails.php">
      <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:20%">View All Details</button>
    </a>
    
    </div>
  </div>
  </body>
  </html>

  